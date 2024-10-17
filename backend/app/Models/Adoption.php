<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Adoption extends Model
{
    use HasFactory;

    protected $table = 'adoptions'; // Asegúrate de que este sea el nombre correcto de tu tabla
    protected $primaryKey = 'adoption_id'; // Cambia esto si tienes una clave primaria específica
    public $incrementing = true; // Indica que la clave primaria es autoincrementable
    protected $keyType = 'int'; // Especifica que la clave primaria es un entero

    protected $fillable = ['pet_id', 'user_id', 'status'];

    public function pet()
    {
        return $this->belongsTo(Pet::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
