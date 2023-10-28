<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
class Community extends Model {
    use HasFactory;
    protected $fillable = ['nombre', 'descripcion', 'imagen', 'privacidad', 'user_id'];
    public function publications(): HasMany {
        return $this->hasMany(Publication::class);
    }
    public function users(): BelongsToMany {
        return $this->belongsToMany(User::class)->withTimestamps();
    }
    public function requests(): HasMany {
        return $this->hasMany(Request::class);
    }
    public function chats(): BelongsToMany {
        return $this->BelongsToMany(Chat::class);
    }
}
