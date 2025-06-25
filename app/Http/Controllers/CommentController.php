<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Forum;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Notifications\ForumNotification;

class CommentController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'forum_id' => 'required|exists:forums,id',
            'body' => 'required',
            'attachment' => 'nullable|file|max:2048'
        ]);

        $path = null;
        if ($request->hasFile('attachment')) {
            $path = $request->file('attachment')->store('attachments', 'public');
        }

        $comment = Comment::create([
            'user_id' => auth()->id(),
            'forum_id' => $request->forum_id,
            'body' => $request->body,
            'attachment' => $path,
        ]);

        // Kirim notifikasi ke semua anggota forum (kecuali pengomentar)
        $forum = $comment->forum;
        $forum->members
            ->where('id', '!=', auth()->id())
            ->each(function ($user) use ($comment) {
                $user->notify(new ForumNotification(
                    'Diskusi Baru di Forum',
                    "{$comment->user->name} mengomentari forum: {$comment->forum->title}",
                    route('forums.show', $comment->forum_id)
                ));
            });

        return back()->with('success', 'Komentar berhasil ditambahkan.');
    }

    public function reply(Request $request, $parentId)
    {
        $request->validate([
            'body' => 'required|string',
            'attachment' => 'nullable|file|max:2048',
        ]);

        $parent = Comment::findOrFail($parentId);

        $path = null;
        if ($request->hasFile('attachment')) {
            $path = $request->file('attachment')->store('attachments', 'public');
        }

        $reply = Comment::create([
            'forum_id' => $parent->forum_id,
            'parent_id' => $parentId,
            'user_id' => auth()->id(),
            'body' => $request->body,
            'attachment' => $path,
        ]);

        // Kirim notifikasi ke pemilik komentar jika bukan diri sendiri
        if ($parent->user_id !== auth()->id()) {
            $parent->user->notify(new ForumNotification(
                'Balasan Komentar di Forum',
                "{$reply->user->name} membalas komentarmu di forum: {$reply->forum->title}",
                route('forums.show', $reply->forum_id) . "#komentar-{$reply->id}"
            ));
        }

        return redirect()->route('forums.show', $parent->forum_id)
                         ->with('success', 'Balasan berhasil dikirim!');
    }

    public function edit($id)
    {
        $comment = Comment::findOrFail($id);

        if ($comment->user_id != auth()->id()) {
            abort(403);
        }

        return view('comments.edit', compact('comment'));
    }

    public function update(Request $request, $id)
    {
        $comment = Comment::findOrFail($id);

        if ($comment->user_id != auth()->id()) {
            abort(403);
        }

        $request->validate([
            'body' => 'required',
            'attachment' => 'nullable|file|max:2048',
        ]);

        if ($request->has('remove_attachment') && $comment->attachment) {
            Storage::disk('public')->delete($comment->attachment);
            $comment->attachment = null;
        }

        if ($request->hasFile('attachment')) {
            if ($comment->attachment) {
                Storage::disk('public')->delete($comment->attachment);
            }

            $path = $request->file('attachment')->store('attachments', 'public');
            $comment->attachment = $path;
        }

        $comment->body = $request->body;
        $comment->save();

        return redirect()->route('forums.show', $comment->forum_id)
                         ->with('success', 'Komentar diperbarui.');
    }

    public function destroy($id)
    {
        $comment = Comment::findOrFail($id);

        if ($comment->user_id != auth()->id()) {
            abort(403);
        }

        if ($comment->attachment) {
            Storage::disk('public')->delete($comment->attachment);
        }

        $forumId = $comment->forum_id;
        $comment->delete();

        return redirect()->route('forums.show', $forumId)
                         ->with('success', 'Komentar dihapus.');
    }
}
