<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class inventory_transaction extends Model
{
    
    protected $fillable = ['inventory_id', 'order_id', 'type', 'quantity', 'before_qty', 'after_qty', 'notes'];

    public function inventory()
    {
        return $this->belongsTo(Inventory::class);
    }

    public function order()
    {
        return $this->belongsTo(Order::class);
    }

}
