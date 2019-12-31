<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\CategoriaProduto;
use Illuminate\Support\Facades\Validator;

class CategoriaController extends Controller
{
    private $categoria;

    public function __construct(CategoriaProduto $c){
        $this->categoria = $c;
    }

    public function index(){

        if(sizeof($this->categoria->all()) <= 0 ){
            return response()->json(['data' => ['msg' => 'Nenhuma Categoria cadastrada']], 404);
        }
        else{
            return response()->json($this->categoria->all(), 200);
        }        

    }

    public function store(Request $request){

        $validator = Validator::make($request->all(),[
            'descricao' => 'required|string|min:3|max:25|unique:categoria_produtos,descricao'
        ]);
        
        if(sizeof($validator->errors()) > 0){
            return response()->json($validator->errors(), 404);
        }

        try{
            CategoriaProduto::create([
                'descricao' => $request->get('descricao')
            ]);
            return response()->json(['data' => ['msg' => 'Marca cadastrada com sucesso'] ],200);
        }catch(Exception $e){
            return response()->json($e, 400);
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

        $categoria = CategoriaProduto::where('id', $id)->get();
        $teste = count($categoria);
        if($teste != 0 ){
            $data = ['data' => [$categoria]];
            return response()->json($categoria,200);
        }else{
            $empty = ['data' => ["Não existe nenhuma marca com esse id"]];
            return response()->json($empty, 404);
        }
    }

    public function delete($id){

        $i = ['id' => $id];
        $validatorid = Validator::make($i,[
            'id' => 'required|numeric'
        ]);
        if(sizeof($validatorid->errors()) > 0 ){
            return response()->json($validator->errors(), 404);
        }

        $categoria_count = CategoriaProduto::where('id', $id)->count();
        $categoria = CategoriaProduto::find($id);
        if($categoria_count != 0){
            $categoria->delete();
            return response()->json(['data' => ['msg' => 'Categoria removida com sucesso!','id' => $i ]], 200);
        }else{
            return response()->json(['data' => ['msg' => 'Esta Categoria nao pode ser removida porque nao existe']], 500);
        }
        //return response()->json($medicao ,201);
        $json = ['data' => [$categoria]];
        return response()->json($json ,201);

    }

    public function update(Request $request, $id){
        $i = ['id' => $id];
        $validatorid = Validator::make($i,[
            'id' => 'required|numeric'
        ]);
        $validator = Validator::make($request->all(),[
            'descricao' => 'required|string|min:3|max:25|unique:categoria_produtos,descricao'
        ]);
        
        if(sizeof($validator->errors()) > 0){
            return response()->json($validator->errors(), 404);
        }

        if(sizeof($validatorid->errors()) > 0 ){
            return response()->json($validatorid->errors(), 404);
        }

        $cat_count = CategoriaProduto::where('id', $id)->count();
        $categoria = CategoriaProduto::find($id);

        if($cat_count != 0){
            $update_req = $request->all();
            $categoria->update([
                'descricao' => $request->get('descricao')
            ]);
            //$json = ['data' => ['empresa' => $ep,'msg' => 'Update feito com sucesso']];
            $json = ['msg' => ['Update feito com sucesso']];
            return response()->json($json , 200);
        }else{
            return response()->json(['data' => ['msg' => 'Esta Categoria nao pode ser atualizada porque não existe']], 500);
        }
        

    }


   
}
