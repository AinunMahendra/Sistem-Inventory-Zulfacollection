<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pivot_receiving extends Model
{
    use HasFactory;
    protected $table = 'pivot_receivings';
    protected $guarded = ['id'];

    public function item()
    {
        return $this->belongsTo(item::class, 'item_sku', 'sku');
    }

    public function receiving()
    {
        return $this->belongsTo(Receiving::class , 'receiving_transaksi', 'no_transaksi');
    }

}
