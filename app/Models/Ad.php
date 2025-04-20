<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ad extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'price_per_day',
        'city',
        'category_id',
        'partner_id',
        'premium_until',
        'status'
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function partner()
    {
        return $this->belongsTo(User::class, 'partner_id');
    }

    public function images()
    {
        return $this->hasMany(AdImage::class);
    }

    public function bookings()
    {
        return $this->hasMany(Booking::class);
    }
}