<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Shelter extends Model
{
    use HasFactory;

    protected $table = 'shelters'; // Asegúrate de que este sea el nombre correcto de tu tabla
    protected $primaryKey = 'shelter_id'; // Define la clave primaria
    public $incrementing = true; // Indica que la clave primaria es autoincrementable
    protected $keyType = 'int'; // Especifica que la clave primaria es un entero

    protected $fillable = ['name', 'email', 'location', 'contact_number', 'role']; // Elimina shelter_id

    public function pets()
    {
        return $this->hasMany(Pet::class);
    }
}
