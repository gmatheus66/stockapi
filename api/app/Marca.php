<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Marca extends Model
{
    protected $table = 'marcas';

    protected $fillable = [
        'descricao'
    ];

    protected $guarded = [
        'id',
        'created_at',
        'updated_at'
    ];

    public function produto(){
        return $this->hasMany('App\Produto');
    }
}
