<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class AdImage extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'ad_id',
        'path',
        'is_primary',
        'caption'
    ];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = ['full_url'];

    /**
     * Get the ad that owns the image.
     */
    public function ad()
    {
        return $this->belongsTo(Ad::class);
    }

    /**
     * Get full URL for the image
     */
    public function getFullUrlAttribute()
    {
        return asset($this->path);
    }

    /**
     * Delete the file when model is deleted
     */
    protected static function boot()
    {
        parent::boot();

        static::deleting(function ($image) {
            // Convert storage path to filesystem path
            $filePath = str_replace('/storage/', '', $image->path);
            Storage::disk('public')->delete($filePath);
        });
    }
}