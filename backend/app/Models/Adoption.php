<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Carbon;

class Adoption extends Model
{
    use HasFactory;

    protected $table = 'adoptions';
    protected $primaryKey = 'adoption_id';
    public $incrementing = true;
    protected $keyType = 'int';

    protected $fillable = [
        'user_id',
        'pet_id',
        'status',
        'adoption_date',
        'end_date',
        'end_reason'
    ];

    protected $casts = [
        'adoption_date' => 'datetime',
        'end_date' => 'datetime',
    ];

    public function pet(): BelongsTo
    {
        return $this->belongsTo(Pet::class, 'pet_id');
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public static function canAdopt(int $pet_id): bool
    {
        return !self::where('pet_id', $pet_id)
                    ->where('status', 'active')
                    ->exists();
    }

    protected static function boot()
    {
        parent::boot();

        static::creating(function (Adoption $adoption) {
            if (!self::canAdopt($adoption->pet_id)) {
                throw new \Exception('Este animal ya tiene una adopción activa.');
            }

            $adoption->adoption_date = $adoption->adoption_date ?? Carbon::now();
            $adoption->status = 'active';
        });
    }

    public function endAdoption(string $reason, ?Carbon $endDate = null): void
    {
        $this->status = 'returned';
        $this->end_reason = $reason;
        $this->end_date = $endDate ?? Carbon::now();
        $this->save();
    }
}
