<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Item extends Model
{
    use HasFactory;

    protected $fillable = [
        'project_id',
        'category_id',
        'product_id',
        'name',
        'descriptions',
        'quantities',
    ];

    protected $casts = [
        'quantities' => 'array',
        'descriptions' => 'array',
    ];

    public function project(): BelongsTo
    {
        return $this->belongsTo(Project::class);
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    public function inquiries(): BelongsToMany
    {
        return $this->belongsToMany(Inquiry::class)->withPivot('inquiry_id');
    }
}
