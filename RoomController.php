<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Room;
use Illuminate\Support\Facades\DB;
use App\LogicMafiaServices\RoomService;

class RoomController extends Controller
{
    public function GetAllRooms()
    {
        $rooms = Room::all();
        return $rooms;
    }
    public function GetUnActiveRooms()
    {
        $room = DB::table('rooms')->select('*')->where('status', true)->get();
        if ($room)
            return $room;
        else
            return "Was not found";
    }

    public function GetActiveRooms($roomId)
    {
        // $room = new RoomService();
        // $result = $room->CountOfPLayersInRoom();
        $count = DB::table('users_in_rooms')->where('room_id', $roomId)->count('user_id');

        $room = Room::find($roomId);
        $room->userId = $count;
        $room->save();

        if ($room)
            return $room;
        else
            return "Was not found";
    }

    public function GetCountOfSpectatot()
    {
        $room = DB::table('rooms')->select('id', "countOfSpectatot")->where('status', false)->get();
        if ($room)
            return $room;
        else
            return "Was not found";
    }

    public function GetCountOfPlayers()
    {
        $room = DB::table('rooms')->select('id', "userId")->where('status', true)->get();
        if ($room)
            return $room;
        else
            return "Was not found";
    }

    public function GetRoomId($id)
    {
        $room = Room::find($id);
        if ($room)
            return $room->id;
        else
            return "Was not found";
    }

    public function GetLastRoomId()
    {
        $room = DB::table('rooms')->select('id')->where('status', true)->orderBy('id', 'desc')->first();
        if ($room)
            return Response()->json([$room], 201);
        else
            return Response()->json([], 204);
    }

    public function GetRoomById($id)
    {
        $room = Room::find($id);
        if ($room)
            return Response()->json([$room], 201);
        else
            return Response()->json([], 204);
    }

    public function CreateRoom(Request $request)
    {
        $room = new Room();
        $room->status = 1;
        $room->countOfSpectatot = 0;
        $room->save();
        return Response()->json([$room], 201);
    }

    public function UpdateRoom(Request $request, $id)
    {
        $room = Room::find($id);
        if ($room){
            $room->status = $request->status;
            $room->countOfSpectatot = $request->countOfSpectatot;
            $room->update();
            $room->save();
            return Response()->json([$room], 201);
        }
        else{
            return Response()->json([$room], 400);
        }
        
    }

    public function DeleteRoom($id)
    {
       Room::whereId($id)->delete();
       return Response()->json([], 410);
    }
}