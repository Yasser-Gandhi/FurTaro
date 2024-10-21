<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Pet;
use Illuminate\Support\Facades\Log;

class Favorite extends Model
{
    use HasFactory;

    protected $table = 'favorites';
    protected $primaryKey = 'favorite_id';
    public $incrementing = true;
    protected $keyType = 'int';

    protected $fillable = ['user_id', 'pet_id'];

    // Relación con el modelo User
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'user_id');
    }

    // Relación con el modelo Pet
    public function pet()
    {
        return $this->belongsTo(Pet::class, 'pet_id', 'pet_id');
    }

    // Método estático para generar favoritos para un usuario específico
    public static function generateFavoritesForUser($userId)
    {
        // Obtén todos los IDs de mascotas
        $pets = Pet::all()->pluck('pet_id');

        // Verifica si hay mascotas disponibles
        if ($pets->isNotEmpty()) {
            foreach ($pets as $petId) {
                // Crea un nuevo registro en la tabla 'favorites' si no existe
                self::firstOrCreate([
                    'user_id' => $userId,
                    'pet_id' => $petId,
                ]);
            }
        } else {
            // Maneja el caso donde no hay mascotas
            Log::info('No hay mascotas disponibles para agregar a favoritos.');
        }
    }
}
 