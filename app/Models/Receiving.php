<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Receiving extends Model
{
    use HasFactory;

    protected $table = 'receivings';
    protected $guarded = ['id'];

    public function Pivot_receivings()
    {
        return $this->hasMany(Pivot_receiving::class, 'receiving_transaksi', 'no_transaksi');
    }
}
