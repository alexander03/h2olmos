@php
	if($checklistvehicular == null) {//Nuevo
		$sistema_electrico = [
			(object) ['id' => 'freno_emergencia', 'titulo' => 'Freno de emergencia', 'estado' => null],
			(object) ['id' => 'funcionamiento_tablero', 'titulo' => 'Funcionamiento de tablero','estado' => null],
			(object) ['id' => 'estado_bateria_funcionamiento', 'titulo' => 'Estado de batería y funcionamiento', 'estado' => null],
			(object) ['id' => 'funcionamiento_claxon', 'titulo' => 'Funcionamiento de claxon', 'estado' => null],
			(object) ['id' => 'luces_retroceso_pirata', 'titulo' => 'Luces de retroceso pirata','estado' => null],
			(object) ['id' => 'luces_direccional', 'titulo' => 'Luces direccional','estado' => null],
			(object) ['id' => 'faros_neblineros', 'titulo' => 'Faros neblineros','estado' => null],
			(object) ['id' => 'faros_delanteros', 'titulo' => 'Faros delanteros','estado' => null],
			(object) ['id' => 'faros_posteriores', 'titulo' => 'Faros posteriores','estado' => null],
			(object) ['id' => 'alarma_retroceso', 'titulo' => 'Alarma de retroceso','estado' => null],
		];
		$sistema_mecanico = [
			(object) ['id' => 'nivel_liquido_freno', 'titulo' => 'Nivel liquido de freno', 'estado' => null],
			(object) ['id' => 'sistema_direccion', 'titulo' => 'Sistema de dirección', 'estado' => null],
			(object) ['id' => 'palancas_cambios', 'titulo' => 'Palancas de cambios', 'estado' => null],
			(object) ['id' => 'estado_neumaticos', 'titulo' => 'Estado de neumáticos', 'estado' => null],
			(object) ['id' => 'llantas_repuesto', 'titulo' => 'Llantas de repuesto', 'estado' => null],
			(object) ['id' => 'ajustes_tuercas', 'titulo' => 'Ajustes de tuercas', 'estado' => null],
			(object) ['id' => 'presion_llantas_libras', 'titulo' => 'Presion de llantas en libras', 'estado' => null],
			(object) ['id' => 'cinturon_seguridad_conductor', 'titulo' => 'Cinturon de seguridad conductor', 'estado' => null],
			(object) ['id' => 'cinturon_seguridad_pasajeros', 'titulo' => 'Cinturon de seguridad pasajeros', 'estado' => null],
			(object) ['id' => 'suspension', 'titulo' => 'Suspensión', 'estado' => null],

			(object) ['id' => 'sistema_freno', 'titulo' => 'Sistema de freno', 'estado' => null],
			(object) ['id' => 'pernos_neumaticos', 'titulo' => 'Pernos de neumáticos', 'estado' => null],
			(object) ['id' => 'nivel_aceite', 'titulo' => 'Nivel de aceite', 'estado' => null],
			(object) ['id' => 'espejos_int_ext', 'titulo' => 'Espejos int y ext', 'estado' => null],
			(object) ['id' => 'parachoques', 'titulo' => 'Parachoques', 'estado' => null],
			(object) ['id' => 'parabrisas_ventanas', 'titulo' => 'Parabrisas y ventanas', 'estado' => null],
			(object) ['id' => 'puertas_cabina', 'titulo' => 'Puertas de cabina', 'estado' => null],
			(object) ['id' => 'puertas_tolva', 'titulo' => 'Puertas de tolva', 'estado' => null],
			(object) ['id' => 'plumillas', 'titulo' => 'Plumillas', 'estado' => null],
			(object) ['id' => 'estado_carroceria', 'titulo' => 'Estado de carrocería', 'estado' => null],
		];
		$accesorios = [
			(object) ['id' => 'estuche_herramientas', 'titulo' => 'Estuche de herramientas', 'estado' => null],
			(object) ['id' => 'estado_carga_extintor', 'titulo' => 'Estado y carga de extintor', 'estado' => null],
			(object) ['id' => 'botiquin', 'titulo' => 'Botiquín', 'estado' => null],
			(object) ['id' => 'cable_remolque', 'titulo' => 'Cable de remolque', 'estado' => null],
			(object) ['id' => 'tacos_seguridad_cuña_2', 'titulo' => 'Tacos de seguridad cuña(2)', 'estado' => null],
			(object) ['id' => 'llave_ruedas', 'titulo' => 'Llave de ruedas', 'estado' => null],
			(object) ['id' => 'kit_antiderrames', 'titulo' => 'Kit antiderrames', 'estado' => null],
			(object) ['id' => 'limpieza_unidad', 'titulo' => 'Limpieza de la unidad', 'estado' => null],
		];
		$documentos = [
			(object) ['id' => 'tarjeta_propiedad', 'titulo' => 'Tarjeta de propiedad', 'estado' => null],
			(object) ['id' => 'soat', 'titulo' => 'SOAT', 'estado' => null],
			(object) ['id' => 'licencia_conducir', 'titulo' => 'Licencia de conducir', 'estado' => null],
			(object) ['id' => 'revision_tecnica', 'titulo' => 'Revisión técnica', 'estado' => null],
		];
	}
@endphp

<div id="divMensajeError{!! $entidad !!}"></div>
{!! Form::model($checklistvehicular, $formData) !!}	
{!! Form::hidden('listar', $listar, array('id' => 'listar')) !!}
<div class="form-row">
	<div class="form-group col-4">
		{!! Form::label('fecha_registro', 'F. Registro:', array('class' => 'col-lg-12 col-md-12 col-sm-12 control-label')) !!}
		<div class="col-lg-12 col-md-12 col-sm-12">
			{!! Form::date('fecha_registro', null, array('class' => 'form-control input-xs', 'id' => 'fecha_registro', 'min' => date('Y-m-d') )) !!}
		</div>
	</div>
	<div class="form-group col-2">
		{!! Form::label('unidad_placa', 'Unidad placa:', array('class' => 'col-lg-12 col-md-12 col-sm-12 control-label')) !!}
		<div class="col-lg-12 col-md-12 col-sm-12">
			{!! Form::text('unidad_placa', null, array('class' => 'form-control input-xs solo-lectura', 'id' => 'unidad_placa')) !!}
		</div>
	</div>
	<div class="form-group col-1">
		<i id="loader-unidad" class="fa fa-spinner fa-lg text-info" aria-hidden="true" hidden></i>
	</div>
	<div class="form-group col-5">
		{!! Form::label('unidad_descripcion', 'Unidad descripción:', array('class' => 'col-lg-12 col-md-12 col-sm-12 control-label')) !!}
		<div class="col-lg-12 col-md-12 col-sm-12">
			{!! Form::text('unidad_descripcion', null, array('class' => 'form-control input-xs solo-lectura', 'id' => 'unidad_descripcion', 'readonly' => true)) !!}
		</div>
	</div>
</div>
<div class="form-row">
	<div class="form-group col-3">
		{!! Form::label('kilometrajeinicial', 'Kilometraje inicial:', array('class' => 'col-lg-12 col-md-12 col-sm-12 control-label')) !!}
		<div class="col-lg-12 col-md-12 col-sm-12">
			{!! Form::number('kilometrajeinicial', null, array('class' => 'form-control input-xs solo-lectura', 'id' => 'kilometrajeinicial')) !!}
		</div>
	</div>
	<div class="form-group col-3">
		{!! Form::label('kilometrajefinal', 'Kilometraje final:', array('class' => 'col-lg-12 col-md-12 col-sm-12 control-label')) !!}
		<div class="col-lg-12 col-md-12 col-sm-12">
			{!! Form::number('kilometrajefinal', null, array('class' => 'form-control input-xs solo-lectura', 'id' => 'kilometrajefinal')) !!}
		</div>
	</div>
	<div class="form-group col-6">
		{!! Form::label('liderarea', 'Lider del área:', array('class' => 'col-lg-12 col-md-12 col-sm-12 control-label')) !!}
		<div class="col-lg-12 col-md-12 col-sm-12">
			{!! Form::text('liderarea', null, array('class' => 'form-control input-xs solo-lectura', 'id' => 'liderarea')) !!}
		</div>
	</div>
</div>
<div class="form-row">
	<div class="form-group col-6">
		{!! Form::label('conductor_id', 'Conductor:', array('class' => 'col-lg-12 col-md-12 col-sm-12 control-label')) !!}
		<div class="col-lg-12 col-md-12 col-sm-12">
			{!! Form::select('conductor_id', $cboConductores, null, array('class' => 'form-control input-xs', 'id' => 'conductor_id')) !!}
		</div>
	</div>
</div>
<div class="form-row">
	<div class="container">
		<h5>Revisión de accesorios</h5>
		<div class="row">
			<div class="col-4 d-flex justify-content-center">
				<table class="table-sm">
					<thead>
						<th class="">SISTEMA ELECTRICO</th>
						<th class="text-center">SI</th>
						<th class="text-center">NO</th>
					</thead>
					<tbody class="table__personal-body">
						@foreach ($sistema_electrico as $item)
							<tr>
								<td>{{ $item->titulo }}</td>
								<td class="text-center">
									{!! Form::radio( $item->id, 'si', $item->estado ? true : false) !!}
								</td>
								<td class="text-center">
									{!! Form::radio( $item->id, 'no', $item->estado !== null && !$item->estado ? true : false) !!}
								</td>
							</tr>
						@endforeach
					</tbody>
				</table>
			</div>
			<div class="col-4 d-flex justify-content-center">
				<table class="table-sm">
					<thead>
						<th class="text-uppercase">Sistema Mecanico</th>
						<th class="text-uppercase text-center">Si</th>
						<th class="text-uppercase text-center">No</th>
					</thead>
					<tbody class="table__personal-body">
						@for ($i = 0; $i < 10; $i++)
							<tr>
								<td>{{ $sistema_mecanico[$i]->titulo }}</td>
								<td class="text-center">
									{!! Form::radio( $sistema_mecanico[$i]->id, 'si', $sistema_mecanico[$i]->estado ? true : false) !!}
								</td>
								<td class="text-center">
									{!! Form::radio( $sistema_mecanico[$i]->id, 'no', $sistema_mecanico[$i]->estado !== null && !$sistema_mecanico[$i]->estado ? true : false) !!}
								</td>
							</tr>
						@endfor
					</tbody>
				</table>
			</div>
			<div class="col-4 d-flex justify-content-center">
				<table class="table-sm">
					<thead>
						<th class="text-uppercase">Sistema Mecanico</th>
						<th class="text-uppercase text-center">Si</th>
						<th class="text-uppercase text-center">No</th>
					</thead>
					<tbody class="table__personal-body">
						@for ($i = 10; $i < count($sistema_mecanico); $i++)
							<tr>
								<td>{{ $sistema_mecanico[$i]->titulo }}</td>
								<td class="text-center">
									{!! Form::radio( $sistema_mecanico[$i]->id, 'si', $sistema_mecanico[$i]->estado ? true : false) !!}
								</td>
								<td class="text-center">
									{!! Form::radio( $sistema_mecanico[$i]->id, 'no', $sistema_mecanico[$i]->estado !== null && !$sistema_mecanico[$i]->estado ? true : false) !!}
								</td>
							</tr>
						@endfor
					</tbody>
				</table>
			</div>
			<div class="col-4 d-flex justify-content-center">
				<table class="table-sm">
					<thead>
						<th class="text-uppercase">Accesorios</th>
						<th class="text-uppercase text-center">Si</th>
						<th class="text-uppercase text-center">No</th>
					</thead>
					<tbody class="table__personal-body">
						@foreach ($accesorios as $item)
							<tr>
								<td>{{ $item->titulo }}</td>
								<td class="text-center">
									{!! Form::radio( $item->id, 'si', $item->estado ? true : false) !!}
								</td>
								<td class="text-center">
									{!! Form::radio( $item->id, 'no', $item->estado !== null && !$item->estado ? true : false) !!}
								</td>
							</tr>
						@endforeach
					</tbody>
				</table>
			</div>
			<div class="col-4 d-flex justify-content-center">
				<table class="table-sm">
					<thead>
						<th class="text-uppercase">Documentos</th>
						<th class="text-uppercase text-center">Si</th>
						<th class="text-uppercase text-center">No</th>
					</thead>
					<tbody class="table__personal-body">
						@foreach ($documentos as $item)
							<tr>
								<td>{{ $item->titulo }}</td>
								<td class="text-center">
									{!! Form::radio( $item->id, 'si', $item->estado ? true : false) !!}
								</td>
								<td class="text-center">
									{!! Form::radio( $item->id, 'no', $item->estado !== null && !$item->estado ? true : false) !!}
								</td>
							</tr>
						@endforeach
					</tbody>
				</table>
			</div>
			<div class="col-4">
				<h5>Observaciones e incidentes</h5>
				<textarea name="observaciones_incidentes" class="form-control" rows="9" cols="26"></textarea>
			</div>
		</div>
	</div>
</div>

<div class="form-group">
	<div class="col-lg-12 col-md-12 col-sm-12 text-right">
		{!! Form::button('<i class="fa fa-check fa-lg"></i> '.$boton, array('class' => 'btn btn-success btn-sm', 'id' => 'btnGuardar', 'onclick' => 'guardar(\''.$entidad.'\', this)')) !!}
		{!! Form::button('<i class="fa fa-exclamation fa-lg"></i> Cancelar', array('class' => 'btn btn-warning btn-sm', 'id' => 'btnCancelar'.$entidad, 'onclick' => 'cerrarModal();')) !!}
	</div>
</div>
{!! Form::close() !!}

<style>
	.solo-lectura:read-only {
		background-color: transparent;
		cursor: not-allowed;
	}
	.hidden {
		display: none;
	}
</style>
<script type="text/javascript">
	$(document).ready(function() {
		configurarAnchoModal('900');
		init(IDFORMMANTENIMIENTO+'{!! $entidad !!}', 'M', '{!! $entidad !!}');

		const inputUnidadPlaca = document.getElementById('unidad_placa');
		const inputUnidadDescripcion = document.getElementById('unidad_descripcion');

		const getDateCurrent = () => {
			const fecha = new Date();
			let mes = fecha.getMonth()+1;
			let dia = fecha.getDate();
			const ano = fecha.getFullYear();
			if(dia<10) dia = '0' + dia;
			if(mes<10) mes = '0' + mes;
			document.getElementById('fecha_registro').value = ano+"-"+mes+"-"+dia;
		}
		getDateCurrent();

		inputUnidadPlaca.addEventListener('keyup', async (e) => {
			const placa = e.target.value;
			inputUnidadDescripcion.value = 'Buscando...';
			const loaderUnidad = document.getElementById('loader-unidad');
			if(placa.length > 0){
				loaderUnidad.removeAttribute('hidden');
			} else {
				loaderUnidad.setAttribute('hidden', true);
				inputUnidadDescripcion.value = '';
			}

			if(placa.length >=6) {
				const unidad = await consultarUnidad(placa);
				if(unidad != null) {
					inputUnidadDescripcion.value = unidad.descripcion;
					loaderUnidad.removeAttribute('hidden');
				} else {
					inputUnidadDescripcion.value = 'Buscando...';
				}
			}

		});

		const consultarUnidad = async (placa = '') => {
			const uri = `./existeunidad?placa=${placa}`;
			return fetch(uri)
			.then(res => res.status === 200 ? res.json() : console.error(`Error al cosultar Conductor en la db: ${res.status}`))
			.then(res => res.unidad)
			.catch(err => console.log(`Error en consultarUnidad(): ${err}`))
		}
		
	}); 

</script>
<style>
	.table__personal-body {
		font-size: .85em; !important
	}
</style>