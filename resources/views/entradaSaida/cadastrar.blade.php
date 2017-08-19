@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                  <a href="{{ route('home') }}">Dashboard</a> / 
                  <a href="{{ route('listarEntradaSaida') }}">Entrada/Despesa</a> /
                  @if(!isset($entradaSaidaEdit))
                  <span class="active">Nova Entrada/Despesa</span>
                  @else
                  <span class="active">Editar Entrada/Despesa</span>
                  @endif
                </div>

                <div class="panel-body">
                    <div class="col-md-3">
                         @include('parts.menu')
                    </div>
                    
                    <div class="col-md-9">
                        <div class="row col-md-12">
                            @if(!isset($entradaSaidaEdit))
                                <p class="titulo"> Nova Entrada/Despesa</p>
                            @else
                                <p class="titulo">Editar Entrada/Despesa</p>
                            @endif
                        </div>
                            
                        @if(!isset($entradaSaidaEdit))
                        <div class="row col-md-12">
                            <form method="post" class="form" action="{{ route('inserirEntradaSaida') }}">
                                {{ csrf_field() }}
                                <label class="hide"><input type="text" name="idUser" value="{{ Auth::user()->id }}"></label>
                                
                                <label class="col-xs-12 .col-sm-6 .col-lg-8">
                                <span class="titulosCampos">Tipo</span>
                                    <select name="tipo" value="{{ old('tipo') }}">
                                        <option value="1">Entrada</option>
                                        <option value="2">Despesa</option>
                                    </select>
                                    @if ($errors->has('tipo')) <span class="alertas">{{ $errors->first('tipo') }}</span> @endif
                                </label>

                                <label class="col-xs-12 .col-sm-6 .col-lg-8">
                                <span class="titulosCampos">Local</span>
                                <input type="text" name="local" value="{{ old('local') }}" placeholder="local">
                                @if ($errors->has('local')) <span class="alertas">{{ $errors->first('local') }}</span> @endif
                                </label>
                                
                                <label class="col-xs-12 .col-sm-6 .col-lg-8">
                                <span class="titulosCampos">Data</span>
                                <input type="date" name="data" value="{{ old('data') }}">
                                 @if ($errors->has('data')) <span class="alertas">{{ $errors->first('data') }}</span> @endif
                                </label>

                                <label class="col-xs-12 .col-sm-6 .col-lg-8">
                                <span class="titulosCampos">Valor</span>
                                <input type="text" name="valor" value="{{ old('valor') }}" placeholder="0,00">
                                 @if ($errors->has('valor')) <span class="alertas">{{ $errors->first('valor') }}</span> @endif
                                </label>
                                
                                <label><input type="submit" name="inserir" value="Inserir" class="btn btn-success btn-small"></label>
                            </form>
                        </div>
                        @else
                            @foreach ($entradaSaidaEdit as $entradaSaidas)
                            <div class="row col-md-12">
                                <form method="post" action="{{ route('atualizarEntradaSaida')}}">
                                {{ csrf_field() }}
                                <label class="hide"><input type="text" name="idUser" value="{{ Auth::user()->id }}"></label>
                                <label class="hide"><input type="text" name="id" value="{{ $entradaSaidas->id }}"></label>
                                
                                <label class="col-xs-12 .col-sm-6 .col-lg-8">
                                <span class="titulosCampos">Tipo</span>
                                    <select name="tipo" value="{{ $entradaSaidas->tipo }}">
                                        <option value="1">Entrada</option>
                                        <option value="2">Despesa</option>
                                    </select>
                                    @if ($errors->has('tipo')) <span class="alertas">{{ $errors->first('tipo') }}</span> @endif
                                </label>

                                <label class="col-xs-12 .col-sm-6 .col-lg-8">
                                <span class="titulosCampos">local</span>
                                <input type="text" name="local" value="{{ $entradaSaidas->local }}" placeholder="local">
                                @if ($errors->has('local')) <span class="alertas">{{ $errors->first('local') }}</span> @endif
                                </label>
                                
                                <label class="col-xs-12 .col-sm-6 .col-lg-8">
                                <span class="titulosCampos">Data</span>
                                <input type="date" name="data" value="{{ $entradaSaidas->data }}">
                                 @if ($errors->has('data')) <span class="alertas">{{ $errors->first('data') }}</span> @endif
                                </label>

                                <label class="col-xs-12 .col-sm-6 .col-lg-8">
                                <span class="titulosCampos">Valor</span>
                                <input type="text" name="valor" value="{{ $entradaSaidas->valor }}" placeholder="0,00">
                                 @if ($errors->has('valor')) <span class="alertas">{{ $errors->first('valor') }}</span> @endif
                                </label>
                                                                
                                <label><input type="submit" name="salvar" value="Salvar" class="btn btn-success btn-small"></label>
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


