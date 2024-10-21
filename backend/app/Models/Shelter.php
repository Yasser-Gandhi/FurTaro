<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Shelter extends Model
{
    use HasFactory;

    protected $table = 'shelters';
    protected $primaryKey = 'shelter_id';
    public $incrementing = true;
    protected $keyType = 'int';

    protected $fillable = ['name', 'email', 'location', 'phone_number'];

    public function pets()
    {
        return $this->hasMany(Pet::class);
    }

    // Método para crear un refugio con valores predeterminados
    public static function createDefaultShelter()
    {
        return self::create([
            'name' => 'Refugio Predeterminado',
            'email' => 'info@refugio.com',
            'location' => 'Ubicación Predeterminada',
            'phone_number' => '1234567890',
        ]);
    }
}
