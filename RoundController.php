<?php

namespace App\Http\Controllers;


use App\LogicMafiaServices\MafiaService;
use App\LogicMafiaServices\MusorService;
use App\LogicMafiaServices\DoctorService;
use App\LogicMafiaServices\GameService;
use App\LogicMafiaServices\RoundService;
use Illuminate\Http\Request;
use App\Models\PlayerInGame;
use App\Models\Round;

class RoundController extends Controller
{
    public function GetAllRounds()
    {
        $rounds = Round::all();
        if ($rounds)
            return Response()->json([$rounds], 200);
        else
            return Response()->json([], 204);
    }

    public function GetRoundById($id)
    {
        $round = Round::find($id);
        if ($round)
            return Response()->json([$round], 200);
        else
            return Response()->json([], 204);
    }

    public function CreateRound(Request $request)
    {
        $round = new Round();
        $round->dayTime = $request->dayTime;
        $round->Count = $request->Count;
        $round->HowDie = $request->HowDie;
        $round->WhoDie = $request->WhoDie;
        $round->save();
        return Response()->json([$round], 201);
    }

    public function UpdateRound(Request $request, $id)
    {
        $round = Round::find($id);
        if($round){
            $round->dayTime = $request->dayTime;
            $round->Count = $request->Count;
            $round->HowDie = $request->HowDie;
            $round->WhoDie = $request->WhoDie;
            $round->update();
            $round->save();
            return Response()->json([$round], 201);
        }else{
            return Response()->json([$round], 400);
        }

    }

    public function KillPlayer(Request $request, $roundId)
    {
        $round = Round::find($roundId);
        if ($round) {
            $round->HowDie = $request->HowDie;
            $round->WhoDie = $request->WhoDie;
            $round->update();
            $round->save();
            return Response()->json([$round], 200);
        } else {
            return Response()->json([$round], 418);
        }
    }
    public function HealPlayer(Request $request, $roundId)
    {
        $round = Round::find($roundId);
        if ($round) {
            if ($round->WhoDie == $request->userId) {
                $round->WhoDie = null;
            }
            $round->update();
            $round->save();
            return Response()->json([$round], 200);
        } else {
            return Response()->json([$round], 418);
        }
    }
    public function KickPlayer(Request $request, $roundId)
    {
        $round = Round::find($roundId);
        if ($round) {
            $round->HowDie = $request->HowDie;
            $round->WhoDie = $request->WhoDie;
            $round->update();
            $round->save();
            return Response()->json([$round], 200);
        } else {
            return Response()->json([$round], 418);
        }
    }
    public function CheckPlayer(Request $request, $user_id)
    {
        $pig = PlayerInGame::where("user_id", $user_id)->first();
        if ($pig)
            return Response()->json([$pig], 200);
        else
            return Response()->json([$pig], 418);
    }
}