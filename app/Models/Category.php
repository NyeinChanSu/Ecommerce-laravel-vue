<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Category extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'slug', 'description'];

    protected $casts = [
        'position' => 'integer',
    ];

    public function products()
    {
        return $this->hasMany(Product::class);
    }

    public function parent()
    {
        return $this->belongsTo(self::class, 'parent_id');
    }

    public function children()
    {
        return $this->hasMany(self::class, 'parent_id')->orderBy('position');
    }

    public function scopeOrdered($query)
    {
        return $query->orderBy('position')->orderBy('name');
    }

    protected static function booted()
    {
        static::creating(function ($category) {
            if (is_null($category->position)) {
                $max = self::where('parent_id', $category->parent_id)->max('position');
                $category->position = is_null($max) ? 0 : $max + 1;
            }
        });
    }
}
