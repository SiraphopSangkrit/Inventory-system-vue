<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class M_order extends Model
{
    use HasFactory;
    protected $table = 'm_order';
    protected $guarded = [];

    protected $primaryKey = 'm_order_id';

    public function customers(){
        return $this->belongsTo(Customers::class,'cus_id','cus_id');
      }
}
