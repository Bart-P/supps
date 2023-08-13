<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Category extends Model
{
    use HasFactory;

    protected $fillable = ['name'];

    public function tags(): BelongsToMany
    {
        return $this->belongsToMany(Tag::class)->withPivot('tag_id');
    }

    function suppliers(): BelongsToMany
    {
        return $this->belongsToMany(Supplier::class)->withPivot('supplier_id');
    }

    function products(): HasMany
    {
        return $this->hasMany(Product::class);
    }

    public static function boot()
    {
        parent::boot();
        self::deleting(function ($category) {
            $category->products()->each(function ($product) {
                $product->delete();
            });
        });
    }
}
