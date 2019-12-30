<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Marca;
use Illuminate\Support\Facades\Validator;

class MarcaController extends Controller
{
    private $marca;

    public function __construct(Marca $m){
        $this->marca = $m;
    }

    public function index(){

        if(sizeof($this->marca->all()) <= 0 ){
            return response()->json(['data' => ['msg' => 'Nenhuma Marca cadastrada']], 404);
        }
        else{
            return response()->json($this->marca->all(), 200);
        }        

    }

    public function store(Request $request){

        $validator = Validator::make($request->all(),[
            'descricao' => 'required|string|min:3|max:25|unique:marcas,descricao'
        ]);
        
        if(sizeof($validator->errors()) > 0){
            return response()->json($validator->errors(), 404);
        }

        try{
            Marca::create([
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

        $marca = Marca::where('id', $id)->get();
        $teste = count($marca);
        if($teste != 0 ){
            $data = ['data' => [$marca]];
            return response()->json($marca,200);
        }else{
            $empty = ['data' => ["Não existe nenhuma marca com esse id"]];
            return response()->json($empty, 404);
        }
    }

    public function update(Request $request, $id){

        $i = ['id' => $id];
        $validatorid = Validator::make($i,[
            'id' => 'required|numeric'
        ]);
        $validator = Validator::make($request->all(),[
            'descricao' => 'required|string|min:3|max:25|unique:marcas,descricao'
        ]);
        
        if(sizeof($validator->errors()) > 0){
            return response()->json($validator->errors(), 404);
        }

        if(sizeof($validatorid->errors()) > 0 ){
            return response()->json($validator->errors(), 404);
        }
        

        $mc_count = Marca::where('id', $id)->count();
        $mc = Marca::find($id);

        if($mc_count != 0){
            $update_req = $request->all();
            $mc->update([
                'descricao' => $request->get('descricao')
            ]);
            //$json = ['data' => ['empresa' => $ep,'msg' => 'Update feito com sucesso']];
            $json = ['msg' => ['Update feito com sucesso']];
            return response()->json($json , 200);
        }else{
            return response()->json(['data' => ['msg' => 'Esta Marca nao pode ser atualizada porque não existe']], 500);
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

        $marca_count = Marca::where('id', $id)->count();
        $marca = Marca::find($id);
        if($marca_count != 0){
            $marca->delete();
            return response()->json(['data' => ['msg' => 'Marca removida com sucesso!','id' => $i ]], 200);
        }else{
            return response()->json(['data' => ['msg' => 'Esta Marca nao pode ser removida porque nao existe']], 500);
        }
        //return response()->json($medicao ,201);
        $json_medicao = ['data' => [$marca]];
        return response()->json($json_medicao ,201);

    }
}
