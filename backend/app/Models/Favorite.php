<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Favorite extends Model
{
    use HasFactory;

    protected $table = 'favorites'; // Asegúrate de que este sea el nombre correcto de tu tabla
    protected $primaryKey = 'favorite_id'; // Clave primaria específica
    public $incrementing = true; // Indica que la clave primaria es autoincrementable
    protected $keyType = 'int'; // Especifica que la clave primaria es un entero

    protected $fillable = [
        'user_id',
        'pet_id',
        'is_favorite', // Incluye el nuevo campo is_active
    ];

    // Relación con el modelo User
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Relación con el modelo Pet
    public function pet()
    {
        return $this->belongsTo(Pet::class);
    }
}
