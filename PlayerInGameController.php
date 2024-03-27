<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PlayerInGame;
use App\LogicMafiaServices\GameService;
use Illuminate\Support\Facades\DB;
use App\LogicMafiaServices\PIGService;

class PlayerInGameController extends Controller
{
    public function GetAllPIG()
    {
        $pigs = PlayerInGame::all();
        if ($pigs)
            return Response()->json([$pigs], 200);
        else
            return Response()->json([], 204);
    }

    public function GetPIGFromGame($gameId)
    {
        $room = DB::table('player_in_games')
            ->select('users.user_id')
            ->join('users', 'users.user_id', '=', 'player_in_games.user_id')
            ->where('player_in_games.game_id', $gameId)
            ->where('player_in_games.status', true)
            ->get();


        if ($room)
            return $room;
        else
            return "Was not found";
    }

    public function GetPIGById($id)
    {
        $pig = PlayerInGame::find($id);
        if ($pig)
            return Response()->json([$pig], 200);
        else
            return Response()->json([], 204);
    }

    public function RoleGive(Request $request)
    {
        $pig = new GameService();
        $resultPIG = $pig->getListUsersInRoom($request->room_id);
        $result = $pig->GivesRandomRole($resultPIG);
        return $result;
    }

    public function UpdatePIG_status(Request $request, $id)
    {
        $pig = PlayerInGame::find($id);
        if ($pig) {
            $pig->status = $request->status;
            $pig->update();
            $pig->save();
            return Response()->json([$pig], 201);
        } else {
            return Response()->json([], 400);
        }
    }

    public function DeletePIG($id)
    {
        PlayerInGame::whereId($id)->delete();
        return Response()->json([], 410);
    }

    public function CreatePIG(Request $request)
    {
        $pig = new PlayerInGame();
        $pig->status = true;
        $pig->game_id = $request->game_id;
        $pig->role_id = $request->role_id;
        $pig->user_id = $request->user_id;
        $pig->save();
        return Response()->json([$pig], 201);
    }
}