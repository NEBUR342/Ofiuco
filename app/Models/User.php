<?php
namespace App\Models;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Fortify\TwoFactorAuthenticatable;
use Laravel\Jetstream\HasProfilePhoto;
use Laravel\Sanctum\HasApiTokens;
class User extends Authenticatable implements MustVerifyEmail {
    use HasApiTokens;
    use HasFactory;
    use HasProfilePhoto;
    use Notifiable;
    use TwoFactorAuthenticatable;
    protected $fillable = ['name','email','password','is_admin','temaoscuro','community_id','privado', 'avatar','external_id','external_auth'];
    protected $hidden = ['password','remember_token','two_factor_recovery_codes','two_factor_secret',];
    protected $appends = ['profile_photo_url',];
    public function comments(): HasMany {
        return $this->hasMany(Comment::class);
    }
    public function communities(): BelongsToMany {
        return $this->belongsToMany(Community::class)->withTimestamps();
    }
    public function likes(): HasMany {
        return $this->hasMany(Like::class);
    }
    public function publications(): HasMany {
        return $this->hasMany(Comment::class);
    }
    public function saves(): HasMany {
        return $this->hasMany(Save::class);
    }
    public function requests(): HasMany {
        return $this->hasMany(Request::class);
    }
    public function friends(): HasMany {
        return $this->hasMany(Friend::class);
    }
    public function follows(): HasMany {
        return $this->hasMany(Follow::class);
    }
    public function chats(): HasMany {
        return $this->hasMany(Chat::class);
    }
}
