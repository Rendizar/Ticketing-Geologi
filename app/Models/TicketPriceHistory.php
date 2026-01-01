<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class TicketPriceHistory extends Model
{
    use HasFactory;

    protected $table = 'ticket_price_history';

    protected $fillable = [
        'ticket_category_id',
        'old_price',
        'new_price',
        'changed_by',
        'reason'
    ];

    protected $casts = [
        'old_price' => 'decimal:2',
        'new_price' => 'decimal:2'
    ];

    /**
     * Relasi ke kategori tiket
     */
    public function ticketCategory()
    {
        return $this->belongsTo(TicketCategory::class);
    }

    /**
     * Relasi ke admin yang mengubah
     */
    public function admin()
    {
        return $this->belongsTo(Admin::class, 'changed_by', 'id_login');
    }
}

