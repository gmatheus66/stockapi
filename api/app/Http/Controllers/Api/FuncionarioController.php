<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Controller;
use App\Funcionario;

class FuncionarioController extends Controller
{
    private $funcionario;

    public function __construct(Funcionario $func){
        $this->funcionario = $func;
    }

    public function index(){

        if(sizeof($this->funcionario->all()) <= 0 ){
            return response()->json(['data' => ['msg' => 'Nenhum Funcionario cadastrado']], 404);
        }
        else{
            return response()->json($this->funcionario->all(), 200);
        }        

    }

    public function store(Request $request){

        $validator = Validator::make($request->all(),[
            'nome' => 'required|string|max:25',
            'idade' => 'required|numeric',
            'endereco' => 'required|string|max:50',
            'cep' => 'required|string',
            'numero_residencia' =>'required|numeric',
            'bairro' => 'required|string',
            'cidade' => 'required|string',
            'pais' => 'required|string|max:2',
            'estado' => 'required|string|max:2',
            'cargo' => 'required|string|max:25',
            'empresa_id' => 'required|numeric'
        ]);

        if(sizeof($validator->errors()) > 0 ){
            return response()->json($validator->errors(), 404);
        }

        try{

            Funcionario::create([
                'nome' => $request->get('nome'),
                'idade' => $request->get('idade'),
                'endereco' => $request->get('endereco'),
                'cep' => $request->get('cep'),
                'numero_residencia' => $request->get('numero_residencia'),
                'bairro' => $request->get('bairro'),
                'cidade' => $request->get('cidade'),
                'pais' => $request->get('pais'),
                'estado' => $request->get('estado'),
                'cargo' => $request->get('cargo'),
                'empresa_id' => $request->get('empresa_id')
            ]);

            return response()->json(['data' => ['msg' => 'Funcionario cadastrado com sucesso'] ],200);

        }catch(Exception $e){
            return response()->json($e,404);
        }

    }

    public function update(Request $request, $id){

        $i = ['id' => $id];
        $validatorid = Validator::make($i,[
            'id' => 'required|numeric'
        ]);
        if(sizeof($validatorid->errors()) > 0 ){
            return response()->json($validatorid->errors(), 404);
        }
        $validator = Validator::make($request->all(),[
            'nome' => 'required|string|max:25',
            'idade' => 'required|numeric',
            'endereco' => 'required|string|max:50',
            'cep' => 'required|string',
            'numero_residencia' =>'required|numeric',
            'bairro' => 'required|string',
            'cidade' => 'required|string',
            'pais' => 'required|string|max:2',
            'estado' => 'required|string|max:2',
            'cargo' => 'required|string|max:25',
            'empresa_id' => 'required|numeric'
        ]);

        if(sizeof($validator->errors()) > 0 ){
            return response()->json($validator->errors(), 404);
        }

        $func_count = Funcionario::where('id', $id)->count();
        $func = Funcionario::find($id);

        if($func_count != 0){

            try{
                $func->update([
                    'nome' => $request->get('nome'),
                    'idade' => $request->get('idade'),
                    'endereco' => $request->get('endereco'),
                    'cep' => $request->get('cep'),
                    'numero_residencia' =>  $request->get('numero_residencia'),
                    'bairro' => $request->get('bairro'),
                    'cidade' => $request->get('cidade'),
                    'pais' => $request->get('pais'),
                    'estado' => $request->get('estado'),
                    'cargo' => $request->get('cargo'),
                    'empresa_id' => $request->get('empresa_id')
                    ]);
                    
                    $json = ['msg' => ['Update feito com sucesso']];
                    return response()->json($json , 200);
                    
                }catch(Exception $e){
                    return response()->json($e, 400);
                }
        }else{
            return response()->json(['data' => ['msg' => 'Este Funcionario nao pode ser atualizada porque não existe']], 500);
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

        $func = Funcionario::where('id', $id)->get();
        $teste = count($func);
        if($teste != 0 ){
            $data = ['data' => $func];
            return response()->json($func,200);
        }else{
            $empty = ['data' => ["Não existe nenhuma empresa com esse id"]];
            return response()->json($empty, 404);
        }

    }

    public function delete($id){

        $i = ['id' => $id];
        $validatorid = Validator::make($i,[
            'id' => 'required|numeric'
        ]);

        if(sizeof($validatorid->errors()) > 0 ){
            return response()->json($validatorid->errors(), 404);
        }

        $func_count = Funcionario::where('id', $id)->count();
        $func = Funcionario::find($id);
        
        if($func_count != 0){
            $func->delete();
            return response()->json(['data' => ['msg' => 'Seção removida com sucesso!','id' => $i ]], 200);
        }else{
            return response()->json(['data' => ['msg' => 'Esta Seção nao pode ser removida porque nao existe']], 500);
        }
        //return response()->json($medicao ,201);
        $json = ['data' => [$func]];
        return response()->json($json,201);

    }

}
