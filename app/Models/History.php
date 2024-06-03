<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class History extends Model
{
    use HasFactory;
    protected $table = 'history';
    protected $fillable = [
        'user_id', 'product_id', 'quantity'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function product()
    {
        return $this->belongsTo(Products::class);
    }

    public function getStatusAttribute()
    {
        $threeHoursAgo = Carbon::now()->subHours(3);
        return $this->created_at < $threeHoursAgo ? 'closed' : 'open';
    }
}
