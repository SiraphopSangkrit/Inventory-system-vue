<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\H_order;

class Customers extends Model
{
    use HasFactory;
    protected $table = 'cus_name';
    protected $guarded = [];

    protected $primaryKey = 'cus_id';
    public $incrementing = false;


    protected $keyType = 'string';

    public function h_order()
    {
        return $this->hasMany(H_order::class);
    }
    public function m_order(){
        return $this->hasMany(Customers::class);
      }
}
