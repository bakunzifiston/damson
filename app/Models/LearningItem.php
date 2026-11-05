<?php

namespace App\Models;

use App\Support\DamsonAssets;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

/** One model for the three kinds of Learning content: articles (blog), guides and downloads (library). */
class LearningItem extends Model
{
    public const TYPE_ARTICLE = 'article';

    public const TYPE_GUIDE = 'guide';

    public const TYPE_DOWNLOAD = 'download';

    /** @var array<string, string> type => plural label */
    public const TYPES = [
        self::TYPE_ARTICLE => 'Articles',
        self::TYPE_GUIDE => 'Guides',
        self::TYPE_DOWNLOAD => 'Downloads',
    ];

    public const DIFFICULTIES = ['beginner', 'intermediate', 'advanced'];

    protected $fillable = [
        'type', 'title', 'slug', 'excerpt', 'body', 'category', 'difficulty', 'format',
        'external_url', 'file_path', 'sort_order', 'is_published', 'published_at',
    ];

    protected function casts(): array
    {
        return [
            'sort_order' => 'integer',
            'is_published' => 'boolean',
            'published_at' => 'datetime',
        ];
    }

    public function getRouteKeyName(): string
    {
        return 'slug';
    }

    public function scopeOfType(Builder $query, string $type): Builder
    {
        return $query->where('type', $type);
    }

    /** Visible on the public site: published and not scheduled for the future. */
    public function scopePublished(Builder $query): Builder
    {
        return $query->where('is_published', true)
            ->where(fn (Builder $q) => $q->whereNull('published_at')->orWhere('published_at', '<=', now()));
    }

    public function getTypeLabelAttribute(): string
    {
        return match ($this->type) {
            self::TYPE_ARTICLE => 'Article',
            self::TYPE_GUIDE => 'Guide',
            self::TYPE_DOWNLOAD => 'Download',
            default => ucfirst((string) $this->type),
        };
    }

    public function getFileUrlAttribute(): ?string
    {
        return $this->file_path ? DamsonAssets::storage($this->file_path) : null;
    }

    public function isVisible(): bool
    {
        return $this->is_published && ($this->published_at === null || $this->published_at->lte(now()));
    }
}
