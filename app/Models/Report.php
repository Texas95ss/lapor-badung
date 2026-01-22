<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Report extends Model
{
    use HasFactory;

    // Izinkan kolom ini diisi
    protected $fillable = [
        'user_id',
        'title',
        'description',
        'category',
        'location',
        'image',
        'status',
        'rating',
        'review',
        'latitude',
        'longitude',
    ];

    // Relasi: Laporan ini milik User siapa?
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Relasi: Satu laporan bisa punya BANYAK komentar
    public function comments()
    {
        return $this->hasMany(Comment::class);
    }
}