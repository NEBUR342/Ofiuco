<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
class Publication extends Model {
    use HasFactory;
    protected $fillable = ['titulo', 'contenido', 'estado', 'comunidad', 'imagen', 'user_id', 'community_id'];
    public function comments(): HasMany {
        return $this->hasMany(Comment::class);
    }
    public function community(): BelongsTo {
        return $this->belongsTo(Community::class);
    }
    public function likes(): HasMany {
        return $this->hasMany(Like::class);
    }
    public function tags(): BelongsToMany {
        return $this->belongsToMany(Tag::class);
    }
    public function user(): BelongsTo {
        return $this->belongsTo(User::class);
    }
    public function saves(): HasMany {
        return $this->hasMany(Save::class);
    }
}
