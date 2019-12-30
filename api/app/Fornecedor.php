<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Fornecedor extends Model
{
    protected $table = 'fornecedors';

    protected $fillable = [
        'razao_social',
        'nome_fantasia',
        'cnpj',
        'endereco',
        'cep',
        'numero_residencia',
        'bairro',
        'cidade',
        'pais',
        'estado'
    ];

    protected $guarded = [
        'id',
        'created_at',
        'updated_at'
    ];
}
