@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                  <a href="{{ route('home') }}">Dashboard</a> / 
                  <a href="{{ route('poupanca') }}">Poupança</a> /
                  <span class="active">Dados do Movimento</span>                
                </div>

                <div class="panel-body">
                    <div class="col-md-3">
                         @include('parts.menu')
                    </div>
                    
                    <div class="col-md-9">
                        <div class="row col-md-12">
                            <p class="titulo"> Dados do Movimento </p>
                        </div>
                          <div class="row col-md-12">
                            @foreach ($movimentoVisualizar as $movimento)
                            	<p><span class="titulo">Data:</span> {{ date("d/m/Y", strtotime($movimento->data)) }}</p>

                              @if($movimento->tipo == 1)
                                <p><span class="titulo">Tipo:</span> Deposito </p>
                              @elseif($movimento->tipo ==2 )
                                <p><span class="titulo">Tipo:</span> Saque </p>
                              @elseif($movimento->tipo == 3 )
                                <p><span class="titulo">Tipo:</span> Transferencia + </p>
                              @else
                                <p><span class="titulo">Tipo:</span> Transferencia - </p>
                              @endif

                            	
                            	<p><span class="titulo">Valor:</span> R$ {{ number_format($movimento->valor, 2, ',', '') }}</p>
                            	<p><span class="titulo">Criado:</span> {{ date_format($movimento->created_at, 'd/m/Y H:i:s') }}</p>
                            	<p><span class="titulo">Atualizado:</span> {{ date_format($movimento->updated_at, 'd/m/Y H:i:s') }}</p>
                            @endforeach
                          </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
  $('ul .btnModulos').click(function(e) {
    e.preventDefault();
    $(this).closest("li").find("[class^='ul_submenu']").slideToggle();
  });
</script>
@endsection