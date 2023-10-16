<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class SupplierInquiry extends Model
{
    use HasFactory;

    public function inquiries(): BelongsTo
    {
        return $this->belongsTo(Inquiry::class);
    }

    public function suppliers(): BelongsTo
    {
        return $this->belongsTo(Supplier::class);
    }
}
