<div class="content">
  <div class="container-fluid">
    <div class="row">
      <div class="col-md-12">
        <div class="card">
          <div class="card-header card-header-info">
            <h4 class="card-title ">{{ $title }}</h4>
          </div>
          <div class="card-body">
						{!! Form::open(['route' => $ruta["search"], 'method' => 'POST' ,'onsubmit' => 'return false;', 'class' => 'row', 'role' => 'form', 'autocomplete' => 'off', 'id' => 'formBusqueda'.$entidad]) !!}
						{!! Form::hidden('page', 1, array('id' => 'page')) !!}
						{!! Form::hidden('accion', 'listar', array('id' => 'accion')) !!}
						<div class="col-4 col-sm-3 col-md-2 col-lg-2">
							{!! Form::label('estado', 'Estado:') !!}
							{!! Form::select('estado', array('all' => 'TODOS', 'activos' => 'ACTIVOS', 'desactivados' => 'DESACTIVADOS'), 'activos', array('class' => 'form-control input-xs', 'onchange' => 'buscar(\''.$entidad.'\')', 'id' => 'estado')) !!}
						</div>
						<div class="col-8 col-sm-9 col-md-3 col-lg-3">
							{!! Form::label('filter', 'Codigo/descripción:') !!}
							{!! Form::text('filter', '', array('class' => 'form-control input-xs', 'id' => 'filter')) !!}
						</div>
						<div class="col-9 col-sm-6 col-md-3 col-lg-3">
							{!! Form::label('unidad', 'Unidad:') !!}
							{!! Form::select('unidad', $cboUnidades, 'all', array('class' => 'form-control input-xs', 'onchange' => 'buscar(\''.$entidad.'\')', 'id' => 'unidad')) !!}
						</div>
						<div class="col-3 col-sm-2 col-md-2 col-lg-1">
							{!! Form::label('filas', 'Filas')!!}
							{!! Form::selectRange('filas', 1, 30, 20, array('class' => 'form-control input-xs', 'onchange' => 'buscar(\''.$entidad.'\')')) !!}
						</div>
						<div class="col-12 col-sm-4 col-md-2 col-lg-3 d-flex justify-content-around align-items-center">
							{!! Form::button('<i class="material-icons">search</i>Buscar', array('class' => 'btn btn-success p-2 pl-1 pr-1', 'id' => 'btnBuscar', 'onclick' => 'buscar(\''.$entidad.'\')')) !!}
							{!! Form::button('<i class="material-icons">add</i>Nuevo', array('class' => 'btn btn-info p-2 pl-1 pr-1', 'id' => 'btnNuevo', 'onclick' => 'modal (\''.URL::route($ruta["create"], array('listar'=>'SI')).'\', \''.$titulo_registrar.'\', this);')) !!}
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
		$(IDFORMBUSQUEDA + '{{ $entidad }} :input[id="filter"]').keyup(function (e) {
			var key = window.event ? e.keyCode : e.which;
			if (key == '13') {
				buscar('{{ $entidad }}');
			}
		});
	});
</script>