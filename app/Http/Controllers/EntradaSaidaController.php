<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;
use Validator;
use App\EntradaSaida;

class EntradaSaidaController extends Controller
{
	/**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');

    }

    
    
    public function listar(){

        $existeEntradaSaida = EntradaSaida::where('idUser', Auth::user()->id)->get();
        
        if(count($existeEntradaSaida) > 0) {
            $entradasSaidas = EntradaSaida::where('idUser', Auth::user()->id)->orderBy('data', 'desc')->get();
                                        
        } else {
            $entradasSaidas = "";
        }

        return view('entradaSaida.listar',['entradasSaidas' => $entradasSaidas] ); 
    }

    public function cadastrar() {
        return view('entradaSaida.cadastrar');
    }

    public function inserir(Request $request)
    {
        $dados = $request->except('_token'); 

        $rules = array(
            'tipo' => 'required',
            'data' => 'required',
            'local' => 'required',
            'valor' => 'required',
        );

        $validator = Validator::make($dados, $rules);
        if($validator->fails()) {
            return redirect()->back()->withInput()->withErrors($validator);
        }

        unset($dados['inserir']);
        $dados['valor'] = str_replace(",", ".", $dados['valor']);
        
        $entradaSaida = EntradaSaida::create($dados);
        if($dados['tipo'] == 1){
            $request->session()->flash('alert-success', 'Nova entrada adicionada com sucesso!');
        } else {
            $request->session()->flash('alert-success', 'Nova despesa adicionada com sucesso!');
        }
        return redirect()->route('listarEntradaSaida');
    }

    public function editar($id){

        $entradaSaidaEdit = EntradaSaida::where('id','=', $id)
                                ->where('idUser','=', Auth::user()->id)
                                ->get();

        return view('EntradaSaida.cadastrar', ['entradaSaidaEdit' => $entradaSaidaEdit]);
    }

    public function atualizar(Request $request){

        $dados = $request->except('_token'); 

        $rules = array(
            'tipo' => 'required',
            'data' => 'required',
            'local' => 'required',
            'valor' => 'required',
        );

        $validator = Validator::make($dados, $rules);
        if($validator->fails()) {
            return redirect()->back()->withInput()->withErrors($validator);
        }
        
        unset($dados['salvar']);
        $dados['valor'] = str_replace(",", ".", $dados['valor']);
        $dados['updated_at'] = date('Y-m-d H:i:s');
        
        $poupanca = EntradaSaida::where('id', $dados['id'])
                ->update($dados);

        if($dados['tipo'] == 1){
            $request->session()->flash('alert-success', 'Entrada atualizada com sucesso!');
        } else {
            $request->session()->flash('alert-success', 'Despesa atualizada com sucesso!');
        }
        return redirect()->route('listarEntradaSaida');
    }

     public function delete($id) {
        $poupanca = EntradaSaida::destroy($id);
        return response(['msg' => 'success']);
    }

}
