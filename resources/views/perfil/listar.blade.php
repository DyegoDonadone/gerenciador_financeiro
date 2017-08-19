@extends('layouts.app')

@section('content')
<div class="container">
  <div class="row">
    <div class="col-md-12">
      <div class="panel panel-default">
        <div class="panel-heading">
          <a href="{{ route('home') }}">Dashboard</a> / 
          <span class="active">Perfil</span>
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
  
            </div>                     
            <div class="row col-md-12" id="tabelaVisual">
              <table id="example" class="display m-t-5" cellspacing="0">
                <thead>
                  <tr>
                    <th>E-mail</th>
                    <th>Ação</th>
                  </tr>
                </thead>
                  <tbody>
                    @if ($perfil != "")
                     @foreach ($perfil as $perfil)
                      <tr>
                        
                        <td>{{ $perfil->email }}</td>
                        <td>
                          <a href="{{ route('editarPerfil') }}/{{ $perfil->id }}" name="editaPoupanca" class="editaPoupanca btn  btn-primary btn-sm m-l-5 m-b-5" title="Editar">
                            <i class="fa fa-pencil-square-o" aria-hidden="true"></i>
                          </a>

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


