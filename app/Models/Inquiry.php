<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Inquiry extends Model
{
    use HasFactory;

    protected $fillable = [
        'project_id',
        'name',
    ];

    public function project(): BelongsTo
    {
        return $this->belongsTo(Project::class);
    }

    public function items(): BelongsToMany
    {
        return $this->belongsToMany(Item::class)->withPivot('item_id');
    }
}
