<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Funcionario extends Model
{
    protected $table = 'funcionarios';

    protected $fillable = [
        'nome',
        'idade',
        'endereco',
        'cep',
        'numero_residencia',
        'bairro',
        'cidade',
        'pais',
        'estado'
    ];

    protected $guarded =[
        'id',
        'created_at',
        'updated_at'
    ];

    public function empresa(){
        return $this->belongsTo('App\Empresa');
    }
}
