<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Adoption extends Model
{
    use HasFactory;

    protected $table = 'adoptions';
    protected $primaryKey = 'adoption_id';
    public $incrementing = true;
    protected $keyType = 'int';

    protected $fillable = ['user_id', 'pet_id', 'adoption_date'];
    public function pet()
    {
        return $this->belongsTo(Pet::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
