<?php
namespace App\Models\admin;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;


class Category extends Model
{
    use SoftDeletes;
    protected $guarded = [];

    protected $fillable = [
        'name', 'slug', 'type', 'order',
        'is_active', 'icon', 'color'
    ];

    protected $casts = [
        'is_active' => 'boolean'
    ];

    // Автоматическая генерация slug
    public static function boot()
    {
        parent::boot();

        static::creating(function($model) {
            $model->slug = Str::slug($model->name);
        });
    }

    // Связи (если будут, например, с постами)
    public function posts()
    {
        //return $this->hasMany(Post::class);
    }
    public function products()
    {
        //return $this->hasMany(Product::class);
    }
}
