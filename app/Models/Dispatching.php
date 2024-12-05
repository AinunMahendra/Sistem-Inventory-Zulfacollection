<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Dispatching extends Model
{
    use HasFactory;

    protected $table = 'dispatchings';
    protected $guarded = ['id'];

    public function Pivot_dispatchings()
    {
        return $this->hasMany(Pivot_dispatching::class, 'dispatching_transaksi', 'no_transaksi');
    }
}
