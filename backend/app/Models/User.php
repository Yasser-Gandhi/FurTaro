<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $primaryKey = 'user_id';

    protected $fillable = ['name', 'phone_number', 'email', 'password'];

    protected $hidden = ['password'];

    public function adoptions()
    {
        return $this->hasMany(Adoption::class);
    }

    public function favorites()
    {
        // Relación muchos a muchos con mascotas favoritas
        return $this->belongsToMany(Pet::class, 'favorites', 'user_id', 'pet_id');
    }
}
