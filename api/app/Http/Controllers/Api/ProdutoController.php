<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Produto;

class ProdutoController extends Controller
{
    private $produto;

    public function __construct(Produto $prt){
        $this->produto = $prt;
    }

    public function index(){

        if(sizeof($this->produto->all()) <= 0 ){
            return response()->json(['data' => ['msg' => 'Nenhum Produto cadastrado']], 404);
        }
        else{
            
            return response()->json($this->produto->all(), 200); 
        }
    }

    public function store(Request $request){

        $validator = Validator::make($request->all(),[
            'codigo' => 'required|numeric',
            'nome' => 'required',
            'preco_custo' => 'required',
            'lucro' => 'required',
            'preco_venda' => 'required',
            'ncm_nfe' => 'required|max:9',
            'unidade_medida' => 'required|in:UN,PC,KG,CX,CJ',
            'origem' => 'required|in:Nacional,Extrangeiro',
            'codigo_barras' =>'required|max:10',
            'marca_id' => 'required|numeric',
            'categoria_id' => 'required|numeric',
            'secao_id' => 'required|numeric',
            'fornecedor_id' => 'required|numeric'
        ]);


        if(sizeof($validator->errors()) > 0){
            return response()->json($validator->errors(), 404);
        }

        try{
            
            $this->produto->create([
                'codigo' => $request->get('codigo'),
                'nome' => $request->get('nome'),
                'preco_custo' => $request->get('preco_custo'),
                'lucro' => $request->get('lucro'),
                'preco_venda' => $request->get('preco_venda'),
                'icms' => $request->get('icms'),
                'subst_tributaria' => $request->get('subst_tributaria'),
                'cst_nfe' => $request->get('cst_nfe'),
                'ncm_nfe' => $request->get('ncm_nfe'),
                'unidade_medida' => $request->get('unidade_medida'),
                'origem' => $request->get('origem'),
                'codigo_barras' => $request->get('codigo_barras'),
                'marca_id' => $request->get('marca_id'),
                'categoria_id' => $request->get('categoria_id'),
                'secao_id' => $request->get('secao_id'),
                'fornecedor_id' => $request->get('fornecedor_id')
            ]);
            
            return response()->json(['data' => ['msg' => 'Produto cadastrado com sucesso'] ],200);

        }catch(Exception $e){
            return response()->json($e, 400);
        }

    }

    public function update(Request $request, $id){

        $validator = Validator::make($request->all(),[
            'codigo' => 'required|numeric',
            'nome' => 'required',
            'preco_custo' => 'required',
            'lucro' => 'required',
            'preco_venda' => 'required',
            'ncm_nfe' => 'required|max:9',
            'unidade_medida' => 'required|in:UN,PC,KG,CX,CJ',
            'origem' => 'required|in:Nacional,Extrangeiro',
            'codigo_barras' =>'required|max:10',
            'marca_id' => 'required|numeric',
            'categoria_id' => 'required|numeric',
            'secao_id' => 'required|numeric',
            'fornecedor_id' => 'required|numeric'
        ]);
        $i = ['id' => $id];
        $validatorid = Validator::make($i, [
            'id' => 'required|numeric'
        ]);

        if(sizeof($validatorid->errors()) > 0 ){
            return response()->json($validatorid->errors(), 404);
        }

        if(sizeof($validator->errors()) > 0){
            return response()->json($validator->errors(), 404);
        }

        $prd_count = Produto::where('id', $id)->count();
        $prd = Produto::find($id);

        if($prd_count != 0){
            $update_req = $request->all();
            $prd->update([
                'codigo' => $request->get('codigo'),
                'nome' => $request->get('nome'),
                'preco_custo' => $request->get('preco_custo'),
                'lucro' => $request->get('lucro'),
                'preco_venda' => $request->get('preco_venda'),
                'icms' => $request->get('icms'),
                'subst_tributaria' => $request->get('subst_tributaria'),
                'cst_nfe' => $request->get('cst_nfe'),
                'ncm_nfe' => $request->get('ncm_nfe'),
                'unidade_medida' => $request->get('unidade_medida'),
                'origem' => $request->get('origem'),
                'codigo_barras' => $request->get('codigo_barras'),
                'marca_id' => $request->get('marca_id'),
                'categoria_id' => $request->get('categoria_id'),
                'secao_id' => $request->get('secao_id'),
                'fornecedor_id' => $request->get('fornecedor_id')                
            ]);
            //$json = ['data' => ['empresa' => $ep,'msg' => 'Update feito com sucesso']];
            $json = ['msg' => ['Update feito com sucesso']];
            return response()->json($json , 200);
        }else{
            return response()->json(['data' => ['msg' => 'Este Produto nao pode ser atualizada porque não existe']], 500);
        }


    }

    public function show($id){

        $i = ['id' => $id];
        $validator = Validator::make($i,[
            'id' => 'required|numeric'
        ]);
        if(sizeof($validator->errors()) > 0 ){
            return response()->json($validator->errors(), 404);
        }

        $prd = Produto::where('id', $id)->get();
        $teste = count($prd);
        if($teste != 0 ){
            $data = ['data' => [$prd]];
            return response()->json($prd,200);
        }else{
            $empty = ['data' => ["Não existe nenhum produto com esse id"]];
            return response()->json($empty, 404);
        }

    }

    public function delete($id){
        $i = ['id' => $id];
        $validator = Validator::make($i, [
            'id' => 'required|numeric'
        ]);
        if(sizeof($validator->errors()) > 0 ){
            return response()->json($validator->errors(), 404);
        }
        $prd_count = Produto::where('id', $id)->count();
        $prd = Produto::find($id);
        if($prd_count != 0){
            $prd->delete();
            return response()->json(['data' => ['msg' => 'Produto removido com sucesso!','id' => $i ]], 200);
        }else{
            return response()->json(['data' => ['msg' => 'Este Produto nao pode ser removida porque nao existe']], 500);
        }
        $json = ['data' => [$prd]];
        return response()->json($json ,201);
    }



}
