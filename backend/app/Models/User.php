<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $primaryKey = 'user_id';

    protected $fillable = ['name', 'phone_number', 'email', 'password', 'adoption_date'];

    protected $hidden = ['password'];

    public function adoptions()
    {
        return $this->hasMany(Adoption::class);
    }

    public function favorites()
    {
        return $this->hasMany(Favorite::class);
    }
}
