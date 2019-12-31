<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProdutosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('produtos', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('codigo');
            $table->string('nome');
            $table->decimal('preco_custo',8,2);
            $table->decimal('lucro',8,2);
            $table->decimal('preco_venda',8,2);
            $table->decimal('icms',3,2)->nullable();
            $table->decimal('subst_tributaria',3,2)->nullable();
            $table->integer('cst_nfe')->nullable();
            $table->integer('ncm_nfe');
            $table->enum('unidade_medida', ['UN','PC','KG','CX','CJ']);
            $table->enum('origem', ['Nacional','Extrangeiro']);
            $table->integer('codigo_barras');

            $table->unsignedBigInteger('marca_id');
            $table->foreign('marca_id')->references('id')->on('marcas');

            $table->unsignedBigInteger('categoria_id');
            $table->foreign('categoria_id')->references('id')->on('categoria_produtos');

            $table->unsignedBigInteger('secao_id');
            $table->foreign('secao_id')->references('id')->on('secao_estoques');

            $table->unsignedBigInteger('fornecedor_id');
            $table->foreign('fornecedor_id')->references('id')->on('fornecedors');

            

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('produtos');
    }
}
