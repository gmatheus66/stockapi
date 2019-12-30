<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Produto extends Model
{
    protected $table = 'produtos';

    protected $fillable =[
        'codigo',
        'nome',
        'preco_custo',
        'lucro',
        'preco_venda',
        'icms',
        'subst_tributaria',
        'cst_nfe',
        'ncm_nfe',
        'unidade_medida',
        'origem',
        'codigo_barras',
        'marca_id',
        'categoria_id'
    ];

    protected $guarded = [
        'id',
        'created_at',
        'updated_at'
    ];

    public function marca(){
        return $this->belongsTo('App\Marca');
    }

    public function  categoria(){
        return $this->belongsTo('App\CategoriaProduto');
    }

    public function secaoestoque(){
        return $this->belongsTo('App\SecaoEstoque');
    }
}
