<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pet extends Model
{
    use HasFactory;

    protected $table = 'pets'; // Tabla a la que hace referencia el modelo
    protected $primaryKey = 'pet_id'; // Especifica la clave primaria
    public $incrementing = true; // Indica que pet_id es autoincrementable
    protected $keyType = 'int'; // Especifica que pet_id es un entero
    protected $fillable = ['name', 'species', 'age', 'description', 'shelter_id']; // Campos asignables

    // Relación con el modelo Shelter
    public function shelter()
    {
        return $this->belongsTo(Shelter::class);
    }

    // Relación con el modelo Adoption
    public function adoptions()
    {
        return $this->hasMany(Adoption::class);
    }

    // Relación con el modelo Favorite
    public function favorites()
    {
        return $this->hasMany(Favorite::class);
    }
}
