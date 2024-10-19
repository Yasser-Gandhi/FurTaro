<?php

namespace App\Models; // Define el espacio de nombres donde se encuentra el modelo User

// use Illuminate\Contracts\Auth\MustVerifyEmail; // Esta línea está comentada, pero podría usarse para implementar verificación de email
use Illuminate\Database\Eloquent\Factories\HasFactory; // Importa la trait HasFactory para facilitar la creación de instancias de este modelo
use Illuminate\Foundation\Auth\User as Authenticatable; // Extiende la clase Authenticates para funciones de autenticación
use Illuminate\Notifications\Notifiable; // Importa la trait Notifiable para permitir la notificación de eventos
use Illuminate\Database\Eloquent\Model;
class User extends Authenticatable // Define la clase User que hereda de Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable; // Usa las traits HasFactory y Notifiable

    /**
     * Los atributos que se pueden asignar masivamente.
     *
     * @var array<int, string>
     */
    protected $fillable = ['name', 'phone_number', 'email', 'password'];
    // Define los atributos que se pueden asignar masivamente al crear o actualizar un usuario

    protected $hidden = ['password'];
    // Especifica que el atributo 'password' debe estar oculto en las conversiones a arrays o JSON

    public function adoptions() // Define una relación uno a muchos con el modelo Adoption
    {
        return $this->hasMany(Adoption::class); // Un usuario puede tener muchas adopciones
    }

    public function favorites() // Define una relación uno a muchos con el modelo Favorite
    {
        return $this->hasMany(Favorite::class); // Un usuario puede tener muchos favoritos
    }
}
