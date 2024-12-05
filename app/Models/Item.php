<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    use HasFactory;

    // protected $fillable = [
    //     'sku',
    //     'nama',
    //     'jenis',
    //     'warna',
    //     'ukuran',
    //     'stok',
    //     'gambar',
    //     'marterial',
    //     'archive',
    // ];

    protected $table = 'items';
    protected $guarded = ['id'];

    public function Pivot_receiving()
    {
        return $this->hasMany(Pivot_receiving::class, 'item_sku', 'sku');
    }

    public function Pivot_dispatching()
    {
        return $this->hasMany(Pivot_receiving::class, 'item_sku', 'sku');
    }

    public function lotforlot()
    {
        return $this->hasOne(Lotforlot::class, 'item_sku', 'sku');
    }

    protected static function boot()
    {
        parent::boot();

        static::created(function ($item) {
            LotForLot::create([
                'item_sku' => $item->sku,
                'jan_feb' => 0,
                'mar_apr' => 0,
                'mei_jun' => 0,
                'jul_agt' => 0,
                'sep_okt' => 0,
                'nov_des' => 0,
            ]);
        });
    }
}
