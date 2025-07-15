<?php

namespace App\Models;

use App\Enums\OrderStatus;
use App\Enums\PaymentMethod;
use App\Enums\PaymentStatus;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_number',
        'user_id',
        'total_amount',
        'status',
        'payment_method',
        'payment_status',
        'delivery_address',
        'observations'
    ];

    protected $casts = [
        'delivery_address' => 'array',
        'total_amount' => 'decimal:2',
        'status' => OrderStatus::class,
        'payment_method' => PaymentMethod::class,
        'payment_status' => PaymentStatus::class,
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function orderItems(): HasMany
    {
        return $this->hasMany(OrderItem::class);
    }

    public static function generateOrderNumber(): string
    {
        return 'ORD-' . now()->format('YmdHis') . '-' . str_pad(rand(1, 9999), 4, '0', STR_PAD_LEFT);
    }
}
