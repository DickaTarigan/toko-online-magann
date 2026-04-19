<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class Product extends Model
{
    //
    use SoftDeletes;

    protected $fillable = [
        'user_id', 'category_id', 'name', 'slug',
        'description', 'price', 'stock', 'image', 'status'
    ];

    protected $casts = [
        'price' => 'decimal:2',
        'stock' => 'integer',
    ];

    //--Relasi----
    public function seller(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    //--Helper : URL lengkap foto produk
    public function getImageUrlAttribute(): ?string
    {
        return $this->image
        ?asset('/storage' . $this->image)
        :null;
    }

    //--Helper : mengubah format menjadi rupiah
    public function getFormattedPriceAttribute(): string
    {
        return 'Rp ' . number_format($this->price, 0, ',', '.');
    }

    //--Auto-generate slug dari name
    protected static function boot(): void
    {
        parent::boot();
        static::creating(function ($product) {
            if (!$product->slug) {
                $product->slug  = Str::slug($product->name) . '-' . Str::random(6);
            }
        });
    }
}
