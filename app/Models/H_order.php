<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Customers;
class H_order extends Model
{
    use HasFactory;
    protected $table = 'h_order';
    protected $guarded = [];

    protected $primaryKey = 'Order_no';


  public function customers(){
    return $this->belongsTo(Customers::class,'cus_id','cus_id');
  }
  public function d_order(){
    return $this->hasMany(D_order::class,'Order_no','Order_no');
  }
}
