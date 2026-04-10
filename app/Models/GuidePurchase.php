<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GuidePurchase extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'guide_id',
        'amount',
        'paid_at',
    ];

    protected function casts(): array
    {
        return [
            'paid_at' => 'datetime',
            'amount' => 'decimal:2',
        ];
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function guide()
    {
        return $this->belongsTo(Guide::class);
    }
}
