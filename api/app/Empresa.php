<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Empresa extends Model
{
    protected $table = 'empresas';

    protected $fillable = [
        'razao_social',
        'cnpj',
        'nome_fantasia',
        'ddd',
        'telefone',
        'nome_contato'
    ];

    protected $guarded =[
        'id',
        'created_at',
        'updated_at'
    ];

    public function estoque(){
        return $this->hasMany('App\Estoque');
    }

    public function funcionario(){
        return $this->hasMany('App\Funcionario');
    }
}
