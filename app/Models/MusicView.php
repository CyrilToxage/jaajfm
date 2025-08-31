<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MusicView extends Model
{
    use HasFactory;

    protected $table = 'analytics_music_views';

    protected $fillable = [
        'music_id',
        'user_id',
        'ip_address',
        'user_agent',
        'viewed_at'
    ];

    public function music()
    {
        return $this->belongsTo(Music::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
