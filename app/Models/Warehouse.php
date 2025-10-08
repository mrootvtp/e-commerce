<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Warehouse extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'address', 'country_id'];

    public function country()
    {
        return $this->belongsTo(Country::class);
    }


}
