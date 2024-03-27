<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Crypt;

class UserController extends Controller
{
    public function GetAllUsers()
    {
        $users = User::all();
        if ($users)
            return Response()->json([$users], 200);
        else
            return Response()->json([], 404);
    }

    public function GetUserById($id)
    {
        $user = User::find($id);
        if ($user)
            return Response()->json([$user], 200);
        else
            return Response()->json([], 404);
    }

    public function GetUserByLogin($log)
    {
        // Используем Eloquent для поиска пользователя по имени пользователя
        $user = User::where('userName', $log)->first();

        // Проверяем, найден ли пользователь
        if ($user) {
            // Если пользователь найден, возвращаем его пароль
            return Response()->json([$user->userName], 200);
        } else {
            // Если пользователь не найден, возвращаем сообщение об ошибке
            return Response()->json([], 404);
        }
    }

    public function GetPassword($log)
    {
        // Используем Eloquent для поиска пользователя по имени пользователя
        $user = User::where('userName', $log)->first();

        $albeni = Crypt::decryptString($user->password);

        // Проверяем, найден ли пользователь
        if ($user) {
            // Если пользователь найден, возвращаем его пароль
            return Response()->json([$albeni], 200);
        } else {
            // Если пользователь не найден, возвращаем сообщение об ошибке
            return Response()->json([], 404);
        }
    }

    public function CreateUser(Request $request)
    {
        $user = new User();
        $user->userName = $request->userName;
        //$user->password = $request->password = Hash::make('password');
        $user->password = Crypt::encryptString($request->password);
        $user->wins = 0;
        $user->loses = 0;
        $user->status = $request->status;

        $user->save();
        return Response()->json([$user], 201);
    }

    public function UpdateUser(Request $request, $id)
    {
        $user = User::find($id);
        if ($user) {
            $user->userName = $request->userName;
            $user->password = $request->password;
            $user->wins = $request->wins;
            $user->loses = $request->loses;
            $user->status = $request->status;
            $user->update();
            $user->save();
            return Response()->json([$user], 201);
        } else {
            return Response()->json([], 400);
        }
    }

    public function DeleteUser($id)
    {
        User::whereId($id)->delete();
        return Response()->json([], 410);
    }
}