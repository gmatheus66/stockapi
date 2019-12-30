<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SecaoEstoque extends Model
{
    protected $table = 'secao_estoques';

    protected $fillable = [
        'descricao',
        'estoque_id'
    ];

    protected $guarded =[
        'id',
        'created_at',
        'updated_at'
    ];

    public function produto(){
        return $this->hasMany('App\Produto');
    }

    public function estoque(){
        return $this->belongsTo('App\Estoque');
    }
}
