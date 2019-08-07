<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;


use App\Events;
use App\User;


class user_controller extends Controller
{
    public function __construct()
    {
        $this->middleware('auth.basic.log');
    }

    public function profile()
    {

        $user = User::whereemail(request()->header('php-auth-user'))->get();

        $var = User::whereid($user[0]['id'])->get();

        if (is_null($var)) {
            return response()->json(['message' => "Record not found"], 404);
        }

        return response()->json($var, 200);
    }


    public function show()
    {
        $user = User::whereemail(request()->header('php-auth-user'))->get();

        $admin = $user[0]["admin"];

        if ($admin) {

            return response()->json(User::get(), 200);
        }
        else{

            $var = User::whereid($user[0]['id'])->get();

            if (is_null($var)) {
                return response()->json(['message' => "Record not found"], 404);
            }

            return response()->json($var, 200);
        }
    }


    public function update(Request $request, User $user)
    {

        if (is_null($user)) {
            return response()->json(['message' => "Record not found"], 404);
        }

        $users = User::whereemail(request()->header('php-auth-user'))->get();

        $admin = $users[0]["admin"];

        if (!$admin) {
            if ($user->id != $users[0]['id']) {
                return response()->json(['message' => "Auth Error"], 401);
            }
        }

        $user->update($request->all());

        return response($user, 200);
    }


    public function delete(Request $request, User $user)
    {

        if (is_null($user)) {
            return response()->json(['message' => "Record not found"], 404);
        }

        $users = User::whereemail(request()->header('php-auth-user'))->get();

        $admin = $users[0]["admin"];

        if (!$admin) {
            if ($user->userid != $users[0]['id']) {
                return response()->json(['message' => "Auth Error"], 401);
            }
        }

        $user->delete();

        return response()->json(['message' => "Deleted Successfully"], 200);
    }

}

