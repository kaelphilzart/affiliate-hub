<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Attributes\Fillable;

class TrackAudience extends Model
{
    use HasUuids;

    protected $table = 'track_audiences';

    protected $keyType = 'string';
    public $incrementing = false;

     protected $fillable = [
        'product_id',
        'ip_address',
        'user_agent',
    ];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}