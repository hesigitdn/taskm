<?php

namespace App\Http\Controllers;

use App\Models\Forum;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class ForumController extends Controller
{
    use AuthorizesRequests;

    public function index(Request $request)
    {
        $query = Forum::with('user')->latest();

        if ($request->has('filter') && $request->filter === 'mine') {
            $query->whereHas('members', function ($q) {
                $q->where('user_id', auth()->id());
            });
        }

        if ($request->has('search')) {
            $query->where(function ($q) use ($request) {
                $q->where('title', 'like', '%' . $request->search . '%')
                ->orWhere('body', 'like', '%' . $request->search . '%');
            });
        }


        $forums = $query->paginate(5);

        if ($request->ajax()) {
            return view('forums.partials.list', compact('forums'))->render();
        }

        return view('forums.index', compact('forums'));
    }

    public function create()
    {
        return view('forums.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|max:255',
            'body' => 'required',
        ]);

        $forum = Forum::create([
            'title' => $request->title,
            'body' => $request->body,
            'user_id' => Auth::id(),
        ]);

        $forum->members()->attach(Auth::id());

        return redirect()->route('forums.index')->with('success', 'Forum berhasil dibuat.');
    }

    public function show($id)
    {
        $forum = Forum::with(['user', 'comments.user.replies', 'members'])->findOrFail($id);
        $isMember = $forum->members->contains(auth()->id());
        return view('forums.show', compact('forum', 'isMember'));
    }

    public function join($id)
    {
        $forum = Forum::findOrFail($id);
        $forum->members()->syncWithoutDetaching([auth()->id()]);
        return back()->with('success', 'Berhasil bergabung ke forum.');
    }

    public function myForums()
    {
        $user = auth()->user();
        $forums = $user->forums()->with('user')->latest()->paginate(10);
        return view('forums.mine', compact('forums'));
    }

    public function leave(Forum $forum)
    {
        $user = auth()->user();

        if ($forum->user_id === $user->id) {
            return back()->with('error', 'Kamu adalah pembuat forum dan tidak bisa keluar.');
        }

        $forum->members()->detach($user->id);
        return back()->with('success', 'Kamu telah keluar dari forum.');
    }

    public function edit(Forum $forum)
    {
        $this->authorize('update', $forum);
        return view('forums.edit', compact('forum'));
    }

    public function update(Request $request, Forum $forum)
    {
        $this->authorize('update', $forum);

        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        $forum->update([
            'title' => $request->title,
            'description' => $request->description,
        ]);

        return redirect()->route('forums.show', $forum->id)->with('success', 'Forum berhasil diperbarui.');
    }

    public function members(Forum $forum)
    {
        $this->authorize('update', $forum);
        $members = $forum->members()->get();
        return view('forums.members', compact('forum', 'members'));
    }

    public function kick(Forum $forum, User $user)
    {
        $this->authorize('update', $forum);

        if ($forum->user_id == $user->id) {
            return back()->with('error', 'Tidak dapat mengeluarkan pembuat forum.');
        }

        $forum->members()->detach($user->id);
        return back()->with('success', 'Anggota berhasil dikeluarkan.');
    }

public function list(Request $request)
{
    $query = Forum::with('user')->latest();

    // Filter Forum Saya
    if ($request->filter === 'mine') {
        $query->whereHas('members', function ($q) {
            $q->where('user_id', auth()->id());
        });
    }

    // Pencarian
    if ($request->search) {
        $search = $request->search;
        $query->where(function ($q) use ($search) {
            $q->where('title', 'like', "%$search%")
              ->orWhere('body', 'like', "%$search%");
        });
    }

    $forums = $query->paginate(5);

    return view('forums.partials.list', compact('forums'));
}

}
