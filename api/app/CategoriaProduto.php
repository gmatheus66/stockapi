<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CategoriaProduto extends Model
{
   protected $table = 'categoria_produtos';

   protected $fillable = [
       'descricao'
   ];

   protected $guarded = [
        'id',
        'created_at',
        'update_at'
   ];

   public function produto(){
       return $this->hasMany('App\Produto');
   }
}
