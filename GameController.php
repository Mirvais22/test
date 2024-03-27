<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Game;

class GameController extends Controller
{
    public function GetAllGames()
    {
        $games = Game::all();
        if ($games)
            return Response()->json([$games], 201);
        else
            return Response()->json([], 204);
    }

    public function GetGameById($id)
    {
        $game = Game::find($id);
        if ($game)
            return Response()->json([$game], 201);
        else
            return Response()->json([], 204);
    }

    public function CreateGame(Request $request)
    {
        $game = new Game();
        $game->status = "";
        $game->whoMove = $request->whoMove;
        $game->room_id = $request->room_id;

        $game->save();
        return Response()->json([$game], 201);
    }

    public function UpdateGameMove(Request $request, $id)
    {
        $game = Game::find($id);
        if ($game) {
            $game->whoMove = $request->whoMove;
            $game->update();
            $game->save();
            return Response()->json([$game], 201);
        } 
        else 
        {
            return Response()->json([], 404);
        }
    }

    public function UpdateGameStatus(Request $request, $id)
    {
        $game = Game::find($id);
        if ($game) {
            $game->status = $request->status;
            $game->update();
            $game->save();
            return Response()->json([$game], 201);
        }
        else 
        {
            return Response()->json([], 404);
        }
    }

    public function DeleteGame($id)
    {
        Game::whereId($id)->delete();
        return Response()->json([], 410);
    }
}