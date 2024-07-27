<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Storage;

class File extends Model
{
    use HasFactory;
    protected $fillable = [
        'path',
        'name',
    ];

    public function team():BelongsTo {
        return $this->belongsTo(Team::class);
    }

    public function getUrlAttribute(): string {
        $url = Storage::disk('s3')->temporaryUrl(
            $this->path, now()->addMinutes(5)
        );
        return $url;
    }

    public function getIsImageAttribute(): bool {
        $mt = Storage::disk('s3')->mimeType($this->path);
        return str_contains($mt, 'image');
    }
}
