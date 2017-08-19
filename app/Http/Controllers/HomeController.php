<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Perfil;
use App\Poupanca;
use App\EntradaSaida;
use Auth;

class HomeController extends Controller
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

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        //consome API cotação

        function get_page($url) {
            $curl = curl_init();
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, True);
            curl_setopt($curl, CURLOPT_URL, $url);
            curl_setopt($curl,CURLOPT_USERAGENT,'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.7; rv:7.0.1) Gecko/20100101 Firefox/7.0.1');
            $return = curl_exec($curl);
            curl_close($curl);
            return $return;
        }

        $contents = json_decode(get_page('http://api.promasters.net.br/cotacao/v1/valores?moedas=USD&alt=json'), true);

        $cotacoes = $contents['valores'];

        $existePerfil = Perfil::select("valorRenda")->where('idUser', Auth::user()->id)->get();

        if (count($existePerfil) > 0) {
            $valorRenda = Perfil::select("valorRenda")->where('idUser', Auth::user()->id)->first()->valorRenda;
        } else {
            $valorRenda = 0;
        }

        $existePoupanca = Poupanca::where('idUser', Auth::user()->id)->get();
        if (count($existePoupanca) > 0) {
            $poupancas = Poupanca::where('idUser', Auth::user()->id)->get();
        } else {
            $poupancas = "";
        }
        
        //movimentação
        $existeEntradaSaida = EntradaSaida::where('idUser', Auth::user()->id)->get();
        
        $date = date('Y-m');
        $dateStart = date($date.'-01');
        $dateEnd = date($date.'-t');

        if(count($existeEntradaSaida) > 0) {
            $movimentacoes = EntradaSaida::where('idUser', Auth::user()->id)
                                         ->where('data', '>=', $dateStart)
                                         ->where('data', '<=', $dateEnd)->get();
                                        
        $entradas = 0;
        $saidas = 0;
        
        foreach ($movimentacoes as $value) {
            if ($value['tipo'] == 1) {
                $entradas = $value['valor']+$entradas;
                $entradas++;
            } else {
                $saidas = $value['valor'];
                $saidas++;
            }
        }
                                    
        } else {
            $movimentacoes = "";
            $entradas = 0;
            $saidas = 0;
            $sobra = 0;
        }

        

        $totalEntrada = $valorRenda + $entradas;
        $sobra = $totalEntrada - $saidas;
        
        return view('home', ['cotacoes' => $cotacoes, 
                             'valorRenda' => $valorRenda, 
                             'poupancas'=> $poupancas,
                             'totalEntrada' => $totalEntrada,
                             'saidas' => $saidas,
                             'sobra' => $sobra,
                             'movimentacoes' => $movimentacoes]);
    }
}
