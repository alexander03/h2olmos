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
			<div class="col-2 col-sm-2 col-md-2 col-lg-2">
				{!! Form::label('equipo_ua', 'Ua de equipo:') !!}
				{!! Form::text('equipo_ua', '', array('class' => 'form-control', 'id' => 'equipo_ua')) !!}
			</div>
			<div class="col-2 col-sm-2 col-md-2 col-lg-2">
				{!! Form::label('descripcion', 'Descripcion:') !!}
				{!! Form::text('descripcion', '', array('class' => 'form-control', 'id' => 'descripcion')) !!}
			</div>
			<div class="col-2 col-sm-2 col-md-2 col-lg-2">
				{!! Form::label('ua', 'Ua de proyecto:') !!}
				{!! Form::text('ua', '', array('class' => 'form-control', 'id' => 'ua')) !!}
			</div>
			<div class="col-2 col-sm-2 col-md-2 col-lg-2">
				{!! Form::label('filas', 'Filas a mostrar:')!!}
				{!! Form::selectRange('filas', 1, 30, 20, array('class' => 'form-control', 'onchange' => 'buscar(\''.$entidad.'\')')) !!}
			</div>
			<div class="col-1 col-sm-1 col-md-1 col-lg-1">
				{!! Form::label('anio', 'Año:') !!}
				{!! Form::text('anio', '', array('class' => 'form-control', 'id' => 'anio')) !!}
			</div>
			<div class="col-1 col-sm-1 col-md-1 col-lg-1">
				{!! Form::label('mes', 'Mes:') !!}
				{!! Form::text('mes', '', array('class' => 'form-control', 'id' => 'mes')) !!}
			</div>
			<div class="col-1 col-sm-1 col-md-1 col-lg-1">
				{!! Form::label('dia', 'Dia:') !!}
				{!! Form::text('dia', '', array('class' => 'form-control', 'id' => 'dia')) !!}
			</div>
			<div class="form-group">
				{!! Form::button('<i class="material-icons">search</i>Buscar', array('class' => 'btn btn-success btn-sm', 'id' => 'btnBuscar', 'onclick' => 'buscar(\''.$entidad.'\')')) !!}
				{!! Form::button('<i class="material-icons">add</i>Nuevo', array('class' => 'btn btn-info btn-sm', 'id' => 'btnNuevo', 'onclick' => 'modal (\''.URL::route($ruta["create"], array('listar'=>'SI')).'\', \''.$titulo_registrar.'\', this);')) !!}
				<a href="{{ route('controldiario.exportExcelReport') }}" target="_blank" class="btn btn-sm btn-primary" title="Exportar">
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