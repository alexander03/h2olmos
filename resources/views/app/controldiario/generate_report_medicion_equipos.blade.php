<?php 
$icono = '';
if ($controldiario !== NULL) {
	$icono = $controldiario->icono;
}
?>

<div id="divMensajeError{!! $entidad !!}"></div>
{!! Form::open(array('url' => route('controldiario.exportExcelReportMedicionEquipos'), 'method' => 'POST', 'target' => '_blank')) !!}
{!! Form::hidden('listar', $listar, array('id' => 'listar')) !!}

<div class="form-group">

	{{-- ENCABEZADO PRINCIPAL --}}
	<div class="col-12 container-small form-group">
		<div class="shadow rounded pt-2 table-primary input-group" style="border: 1px solid;">
			<div class="col-12 form-group input-group">
				{!! Form::label('fecha', 'Seleccione el rango de fechas del reporte', array('class' => 'col-lg-8 col-md-8 col-sm-8 control-label mt-1 mb-0 h5 font-weight-bold text-dark')) !!}
				<div class="col-4 p-0 m-0 input-group">
					{!! Form::label(NULL, 'Reporte', array('class' => 'col-lg-6 col-md-6 col-sm-6 control-label mt-1 mb-0 font-weight-bold text-dark')) !!}
					{!! Form::select('reporte', ['bya (os) - 2' => 'B&A', 'jymp (os) - 1' => 'J&MP'], 'bya (os) - 2', ['class' => 'col-6 pt-0 pb-0 pl-2 form-control-sm']) !!}
				</div>
			</div>
			<div class="col-12 form-group input-group">
				<div class="col-lg-6 col-md-6 col-sm-12 p-0 m-0 input-group">
					{!! Form::label('start_date', 'Fecha inicial: ', array('class' => 'mt-3 col-lg-5 col-md-5 col-sm-6 control-label text-right text-dark')) !!}
					<input type="date" name="start_date" id='start_date' class="form-control input-xs mt-1">
				</div>
				<div class="col-lg-6 col-md-6 col-sm-12 p-0 m-0 input-group">
					{!! Form::label('end_date', 'Fecha final: ', array('class' => 'mt-3 col-lg-5 col-md-5 col-sm-6 control-label text-right text-dark')) !!}
					<input type="date" name="end_date" id='end_date' class="form-control input-xs mt-1">
				</div>
			</div>
		</div>
	</div>

	{{-- OPCIONES DE EQUIPOS --}}
	<div class="col-12 container-small form-group">

		<div id="equipos_found" class="shadow rounded table-primary" style="border: 1px solid;">
			<div class="col-12 pt-2">
				{!! Form::label(NULL, 'Todos los equipos: ', array('class' => 'col-3 control-label text-dark mt-2')) !!}
				{!! Form::checkbox('all_equipos', NULL, true, ['id' => 'cb_all_equipos']) !!}
			</div>
			<hr class="mt-2 mb-2">
			<div id="table_checkbox_equipos" class="col-12 mb-1"></div>
		</div>

		<div id="equipos_not_found" class="shadow rounded table-warning" style="border: 1px solid;">
			{!! Form::label(NULL, '¡No se han encontrado equipos que hayan trabajado entre esas fechas!', array('class' => 'col-12 control-label h5 mt-2 mb-2 text-warning')) !!}
		</div>
		
		<div id="loading_equipos" class="shadow rounded table-primary" style="border: 1px solid;">
			{!! Form::label(NULL, 'Cargando...', array('class' => 'col-12 control-label h5 mt-2 mb-2 text-success')) !!}
		</div>

	</div>

</div>

<div class="form-group">
	<div class="col-lg-12 col-md-12 col-sm-12 text-right">
		{{-- <a href="{{ route('controldiario.exportExcelReport') }}" target="_blank" class="btn btn-sm btn-primary" title="Exportar">
			<i class="material-icons">cloud_download</i> Generar Reporte
		</a> --}}
		{!! Form::button('<i class="fa fa-check fa-lg"></i> '.$boton, array('class' => 'btn btn-success btn-sm', 'id' => 'btnGenerar', 'type' => 'submit')) !!}
		{!! Form::button('<i class="fa fa-exclamation fa-lg"></i> Cancelar', array('class' => 'btn btn-warning btn-sm', 'id' => 'btnCancelar'.$entidad, 'onclick' => 'cerrarModal();')) !!}
	</div>
</div>

{!! Form::close() !!}

<script type="text/javascript">
	$(document).ready(function() {
		configurarAnchoModal('750');
		init(IDFORMMANTENIMIENTO+'{!! $entidad !!}', 'M', '{!! $entidad !!}');

		
		// Control de fechas
		const startDate = document.getElementById('start_date');
		const endDate = document.getElementById('end_date');

		const getCurrentDate = () => {
			const fecha = new Date();
			let mes = fecha.getMonth()+1;
			let dia = fecha.getDate();
			const ano = fecha.getFullYear();
			if(dia<10) dia = '0' + dia;
			if(mes<10) mes = '0' + mes;

			endDate.value = ano+"-"+mes+"-"+dia;
			startDate.setAttribute('max', ano+"-"+mes+"-"+dia);
		}
		
		
		// Control de equipos
		const equiposFound = document.getElementById('equipos_found');
		const equiposNotFound = document.getElementById('equipos_not_found');
		const loadingEquipos = document.getElementById('loading_equipos');
		const tableCheckboxEquipos = Array.from([document.getElementById('table_checkbox_equipos')])[0];
		const cbAllEquipos = Array.from([document.getElementById('cb_all_equipos')])[0];
		const listCheckboxEquipos = () => Array.from(document.getElementsByName('checkbox_equipo'));

		const evaluateCheckedBoxes = () => {
			let equipos = listCheckboxEquipos();
			let checked = true;
			
			for (let i = 0; i < equipos.length; i++) {
				Array.from(equipos[i].children).forEach(child => {
					if ( child.localName == 'input' ) checked = child.checked;
				});
				
				if ( !checked ) break;
			}

			cbAllEquipos.checked = checked;
		}
		const addEventListeners = () => {
			listCheckboxEquipos().forEach(equipo => {
				Array.from(equipo.children).forEach(child => {
					if ( child.localName == 'input' ) child.addEventListener('change', (e) => {
						evaluateCheckedBoxes();
					});
				});
			});
		}
		const queryGetEquipos = async () => {
			let url = `./controldiario/getEquipos?startDate=${startDate.value}&endDate=${endDate.value}`;

			return await fetch(url)
				.then(response => response.status === 200 ? response.json() : console.error(`Error on getEquipos's method. Status: ${response.status}`))
				.then(response => response.listEquipos)
				.catch(error => console.error(`Error on getEquipos' method. Exception: ${error}`));
		}
		const getEquipos = async () => {
			if ( !startDate.value || !endDate.value || startDate.value > endDate.value ) return;
			
			equiposFound.hidden = true;
			equiposNotFound.hidden = true;
			loadingEquipos.hidden = false;

			let listEquipos = await queryGetEquipos();

			if ( listEquipos.length > 0 ) {
				tableCheckboxEquipos.innerHTML = '';

				listEquipos.forEach(equipo => {
					tableCheckboxEquipos.innerHTML += `
						<div name="checkbox_equipo" class="col-12 input-group">
							<input type="checkbox" name="equipo[]" value="${equipo.id}" class="col-1 form-control-sm mt-1 mb-1" checked>
							<label class="col-11 control-label text-dark mb-1">${equipo.descripcion}</label>
						</div>
					`;
				});

				equiposFound.hidden = false;

				addEventListeners();
			} else {
				equiposNotFound.hidden = false;
			}

			loadingEquipos.hidden = true;
		}
		

		// Inicio de la pagina
		const start = () => {
			equiposFound.hidden = true;
			equiposNotFound.hidden = true;
			loadingEquipos.hidden = true;
		}

		start();
		getCurrentDate();

		// Eventos de la pagina
		endDate.addEventListener('change', async (e) => {
			startDate.setAttribute('max', endDate.value);
			
			let start_date = new Date(startDate.value);
			let end_date = new Date(endDate.value);

			if ( start_date > end_date ) startDate.value = endDate.value;

			if ( endDate.value ) getEquipos();
		});
		startDate.addEventListener('change', async () => {
			if ( startDate.value ) getEquipos();
		});
		cbAllEquipos.addEventListener('change', (e) => {
			let checked = e.srcElement.checked
			
			listCheckboxEquipos().forEach(equipo => {
				Array.from(equipo.children).forEach(child => {
					if ( child.localName == 'input' ) child.checked = checked;
				});
			});
		});
	});
</script>