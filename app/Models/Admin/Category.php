<?php
namespace App\Models\Admin;

use App\Models\Type;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;


class Category extends Model
{
    protected $guarded = [];

    protected $fillable = ['name', 'slug', 'type_id', 'is_active'];

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
    public function type()
    {
        return $this->belongsTo(Type::class);
    }
}
