<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class InventoryTransactionController extends Controller
{
    
    // --- IGNORE ---

    protected $fillable = ['inventory_id', 'order_id', 'type', 'quantity', 'before_qty', 'after_qty', 'notes'];

}
