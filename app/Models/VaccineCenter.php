<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class VaccineCenter extends Model
{
    use HasFactory;

    protected static function boot() {

        parent::boot();

        static::saved(function ($vaccineCenter) {
            // Clear cache after saving (for both create and update operations)
            Cache::forget('vaccine_centers');
        });

        static::deleted(function ($vaccineCenter) {
            // Clear cache after deleting a vaccine center
            Cache::forget('vaccine_centers');
        });

    }
}
