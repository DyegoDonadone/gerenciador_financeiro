@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                  <a class="active" href="{{ route('home') }}">Dashboard</a>
                </div>


                <div class="panel-body">
                    <div class="col-md-3">
                         @include('parts.menu')
                    </div>
                    
                    <div class="col-md-9">
                      
                      <!-- Informações Renda / Cotação  -->
                      <div class="row">
                        
                        <div class="col-md-3 alert alert-info">
                          @foreach ($cotacoes as $cotacao)
                            Cotação {{ $nome = $cotacao['nome'] }}: <b>R$
                            {{ $valor = $cotacao['valor'] }}</b>.
                          @endforeach
                        </div>

                        <div class="col-md-9 alert alert-default">
                          Sua Renda: <b>R$ {{number_format($valorRenda, 2, ',', '')}} | US$ {{number_format($valorRenda/$valor, 2, ',', '')}}</b>.
                        </div>

                      </div>
                      <!-- fim informações -->
                                         
                      <div class="row">
                        <div class="alert-info p-all col-md-12">
                          Despesas do mês {{ $date = date('m/Y') }}
                        </div>
                        <div class="col-md-12 m-t-5">
                          <table id="example" class="display m-t-5" cellspacing="0">
                            <thead>
                              <tr>
                                <th width="15"></th>
                                <th>Local</th>
                                <th>Data</th>
                                <th>Valor</th>  
                              </tr>
                            </thead>
                              <tbody>
                                @if ($movimentacoes != "")
                                @foreach ($movimentacoes as $registros)
                                <tr>
                                @if($registros->tipo == 1)
                                  <td><i class="positivo fa fa-chevron-up" aria-hidden="true"></i></td>
                                @else
                                  <td><i class="negativo fa fa-chevron-down" aria-hidden="true"></i></td>
                                @endif 
                                  <td>{{ $registros->local }} </td>
                                  <td> {{ date("d/m/Y", strtotime($registros->data)) }} </td>
                                  <td>R$ {{ number_format($registros->valor, 2, ',', '') }}</td>
                                </tr>
                                @endforeach
                                @endif
                            </tbody>
                          </table>
                        </div>
                      </div>

                      <div class="row m-t-5">
                        <div class="col-md-3 alert-danger m-r-5 p-all">
                          Total Despesas: R$ {{ $saidas }}.
                        </div>
                        <div class="col-md-3 alert-success m-r-5 p-all">
                          Total Entradas: R$ {{ $totalEntrada }}.
                        </div>
                        <div class="col-md-2 alert-info m-r-5 p-all">
                          Sobra: R$ {{ $sobra }}.
                        </div>
                      </div>
                      @if ($poupancas != "")
                        <div class="row m-t-5">
                        @foreach ($poupancas as $poupanca)
                        
                        <div class="col-md-3 alert alert-info m-t-5 m-r-5">
                          <span>Poupança {{ str_limit($poupanca->banco, 13)}}</span><br>
                          <span class="small">Saldo: R$ {{  number_format($poupanca->saldo, 2, ',', '') }}</span>
                        </div>
                      
                        @endforeach

                       </div>
                      @endif

                        <!-- modal Renda -->

                        <button id="btnRenda" type="button" class="btn btn-primary hide" data-toggle="modal" data-target=".bs-example-modal-sm">renda</button>

                        <div class="modal fade bs-example-modal-sm" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" data-backdrop="static">
                          <div class="modal-dialog modal-sm" role="document">
                            <div class="modal-content p-10" style="padding: 10px">
                              <p> Para o primeiro uso, <br> insira sua renda mensal no campo abaixo</p>
                              <form form class="form-horizontal" method="post" id="formulario">
                                  {{ csrf_field() }}
                                  <input type="text" name="idUser" value="{{ Auth::user()->id }}" class="hide">
                                  <input type="text" name="nome" value="{{ Auth::user()->name }}" class="hide">
                                  <input type="text" name="email" value="{{ Auth::user()->email }}" class="hide">
                                  <input type="text" name="idade" value="" class="hide">
                                  <input type="number" step="any" name="valorRenda" required="required" placeholder="1000,00">
                                  <button class="btn btn-success">Salvar</button>
                              </form>
                            </div>
                          </div>
                        </div>
                        <!-- Fim verifica renda -->
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@if(($valorRenda == "") || $valorRenda == null)
  <script type="text/javascript">
      $(document).ready(function () {
          $( "#btnRenda" ).trigger('click');

          $('#formulario').submit(function() {
            var dados = $('#formulario').serialize();

            $.ajax({
                type : 'POST',
                url  : '{{ route("dados") }}',
                data : dados,
                dataType: 'json',
                success :  function(response){
                    $('.bs-example-modal-sm').modal('hide');
                    location.reload();
                }
            });
            return false;
        });
      });

  </script>
@endif

  <script type="text/javascript">
      $('ul .btnModulos').click(function(e) {
        e.preventDefault();
        $(this).closest("li").find("[class^='ul_submenu']").slideToggle();
      });
  </script>

  <script>
    $(document).ready(function() {
        $('#example').DataTable( {
            "language": {
              "lengthMenu": "Mostrar _MENU_ registros por página",
              "zeroRecords": "Nenhum registro encontrado - sorry",
              "info": "Mostrando página _PAGE_ de _PAGES_",
              "infoEmpty": "Nenhum registro",
              "infoFiltered": "(filtrados from _MAX_ total records)",
              "search": "<i class='fa fa-search' aria-hidden='true'></i>"
            }
        } );
    } );
    </script>
@endsection


