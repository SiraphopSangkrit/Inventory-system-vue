<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class D_order extends Model
{
    use HasFactory;
    protected $table = 'd_order';
    protected $guarded = [];
    protected $primaryKey = 'order_detail_id';


public function goods(){
    return $this->belongsTo(Goods::class,'goods_id','goods_id');
}

public function h_order(){
    return $this->belongsTo(H_order::class,'Order_no','Order_no');
}

}
