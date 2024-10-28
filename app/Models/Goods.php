<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Goods extends Model
{
    use HasFactory;
    protected $table = 'goods_name';
    protected $guarded = [];

    protected $primaryKey = 'goods_id';
    public $incrementing = false;


    protected $keyType = 'string';

    public function d_order(){

        return $this->hasMany(D_order::class);
    }
}
