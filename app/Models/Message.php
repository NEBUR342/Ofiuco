<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Message extends Model {
    use HasFactory;
    protected $fillable = ['user_id', 'destinatario_id', 'community_id', 'contenido'];
    public function user(): BelongsTo {
        return $this->belongsTo(User::class);
    }
    public function community(): BelongsTo {
        return $this->belongsTo(Community::class);
    }
}
