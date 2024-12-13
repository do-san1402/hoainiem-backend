<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Models\Comment;
use App\Http\Controllers\Controller;
use App\Models\Like;
use Illuminate\Support\Facades\Auth;

class CommentController extends Controller
{
    public function index($postId)
    {
        $userId = Auth::id();
        $totalComments = Comment::where('post_id', $postId)->count();

        $comments = Comment::with(['user', 'replies' => function ($query) use ($userId) {
            $query->with('user')
                ->withCount('likes')
                ->orderBy('created_at', 'desc');
        }])
            ->where('post_id', $postId)
            ->withCount('likes')
            ->orderBy('created_at', 'desc')
            ->get();

        $comments->transform(function ($comment) use ($userId) {
            $comment->isLikedByUser = Like::where('user_id', $userId)
                ->where('comment_id', $comment->id)
                ->exists();

            // Convert created_at to "time ago" format
            $comment->created_at_human = $comment->created_at->diffForHumans();

            if ($comment->replies) {
                $comment->replies->transform(function ($reply) use ($userId) {
                    $reply->isLikedByUser = Like::where('user_id', $userId)
                        ->where('comment_id', $reply->id)
                        ->exists();

                    // Convert created_at for replies to "time ago" format
                    $reply->created_at_human = $reply->created_at->diffForHumans();

                    return $reply;
                });
            }

            return $comment;
        });

        return response()->json([
            'total_comments' => $totalComments,
            'comments' => $comments,
        ]);
    }


    public function store(Request $request)
    {
        $validated = $request->validate([
            'id' => 'required|exists:news_msts,id',
            'content' => 'required|string',
            'parent_id' => 'nullable|exists:comments,id',
        ]);

        $comment = Comment::create([
            'post_id' => $validated['id'],
            'user_id' => auth()->id(),
            'content' => $validated['content'],
            'parent_id' => $validated['parent_id'] ?? null,
        ]);

        $comment->load('user');

        return response()->json($comment, 201);
    }


    public function reply(Request $request, $commentId)
    {
        $validated = $request->validate([
            'content' => 'required|string',
        ]);

        $parentComment = Comment::findOrFail($commentId);

        $reply = Comment::create([
            'post_id' => $parentComment->post_id,
            'user_id' => auth()->id(),
            'content' => $validated['content'],
            'parent_id' => $commentId,
        ]);

        return response()->json($reply->load('user'), 201);
    }

    public function getTotalLikes($commentId)
    {
        $comment = Comment::findOrFail($commentId);

        return response()->json([
            'comment_id' => $commentId,
            'total_likes' => $comment->likes,
        ]);
    }

    public function toggleLikeComment($commentId)
    {
        $userId = Auth::user()->id;
        $comment = Comment::findOrFail($commentId);

        $like = Like::where('user_id', $userId)
            ->where('comment_id', $commentId)
            ->first();

        if ($like) {

            $like->delete();
            $comment->decrement('likes');
            return response()->json([
                'message' => 'Unliked successfully',
                'total_likes' => $comment->likes,
                'isLikedByUser' => false,
            ]);
        } else {

            Like::create([
                'user_id' => $userId,
                'comment_id' => $commentId,
                'type' => 'comment',
            ]);

            $comment->increment('likes');
            return response()->json([
                'message' => 'Liked successfully',
                'total_likes' => $comment->likes,
                'isLikedByUser' => true,
            ]);
        }
    }
}
