<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'adresse',
        'activity_id',
        'image'
    ];

    public function activity()
    {
        return $this->belongsTo(Activity::class);
    }
}
