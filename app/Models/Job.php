<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class Job extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'title',
        'description',
        'type',
        'salary',
        'expiration_date',
        'status',
    ];

    protected $casts = [
        'expiration_date' => 'date',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function applications()
    {
        return $this->hasMany(Application::class);
    }

    public function scopeActive(Builder $query): Builder
    {
        return $query->where('status', 'approved')
            ->where('expiration_date', '>=', now());
    }

    public function scopePending(Builder $query): Builder
    {
        return $query->where('status', 'pending');
    }

    public function scopeExpired(Builder $query): Builder
    {
        return $query->where('expiration_date', '<', now())
            ->orWhere('status', 'rejected');
    }
}
