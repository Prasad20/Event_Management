<?php

namespace App;


use Illuminate\Database\Eloquent\Model;

class Invites extends Model
{
    protected $table="Invites";

    public $timestamps = false;

    protected $fillable=['userid','eventid','status'];


    public function Events()
    {
        return $this->belongsTo(App\Events::class);
    }

    public function User()
    {
        return $this->belongsTo(App\User::class);
    }


}
