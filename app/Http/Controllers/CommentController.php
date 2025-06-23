<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Forum;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Notifications\NewCommentNotification;

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
            'forum_id' => $request->forum_id,
            'parent_id' => $request->parent_id,
            'user_id' => Auth::id(),
            'body' => $request->body,
            'attachment' => $path,
        ]);

        // Kirim notifikasi ke semua anggota forum, kecuali pengirim komentar
        $forum = Forum::with('members')->find($request->forum_id);
        foreach ($forum->members as $member) {
            if ($member->id !== auth()->id()) {
                $member->notify(new NewCommentNotification($forum));
            }
        }

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

        Comment::create([
            'forum_id' => $parent->forum_id,
            'parent_id' => $parentId,
            'user_id' => auth()->id(),
            'body' => $request->body,
            'attachment' => $path,
        ]);

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

        // Hapus lampiran lama jika diminta
        if ($request->has('remove_attachment') && $comment->attachment) {
            Storage::disk('public')->delete($comment->attachment);
            $comment->attachment = null;
        }

        // Upload lampiran baru
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

        // Hapus lampiran jika ada
        if ($comment->attachment) {
            Storage::disk('public')->delete($comment->attachment);
        }

        $forumId = $comment->forum_id;
        $comment->delete();

        return redirect()->route('forums.show', $forumId)
                         ->with('success', 'Komentar dihapus.');
    }
}
