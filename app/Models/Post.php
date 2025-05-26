<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Cache;

class Post extends Model
{
    protected $guarded = ['id'];

    public function scopeFilter(Builder $query, $filters)
    {
        if (isset($filters['status'])) {
            return $query->where('status', $filters['status']);
        }
        if (isset($filters['date'])) {
            return $query->whereDate('scheduled_time', $filters['date']);
        }
        if (isset($filters['start']) && isset($filters['end'])) {
            return $query->whereBetween('scheduled_time', [$filters['start'], $filters['end']]);
        }
    }


    public function platforms()
    {
        return $this->belongsToMany(Platform::class, 'post_platforms')->withPivot('platform_status');
    }


    protected static function boot()
    {
        parent::boot();
        static::created(function ($model) {
            Cache::flush();
        });
        static::updated(function ($model) {
            Cache::flush();
        });
        static::deleted(function ($model) {
            Cache::flush();
        });
    }
}
