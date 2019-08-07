# Event_Management Using Laravel

/*
|--------------------------------------------------------------------------
| API Event Routes
|--------------------------------------------------------------------------
*/

Route::post('/event','event_controller@store');                 //Create events <br />

Route::get('/event','event_controller@show');                   //Show Events created by user in case of admin all events will be shown<br />

Route::put('/event/update/{Events}','event_controller@update'); //Update Events <br />

Route::delete('/event/delete/{Events}','event_controller@delete'); //Delete Events<br />


/*
|--------------------------------------------------------------------------
| API Users Routes
|--------------------------------------------------------------------------
*/


Route::post('/user',function (Request $request);                     // Create/Register Users<br />

Route::get('/user','user_controller@show');             // Shows profile of all users if he is admin else self-profile<br />

Route::get('/profile','user_controller@profile');       // Shows profile of admin<br />

Route::put('/user/update/{user}','user_controller@update');        //Update profile<br />

Route::delete('/user/delete/{user}','user_controller@delete');      //Delete User<br />


/*
|--------------------------------------------------------------------------
| API Invite Routes
|--------------------------------------------------------------------------
*/


Route::get('/invite','invite_controller@show');             // Shows invites received to specific user<br />

Route::get('/ainvite','invite_controller@ashow');           // Shows all the invites to admin<br />

Route::get('/invite/event', 'invite_controller@event');     // Shows all the invites sent to<br />

Route::get('/invitation', 'invite_controller@invitation');  // Shows all the invitations received to the user<br />

Route::post('/invite','invite_controller@store');           // Send Invites<br />

Route::put('/invite','invite_controller@update');           // Update the status of the event<br />




