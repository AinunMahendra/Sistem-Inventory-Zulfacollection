<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Lotforlot extends Model
{
    use HasFactory;

    protected $table = 'lotforlots';
    protected $guarded = ['id'];


    public function item()
    {
        return $this->belongsTo(item::class, 'item_sku', 'sku');
    }


}
