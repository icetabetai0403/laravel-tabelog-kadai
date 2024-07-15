<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Kyslik\ColumnSortable\Sortable;

class Store extends Model
{
    use HasFactory, Sortable;

    protected $fillable = [
        'name',
        'description',
        'image',
        'price',
        'business_hours',
        'postal_code',
        'address',
        'phone',
        'regular_holiday',
        'category_id',
        'prefecture',
        'recommend_flag',
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function reviews()
    {
        return $this->hasMany(Review::class);
    }

    public function favorite_users()
    {
        return $this->belongsToMany(User::class)->withTimeStamps();
    }

    public function reservations()
    {
        return $this->hasMany(Reservation::class);
    }
}
