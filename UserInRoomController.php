<?php

namespace App\Http\Controllers;

use App\Models\UsersInRoom;
use Illuminate\Http\Request;

class UserInRoomController extends Controller
{
    public function GetAllUIRs()
    {
        $uirs = UsersInRoom::all();
        if ($uirs)
            return Response()->json([$uirs], 200);
        else
            return Response()->json([], 204);
    }

    public function GetUIRById($id)
    {
        $uir = UsersInRoom::find($id);
        if ($uir)
            return Response()->json([$uir], 200);
        else
            return Response()->json([], 204);
    }

    public function CreateUIR(Request $request)
    {
        $uir = new UsersInRoom();
        $uir->user_id = $request->user_id;
        $uir->room_id = $request->room_id;
        $uir->save();
        return Response()->json([$uir], 201);
    }

    public function UpdateUIR(Request $request, $id)
    {
        $uir = UsersInRoom::find($id);
        if ($uir) {
            $uir->user_id = $request->user_id;
            $uir->room_id = $request->room_id;
            $uir->update();
            $uir->save();
            return Response()->json([$uir], 201);
        } else {
            return Response()->json([], 400);
        }
    }

    public function DeleteUIR($id)
    {
        UsersInRoom::whereId($id)->delete();
        return Response()->json([], 410);
    }
}