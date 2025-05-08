<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Image extends Model
{
    use HasFactory;

    protected $table = 'image'; // Si ta table s'appelle bien "image"

    protected $fillable = [
        'url',
        'objet_id',
    ];

    
    public function images()
    {
        return $this->hasMany(Image::class);
    }
    
    public function objet()
    {
        return $this->belongsTo(Objet::class, 'objet_id');
    }
}
