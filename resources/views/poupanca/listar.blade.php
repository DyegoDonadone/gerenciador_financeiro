@extends('layouts.app')

@section('content')
<div class="container">
  <div class="row">
    <div class="col-md-12">
      <div class="panel panel-default">
        <div class="panel-heading">
          <a href="{{ route('home') }}">Dashboard</a> / 
          <span class="active">Poupança</span>
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
              <a href="{{ route('novaPoupanca') }}" class="btn btn-sm btn-primary m-b-5">
                <i class="fa fa-plus" aria-hidden="true"></i> Nova Poupança
              </a>
            </div>                     
            <div class="row col-md-12" id="tabelaVisual">
              <table id="example" class="display m-t-5" cellspacing="0">
                <thead>
                  <tr>
                    <th>Banco</th>
                    <th>Saldo</th>
                    <th>Ações</th>
                  </tr>
                </thead>
                  <tbody>
                    @if ($poupancas != "")
                     @foreach ($poupancas as $poupanca)
                      <tr>
                        <td>{{ $poupanca->banco }} <!-- <br> {{ $poupanca->conta }} --></td>
                        <td>R$ {{ number_format($poupanca->saldo, 2, ',', '') }}</td>
                        <td>
                          <a href="{{ route('listarMovimento') }}/{{ $poupanca->id }}" name="visualizaPoupanca" class="visualizaPoupanca btn btn-success btn-sm m-l-5 m-b-5" value="{{ $poupanca->id }}" title="Depósito/Saque">
                            <i class="fa fa-money" aria-hidden="true"></i>
                          </a>
                          <a href="{{ route('visualizarPoupanca') }}/{{ $poupanca->id }}" name="visualizaPoupanca" class="visualizaPoupanca btn btn-primary btn-sm m-l-5 m-b-5" value="{{ $poupanca->id }}" title="Visualizar">
                            <i class="fa fa-eye" aria-hidden="true"></i>
                          </a>
                          <a href="{{ route('editarPoupanca') }}/{{ $poupanca->id }}" name="editaPoupanca" class="editaPoupanca btn  btn-primary btn-sm m-l-5 m-b-5" title="Editar">
                            <i class="fa fa-pencil-square-o" aria-hidden="true"></i>
                          </a>
                          <button name="excluirPoupanca" class="excluirPoupanca btn btn-danger btn-sm m-l-5 m-b-5" data-id="{{ $poupanca->id }}" data-token="{{ csrf_token() }}" title="Excluir">
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
              Obs.: Todos os registros de depósitos e saques também serão excluídos! 
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
      var idPoupanca = $(this).data("id");
      var token = $(this).data("token"); 
      var $meu_alerta = $("#confirm-delete");
      
      $meu_alerta.modal();
      $meu_alerta.find(".btn-ok").on("click", function(){
      
        $.ajax ({
          url: "{{ route('deletePoupanca') }}/"+idPoupanca,
          type: 'DELETE',
          dataType: "JSON",
          data: {
              "id": idPoupanca,
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


