<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Poupanca;
use App\PoupancaMovimento;
use Auth;
use Validator;

class PoupancaController extends Controller
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
    
    public function index() {
        $existePoupanca = Poupanca::where('idUser', Auth::user()->id)->get();
        if (count($existePoupanca) > 0) {
            $poupancas = Poupanca::where('idUser', Auth::user()->id)->get();
        } else {
            $poupancas = "";
        }

    	return view('Poupanca.listar', ['poupancas' => $poupancas]);
    }

    public function create() {

        return view('Poupanca.cadastrar');
    }

    public function insert(Request $request) {
        
        $dados = $request->except('_token'); 

        $rules = array(
            'banco' => 'required',
            'conta' => 'required',
            'agencia' => 'required',
            'saldo' => 'required',
        );

        $validator = Validator::make($dados, $rules);
        if($validator->fails()) {
            return redirect()->back()->withInput()->withErrors($validator);
        }
        
        unset($dados['inserir']);
        
        $dados['saldo'] = str_replace(",", ".", $dados['saldo']);

        $poupanca = Poupanca::create($dados);

        $existePoupanca = Poupanca::where('idUser', Auth::user()->id)->get();
        if (count($existePoupanca) > 0) {
            $poupancas = Poupanca::where('idUser', Auth::user()->id)->get();
        } else {
            $poupancas;
        }

        $request->session()->flash('alert-success', 'Nova conta adicionada com sucesso!');
        return redirect()->route('poupanca');
    }

    public function delete($id) {
        $poupanca = Poupanca::destroy($id);
        return response(['msg' => 'success']);
    }

    public function editar($id){

        $poupancaEdit = Poupanca::where('id','=', $id)
                                ->where('idUser','=', Auth::user()->id)
                                ->get();

        return view('Poupanca.cadastrar', ['poupancaEdit' => $poupancaEdit]);
    }

    public function atualizar(Request $request){

        $dados = $request->except('_token'); 

        $rules = array(
            'banco' => 'required',
            'conta' => 'required',
            'agencia' => 'required',
            'saldo' => 'required',
        );

        $validator = Validator::make($dados, $rules);
        if($validator->fails()) {
            return redirect()->back()->withInput()->withErrors($validator);
        }
        
        unset($dados['salvar']);
        $dados['saldo'] = str_replace(",", ".", $dados['saldo']);
        $dados['updated_at'] = date('Y-m-d H:i:s');
        
        $poupanca = Poupanca::where('id', $dados['id'])
                ->update($dados);

        $request->session()->flash('alert-success', 'Conta atualizada com sucesso!');
        return redirect()->route('poupanca');

    }

    public function visualizar($id){
        $poupancaVisualizar = Poupanca::where('id','=', $id)
                                ->where('idUser','=', Auth::user()->id)
                                ->get();

        return view('Poupanca.visualizar', ['poupancaVisualizar' => $poupancaVisualizar]);
    }

 /* Movimentação Poupança */

    public function listarMovimento($id){

        $poupancaSaldo = Poupanca::select('saldo')->where('id','=', $id)
                                ->where('idUser','=', Auth::user()->id)
                                ->get();
        
        $saldo = $poupancaSaldo[0]['saldo'];

        $existeMovimento = PoupancaMovimento::where('idPoupanca', $id)->where('idUser', Auth::user()->id)->get();
        if (count($existeMovimento) > 0) {
            $movimentos = PoupancaMovimento::where('idPoupanca', $id)->where('idUser', Auth::user()->id)->get();
        } else {
            $movimentos = "";
        }

        return view('Poupanca.listarMovimento', ['movimentos' => $movimentos, 'idPoupanca' => $id, 'saldoAtual' => $saldo]);
    }

    public function createMovimento($id) {

        return view('Poupanca.cadastrarMovimento', ['idPoupanca' => $id]);
    }
    
    public function insertMovimento(Request $request) {
        $dados = $request->except('_token'); 

        $rules = array(
            'data' => 'required',
            'tipo' => 'required',
            'valor' => 'required'
        );

        $validator = Validator::make($dados, $rules);
        if($validator->fails()) {
            return redirect()->back()->withInput()->withErrors($validator);
        }

        unset($dados['inserir']);

        $dados['valor'] = str_replace(",", ".", $dados['valor']);

        $saldoPoupanca = Poupanca::select('saldo')
                                ->where('id','=', $dados['idPoupanca'])
                                ->where('idUser','=', Auth::user()->id)
                                ->get();

        if(($dados['tipo'] == 1) || ($dados['tipo'] == 3)) {
            $saldoAtualizadoPoupanca = $saldoPoupanca[0]['saldo'] + $dados['valor'];
        } else {
            $saldoAtualizadoPoupanca = $saldoPoupanca[0]['saldo'] - $dados['valor'];
        }

        $movimentos = PoupancaMovimento::create($dados);

        $poupancaAtualizada = Poupanca::where('id', $dados['idPoupanca'])
                            ->update(['saldo' => $saldoAtualizadoPoupanca]);

        $request->session()->flash('alert-success', 'Nova entrada adicionada com sucesso!');
        return redirect()->route('poupanca');
    }

    public function editarMovimento($id){
        $movimentoEdit = PoupancaMovimento::where('id','=', $id)
                                ->where('idUser','=', Auth::user()->id)
                                ->get();

        return view('Poupanca.cadastrarMovimento', ['movimentoEdit' => $movimentoEdit]);
    }

    public function deleteMovimento($id){

        $movimento = PoupancaMovimento::select('valor', 'idPoupanca', 'tipo')->where('id', $id)->get();
        
        $saldoPoupanca = Poupanca::select('saldo')
                                ->where('id','=', $movimento[0]['idPoupanca'])
                                ->where('idUser','=', Auth::user()->id)
                                ->get();

        if(($movimento[0]['tipo'] == 1) || ($movimento[0]['tipo'] == 3)) {
            $saldoAtualizadoPoupanca = $saldoPoupanca[0]['saldo'] - $movimento[0]['valor'];
        } else {
            $saldoAtualizadoPoupanca = $saldoPoupanca[0]['saldo'] + $movimento[0]['valor'];
        }
        
        $poupancaAtualizada = Poupanca::where('id', $movimento[0]['idPoupanca'])
                            ->update(['saldo' => $saldoAtualizadoPoupanca]);

        $poupanca = PoupancaMovimento::destroy($id);
        
        return response(['msg' => 'success']);
    }

    public function atualizarMovimento(Request $request){
        $dados = $request->except('_token'); 

        $rules = array(
            'data' => 'required',
            'tipo' => 'required',
            'valor' => 'required'
        );

        $validator = Validator::make($dados, $rules);
        if($validator->fails()) {
            return redirect()->back()->withInput()->withErrors($validator);
        }
        
        unset($dados['salvar']);
        $dados['updated_at'] = date('Y-m-d H:i:s');
        $dados['valor'] = str_replace(",", ".", $dados['valor']);

        $valorMovimentoAnterior = PoupancaMovimento::select('valor')->where('id', $dados['id'])->get();
        
        $saldoPoupanca = Poupanca::select('saldo')
                                ->where('id','=', $dados['idPoupanca'])
                                ->where('idUser','=', Auth::user()->id)
                                ->get();

        if(($dados['tipo'] == 1) || ($dados['tipo'] == 3)) {
            $saldoAtualizadoPoupanca = ($saldoPoupanca[0]['saldo'] - $valorMovimentoAnterior[0]['valor']) + $dados['valor'];
            
        } else {
            $saldoAtualizadoPoupanca = ($saldoPoupanca[0]['saldo'] + $valorMovimentoAnterior[0]['valor']) - $dados['valor'];
        }
        
        $movimento = PoupancaMovimento::where('id', $dados['id'])
                ->update($dados);

        $poupancaAtualizada = Poupanca::where('id', $dados['idPoupanca'])
                            ->update(['saldo' => $saldoAtualizadoPoupanca]);

        $request->session()->flash('alert-success', 'movimento atualizado com sucesso!');
        return redirect()->route('poupanca');
    }

    public function visualizarMovimento($id){

        $movimentoVisualizar = PoupancaMovimento::where('id','=', $id)
                                ->where('idUser','=', Auth::user()->id)
                                ->get();

        return view('Poupanca.visualizarMovimento', ['movimentoVisualizar' => $movimentoVisualizar]);
    }

}
