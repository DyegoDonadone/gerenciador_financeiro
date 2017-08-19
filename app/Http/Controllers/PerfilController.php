<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Perfil;
use App\User;
use Auth;
use Validator;



class PerfilController extends Controller
{
     public function dados(Request $request) {

     	$dados = $request->all();
     	unset($dados['_token']);

     	$dados['valorRenda'] = str_replace(",", ".", $dados['valorRenda']);

		$perfil = Perfil::create($dados);

		return "200";
    }

    public function listar(){
        
        $perfil = Perfil::where('idUser', Auth::user()->id)->get();
        
    	return view('perfil.listar', ['perfil' => $perfil]);
    }

    public function editar($id){
    	$perfil = Perfil::where('idUser', Auth::user()->id)
    					->where('id', $id)->get();

    	return view('perfil.editar', ['perfil' => $perfil]);
    }

    public function atualizar(Request $request){

        $dados = $request->except('_token'); 

        $rules = array(
            'nome' => 'required',
            'email' => 'required',
            'idade' => 'required',
            'valorRenda' => 'required',
        );

        $validator = Validator::make($dados, $rules);
        if($validator->fails()) {
            return redirect()->back()->withInput()->withErrors($validator);
        }
        
        unset($dados['salvar']);
        $dados['valorRenda'] = str_replace(",", ".", $dados['valorRenda']);
        $dados['updated_at'] = date('Y-m-d H:i:s');
        
        $perfil = Perfil::where('id', $dados['id'])
                ->update($dados);

        $auth = User::where('id', Auth::user()->id)
			         ->update(['name' => $dados['nome'], 'email' => $dados['email']]);

        $request->session()->flash('alert-success', 'Perfil atualizado com sucesso!');
        
        return redirect()->route('listarPerfil');
    }
}
