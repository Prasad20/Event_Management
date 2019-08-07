<?php

namespace App\Http\Controllers;

use App\Events;
use App\Invites;
use App\Mail\EventCreated;
use App\User;

use Mail;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;


class invite_controller extends Controller
{
    public function show()
    {
        $user = User::whereemail(request()->header('php-auth-user'))->get();

        $admin = $user[0]["admin"];

        $var =  Invites::whereuserid($user[0]['id'])->get();

        if(is_null($var))
        {
            return response()->json(['message'=>"Record not found"],404);
        }

        return response()->json($var,200);
    }

    public function ashow()
    {
        $user = User::whereemail(request()->header('php-auth-user'))->get();

        $admin = $user[0]["admin"];

        if($admin)
        {
            return response()->json(Invites::get(), 200);
        }
    }

    public function event()
    {
        $user = User::whereemail(request()->header('php-auth-user'))->get();

        $events = Events::whereuserid($user[0]['id'])->get();

        $arr = array();

        foreach ($events as $event)
        {
            $var = Invites::whereeventid($event['id'])->get();
            array_push($arr,$var);
        }

        return $arr;
    }


    public function invitation()
    {
        $user = User::whereemail(request()->header('php-auth-user'))->get();

        $events = Invites::whereuserid($user[0]['id'])->get();

        $arr = array();


        foreach ($events as $event)
        {
            $var = Events::whereid($event['eventid'])->get();
            array_push($arr,$var);
        }

        return $arr;
    }

    public function store(Request $request)
    {
//        $validator = Validator::make($request->getContent(),[
//            'userid' => 'required',
//
//            'eventid' => 'required',
//       ]);
//
//        if ($validator->fails()) {
//            return response()->json($validator->errors());
//        }

        $user = User::whereemail(request()->header('php-auth-user'))->get();

        $id = $user[0]['id'];

        $admin = $user[0]["admin"];

        $request1 = json_decode($request->getContent(),true);

        if(!$admin) {

            User::findOrFail($request1['userid']);

            $valid = Events::whereuserid($id)->whereid($request1['eventid'])->get();

            if ($valid->isEmpty())
            {
                return response()->json(['message'=>"This is not your event"],404);
            }
        }

        $var = new Invites;

        $var->userid = $request1['userid'];
        $var->eventid = $request1['eventid'];

        $var->save();

        $email = User::whereid($request1['userid'])->get();

        $msg = "Event Invite";

        Mail::to($email[0]['email'])->send(
            new EventCreated($msg)
        );

        return response()->json($var,200);
    }

    public function update(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'userid' => 'required',

            'eventid' => 'required',
       ]);

        if ($validator->fails()) {
            return response()->json($validator->errors());
        }


        $user = User::whereemail(request()->header('php-auth-user'))->get();

        $admin = $user[0]["admin"];

        if($admin)
        {
            Invites::whereuserid($request['userid'])->whereeventid($request['eventid'])->update($request->all());
        }
        else
        {
            if((Invites::whereuserid($user[0]['id'])->whereeventid($request['eventid'])->get())->Isempty())
            {
                return response()->json(['message'=>"Your not allowed to update status of the event"],404);
            }

            Invites::whereuserid($user[0]['id'])->whereeventid($request['eventid'])->update($request->all());
        }

        return response("Updated",200);
    }


}
