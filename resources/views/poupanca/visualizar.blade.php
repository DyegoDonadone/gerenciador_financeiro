@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                  <a href="{{ route('home') }}">Dashboard</a> / 
                  <a href="{{ route('poupanca') }}">Poupança</a> /
                  <span class="active">Dados da Poupança</span>                
                </div>

                <div class="panel-body">
                    <div class="col-md-3">
                         @include('parts.menu')
                    </div>
                    
                    <div class="col-md-9">
                        <div class="row col-md-12">
                            <p class="titulo"> Dados da Poupança </p>
                        </div>
                          <div class="row col-md-12">
                            @foreach ($poupancaVisualizar as $poupanca)
                            	<p><span class="titulo">Banco:</span> {{ $poupanca->banco }}</p>
                            	<p><span class="titulo">Agência/Conta:</span> {{ $poupanca->agencia }}/{{ $poupanca->conta }}</p>
                            	<p><span class="titulo">Saldo:</span> R$ {{ number_format($poupanca->saldo, 2, ',', '') }}</p>
                            	<p><span class="titulo">Criado:</span> {{ date_format($poupanca->created_at, 'd/m/Y H:i:s') }}</p>
                            	<p><span class="titulo">Atualizado:</span> {{ date_format($poupanca->updated_at, 'd/m/Y H:i:s') }}</p>
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


