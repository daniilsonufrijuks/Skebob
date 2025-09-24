<?php

namespace App\Enums;

enum OrderStatus: string
{
    /**
     * Uzskaitījums pasūtījuma (Order) laukam 'status'
     */
    case Cart = 'cart';
    case Pending = 'pending';
    case Paid = 'paid';
    case Processing = 'processing';
    case Shipped = 'shipped';
    case Delivered = 'delivered';
    case Cancelled = 'cancelled';
    case Refunded = 'refunded';
}
