<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

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
}
