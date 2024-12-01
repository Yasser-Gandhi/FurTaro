<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pet extends Model
{
    use HasFactory;

    protected $table = 'pets';
    protected $primaryKey = 'pet_id';
    public $incrementing = true;
    protected $keyType = 'int';

    protected $fillable = [
        'name',
        'species',
        'age',
        'description',
        'shelter_id',
        'status',
    ];

    public function shelter()
    {
        return $this->belongsTo(Shelter::class, 'shelter_id', 'shelter_id');
    }

    public function adoptions()
    {
        return $this->hasMany(Adoption::class);
    }

    public function favorites()
    {
        return $this->hasMany(Favorite::class, 'pet_id', 'pet_id');
    }
}
