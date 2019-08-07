<?php

namespace App\Http\Controllers;

use App\Invites;
use http\Env\Response;
use Illuminate\Http\Request;

use App\Events;
use App\User;
use App\Http\Controllers\Auth;

use Mail;


use App\Mail\EventCreated;


class event_controller extends Controller
{
    public function __construct()
    {
        $this->middleware('auth.basic.log');
    }

    public function store(Request $request)
    {
//        $validator = $request->validate([
//            'name'  =>   'required',
//
//        ]);
//
//        if ($validator->fails()) {
//            return response()->json($validator->errors());
//        }

        $user = User::whereemail(request()->header('php-auth-user'))->get();


        $id = $user[0]['id'];


        $var = new Events;

        $admin = $user[0]["admin"];

        $request1 = json_decode($request->getContent(),true);


//        if($admin and !is_null($request['id']))
//        {
//            $id = $request['id'];
//        }

        $var->userid = $id;
        $var->name = $request1['name'];
        $var->description = $request1['description'];

        $var->save();

        return response()->json($var,200);
    }

    public function show()
    {
        $user = User::whereemail(request()->header('php-auth-user'))->get();


        $admin = $user[0]["admin"];


        if($admin)
        {
            return response()->json(Events::get(),200);
        }
        else
        {
            $var =  Events::whereuserid($user[0]['id'])->get();

            if(is_null($var))
            {
                return response()->json(['message'=>"Record not found"],404);
            }

            return response()->json($var,200);
        }
    }


    public function update(Request $request, Events $Events)
    {

        $user = User::whereemail(request()->header('php-auth-user'))->get();

        $admin = $user[0]["admin"];

        if(!$admin)
        {
            if($Events->userid!=$user[0]['id'])
            {
                return response()->json(['message'=>"Auth Error"],401);
            }
        }


        $Events->update($request->all());

        return response($Events,200);
    }


    public function delete(Request $request, Events $Events)
    {
        $user = User::whereemail(request()->header('php-auth-user'))->get();

        $admin = $user[0]["admin"];

        if(!$admin)
        {
            if($Events->userid!=$user[0]['id'])
            {
                return response()->json(['message'=>"Auth Error"],401);
            }
        }

        $users = Invites::whereeventid($Events['id'])->get();

        $msg = "Event Cancelled";

        foreach ($users as $user)
        {
            $email = User::whereid($user['userid'])->get();

            Mail::to($email[0]['email'])->send(
                new EventCreated($msg)
            );
        }

        $Events->delete();


        return response()->json(['message'=>"Deleted Successfully"],200);
    }

}
