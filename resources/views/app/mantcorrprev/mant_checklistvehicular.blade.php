@php
	$modalNuevo = false;
	if($checklistvehicular == null) {//Nuevo
		$modalNuevo = true;
		$sistema_electrico = [
			['orden' => 1, 'id' => 'freno_emergencia', 'titulo' => 'Freno de emergencia', 'estado' => null],
			['orden' => 2, 'id' => 'funcionamiento_tablero', 'titulo' => 'Funcionamiento de tablero','estado' => null],
			['orden' => 3, 'id' => 'estado_bateria_funcionamiento', 'titulo' => 'Estado de batería y funcionamiento', 'estado' => null],
			['orden' => 4, 'id' => 'funcionamiento_claxon', 'titulo' => 'Funcionamiento de claxon', 'estado' => null],
			['orden' => 5, 'id' => 'luces_retroceso_pirata', 'titulo' => 'Luces de retroceso pirata','estado' => null],
			['orden' => 6, 'id' => 'luces_direccional', 'titulo' => 'Luces direccional','estado' => null],
			['orden' => 7, 'id' => 'faros_neblineros', 'titulo' => 'Faros neblineros','estado' => null],
			['orden' => 8, 'id' => 'faros_delanteros', 'titulo' => 'Faros delanteros','estado' => null],
			['orden' => 9, 'id' => 'faros_posteriores', 'titulo' => 'Faros posteriores','estado' => null],
			['orden' => 10,'id' => 'alarma_retroceso', 'titulo' => 'Alarma de retroceso','estado' => null],
		];
		$sistema_mecanico = [
			['orden' => 1, 'id' => 'nivel_liquido_freno', 'titulo' => 'Nivel liquido de freno', 'estado' => null],
			['orden' => 2, 'id' => 'sistema_direccion', 'titulo' => 'Sistema de dirección', 'estado' => null],
			['orden' => 3, 'id' => 'palancas_cambios', 'titulo' => 'Palancas de cambios', 'estado' => null],
			['orden' => 4, 'id' => 'estado_neumaticos', 'titulo' => 'Estado de neumáticos', 'estado' => null],
			['orden' => 5, 'id' => 'llantas_repuesto', 'titulo' => 'Llantas de repuesto', 'estado' => null],
			['orden' => 6, 'id' => 'ajustes_tuercas', 'titulo' => 'Ajustes de tuercas', 'estado' => null],
			['orden' => 7, 'id' => 'presion_llantas_libras', 'titulo' => 'Presion de llantas en libras', 'estado' => null],
			['orden' => 8, 'id' => 'cinturon_seguridad_conductor', 'titulo' => 'Cinturon de seguridad conductor', 'estado' => null],
			['orden' => 9, 'id' => 'cinturon_seguridad_pasajeros', 'titulo' => 'Cinturon de seguridad pasajeros', 'estado' => null],
			['orden' => 10, 'id' => 'suspension', 'titulo' => 'Suspensión', 'estado' => null],

			['orden' => 11, 'id' => 'sistema_freno', 'titulo' => 'Sistema de freno', 'estado' => null],
			['orden' => 12, 'id' => 'pernos_neumaticos', 'titulo' => 'Pernos de neumáticos', 'estado' => null],
			['orden' => 13, 'id' => 'nivel_aceite', 'titulo' => 'Nivel de aceite', 'estado' => null],
			['orden' => 14, 'id' => 'espejos_int_ext', 'titulo' => 'Espejos int y ext', 'estado' => null],
			['orden' => 15, 'id' => 'parachoques', 'titulo' => 'Parachoques', 'estado' => null],
			['orden' => 16, 'id' => 'parabrisas_ventanas', 'titulo' => 'Parabrisas y ventanas', 'estado' => null],
			['orden' => 17, 'id' => 'puertas_cabina', 'titulo' => 'Puertas de cabina', 'estado' => null],
			['orden' => 18, 'id' => 'puertas_tolva', 'titulo' => 'Puertas de tolva', 'estado' => null],
			['orden' => 19, 'id' => 'plumillas', 'titulo' => 'Plumillas', 'estado' => null],
			['orden' => 20, 'id' => 'estado_carroceria', 'titulo' => 'Estado de carrocería', 'estado' => null],
		];
		$accesorios = [
			['orden' => 1, 'id' => 'estuche_herramientas', 'titulo' => 'Estuche de herramientas', 'estado' => null],
			['orden' => 2, 'id' => 'estado_carga_extintor', 'titulo' => 'Estado y carga de extintor', 'estado' => null],
			['orden' => 3, 'id' => 'botiquin', 'titulo' => 'Botiquín', 'estado' => null],
			['orden' => 4, 'id' => 'cable_remolque', 'titulo' => 'Cable de remolque', 'estado' => null],
			['orden' => 5, 'id' => 'tacos_seguridad_cuña_2', 'titulo' => 'Tacos de seguridad cuña(2)', 'estado' => null],
			['orden' => 6, 'id' => 'llave_ruedas', 'titulo' => 'Llave de ruedas', 'estado' => null],
			['orden' => 7, 'id' => 'kit_antiderrames', 'titulo' => 'Kit antiderrames', 'estado' => null],
			['orden' => 8, 'id' => 'limpieza_unidad', 'titulo' => 'Limpieza de la unidad', 'estado' => null],
		];
		$documentos = [
			['orden' => 1, 'id' => 'tarjeta_propiedad', 'titulo' => 'Tarjeta de propiedad', 'estado' => null],
			['orden' => 2, 'id' => 'soat', 'titulo' => 'SOAT', 'estado' => null],
			['orden' => 3, 'id' => 'licencia_conducir', 'titulo' => 'Licencia de conducir', 'estado' => null],
			['orden' => 4, 'id' => 'revision_tecnica', 'titulo' => 'Revisión técnica', 'estado' => null],
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
			{!! Form::date('fecha_registro', null, array('class' => 'form-control input-xs solo-lectura', 'id' => 'fecha_registro_modal', 'readonly' => !$modalNuevo )) !!}
		</div>
	</div>


	{{-- INICIO DE MODIFICACION --}}
	<div class="col-8 p-0 m-0">
		<div class="col-12 p-0 m-0 input-group">
			<div class="form-group col-3">
				{!! Form::label('unidad_placa', 'Unidad placa:', array('class' => 'col-lg-12 col-md-12 col-sm-12 control-label')) !!}
				<div class="col-lg-12 col-md-12 col-sm-12">
					{!! Form::text('unidad_placa', $unidad_placa, array('class' => 'form-control input-xs solo-lectura', 'id' => 'unidad_placa', 'readonly' => !$modalNuevo)) !!}
				</div>
			</div>
			<div class="form-group col-7">
				{!! Form::label('unidad_descripcion', 'Unidad descripción:', array('class' => 'col-lg-12 col-md-12 col-sm-12 control-label')) !!}
				<div class="col-lg-12 col-md-12 col-sm-12">
					{!! Form::text('unidad_descripcion', $unidad_descripcion, array('class' => 'form-control input-xs solo-lectura', 'id' => 'unidad_descripcion', 'readonly' => true)) !!}
					{{-- <input name="unidad_id" id="unidad_id" type="text" class="hidden" value=""> --}}
				</div>
			</div>
			<div class="form-group col-2">
				<i id="unidad_loading" class="fa fa-spinner fa-lg fa-spin text-info" aria-hidden="true" hidden></i>
			</div>
		</div>
		<div id="unidad_data_table" class="data-table">
			<table class="table table-bordered table-sm table-condensed">
				<thead class="dt-row-bordered">
					<tr>
						<th class="table-primary font-weight-bold pt-0 pb-0">PLACA</th>
						<th class="table-primary font-weight-bold pt-0 pb-0">DESCRIPCION</th>
					</tr>
				</thead>
				<tbody id="unidad_data_table_rows">
				</tbody>
			</table>
		</div>
	</div>
	{{-- FIN DE MODIFICACION --}}

	
</div>
<div class="form-row">
	<div class="form-group col-3">
		{!! Form::label('k_inicial', 'Kilometraje inicial:', array('class' => 'col-lg-12 col-md-12 col-sm-12 control-label')) !!}
		<div class="col-lg-12 col-md-12 col-sm-12">
			{!! Form::number('k_inicial', null, array('class' => 'form-control input-xs solo-lectura', 'id' => 'k_inicial', 'readonly' => !$modalNuevo)) !!}
		</div>
	</div>
	<div class="form-group col-3">
		{!! Form::label('k_final', 'Kilometraje final:', array('class' => 'col-lg-12 col-md-12 col-sm-12 control-label')) !!}
		<div class="col-lg-12 col-md-12 col-sm-12">
			{!! Form::number('k_final', null, array('class' => 'form-control input-xs solo-lectura', 'id' => 'k_final', 'readonly' => !$modalNuevo)) !!}
		</div>
	</div>
	<div class="form-group col-6">
		{!! Form::label('lider_area', 'Lider del área:', array('class' => 'col-lg-12 col-md-12 col-sm-12 control-label')) !!}
		<div class="col-lg-12 col-md-12 col-sm-12">
			{!! Form::text('lider_area', null, array('class' => 'form-control input-xs solo-lectura', 'id' => 'lider_area', 'readonly' => !$modalNuevo)) !!}
		</div>
	</div>
</div>
<div class="form-row">
	<div class="form-group col-8">
		{!! Form::label('conductor_id', 'Conductor:', array('class' => 'col-lg-12 col-md-12 col-sm-12 control-label')) !!}
		<div class="col-12 input-group p-0 m-0">
			<div class="col-lg-4 col-md-4 col-sm-4">
				{!! Form::hidden('conductor_id', $conductor['id'], array('id' => 'conductor_id')) !!}
				{!! Form::text('conductor_dni', $conductor['dni'], array('class' => 'form-control input-xs', 'id' => 'conductor_dni', 'disabled' => !$modalNuevo)) !!}
			</div>
			<div class="col-lg-8 col-md-8 col-sm-8">
				{!! Form::text('conductor_nombres', $conductor['nombres'], array('class' => 'form-control input-xs solo-lectura', 'id' => 'conductor_nombres', 'readonly' => true)) !!}
			</div>
		</div>
		<div id="conductor_data_table" class="data-table">
			<table class="table table-condensed table-bordered">
				<thead class="dt-row-bordered">
					<tr>
						<th class="table-primary font-weight-bold pt-0 pb-0">DNI</th>
						<th class="table-primary font-weight-bold pt-0 pb-0">NOMBRE COMPLETO</th>
					</tr>
				</thead>
				<tbody id="conductor_data_table_rows">
				</tbody>
			</table>
		</div>
	</div>
	<div class="col-4 d-flex align-items-center justify-content-end">
		{!! Form::button('<i class="material-icons">edit</i> Editar', array('class' => 'btn btn-warning btn-sm mr-5', 'id' => 'btn-editar', 'hidden' => $modalNuevo)) !!}
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
								<td>{{ $item['titulo'] }}</td>
								<td class="text-center">
									{!! Form::radio( $item['id'], 'si', $item['estado'] ? true : false, ['data-type' => 'sistema_electrico', 'data-titulo' => $item['titulo'], 'data-orden' => $item['orden'], 'disabled' => !$modalNuevo ]) !!}
								</td>
								<td class="text-center">
									{!! Form::radio( $item['id'], 'no', $item['estado'] !== null && !$item['estado'] ? true : false, ['data-type' => 'sistema_electrico', 'data-titulo' => $item['titulo'], 'data-orden' => $item['orden'], 'disabled' => !$modalNuevo ]) !!}
								</td>
							</tr>
						@endforeach
						<input name="sistema_electrico" id="sistema_electrico" type="text" class="hidden" value="{{ json_encode($sistema_electrico) }}">
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
								<td>{{ $sistema_mecanico[$i]['titulo'] }}</td>
								<td class="text-center">
									{!! Form::radio( $sistema_mecanico[$i]['id'], 'si', $sistema_mecanico[$i]['estado'] ? true : false, ['data-type' => 'sistema_mecanico', 'data-titulo' => $sistema_mecanico[$i]['titulo'], 'data-orden' => $sistema_mecanico[$i]['orden'], 'disabled' => !$modalNuevo ]) !!}
								</td>
								<td class="text-center">
									{!! Form::radio( $sistema_mecanico[$i]['id'], 'no', $sistema_mecanico[$i]['estado'] !== null && !$sistema_mecanico[$i]['estado'] ? true : false, ['data-type' => 'sistema_mecanico', 'data-titulo' => $sistema_mecanico[$i]['titulo'], 'data-orden' => $sistema_mecanico[$i]['orden'], 'disabled' => !$modalNuevo]) !!}
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
								<td>{{ $sistema_mecanico[$i]['titulo'] }}</td>
								<td class="text-center">
									{!! Form::radio( $sistema_mecanico[$i]['id'], 'si', $sistema_mecanico[$i]['estado'] ? true : false, ['data-type' => 'sistema_mecanico', 'data-titulo' => $sistema_mecanico[$i]['titulo'], 'data-orden' => $sistema_mecanico[$i]['orden'], 'disabled' => !$modalNuevo]) !!}
								</td>
								<td class="text-center">
									{!! Form::radio( $sistema_mecanico[$i]['id'], 'no', $sistema_mecanico[$i]['estado'] !== null && !$sistema_mecanico[$i]['estado'] ? true : false, ['data-type' => 'sistema_mecanico', 'data-titulo' => $sistema_mecanico[$i]['titulo'], 'data-orden' => $sistema_mecanico[$i]['orden'], 'disabled' => !$modalNuevo]) !!}
								</td>
							</tr>
						@endfor
						<input name="sistema_mecanico" id="sistema_mecanico" type="text" class="hidden" value="{{ json_encode($sistema_mecanico) }}">
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
								<td>{{ $item['titulo'] }}</td>
								<td class="text-center">
									{!! Form::radio( $item['id'], 'si', $item['estado'] ? true : false, ['data-type' => 'accesorios', 'data-titulo' => $item['titulo'], 'data-orden' => $item['orden'], 'disabled' => !$modalNuevo]) !!}
								</td>
								<td class="text-center">
									{!! Form::radio( $item['id'], 'no', $item['estado'] !== null && !$item['estado'] ? true : false, ['data-type' => 'accesorios', 'data-titulo' => $item['titulo'], 'data-orden' => $item['orden'], 'disabled' => !$modalNuevo]) !!}
								</td>
							</tr>
						@endforeach
						<input name="accesorios" id="accesorios" type="text" class="hidden" value="{{ json_encode($accesorios) }}">
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
								<td>{{ $item['titulo'] }}</td>
								<td class="text-center">
									{!! Form::radio( $item['id'], 'si', $item['estado'] ? true : false, ['data-type' => 'documentos', 'data-titulo' => $item['titulo'], 'data-orden' => $item['orden'], 'disabled' => !$modalNuevo]) !!}
								</td>
								<td class="text-center">
									{!! Form::radio( $item['id'], 'no', $item['estado'] !== null && !$item['estado'] ? true : false, ['data-type' => 'documentos', 'data-titulo' => $item['titulo'], 'data-orden' => $item['orden'], 'disabled' => !$modalNuevo]) !!}
								</td>
							</tr>
						@endforeach
						<input name="documentos" id="documentos" type="text" class="hidden" value="{{ json_encode($documentos) }}">
					</tbody>
				</table>
			</div>
			<div class="col-4">
				<h5>Observaciones e incidentes</h5>
				{!! Form::textarea('observaciones', null, ['class' => 'form-control solo-lectura', 'rows' => '9', 'cols' => '26', 'readonly' => !$modalNuevo]) !!}
			</div>
		</div>
	</div>
</div>

<div class="form-group">
	<div class="col-lg-12 col-md-12 col-sm-12 text-right">
		{!! Form::button('<i class="fa fa-check fa-lg"></i> '.$boton, array('class' => 'btn btn-success btn-sm', 'id' => 'btnGuardar', 'onclick' => 'guardar(\''.$entidad.'\', this)', 'hidden' => !$modalNuevo)) !!}
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
	
	.dt-row-bordered-selectable{
		border: 2px solid blueviolet !important;
		cursor: pointer;
	}
	.dt-row-bordered{
		border: 2px solid blueviolet !important;
	}
	.showTable{
		display: block !important;
	}
	.data-table{
		float: left;
		position: absolute;
		display: none;
		z-index: 1000;
	}
</style>
<script type="text/javascript">
	$(document).ready(function() {
		configurarAnchoModal('900');
		init(IDFORMMANTENIMIENTO+'{!! $entidad !!}', 'M', '{!! $entidad !!}');

		

		const btnEditar = document.getElementById('btn-editar');

		//TODO: Revisarlo al final
		const getDateCurrent = () => {
			const fecha = new Date();
			let mes = fecha.getMonth()+1;
			let dia = fecha.getDate();
			const ano = fecha.getFullYear();
			if(dia<10) dia = '0' + dia;
			if(mes<10) mes = '0' + mes;

			const inputFechaRegistro = document.getElementById('fecha_registro_modal');
			// console.log('antes: ', inputFechaRegistro.value);
			inputFechaRegistro.value = ano+"-"+mes+"-"+dia;
			inputFechaRegistro.setAttribute('min', ano+"-"+mes+"-"+dia);
			// console.log('despues: ', inputFechaRegistro.value);
			// console.log(ano+"-"+mes+"-"+dia);
		}
		getDateCurrent();


		// TABLA SELECCIONADORA DE CONDUCTORES
		let listaConductores = [];
		const conductorId = document.getElementById('conductor_id');
		const conductorDNI = document.getElementById('conductor_dni');
		const conductorNombres = document.getElementById('conductor_nombres');
		const conductorDataTable = document.getElementById('conductor_data_table');
		const conductorDataTableRows = document.getElementById('conductor_data_table_rows');

		const searchConductor = async (filter = '') => {
			listaConductores = await querySearchConductor(filter);

			if ( listaConductores.length == 0 ) {
				updateConductor(conductorDNI.value);
				conductorDataTable.classList.remove('showTable');
				return;
			}
			if ( listaConductores.length == 1 && updateConductor(conductorDNI.value) ) {
				conductorDataTable.classList.remove('showTable');
				return;
			};
			
			conductorDataTableRows.innerHTML = '';
			listaConductores.forEach(conductor => {
				conductorDataTableRows.innerHTML += `
					<tr name="conductor_row" data-conductor_dni="${conductor.dni}" class="dt-row-bordered-selectable table-hover">
						<td class="table-secondary pt-0 pb-0">${conductor.dni}</td>
						<td class="table-secondary pt-0 pb-0">${conductor.nombres}</td>
					</tr>
				`;
			});

			const conductor_rows = Array.from(document.getElementsByName('conductor_row'));
			conductor_rows.forEach(row => {
				row.addEventListener('click', e => {
					const trow = e.srcElement.parentElement;
					const dni = trow.dataset.conductor_dni;
					selectConductor(dni);
				});
			});
			
			conductorDataTable.classList.add('showTable');
			updateConductor(conductorDNI.value);
		}
		const querySearchConductor = async (filter) => {
			if ( !filter.length ) return [];

			return list = fetch(`./mantcorrprev/searchConductor?filter=${filter}`)
			.then(response => response.status === 200 ? response.json() : console.log('Error on searchConductor method'))
			.then(response => response.list)
			.catch(error => console.log(`Error on searchConductor method: ${error}`));
		}
		const selectConductor = (dni) => {
			conductorDataTable.classList.remove('showTable');
			updateConductor(dni);	
		}
		const updateConductor = (dni) => {
			let found = false;
			for (let i = 0; i < listaConductores.length; i++) {
				if ( listaConductores[i].dni == dni ) {
					conductorId.value = listaConductores[i].id;
					conductorDNI.value = listaConductores[i].dni;
					conductorNombres.value = listaConductores[i].nombres;
					found = true; break;
				}
			}
			if ( !found ) {
				conductorId.value = null;
				conductorNombres.value = '';
			}

			return found;
		}
		conductorDNI.addEventListener('keyup', async (e) => {
			const filter = e.target.value;
			
			if ( filter.length > 0 ) {
				searchConductor(filter);
			} else {
				updateConductor(conductorDNI.value);
				conductorDataTable.classList.remove('showTable');
			}
		});


		// TABLA SELECCIONADORA DE UNIDADES
		let listaUnidades = [];
		const unidadPlaca = document.getElementById('unidad_placa');
		const unidadDescripcion = document.getElementById('unidad_descripcion');
		const unidadLoading = document.getElementById('unidad_loading');
		const unidadDataTable = document.getElementById('unidad_data_table');
		const unidadDataTableRows = document.getElementById('unidad_data_table_rows');

		const searchUnidad = async (filter = '') => {
			listaUnidades = await querySearchUnidad(filter);
			console.log(listaUnidades);
			if ( listaUnidades.length == 0 ) {
				updateUnidad(unidadPlaca.value);
				unidadDataTable.classList.remove('showTable'); 
				unidadLoading.setAttribute('hidden', true); return;
			}
			if ( listaUnidades.length == 1 && updateUnidad(unidadPlaca.value) ) {
				unidadDataTable.classList.remove('showTable');
				unidadLoading.setAttribute('hidden', true); return;
			}

			unidadDataTableRows.innerHTML = '';
			listaUnidades.forEach(unidad => {
				unidadDataTableRows.innerHTML += `
					<tr name="unidad_row" data-unidad_placa="${unidad.placa}" class="dt-row-bordered-selectable table-hover">
						<td class="table-secondary pt-0 pb-0">${unidad.placa}</td>
						<td class="table-secondary pt-0 pb-0">${unidad.descripcion}</td>
					</tr>
				`;
			});

			unidad_rows = Array.from(document.getElementsByName('unidad_row'));
			unidad_rows.forEach(unidad => {
				unidad.addEventListener('click', e => {
					let trow = e.srcElement.parentElement;
					let placa = trow.dataset.unidad_placa;
					selectUnidad(placa);
				});
			});

			unidadDataTable.classList.add('showTable');
			unidadLoading.setAttribute('hidden', true);
			updateUnidad(unidadPlaca.value);
		}
		const querySearchUnidad = async (filter) => {
			if ( !filter.length ) return [];

			return fetch(`./mantcorrprev/searchUnidad?filter=${filter}`)
			.then(response => response.status === 200 ? response.json() : console.error(`Error on query into querySearchUnidad method: ${response.status}`))
			.then(response => response.equipos.concat(response.vehiculos))
			.catch(error => console.error('Error in querySearchUnidad method'));
		}
		const selectUnidad = (placa) => {
			unidadDataTable.classList.remove('showTable');
			updateUnidad(placa);
		}
		const updateUnidad = (placa) => {
			let found = false;

			for (let i = 0; i < listaUnidades.length; i++) {
				if ( listaUnidades[i].placa == placa ) {
					unidadPlaca.value = listaUnidades[i].placa;
					unidadDescripcion.value = listaUnidades[i].descripcion;
					found = true; return;
				}
			}

			if ( !found ) {
				unidadDescripcion.value = '';
			}
			
			return found;
		}
		unidadPlaca.addEventListener('keyup', async (e) => {
			const filter = e.target.value;
			
			if ( filter.length > 0 ){
				unidadLoading.removeAttribute('hidden');
				searchUnidad(filter);
			} else {
				unidadLoading.setAttribute('hidden', true);
				updateUnidad(unidadPlaca.value);
				unidadDataTable.classList.remove('showTable');
			}
		});

		//SISTEMA ELECTRICO
		$("input[data-type='sistema_electrico']").change(function(){
			const arrObjects = [];
			const el = $(this)[0];
			const brothers = document.querySelectorAll(`input[data-type='sistema_electrico'][name=${el.name}]`);
			Array.from(brothers).forEach(element => {
				element.removeAttribute('checked');
			});
			el.setAttribute('checked', 'checked');

			const listSistemaElectricoChecked = document.querySelectorAll("input[data-type='sistema_electrico'][checked='checked']");
			Array.from(listSistemaElectricoChecked).forEach(el => {
				myObject = {
					orden: el.dataset.orden,
					id: el.name,
					titulo: el.dataset.titulo,
					estado: el.value == 'si' ? true: false
				};
				arrObjects.push(myObject);
				// console.log(arrObjects)
			});

			const listSistemaElectrico = document.querySelectorAll("input[data-type='sistema_electrico']");
			const filtradoSistemaElectrico = Array.from(listSistemaElectrico).filter((el, index) => index % 2 == 0);
			filtradoSistemaElectrico.forEach(el => {
				const brothers = document.querySelectorAll(`input[data-type='sistema_electrico'][name=${el.name}]`);
				const arrBrothers = Array.from(brothers);

				let haveChecked = false;
				for (const item of arrBrothers) {
					if(item.getAttribute('checked') != null) haveChecked = true;
				}
				if(haveChecked == false ) {
					myObject = {
						orden: el.dataset.orden,
						id: el.name,
						titulo: el.dataset.titulo,
						estado: null
					};
					arrObjects.push(myObject);
				}
			});
			// console.log(arrObjects)
			document.getElementById('sistema_electrico').value = JSON.stringify(arrObjects);
		});

		//SISTEMA MECANICO
		$("input[data-type='sistema_mecanico']").change(function(){
			const arrObjects = [];
			const el = $(this)[0];
			const brothers = document.querySelectorAll(`input[data-type='sistema_mecanico'][name=${el.name}]`);
			Array.from(brothers).forEach(element => {
				element.removeAttribute('checked');
			});
			el.setAttribute('checked', 'checked');

			const listSistemaMecanicoChecked = document.querySelectorAll("input[data-type='sistema_mecanico'][checked='checked']");
			Array.from(listSistemaMecanicoChecked).forEach(el => {
				myObject = {
					orden: el.dataset.orden,
					id: el.name,
					titulo: el.dataset.titulo,
					estado: el.value == 'si' ? true: false
				};
				arrObjects.push(myObject);
				// console.log(arrObjects)
			});

			const listSistemaMecanico = document.querySelectorAll("input[data-type='sistema_mecanico']");
			const filtradoSistemaMecanico = Array.from(listSistemaMecanico).filter((el, index) => index % 2 == 0);
			filtradoSistemaMecanico.forEach(el => {
				const brothers = document.querySelectorAll(`input[data-type='sistema_mecanico'][name=${el.name}]`);
				const arrBrothers = Array.from(brothers);

				let haveChecked = false;
				for (const item of arrBrothers) {
					if(item.getAttribute('checked') != null) haveChecked = true;
				}
				if(haveChecked == false ) {
					myObject = {
						orden: el.dataset.orden,
						id: el.name,
						titulo: el.dataset.titulo,
						estado: null
					};
					arrObjects.push(myObject);
				}
			});
			console.log(arrObjects)
			document.getElementById('sistema_mecanico').value = JSON.stringify(arrObjects);
		});
		
		//ACCESORIOS
		$("input[data-type='accesorios']").change(function(){
			const arrObjects = [];
			const el = $(this)[0];
			const brothers = document.querySelectorAll(`input[data-type='accesorios'][name=${el.name}]`);
			Array.from(brothers).forEach(element => {
				element.removeAttribute('checked');
			});
			el.setAttribute('checked', 'checked');

			const listAccesoriosChecked = document.querySelectorAll("input[data-type='accesorios'][checked='checked']");
			Array.from(listAccesoriosChecked).forEach(el => {
				myObject = {
					orden: el.dataset.orden,
					id: el.name,
					titulo: el.dataset.titulo,
					estado: el.value == 'si' ? true: false
				};
				arrObjects.push(myObject);
				// console.log(arrObjects)
			});

			const listAccesorios = document.querySelectorAll("input[data-type='accesorios']");
			const filtradoAccesorios = Array.from(listAccesorios).filter((el, index) => index % 2 == 0);
			filtradoAccesorios.forEach(el => {
				const brothers = document.querySelectorAll(`input[data-type='accesorios'][name=${el.name}]`);
				const arrBrothers = Array.from(brothers);

				let haveChecked = false;
				for (const item of arrBrothers) {
					if(item.getAttribute('checked') != null) haveChecked = true;
				}
				if(haveChecked == false ) {
					myObject = {
						orden: el.dataset.orden,
						id: el.name,
						titulo: el.dataset.titulo,
						estado: null
					};
					arrObjects.push(myObject);
				}
			});
			// console.log(arrObjects)
			document.getElementById('accesorios').value = JSON.stringify(arrObjects);
		});

		//DOCUMENTOS
		$("input[data-type='documentos']").change(function(){
			const arrObjects = [];
			const el = $(this)[0];
			const brothers = document.querySelectorAll(`input[data-type='documentos'][name=${el.name}]`);
			Array.from(brothers).forEach(element => {
				element.removeAttribute('checked');
			});
			el.setAttribute('checked', 'checked');

			const listDocumentosChecked = document.querySelectorAll("input[data-type='documentos'][checked='checked']");
			Array.from(listDocumentosChecked).forEach(el => {
				myObject = {
					orden: el.dataset.orden,
					id: el.name,
					titulo: el.dataset.titulo,
					estado: el.value == 'si' ? true: false
				};
				arrObjects.push(myObject);
				// console.log(arrObjects)
			});

			const listDocumentos = document.querySelectorAll("input[data-type='documentos']");
			const filtradoDocumentos = Array.from(listDocumentos).filter((el, index) => index % 2 == 0);
			filtradoDocumentos.forEach(el => {
				const brothers = document.querySelectorAll(`input[data-type='documentos'][name=${el.name}]`);
				const arrBrothers = Array.from(brothers);

				let haveChecked = false;
				for (const item of arrBrothers) {
					if(item.getAttribute('checked') != null) haveChecked = true;
				}
				if(haveChecked == false ) {
					myObject = {
						orden: el.dataset.orden,
						id: el.name,
						titulo: el.dataset.titulo,
						estado: null
					};
					arrObjects.push(myObject);
				}
			});
			console.log(arrObjects)
			document.getElementById('documentos').value = JSON.stringify(arrObjects);
		});

		btnEditar.addEventListener('click', () => {
			const inputsReadonly = document.querySelectorAll("[readonly]");
			Array.from(inputsReadonly).map(el => {
				el.removeAttribute('readonly');
			});
			const inputsDisabled = document.querySelectorAll("[disabled]");
			Array.from(inputsDisabled).map(el => {
				el.removeAttribute('disabled');
			});

			const btnGuardar = document.getElementById('btnGuardar');
			btnGuardar.removeAttribute('hidden');
		});
	});

</script>
<style>
	.table__personal-body {
		font-size: .85em; !important
	}
</style>