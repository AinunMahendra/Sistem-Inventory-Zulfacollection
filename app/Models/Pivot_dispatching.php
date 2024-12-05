<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pivot_dispatching extends Model
{
    use HasFactory;

    protected $table = 'pivot_dispatchings';
    protected $guarded = ['id'];

    public function item()
    {
        return $this->belongsTo(item::class, 'item_sku', 'sku');
    }

    public function dispatching()
    {
        return $this->belongsTo(Receiving::class , 'receiving_transaksi', 'no_transaksi');
    }
}
