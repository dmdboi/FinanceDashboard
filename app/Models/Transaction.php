<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'description',
        'amount',
        'type',
        'category_id',
        'subscription_id',
        'trx_date',
        'note',
    ];

    protected $casts = [
        'trx_date' => 'datetime',
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }


    // Save a category to the transaction
    public function categorize($category_id): void
    {
        // Categorize the transaction
        $this->category_id = $category_id;
        $this->save();
    }
}
