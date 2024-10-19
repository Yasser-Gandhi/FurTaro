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

    protected $fillable = ['name', 'email', 'location', 'contact_number'];
    public function pets()
    {
        return $this->hasMany(Pet::class);
    }
}
