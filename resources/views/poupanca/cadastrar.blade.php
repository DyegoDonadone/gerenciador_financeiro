@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                  <a href="{{ route('home') }}">Dashboard</a> / 
                  <a href="{{ route('poupanca') }}">Poupança</a> /
                  @if(!isset($poupancaEdit))
                  <span class="active">Nova Poupança</span>
                  @else
                  <span class="active">Editar Poupança</span>
                  @endif
                </div>

                <div class="panel-body">
                    <div class="col-md-3">
                         @include('parts.menu')
                    </div>
                    
                    <div class="col-md-9">
                        <div class="row col-md-12">
                            @if(!isset($poupancaEdit))
                                <p class="titulo"> Nova Poupança </p>
                            @else
                                <p class="titulo">Editar Poupança </p>
                            @endif
                        </div>
                            
                        @if(!isset($poupancaEdit))
                        <div class="row col-md-12">
                            <form method="post" class="form" action="{{ route('inserirPoupanca') }}">
                                {{ csrf_field() }}
                                <label class="hide"><input type="text" name="idUser" value="{{ Auth::user()->id }}"></label>
                                
                                <label class="col-xs-12 .col-sm-6 .col-lg-8">
                                <span class="titulosCampos">Banco</span>
                                <input type="text" name="banco" value="{{ old('banco') }}" placeholder="Banco">
                                @if ($errors->has('banco')) <span class="alertas">{{ $errors->first('banco') }}</span> @endif
                                </label>
                                
                                <label class="col-xs-12 .col-sm-6 .col-lg-8">
                                <span class="titulosCampos">Agência</span>
                                <input type="text" name="agencia" value="{{ old('agencia') }}" placeholder="0000">
                                 @if ($errors->has('agencia')) <span class="alertas">{{ $errors->first('agencia') }}</span> @endif
                                </label>

                                <label class="col-xs-12 .col-sm-6 .col-lg-8">
                                <span class="titulosCampos">Conta</span>
                                <input type="text" name="conta" value="{{ old('conta') }}" placeholder="00000000-0">
                                 @if ($errors->has('conta')) <span class="alertas">{{ $errors->first('conta') }}</span> @endif
                                </label>
                                
                                <label class="col-xs-12 .col-sm-6 .col-lg-8">
                                <span class="titulosCampos">Saldo</span>
                                <input type="number" step="any" value="{{ old('saldo') }}" name="saldo" placeholder="1000,00">
                                 @if ($errors->has('saldo')) <span class="alertas">{{ $errors->first('saldo') }}</span> @endif
                                </label>
                                
                                <label><input type="submit" name="inserir" value="Inserir" class="btn btn-success btn-small"></label>
                            </form>
                        </div>
                        @else
                            @foreach ($poupancaEdit as $poupancas)
                            <div class="row col-md-12">
                                <form method="post" action="{{ route('atualizarPoupanca')}}">
                                {{ csrf_field() }}
                                <label class="hide"><input type="text" name="idUser" value="{{ Auth::user()->id }}"></label>
                                <label class="hide"><input type="text" name="id" value="{{ $poupancas->id }}"></label>
                                
                                <label class="col-xs-12 .col-sm-6 .col-lg-8">
                                <span class="titulosCampos">Banco</span>
                                <input type="text" name="banco" value="{{ $poupancas->banco }}" placeholder="Banco">
                                @if ($errors->has('banco')) <span class="alertas">{{ $errors->first('banco') }}</span> @endif
                                </label>
                                
                                <label class="col-xs-12 .col-sm-6 .col-lg-8">
                                <span class="titulosCampos">Agencia</span>
                                <input type="text" name="agencia" value="{{ $poupancas->agencia }}" placeholder="0000">
                                @if ($errors->has('agencia')) <span class="alertas">{{ $errors->first('agencia') }}</span> @endif
                                </label>
                                
                                <label class="col-xs-12 .col-sm-6 .col-lg-8">
                                <span class="titulosCampos">Conta</span>
                                <input type="text" name="conta" value="{{ $poupancas->conta }}" placeholder="00000000-0">
                                @if ($errors->has('conta')) <span class="alertas">{{ $errors->first('conta') }}</span> @endif
                                </label>
                                
                                <label class="col-xs-12 .col-sm-6 .col-lg-8">
                                <span class="titulosCampos">Saldo</span>
                                <input class="bloqueado" type="number" step="any" name="saldo" value="{{ number_format($poupancas->saldo, 2, '.', '') }}" readonly="readonly"><i class="fa fa-ban m-l-5" aria-hidden="true"></i>
                                 @if ($errors->has('saldo')) <span class="alertas">{{ $errors->first('saldo') }}</span> @endif
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


