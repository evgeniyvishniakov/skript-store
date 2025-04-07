<?php

namespace App\Models\Admin;

use App\Models\Type;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Product extends Model
{
    use HasFactory;

    /**
     * Атрибуты, которые можно массово назначать.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'type_id', 'slug', 'type_id', 'description', 'short_description', 'features',
        'price', 'pricing_tiers', 'license', 'platform', 'compatibility', 'dependencies',
        'cover_image', 'gallery', 'demo_url', 'video_url', 'downloads', 'sales',
        'rating', 'comments_count', 'favorites_count', 'is_active', 'is_featured',
        'published_at', 'category_id','file_path', 'file_size', 'original_filename'
    ];

    /**
     * Атрибуты, которые должны быть приведены к определенным типам.
     *
     * @var array
     */
    protected $casts = [
        'features' => 'array',
        'pricing_tiers' => 'array',
        'compatibility' => 'array',
        'dependencies' => 'array',
        'gallery' => 'array',
        'price' => 'float',
        'rating' => 'float',
        'is_active' => 'boolean',
        'is_featured' => 'boolean',
        'published_at' => 'datetime',
    ];

    /**
     * Связь с категорией
     */
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    /**
     * Связь с автором
     */
    public function author()
    {
        return $this->belongsTo(User::class, 'author_id');
    }

    /**
     * Получить URL обложки с заполнителем по умолчанию
     */
    public function getCoverUrlAttribute()
    {
        if ($this->cover_image) {
            return asset('storage/' . $this->cover_image);
        }

        return asset('images/placeholder.png');
    }

    /**
     * Получить массив URL изображений галереи
     */
    public function getGalleryUrlsAttribute()
    {
        if (!$this->gallery) {
            return [];
        }

        $urls = [];
        foreach ($this->gallery as $image) {
            $urls[] = asset('storage/' . $image);
        }

        return $urls;
    }

    /**
     * Получить отформатированную цену
     */
    public function getFormattedPriceAttribute()
    {
        return '$' . number_format($this->price, 2);
    }

    /**
     * Получить тип продукта с переводом на русский
     */
    public function type()
    {
        return $this->belongsTo(Type::class);
    }

    /**
     * Область запроса для активных продуктов
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Область запроса для избранных продуктов
     */
    public function scopeFeatured($query)
    {
        return $query->where('is_featured', true);
    }

    /**
     * Область запроса для опубликованных продуктов
     */
    public function scopePublished($query)
    {
        return $query->whereNotNull('published_at')
            ->where('published_at', '<=', now());
    }

    /**
     * Область запроса для поиска по названию и описанию
     */
    public function scopeSearch($query, $term)
    {
        return $query->where(function($query) use ($term) {
            $query->where('name', 'LIKE', "%{$term}%")
                ->orWhere('description', 'LIKE', "%{$term}%")
                ->orWhere('short_description', 'LIKE', "%{$term}%");
        });
    }
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            $model->slug = $model->slug ?: Str::slug($model->name);
        });
    }
}
