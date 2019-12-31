<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\SecaoEstoque;

class SecaoEstoqueController extends Controller
{
    private $secaoestoque;

    public function __construct(SecaoEstoque $e){
        $this->secaoestoque = $e;
    }

    public function index(){

        if(sizeof($this->secaoestoque->all()) <= 0 ){
            return response()->json(['data' => ['msg' => 'Nenhum Estoque cadastrado']], 404);
        }
        else{
            return response()->json($this->secaoestoque->all(), 200);
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

        $scest = SecaoEstoque::where('id', $id)->get();
        $teste = count($scest);
        if($teste != 0 ){
            $data = ['data' => $scest];
            return response()->json($scest,200);
        }else{
            $empty = ['data' => ["Não existe nenhuma empresa com esse id"]];
            return response()->json($empty, 404);
        }

    }



    public function store(Request $request){

        $validator = Validator::make($request->all(),[
            'descricao' => 'required|string|max:25|unique:secao_estoques,descricao',
            'estoque_id' => 'required|numeric'
        ]);
        
        if(sizeof($validator->errors()) > 0){
            return response()->json($validator->errors(), 404);
        }

        try{
            SecaoEstoque::create([
                'descricao' => $request->get('descricao'),
                'estoque_id' => $request->get('estoque_id')
            ]);
            return response()->json(['data' => ['msg' => 'Seção cadastrada com sucesso'] ],200);
        }catch(Exception $e){
            return response()->json($e, 400);
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

        $scest_count = SecaoEstoque::where('id', $id)->count();
        $scest = SecaoEstoque::find($id);
        if($scest_count != 0){
            $scest->delete();
            return response()->json(['data' => ['msg' => 'Seção removida com sucesso!','id' => $i ]], 200);
        }else{
            return response()->json(['data' => ['msg' => 'Esta Seção nao pode ser removida porque nao existe']], 500);
        }
        //return response()->json($medicao ,201);
        $json = ['data' => [$scest]];
        return response()->json($json,201);

    }

    public function update(Request $request, $id){
        $i = ['id' => $id];
        $validatorid = Validator::make($i,[
            'id' => 'required|numeric'
        ]);
        $validator = Validator::make($request->all(),[
            'descricao' => 'required|string|max:25|unique:categoria_produtos,descricao',
            'estoque_id' => 'required|numeric'
        ]);
        
        if(sizeof($validator->errors()) > 0){
            return response()->json($validator->errors(), 404);
        }

        if(sizeof($validatorid->errors()) > 0 ){
            return response()->json($validatorid->errors(), 404);
        }

        $scest_count = SecaoEstoque::where('id', $id)->count();
        $scest = SecaoEstoque::find($id);

        if($scest_count != 0){
            $update_req = $request->all();
            $scest->update([
                'descricao' => $request->get('descricao'),
                'estoque_id' => $request->get('estoque_id')
            ]);
            //$json = ['data' => ['empresa' => $ep,'msg' => 'Update feito com sucesso']];
            $json = ['msg' => ['Update feito com sucesso']];
            return response()->json($json , 200);
        }else{
            return response()->json(['data' => ['msg' => 'Esta Seção nao pode ser atualizada porque não existe']], 500);
        }
        

    }


}
