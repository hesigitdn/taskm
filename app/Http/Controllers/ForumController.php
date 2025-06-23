<?php

namespace App\Http\Controllers;

use App\Models\Forum;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ForumController extends Controller
{
    // Tampilkan semua forum
    public function index()
    {
        $forums = Forum::with('user')->latest()->paginate(10);
        return view('forums.index', compact('forums'));
    }

    // Form buat forum baru
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

        // Simpan forum ke database
        $forum = Forum::create([
            'title' => $request->title,
            'body' => $request->body,
            'user_id' => Auth::id(),
        ]);

        // 🟢 Tambahkan user pembuat forum ke daftar anggota forum (pivot table)
        $forum->members()->attach(Auth::id());

        return redirect()->route('forums.index')->with('success', 'Forum berhasil dibuat.');
    }


    // Tampilkan detail forum + komentar
    public function show($id)
    {
        // Ambil forum beserta relasi user & komentar
        $forum = Forum::with(['user', 'comments.user.replies', 'members'])->findOrFail($id);

        // Cek apakah user saat ini tergabung sebagai member
        $isMember = $forum->members->contains(auth()->id());

        // Kirim data forum dan status ke view
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

    // Ambil forum yang user ikuti (termasuk yang dia buat)
    $forums = $user->forums()->with('user')->latest()->paginate(10);

    return view('forums.mine', compact('forums'));
}

public function leave(Forum $forum)
{
    $user = auth()->user();

    // Cegah creator forum keluar
    if ($forum->user_id === $user->id) {
        return back()->with('error', 'Kamu adalah pembuat forum dan tidak bisa keluar.');
    }

    $forum->members()->detach($user->id);

    return back()->with('success', 'Kamu telah keluar dari forum.');
}


}
