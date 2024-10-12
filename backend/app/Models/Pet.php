<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pet extends Model
{
    use HasFactory;

    protected $fillable = ['pet_id', 'name', 'species', 'age', 'description', 'shelter_id'];

    public function shelter()
    {
        return $this->belongsTo(Shelter::class);
    }

    public function adoptions()
    {
        return $this->hasMany(Adoption::class);
    }

    public function favorites()
    {
        return $this->hasMany(Favorite::class);
    }
}
