<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Comment;

class CommentController extends Controller
{
    public function GetAllComments() {
        $coms = Comment::all();
        if($coms)
            return Response()->json([$coms], 201);
        else
            return Response()->json([], 204);
    }

    public function GetCommentById($id){
        $com = Comment::find($id);
        if($com)
            return Response()->json([$com], 201);
        else
            return Response()->json([], 204);
    }

    public function CreateComment(Request $request){
        $com = new Comment();
        $com->Text = $request->Text;
        $com->room_id = $request->room_id;
        $com->user_id = $request->user_id;
        $com->save();

        return Response()->json([], 201);
    }

    public function DeleteComment($id){

        if(Comment::whereId($id)){
            Comment::whereId($id)->delete();
            return Response()->json([], 410);
        }
        else{
            return Response()->json([],400);
        }

    }
}