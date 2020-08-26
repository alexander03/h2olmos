<div class="content">
    <div class="container-fluid">
      <div class="row">
        <div class="col-md-12">
          <div class="card">
            <div class="card-header card-header-info">
              <h4 class="card-title ">{{ $title }}</h4>
            </div>
            <div class="card-body">
                  {!! Form::open(['route' => $ruta["search"], 'method' => 'POST' ,'onsubmit' => 'return false;', 'class' => 'row align-items-center', 'role' => 'form', 'autocomplete' => 'off', 'id' => 'formBusqueda'.$entidad]) !!}
                  {!! Form::hidden('page', 1, array('id' => 'page')) !!}
                  {!! Form::hidden('accion', 'listar', array('id' => 'accion')) !!}

                  <div class="col-12 col-sm-2">
                        <label for="id-date">Fecha de abast.</label>
                        <input type="date" name="date_abastecimiento" class="form-control" id="id-date">
                  </div>
                  <div class="col-12 col-sm-2">
                        <label for="id-ua">Codigo UA</label>
                        <input type="text" name="codigo_ua" class="form-control" id="id-ua">
                  </div>
                  <div class="col-12 col-sm-2">
                        <label for="id-grifo">Grifo</label>
                        <input type="text" name="grifo" class="form-control" id="id-grifo">
                  </div>
                  <div class="col-12 col-sm-2">
                        <label for="id-placa">Placa</label>
                        <input type="text" name="placa" class="form-control" id="id-placa">
                  </div>
                  <div class="col-12 col-sm-2">
                      {!! Form::label('filas', 'Filas a mostrar:')!!}
                      {!! Form::selectRange('filas', 1, 30, 20, array('class' => 'form-control input-xs', 'onchange' => 'buscar(\''.$entidad.'\')')) !!}
                  </div>
                  <div class="col-12 col-sm-2">
                    {!! Form::button('<i class="material-icons">search</i>Buscar', array('class' => 'btn btn-success btn-sm', 'id' => 'btnBuscar', 'onclick' => 'buscar(\''.$entidad.'\')')) !!}
                  </div>
                  <div class="col-12 col-sm-12 d-flex justify-content-center">
                      {!! Form::button('<i class="material-icons">add</i>Nuevo', array('class' => 'btn btn-info btn-sm', 'id' => 'btnNuevo', 'onclick' => 'modal (\''.URL::route($ruta["create"], array('listar'=>'SI')).'\', \''.$titulo_registrar.'\', this);')) !!}
                      <a href="{{ route('abastecimiento.excel.export') }}" class="btn btn-sm btn-dark">
                          <i class="material-icons">cloud_download</i> Exportar
                      </a>
                  </div>
                  {!! Form::close() !!}
                  <div class="table-responsive" id="listado{{ $entidad }}">
              </div>
          </div>
      </div>
  </div>
  
  <script>
      $(document).ready(function () {
          buscar('{{ $entidad }}');
          init(IDFORMBUSQUEDA+'{{ $entidad }}', 'B', '{{ $entidad }}');
          $(IDFORMBUSQUEDA + '{{ $entidad }} :input[id="descripcion"]').keyup(function (e) {
              var key = window.event ? e.keyCode : e.which;
              if (key == '13') {
                  buscar('{{ $entidad }}');
              }
          });
      });
  </script>
  