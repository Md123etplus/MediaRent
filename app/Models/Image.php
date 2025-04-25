<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Image extends Model
{
    protected $table = 'image';
    
    protected $fillable = ['url', 'objet_id'];

    public function objet(): BelongsTo
    {
        return $this->belongsTo(Objet::class);
    }
}