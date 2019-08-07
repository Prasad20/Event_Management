<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

use App\User;

class Events extends Model
{
    protected $table = 'Events';

    public $timestamps = false;

    protected $fillable = [
        'name','userid','description'
    ];

    public function User()
    {
        return $this->belongsTo(App\User::class);
    }

    public function Invites()
    {
        return $this->hasMany(App\Invites::class);
    }
}
