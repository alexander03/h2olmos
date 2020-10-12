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

						<div class="col-lg-7 col-md-12 p-0 form-group input-group">
							{!! Form::label(null, 'Buscar por rango de Fecha de Registro inicial y final', array('class' => 'mb-0')) !!}
							<div class="col-12 p-0 form-group input-group">
								<div class="col-lg-6 col-md-6 col-sm-6 col-12 p-0 input-group">
									{!! Form::label('fecha_registro_inicial', 'Inicio', array('class' => 'col-3 p-0 mt-2')) !!}
									{!! Form::date('fecha_registro_inicial', date('Y-m-01'), array('class' => 'col-7 form-control input-xs', 'id' => 'fecha_registro_inicial')) !!}
									<div class="col-1 p-0">
										<button class="btn btn-warning p-1" id="btn_remove_fecha_registro_inicial">
											<span class="material-icons outlined">close</span>
										</button>
									</div>
								</div>
								<div class="col-lg-6 col-md-6 col-sm-6 col-12 p-0 input-group">
									{!! Form::label('fecha_registro_final', 'Final', array('class' => 'col-3 p-0 mt-2')) !!}
									{!! Form::date('fecha_registro_final', '', array('class' => 'col-7 form-control input-xs', 'id' => 'fecha_registro_final')) !!}
									<div class="col-1 p-0">
										<button class="btn btn-warning p-1" id="btn_remove_fecha_registro_final">
											<span class="material-icons">close</span>
										</button>
									</div>
								</div>
							</div>
						</div>

						<div class="col-lg-5 col-md-12 p-0 form-group input-group">
							<div class="col-lg-3 col-md-2 col-sm-2 col-3 p-0">
								{!! Form::label('filas', 'Filas')!!}
								{!! Form::selectRange('filas', 1, 30, 20, array('class' => 'col-12 form-control input-xs', 'onchange' => 'buscar(\''.$entidad.'\')')) !!}
							</div>
							<div class="col-lg-9 col-md-6 col-sm-8 col-9 d-flex justify-content-around align-items-center">
								{!! Form::button('<i class="material-icons">search</i>Buscar', array('class' => 'btn btn-success p-2 pl-1 pr-1', 'id' => 'btnBuscar', 'onclick' => 'buscar(\''.$entidad.'\')')) !!}
								{!! Form::button('<i class="material-icons">add</i>Registrar', array('class' => 'btn btn-primary p-2 pl-1 pr-1', 'id' => 'btnNuevo', 'onclick' => 'modal (\''.URL::route($ruta["create"], array('listar'=>'SI')).'\', \''.$tituloCheckListVehicular.'\', this);')) !!}
							</div>
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

		document.getElementById('btn_remove_fecha_registro_inicial').addEventListener('click', e => {
			const fecha_registro_inicial = document.getElementById('fecha_registro_inicial');
			fecha_registro_inicial.value = '';
		});
		document.getElementById('btn_remove_fecha_registro_final').addEventListener('click', e => {
			const fecha_registro_final = document.getElementById('fecha_registro_final');
			fecha_registro_final.value = '';
		});

	});
</script>