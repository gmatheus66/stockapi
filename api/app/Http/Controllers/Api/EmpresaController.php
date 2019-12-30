<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Empresa;
use Illuminate\Support\Facades\Validator;

class EmpresaController extends Controller
{
    
    private $empresa;

    public function __construct(Empresa $emp){
        $this->empresa = $emp;
    }

    public function index(){

        if(sizeof($this->empresa->all()) <= 0 ){
            return response()->json(['data' => ['msg' => 'Nenhuma Empresa cadastrada']], 404);
        }
        else{
            
            return response()->json($this->empresa->all(), 200); 
        }
    }

    public function store(Request $request){

        $validator = Validator::make($request->all(),[
            'razao' =>'required|string|max:30',
            'cnpj' => 'required|string|min:18|max:18|unique:empresas,cnpj',
            'nome_fantasia' => 'required|string|max:25',
            'ddd' => 'required|numeric',
            'telefone' => 'required|numeric',
            'nome_contato' => 'required|string|max:25'
        ]);

        if(sizeof($validator->errors()) > 0){
            return response()->json($validator->errors(), 404);
        }

        try{
            
            $this->empresa->create([
                'razao_social' => $request->get('razao'),
                'cnpj' => $request->get('cnpj'),
                'nome_fantasia' => $request->get('nome_fantasia'),
                'ddd' => $request->get('ddd'),
                'telefone' => $request->get('telefone'),
                'nome_contato' => $request->get('nome_contato')
            ]);
            
            return response()->json(['data' => ['msg' => 'Empresa cadastrada com sucesso'] ],200);

        }catch(Exception $e){
            return response()->json($e, 400);
        }

    }

    public function update(Request $request, $id){

        $validator = Validator::make($request->all(),[
            'razao' =>'required|string|max:30',
            'cnpj' => 'required|string|min:18|max:18|unique:empresas,cnpj',
            'nome_fantasia' => 'required|string|max:25',
            'ddd' => 'required|numeric',
            'telefone' => 'required|numeric',
            'nome_contato' => 'required|string|max:25'
        ]);

        $i = ['id' => $id];
        $validatorid = Validator::make($i,[
            'id' => 'required|numeric'
        ]);

        if(sizeof($validator->errors()) > 0){
            return response()->json($validator->errors(), 404);
        }
        if(sizeof($validatorid->errors()) > 0 ){
            return response()->json($validator->errors(), 404);
        }

        $ep_count = Empresa::where('id', $id)->count();
        $ep = Empresa::find($id);

        if($ep_count != 0){
            $update_req = $request->all();
            $ep->update([
                'razao_social' => $request->get('razao'),
                'cnpj' => $request->get('cnpj'),
                'nome_fantasia' => $request->get('nome_fantasia'),
                'ddd' => $request->get('ddd'),
                'telefone' => $request->get('telefone'),
                'nome_contato' => $request->get('nome_contato')
            ]);
            //$json = ['data' => ['empresa' => $ep,'msg' => 'Update feito com sucesso']];
            $json = ['msg' => ['Update feito com sucesso']];
            return response()->json($json , 200);
        }else{
            return response()->json(['data' => ['msg' => 'Esta Empresa nao pode ser atualizada porque não existe']], 500);
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

        $emp = Empresa::where('id', $id)->get();
        $teste = count($emp);
        if($teste != 0 ){
            $data = ['data' => [$emp]];
            return response()->json($emp,200);
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
        $empresa_count = Empresa::where('id', $id)->count();
        $empresa = Empresa::find($id);
        if($empresa_count != 0){
            $empresa->delete();
            return response()->json(['data' => ['msg' => 'Empresa removida com sucesso!','id' => $i ]], 200);
        }else{
            return response()->json(['data' => ['msg' => 'Esta Empresa nao pode ser removida porque nao existe']], 500);
        }
        //return response()->json($medicao ,201);
        $json_medicao = ['data' => [$empresa]];
        return response()->json($json_medicao ,201);
    }

}
