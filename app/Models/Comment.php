<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = ['user_id', 'product_id', 'comment'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function scopeUserID(Builder $query, $userID)
    {
        return $query->where('user_id', $userID);
    }

    public function scopeProductID(Builder $query, $productID)
    {
        return $query->where('product_id', $productID);

    }
}
