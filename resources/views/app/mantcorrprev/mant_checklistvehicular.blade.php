@php
	$edit = true;
	if($checklistvehicular == null) {//Nuevo
		$edit = false;
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
			{!! Form::date('fecha_registro', null, array('class' => 'form-control input-xs', 'id' => 'fecha_registro', 'min' => date('Y-m-d') )) !!}
		</div>
	</div>
	<div class="form-group col-2">
		{!! Form::label('unidad_placa', 'Unidad placa:', array('class' => 'col-lg-12 col-md-12 col-sm-12 control-label')) !!}
		<div class="col-lg-12 col-md-12 col-sm-12">
			{!! Form::text('unidad_placa', $unidad_placa, array('class' => 'form-control input-xs solo-lectura', 'id' => 'unidad_placa')) !!}
		</div>
	</div>
	<div class="form-group col-1">
		<i id="loader-unidad" class="fa fa-spinner fa-lg text-info" aria-hidden="true" hidden></i>
	</div>
	<div class="form-group col-5">
		{!! Form::label('unidad_descripcion', 'Unidad descripción:', array('class' => 'col-lg-12 col-md-12 col-sm-12 control-label')) !!}
		<div class="col-lg-12 col-md-12 col-sm-12">
			{!! Form::text('unidad_descripcion', $unidad_descripcion, array('class' => 'form-control input-xs solo-lectura', 'id' => 'unidad_descripcion', 'readonly' => true)) !!}
			<input name="unidad_id" id="unidad_id" type="text" class="hidden" value="">
		</div>
	</div>
</div>
<div class="form-row">
	<div class="form-group col-3">
		{!! Form::label('k_inicial', 'Kilometraje inicial:', array('class' => 'col-lg-12 col-md-12 col-sm-12 control-label')) !!}
		<div class="col-lg-12 col-md-12 col-sm-12">
			{!! Form::number('k_inicial', null, array('class' => 'form-control input-xs solo-lectura', 'id' => 'k_inicial')) !!}
		</div>
	</div>
	<div class="form-group col-3">
		{!! Form::label('k_final', 'Kilometraje final:', array('class' => 'col-lg-12 col-md-12 col-sm-12 control-label')) !!}
		<div class="col-lg-12 col-md-12 col-sm-12">
			{!! Form::number('k_final', null, array('class' => 'form-control input-xs solo-lectura', 'id' => 'k_final')) !!}
		</div>
	</div>
	<div class="form-group col-6">
		{!! Form::label('lider_area', 'Lider del área:', array('class' => 'col-lg-12 col-md-12 col-sm-12 control-label')) !!}
		<div class="col-lg-12 col-md-12 col-sm-12">
			{!! Form::text('lider_area', null, array('class' => 'form-control input-xs solo-lectura', 'id' => 'lider_area')) !!}
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
	<div class="col-6 d-flex align-items-center justify-content-end">
		{!! Form::button('<i class="material-icons">edit</i> Editar', array('class' => 'btn btn-warning btn-sm mr-5', 'id' => 'btn', 'hidden' => !$edit)) !!}
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
									{!! Form::radio( $item['id'], 'si', $item['estado'] ? true : false, ['data-type' => 'sistema_electrico', 'data-titulo' => $item['titulo'], 'data-orden' => $item['orden']]) !!}
								</td>
								<td class="text-center">
									{!! Form::radio( $item['id'], 'no', $item['estado'] !== null && !$item['estado'] ? true : false, ['data-type' => 'sistema_electrico', 'data-titulo' => $item['titulo'], 'data-orden' => $item['orden']]) !!}
								</td>
							</tr>
						@endforeach
						<input name="sistema_electrico" id="sistema_electrico" type="text" class="hidden" value="">
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
									{!! Form::radio( $sistema_mecanico[$i]['id'], 'si', $sistema_mecanico[$i]['estado'] ? true : false, ['data-type' => 'sistema_mecanico', 'data-titulo' => $sistema_mecanico[$i]['titulo'], 'data-orden' => $sistema_mecanico[$i]['orden']]) !!}
								</td>
								<td class="text-center">
									{!! Form::radio( $sistema_mecanico[$i]['id'], 'no', $sistema_mecanico[$i]['estado'] !== null && !$sistema_mecanico[$i]['estado'] ? true : false, ['data-type' => 'sistema_mecanico', 'data-titulo' => $sistema_mecanico[$i]['titulo'], 'data-orden' => $sistema_mecanico[$i]['orden']]) !!}
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
									{!! Form::radio( $sistema_mecanico[$i]['id'], 'si', $sistema_mecanico[$i]['estado'] ? true : false, ['data-type' => 'sistema_mecanico', 'data-titulo' => $sistema_mecanico[$i]['titulo'], 'data-orden' => $sistema_mecanico[$i]['orden']]) !!}
								</td>
								<td class="text-center">
									{!! Form::radio( $sistema_mecanico[$i]['id'], 'no', $sistema_mecanico[$i]['estado'] !== null && !$sistema_mecanico[$i]['estado'] ? true : false, ['data-type' => 'sistema_mecanico', 'data-titulo' => $sistema_mecanico[$i]['titulo'], 'data-orden' => $sistema_mecanico[$i]['orden']]) !!}
								</td>
							</tr>
						@endfor
						<input name="sistema_mecanico" id="sistema_mecanico" type="text" class="hidden" value="">
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
									{!! Form::radio( $item['id'], 'si', $item['estado'] ? true : false, ['data-type' => 'accesorios', 'data-titulo' => $item['titulo'], 'data-orden' => $item['orden']]) !!}
								</td>
								<td class="text-center">
									{!! Form::radio( $item['id'], 'no', $item['estado'] !== null && !$item['estado'] ? true : false, ['data-type' => 'accesorios', 'data-titulo' => $item['titulo'], 'data-orden' => $item['orden']]) !!}
								</td>
							</tr>
						@endforeach
						<input name="accesorios" id="accesorios" type="text" class="hidden" value="">
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
									{!! Form::radio( $item['id'], 'si', $item['estado'] ? true : false, ['data-type' => 'documentos', 'data-titulo' => $item['titulo'], 'data-orden' => $item['orden']]) !!}
								</td>
								<td class="text-center">
									{!! Form::radio( $item['id'], 'no', $item['estado'] !== null && !$item['estado'] ? true : false, ['data-type' => 'documentos', 'data-titulo' => $item['titulo'], 'data-orden' => $item['orden']]) !!}
								</td>
							</tr>
						@endforeach
						<input name="documentos" id="documentos" type="text" class="hidden" value="">
					</tbody>
				</table>
			</div>
			<div class="col-4">
				<h5>Observaciones e incidentes</h5>
				<textarea name="observaciones" class="form-control" rows="9" cols="26"></textarea>
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
		const inputUnidadId = document.getElementById('unidad_id');

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
			inputUnidadDescripcion.placeholder = 'Buscando...';
			inputUnidadDescripcion.value = '';
			const loaderUnidad = document.getElementById('loader-unidad');
			if(placa.length > 0){
				loaderUnidad.removeAttribute('hidden');
			} else {
				loaderUnidad.setAttribute('hidden', true);
				inputUnidadDescripcion.placeholder = '';
			}

			if(placa.length >=6) {
				const unidad = await consultarUnidad(placa);
				if(unidad != null) {
					inputUnidadDescripcion.value = unidad.descripcion;
					inputUnidadId.value = unidad.id;
					loaderUnidad.setAttribute('hidden', true);
				} else {
					inputUnidadDescripcion.placeholder = 'Buscando...';
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
					title: el.dataset.titulo,
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
						title: el.dataset.titulo,
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
					title: el.dataset.titulo,
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
						title: el.dataset.titulo,
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
					title: el.dataset.titulo,
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
						title: el.dataset.titulo,
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
					title: el.dataset.titulo,
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
						title: el.dataset.titulo,
						estado: null
					};
					arrObjects.push(myObject);
				}
			});
			console.log(arrObjects)
			document.getElementById('documentos').value = JSON.stringify(arrObjects);
		});

	}); 

</script>
<style>
	.table__personal-body {
		font-size: .85em; !important
	}
</style>