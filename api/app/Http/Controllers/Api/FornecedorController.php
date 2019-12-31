<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Fornecedor;
use Illuminate\Support\Facades\Validator;

class FornecedorController extends Controller
{
    private $fornecedor;

    public function __construct(Fornecedor $for){
        $this->fornecedor = $for;
    }

    public function index(){

        if(sizeof($this->fornecedor->all()) <= 0 ){
            return response()->json(['data' => ['msg' => 'Nenhum Funcionario cadastrado']], 404);
        }
        else{
            
            return response()->json($this->fornecedor->all(), 200); 
        }
    }
    
    public function store(Request $request){

        $validator = Validator::make($request->all(),[
            'razao_social' => 'required|string|max:30',
            'nome_fantasia' => 'required|string|max:30',
            'cnpj' => 'required|string|max:30|unique:fornecedors,cnpj',
            'endereco' => 'required|string|max:50',
            'cep' => 'required|max:9',
            'numero_residencia' => 'required|numeric',
            'bairro' => 'required|string|max:25',
            'cidade' => 'required|string|max:25',
            'pais' => 'required|string|max:2',
            'estado' => 'required|string|max:2'
        ]);

        if(sizeof($validator->errors()) > 0){
            return response()->json($validator->errors(), 404);
        }

        try{
            
            $this->fornecedor->create([
                'razao_social' => $request->get('razao_social'),
                'nome_fantasia' => $request->get('nome_fantasia'),
                'cnpj' => $request->get('cnpj'),
                'endereco' => $request->get('endereco'),
                'cep' => $request->get('cep'),
                'numero_residencia' => $request->get('numero_residencia'),
                'bairro' => $request->get('bairro'),
                'cidade' => $request->get('cidade'),
                'pais' => $request->get('pais'),
                'estado' => $request->get('estado')
            ]);
            
            return response()->json(['data' => ['msg' => 'Funcionario cadastrado com sucesso'] ],200);

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

        $for = Fornecedor::where('id', $id)->get();
        $teste = count($for);
        if($teste != 0 ){
            $data = ['data' => [$for]];
            return response()->json($for,200);
        }else{
            $empty = ['data' => ["Não existe nenhuma empresa com esse id"]];
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
        $for_count = Fornecedor::where('id', $id)->count();
        $for = Fornecedor::find($id);
        if($for_count != 0){
            $for->delete();
            return response()->json(['data' => ['msg' => 'Empresa removida com sucesso!','id' => $i ]], 200);
        }else{
            return response()->json(['data' => ['msg' => 'Esta Empresa nao pode ser removida porque nao existe']], 500);
        }
        $json = ['data' => [$for]];
        return response()->json($json ,201);
    }

    public function update(Request $request, $id){

        $validator = Validator::make($request->all(),[
            'razao_social' => 'required|string|max:30',
            'nome_fantasia' => 'required|string|max:30',
            'cnpj' => 'required|string|max:30',
            'endereco' => 'required|string|max:50',
            'cep' => 'required|max:9',
            'numero_residencia' => 'required|numeric',
            'bairro' => 'required|string|max:25',
            'cidade' => 'required|string|max:25',
            'pais' => 'required|string|max:2',
            'estado' => 'required|string|max:2'
        ]);

        $i = ['id' => $id];
        $validatorid = Validator::make($i,[
            'id' => 'required|numeric'
        ]);

        if(sizeof($validator->errors()) > 0){
            return response()->json($validator->errors(), 404);
        }
        if(sizeof($validatorid->errors()) > 0 ){
            return response()->json($validatorid->errors(), 404);
        }

        $for_count = Fornecedor::where('id', $id)->count();
        $for = Fornecedor::find($id);

        if($for_count != 0){
            $update_req = $request->all();
            $for->update([
                'razao_social' => $request->get('razao_social'),
                'nome_fantasia' => $request->get('nome_fantasia'),
                'cnpj' => $request->get('cnpj'),
                'endereco' => $request->get('endereco'),
                'cep' => $request->get('cep'),
                'numero_residencia' => $request->get('numero_residencia'),
                'bairro' => $request->get('bairro'),
                'cidade' => $request->get('cidade'),
                'pais' => $request->get('pais'),
                'estado' => $request->get('estado')
            ]);
            //$json = ['data' => ['empresa' => $ep,'msg' => 'Update feito com sucesso']];
            $json = ['msg' => ['Update feito com sucesso']];
            return response()->json($json , 200);
        }else{
            return response()->json(['data' => ['msg' => 'Esta Empresa nao pode ser atualizada porque não existe']], 500);
        }


    }

}
