<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Estoque;

class EstoqueController extends Controller
{
    private $estoque;

    public function __construct(Estoque $e){
        $this->estoque = $e;
    }

    public function index(){

        if(sizeof($this->estoque->all()) <= 0 ){
            return response()->json(['data' => ['msg' => 'Nenhum Estoque cadastrado']], 404);
        }
        else{
            return response()->json($this->estoque->all(), 200);
        }        

    }

    public function store(Request $request){

        $validator = Validator::make($request->all(),[
            'codigo' => 'required|numeric',
            'descricao' => 'required|string|max:25',
            'tipo_armazem' => 'required|in:Próprio,Terceiros,Padrão',
            'empresa_id' => 'required|numeric'
        ]);

        if(sizeof($validator->errors()) > 0){
            return response()->json($validator->errors(), 404);
        }

        try{

            $this->estoque->create([
                'codigo' => $request->get('codigo'),
                'descricao' => $request->get('descricao'),
                'tipo_armazem' => $request->get('tipo_armazem'),
                'empresa_id' => $request->get('empresa_id')
            ]);

            return response()->json(['data' => ['msg' => 'Estoque cadastrado com sucesso'] ],200);

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

        $est = Estoque::where('id', $id)->get();
        $teste = count($est);
        if($teste != 0 ){
            $data = ['data' => [$est]];
            return response()->json($est,200);
        }else{
            $empty = ['data' => ["Não existe nenhum Estoque com esse id"]];
            return response()->json($empty, 404);
        }
    }

    public function update(Request $request, $id){

        $validator = Validator::make($request->all(),[
            'codigo' => 'required|numeric',
            'descricao' => 'required|string|max:25',
            'tipo_armazem' => 'required|in:Próprio,Terceiros,Padrão',
            'empresa_id' => 'required|numeric'
        ]);
        $i = ['id' => $id];
        $validatorid = Validator::make($i,[
            'id' => 'required|numeric'
        ]);

        if(sizeof($validator->errors()) > 0 ){
            return response()->json($validator->errors(), 404);
        }

        if(sizeof($validatorid->errors()) > 0){
            return response()->json($validatorid->errors(), 404);
        }

        $est_count = Estoque::where('id', $id)->count();
        $estoque = Estoque::find($id);

        if($est_count != 0){
            $update_req = $request->all();
            $estoque->update([
                'descricao' => $request->get('descricao')
            ]);
            //$json = ['data' => ['empresa' => $ep,'msg' => 'Update feito com sucesso']];
            $json = ['msg' => ['Update feito com sucesso']];
            return response()->json($json , 200);
        }else{
            return response()->json(['data' => ['msg' => 'Esse Estoque nao pode ser atualizado porque não existe']], 500);
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
        $estoque_count = Estoque::where('id', $id)->count();
        $estoque = Estoque::find($id);
        if($estoque_count != 0){
            $estoque->delete();
            return response()->json(['data' => ['msg' => 'Estoque removido com sucesso!','id' => $i ]], 200);
        }else{
            return response()->json(['data' => ['msg' => 'Esta Estoque nao pode ser removido porque nao existe']], 500);
        }
        //return response()->json($medicao ,201);
        $json = ['data' => [$estoque]];
        return response()->json($json ,201);
    }


}
