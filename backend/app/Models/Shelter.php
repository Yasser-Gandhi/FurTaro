<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Shelter extends Model
{
    use HasFactory;

    protected $fillable = ['shelter_id', 'name', 'email', 'location', 'contact_number', 'role'];

    public function pets()
    {
        return $this->hasMany(Pet::class);
    }
}

