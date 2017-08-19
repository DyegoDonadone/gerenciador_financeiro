@extends('layouts.app')

@section('content')
<div class="container">
  <div class="row">
    <div class="col-md-12">
      <div class="panel panel-default">
        <div class="panel-heading">
          <a href="{{ route('home') }}">Dashboard</a> / 
          <span class="active">Entrada/Despesa</span>
        </div>

        <div class="panel-body">
          <div class="col-md-3">
            @include('parts.menu')
          </div>
            
          <div class="col-md-9">
            <div class="row col-md-9">
              <div class="flash-message">
                @foreach (['danger', 'warning', 'success', 'info'] as $msg)
                  @if(Session::has('alert-' . $msg))

                  <p class="alert alert-{{ $msg }}">{{ Session::get('alert-' . $msg) }} <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a></p>
                  @endif
                @endforeach
              </div>
            </div>
            <div class="row col-md-2">
              
            </div>
            <div class="row col-md-2 m-b-5">
              <a href="{{ route('novaEntradaSaida') }}" class="btn btn-sm btn-primary m-b-5">
                <i class="fa fa-plus" aria-hidden="true"></i> Entrada/Despesa
              </a>
            </div>                     
            <div class="row col-md-12" id="tabelaVisual">
              <table id="example" class="display m-t-5" cellspacing="0">
                <thead>
                  <tr>
                    <th width="15"></th>
                    <th>Data</th>
                    <th>Local</th>
                    <th>Valor</th>
                    <th>Ações</th>
                  </tr>
                </thead>
                  <tbody>
                    @if ($entradasSaidas != "")
                     @foreach ($entradasSaidas as $entradaSaida)
                      <tr>
                        @if($entradaSaida->tipo == 1)
                          <td><i class="positivo fa fa-chevron-up" aria-hidden="true"></i></td>
                        @else
                          <td><i class="negativo fa fa-chevron-down" aria-hidden="true"></i></td>
                        @endif
                        <td>{{ date("d/m/Y", strtotime($entradaSaida->data)) }}</td>
                        <td>{{ $entradaSaida->local }}</td>
                        <td>R$ {{ number_format($entradaSaida->valor, 2, ',', '') }}</td>
                        <td>
                          <a href="{{ route('editarEntradaSaida') }}/{{ $entradaSaida->id }}" name="editaPoupanca" class="editaPoupanca btn  btn-primary btn-sm m-l-5 m-b-5" title="Editar">
                            <i class="fa fa-pencil-square-o" aria-hidden="true"></i>
                          </a>
                          <button name="excluirPoupanca" class="excluirPoupanca btn btn-danger btn-sm m-l-5 m-b-5" data-id="{{ $entradaSaida->id }}" data-token="{{ csrf_token() }}" title="Excluir">
                            <i class="corretorExcluir fa fa-trash-o" aria-hidden="true"></i>
                          </button>
                        </td>
                      </tr>
                     @endforeach
                    @endif
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- Modal confirmação exclusão -->
<div class="modal fade" id="confirm-delete" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
      <div class="modal-content">
          <div class="modal-header">
              Excluir registro?
          </div>
          <div class="modal-body">
              Confirma a exclusão deste registro?<br>
          </div>
          <div class="modal-footer">
              <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
              <a class="btn btn-danger btn-ok">Deletar</a>
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

    $( ".excluirPoupanca" ).click(function() {
      var idEntradaSaida = $(this).data("id");
      var token = $(this).data("token"); 
      var $meu_alerta = $("#confirm-delete");
      
      $meu_alerta.modal();
      $meu_alerta.find(".btn-ok").on("click", function(){
      
        $.ajax ({
          url: "{{ route('deleteEntradaSaida') }}/"+idEntradaSaida,
          type: 'DELETE',
          dataType: "JSON",
          data: {
              "id": idEntradaSaida,
              "_method": 'DELETE',
              "_token": token,
          },
          success: function () {
            $('#confirm-delete').modal('toggle');
            window.location.reload();
          }
        });
        return false;
      });
    });
  </script>
@endsection


