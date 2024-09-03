<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Rule extends Model
{
    use HasFactory;

    protected $fillable = [
        'property',
        'operator',
        'value',
        'category_id',
        'user_id',
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }



    // Check if the rule matches the transaction
    public function matchesRule(Transaction $trx): bool
    {
        if ($this->operator == 'contains') {
            return strpos($trx[$this->property], $this->value) !== false;
        }

        if ($this->operator == 'equals') {
            return $trx[$this->property] == $this->value;
        }

        return false;
    }
}
