<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Supplier extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'email',
        'web',
    ];


    public function addresses(): HasMany
    {
        return $this->hasMany(Address::class);
    }

    public function people(): HasMany
    {
        return $this->hasMany(Person::class);
    }

    public function categories(): BelongsToMany
    {
        return $this->belongsToMany(Category::class)->withPivot('category_id');
    }

    public function print_types(): BelongsToMany
    {
        return $this->belongsToMany(PrintType::class)->withPivot('print_type_id');
    }

    public function tags(): BelongsToMany
    {
        return $this->belongsToMany(Tag::class)->withPivot('tag_id');
    }
}
