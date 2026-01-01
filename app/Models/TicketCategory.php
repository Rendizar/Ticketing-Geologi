<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class TicketCategory extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'code',
        'price',
        'description',
        'is_active',
        'sort_order'
    ];

    protected $casts = [
        'price' => 'decimal:2',
        'is_active' => 'boolean',
        'sort_order' => 'integer'
    ];

    /**
     * Relasi ke history perubahan harga
     */
    public function priceHistory()
    {
        return $this->hasMany(TicketPriceHistory::class);
    }

    /**
     * Scope untuk kategori aktif
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Scope untuk urutan tampilan
     */
    public function scopeOrdered($query)
    {
        return $query->orderBy('sort_order');
    }

    /**
     * Cek apakah kategori ini adalah kategori utama (tidak boleh dinonaktifkan)
     */
    public function isMainCategory(): bool
    {
        return in_array($this->code, ['pelajar', 'umum', 'asing']);
    }

    /**
     * Override update untuk prevent nonaktifkan kategori utama
     */
    public function update(array $attributes = [], array $options = [])
    {
        // Jika kategori utama, pastikan selalu aktif
        if ($this->isMainCategory() && isset($attributes['is_active'])) {
            $attributes['is_active'] = 1;
        }

        return parent::update($attributes, $options);
    }
}

