<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasUuids;

    protected $keyType = 'string';

    public $incrementing = false;

    protected $fillable = [
        'name',
        'category_id',
        'link',
        'image',
        'type',
    ];

    protected $appends = ['image_url'];

    /* ================= RELATION ================= */
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function audiences()
    {
        return $this->hasMany(TrackAudience::class);
    }

    /* ================= ACCESSOR ================= */
    public function getImageUrlAttribute()
    {
        return $this->image
            ? asset($this->image)
            : null;
    }
}
