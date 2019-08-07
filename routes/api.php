<?php

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;


/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

//
//Route::middleware('auth:api')->get('/user', function (Request $request) {
//    return $request->user();
//});


/*
|--------------------------------------------------------------------------
| API Event Routes
|--------------------------------------------------------------------------
*/


Route::post('/event','event_controller@store');                 //Create events

Route::get('/event','event_controller@show');                   //Show Events created by user in case of admin all events will be shown

Route::put('/event/update/{Events}','event_controller@update'); //Update Events

Route::delete('/event/delete/{Events}','event_controller@delete'); //Delete Events


/*
|--------------------------------------------------------------------------
| API Users Routes
|--------------------------------------------------------------------------
*/


Route::post('/user',function (Request $request)                     // Create/Register Users
{
    $validator = Validator::make($request->get(),[
    'name' => 'required|min:3|max:50',

    'email' => 'required|email|unique:users,email',

    'password' => [
        'min:5',
        'regex:/[a-z]/',
        'regex:/[A-Z]/',
        'regex:/[0-9]/',
        'regex:/[@$!%*#?&]/'],

    'password_confirmation' => 'required_with:password|same:password',
    ]);

    if ($validator->fails()) {
        return response()->json($validator->errors());
    }


    $content = json_decode($request->getContent(),true);

    $content['password'] = Hash::make($content['password']);

    $var = User::create($content);

    return response()->json($var, 200);

});

Route::get('/user','user_controller@show');             // Shows profile of all users if he is admin else self-profile

Route::get('/profile','user_controller@profile');       // Shows profile of admin

Route::put('/user/update/{user}','user_controller@update');        //Update profile

Route::delete('/user/delete/{user}','user_controller@delete');      //Delete User


/*
|--------------------------------------------------------------------------
| API Invite Routes
|--------------------------------------------------------------------------
*/


Route::get('/invite','invite_controller@show');             // Shows invites received to specific user

Route::get('/ainvite','invite_controller@ashow');           // Shows all the invites to admin

Route::get('/invite/event', 'invite_controller@event');     // Shows all the invites sent to

Route::get('/invitation', 'invite_controller@invitation');  // Shows all the invitations received to the user

Route::post('/invite','invite_controller@store');           // Send Invites

Route::put('/invite','invite_controller@update');           // Update the status of the event

