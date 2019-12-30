<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SecaoEstoque extends Model
{
    protected $table = 'secao_estoques';


    public function produto(){
        return $this->hasMany('App\Produto');
    }
}
