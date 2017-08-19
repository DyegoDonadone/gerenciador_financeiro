@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                  <a href="{{ route('home') }}">Dashboard</a> / 
                  <a href="{{ route('listarPerfil') }}">Perfil</a> /
                  <span class="active">Editar Perfil</span>
                </div>

                <div class="panel-body">
                    <div class="col-md-3">
                         @include('parts.menu')
                    </div>
                    
                    <div class="col-md-9">
                        <div class="row col-md-12"> 
                            <p class="titulo">Editar Perfil</p>
                        </div>
                       
                            @foreach ($perfil as $perfil)
                            <div class="row col-md-12">
                                <form method="post" action="{{ route('atualizarPerfil')}}">
                                {{ csrf_field() }}
                                <label class="hide"><input type="text" name="idUser" value="{{ Auth::user()->id }}"></label>
                                <label class="hide"><input type="text" name="id" value="{{ $perfil->id }}"></label>
                                
                                <label class="col-xs-12 .col-sm-6 .col-lg-8">
                                 <span class="titulosCampos">nome</span>
                                 <input type="text" name="nome" value="{{ $perfil->nome }}" placeholder="nome">
                                 @if ($errors->has('nome')) <span class="alertas">{{ $errors->first('nome') }}</span> @endif
                                </label>

                                <label class="col-xs-12 .col-sm-6 .col-lg-8">
                                 <span class="titulosCampos">email</span>
                                 <input type="text" name="email" value="{{ $perfil->email }}" placeholder="email">
                                 @if ($errors->has('email')) <span class="alertas">{{ $errors->first('email') }}</span> @endif
                                </label>

                                <label class="col-xs-12 .col-sm-6 .col-lg-8">
                                 <span class="titulosCampos">idade</span>
                                 <input type="text" name="idade" value="{{ $perfil->idade }}" placeholder="idade">
                                 @if ($errors->has('idade')) <span class="alertas">{{ $errors->first('idade') }}</span> @endif
                                </label>

                                <label class="col-xs-12 .col-sm-6 .col-lg-8">
                                 <span class="titulosCampos">Renda</span>
                                 <input type="number" step="any" value="{{ $perfil->valorRenda }}" name="valorRenda" required="required" placeholder="1000,00">

                                 @if ($errors->has('valorRenda')) <span class="alertas">{{ $errors->first('valorRenda') }}</span> @endif
                                </label>

                                 
                                                                
                                <label><input type="submit" name="salvar" value="Salvar" class="btn btn-success btn-small"></label>
                            </form>
                        </div>
                            @endforeach
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


