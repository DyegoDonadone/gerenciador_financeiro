@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                  <a href="{{ route('home') }}">Dashboard</a> / 
                  <a href="{{ route('poupanca') }}">Poupança</a> /
                  @if(!isset($movimentoEdit))
                  <span class="active">Nova Entrada</span>
                  @else
                  <span class="active">Editar Entrada</span>
                  @endif
                </div>

                <div class="panel-body">
                    <div class="col-md-3">
                         @include('parts.menu')
                    </div>
                    
                    <div class="col-md-9">
                        <div class="row col-md-12">
                            @if(!isset($movimentoEdit))
                                <p class="titulo"> Nova Entrada </p>
                            @else
                                <p class="titulo"> Editar Entrada </p>
                            @endif
                        </div>
                            
                        @if(!isset($movimentoEdit))
                        <div class="row col-md-12">
                            <form method="post" class="form" action="{{ route('inserirMovimento') }}">
                                {{ csrf_field() }}
                                <label class="hide"><input type="text" name="idUser" value="{{ Auth::user()->id }}"></label>
                                
                                <label class="col-xs-12 .col-sm-6 .col-lg-8">
                                <span class="titulosCampos">Data</span>
                                <input type="date" name="data" value="{{ old('data') }}">
                                @if ($errors->has('data')) <span class="alertas">{{ $errors->first('data') }}</span> @endif
                                </label>
                                
                                <label class="col-xs-12 .col-sm-6 .col-lg-8">
                                <span class="titulosCampos">Operação</span>
                                <select name="tipo" value="{{ old('tipo') }}">
                                	<option value="1">Depósito</option>
                                	<option value="2">Saque</option>
                                	<option value="3">Transferência +</option>
                                	<option value="4">Transferência -</option>
                                </select>
                                @if ($errors->has('tipo')) <span class="alertas">{{ $errors->first('tipo') }}</span> @endif
                                </label>

                                <label class="col-xs-12 .col-sm-6 .col-lg-8">
                                	<input type="text" name="idPoupanca" class="hide" value="{{ $idPoupanca }}">
                                </label>
                                
                                <label class="col-xs-12 .col-sm-6 .col-lg-8">
                                <span class="titulosCampos">Valor</span>
                                <input type="number" step="any" value="{{ old('valor') }}" name="valor" placeholder="1000,00">
                                 @if ($errors->has('valor')) <span class="alertas">{{ $errors->first('valor') }}</span> @endif
                                </label>
                                
                                <label>
                                	<input type="submit" name="inserir" value="Inserir" class="btn btn-success btn-small">
                                </label>

                            </form>
                        </div>
                        @else
                            @foreach ($movimentoEdit as $movimento)
                            <div class="row col-md-12">
                                <form method="post" class="form" action="{{ route('atualizarMovimento') }}">
                                {{ csrf_field() }}
                                <label class="hide"><input type="text" name="idUser" value="{{ Auth::user()->id }}"></label>
                                <label class="hide"><input type="text" name="id" value="{{ $movimento->id }}"></label>
                                <label class="col-xs-12 .col-sm-6 .col-lg-8">
                                <span class="titulosCampos">Data</span>
                                <input type="date" name="data" value="{{ $movimento->data }}">
                                @if ($errors->has('data')) <span class="alertas">{{ $errors->first('data') }}</span> @endif
                                </label>
                                
                                <label class="col-xs-12 .col-sm-6 .col-lg-8">
                                <span class="titulosCampos">Operação</span>
                                <select name="tipo" value="{{ $movimento->tipo }}" class="bloqueado" style="pointer-events: none">
                                    <option value="1" {{ $movimento->tipo == '1'?'selected':'' }}>Depósito</option>
                                    <option value="2" {{ $movimento->tipo == '2'?'selected':'' }}>Saque</option>
                                    <option value="3" {{ $movimento->tipo == '3'?'selected':'' }}>Transferência +</option>
                                    <option value="4" {{ $movimento->tipo == '4'?'selected':'' }}>Transferência -</option>
                                </select><i class="fa fa-ban m-l-5" aria-hidden="true"></i>
                                @if ($errors->has('tipo')) <span class="alertas">{{ $errors->first('tipo') }}</span> @endif
                                </label>

                                <label class="col-xs-12 .col-sm-6 .col-lg-8">
                                    <input type="text" name="idPoupanca" class="hide" value="{{ $movimento->idPoupanca }}">
                                </label>
                                
                                <label class="col-xs-12 .col-sm-6 .col-lg-8">
                                <span class="titulosCampos">Valor</span>
                                <input type="number" step="any" value="{{ $movimento->valor }}" name="valor" placeholder="1000,00">
                                 @if ($errors->has('valor')) <span class="alertas">{{ $errors->first('valor') }}</span> @endif
                                </label>
                                
                                <label>
                                    <input type="submit" name="salvar" value="Salvar" class="btn btn-success btn-small">
                                </label>

                            </form>
	                        </div>
                            @endforeach

                        @endif
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


