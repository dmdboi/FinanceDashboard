<?php

namespace App\Models;

use App\Jobs\processTrx;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class File extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'path',
        'type',
        'size',
        'user_id',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // After create hook
    protected static function booted()
    {
        static::created(function ($file) {
            processTrx::dispatch($file->path);
        });
    }

}
