<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
class Tag extends Model {
    use HasFactory;
    protected $fillable = ['nombre', 'descripcion', 'color', 'publication_id'];
    public function publications(): BelongsToMany {
        return $this->belongsToMany(publication::class);
    }
}
