<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\Casts\Attribute;


class User extends Authenticatable implements MustVerifyEmail
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        // 'email',
        'mobile_no',
        'password',
        'type'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    // protected function type(): Attribute
    // {
    //     // return new Attribute(
    //     //     get: fn ($value) =>  ["user", "super-admin", "manager"][$value],
    //     // );
    // }

    // public function setTypeAttribute($value)
    // {
    //     //die(">>>".$value);
    //     // get: fn ($value) =>  ["user", "super-admin", "manager"][$value],
    //     $user_role=["user", "super-admin", "manager"];
    //     // array_walk($value, function ($value, $key) {
    //     //     echo "{$key} => {$user_role[$key]}\n";
    //     //   });
    //     // if (!array_key_exists($column, $attributes))
    //     // {
    //     //     $attributes[$column] = null;
    //     // }
        

    //        //$this->attributes['type'] = $user_role[$value];
    //        //die(">>".$this->attributes['type']);
    //     //print_r($value); die;
    //     //return ucfirst($value);
    // }

}
