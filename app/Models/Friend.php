<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Friend extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'frienduno_id', 'frienddos_id', 'aceptado'];
    
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
