<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Estoque extends Model
{
    protected $table = 'estoques';

    protected $fillable = [
        'codigo',
        'descricao',
        'tipo_armazem',
        'empresa_id'
    ];

    protected $guarded = [
        'id',
        'created_at',
        'updated_at'
    ];

    public function empresa(){
        return $this->belongsTo('App\Empresa');
    }

    public function secao(){
        return $this->hasMany('App\SecaoEstoque');
    }
}
