<?php

namespace App\Http\Controllers;

use App\Bookmark;
use App\Comment;
use Illuminate\Http\Request;
use DateTime;

use App\Http\Requests;

class CommentController extends Controller
{
    public function store(Request $request)
    {
        $bookmark_uid = $request['bookmark_uid'];
        if ($bookmark_uid=='')
            return $this->errorResponse('bookmark_uid not set', 403);

        if (!Bookmark::where('id',$bookmark_uid)->exists())
            return $this->errorResponse('bookmark_uid not found', 404);

        $text = $request['text'];
        if ($text=='')
            return $this->errorResponse('text not set', 403);

        $comment = new Comment();
        $comment->bookmark_id = $bookmark_uid;
        $comment->text = $text;
        $comment->ip = $request->ip();
        $comment->save();
        return $this->successResponse(['uid' => $comment->id]);

    }
    public function update($uid, Request $request){


        if (!Comment::where('id',$uid)->exists())
            return $this->errorResponse('comment_uid not found', 404);

        $comment = Comment::where('id',$uid)->first();
        if ($comment->ip != $request->ip())
            return $this->errorResponse('you ip != comment owner ip', 403);

        $diff = time() - strtotime($comment->created_at);
        $seconds_in_hour = 60 * 60;
        if ($diff > $seconds_in_hour){
            return $this->errorResponse('time > 1 hour', 403);
        }

        if ($request['text']=='')
            return $this->errorResponse('text not set', 404);

        $comment->text = $request['text'];
        $comment->save();

        return $this->successResponse(['msg' => 'comment updated']);
    }
    public function destroy($uid, Request $request){
        if (!Comment::where('id',$uid)->exists())
            return $this->errorResponse('comment_uid not found', 404);

        $comment = Comment::where('id',$uid)->first();
        if ($comment->ip != $request->ip())
            return $this->errorResponse('you ip != comment owner ip', 403);

        $diff = time() - strtotime($comment->created_at);
        $seconds_in_hour = 60 * 60;
        if ($diff > $seconds_in_hour){
            return $this->errorResponse('time > 1 hour', 403);
        }

        $comment->delete();
        return $this->successResponse(['msg' => 'comment removed']);
    }
}
