<div class="content">
  <div class="container-fluid">
    <div class="row">
      <div class="col-md-12">
        <div class="card">
          <div class="card-header card-header-primary">
            <h4 class="card-title ">{{ $title }}</h4>
          </div>
          <div class="card-body">
			<div class="row">
				<div class="col-md-12">
					{!! Form::open(['route' => $ruta["search"], 'method' => 'POST' ,'onsubmit' => 'return false;', 'class' => 'form-inline', 'role' => 'form', 'autocomplete' => 'off', 'id' => 'formBusqueda'.$entidad]) !!}
					{!! Form::hidden('page', 1, array('id' => 'page')) !!}
					{!! Form::hidden('accion', 'listar', array('id' => 'accion')) !!}
					<div class="form-group">
						{!! Form::label('codigo', 'Código:') !!}
						{!! Form::text('codigo', '', array('class' => 'form-control input-xs', 'id' => 'codigo')) !!}
					</div>
					<div class="form-group">
						{!! Form::label('descripcion', 'Descripción:') !!}
						{!! Form::text('descripcion', '', array('class' => 'form-control input-xs', 'id' => 'descripcion')) !!}
					</div>
					<div class="form-group">
						{!! Form::label('placa', 'Placa:') !!}
						{!! Form::text('placa', '', array('class' => 'form-control input-xs', 'id' => 'placa')) !!}
					</div>
					<div class="form-group">
						{!! Form::label('area', 'Area:') !!}
						{!! Form::text('area', '', array('class' => 'form-control input-xs', 'id' => 'area')) !!}
					</div>
					<div class="form-group">
						{!! Form::label('filas', 'Filas a mostrar:')!!}
						{!! Form::selectRange('filas', 1, 30, 20, array('class' => 'form-control input-xs', 'onchange' => 'buscar(\''.$entidad.'\')')) !!}
					</div>
					{!! Form::button('<i class="material-icons">search</i>Buscar', array('class' => 'btn btn-success btn-xs', 'id' => 'btnBuscar', 'onclick' => 'buscar(\''.$entidad.'\')')) !!}
					{!! Form::button('<i class="material-icons">add</i>Nuevo', array('class' => 'btn btn-info btn-xs', 'id' => 'btnNuevo', 'onclick' => 'modal (\''.URL::route($ruta["create"], array('listar'=>'SI')).'\', \''.$titulo_registrar.'\', this);')) !!}
					{!! Form::close() !!}
				</div>
			</div>
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