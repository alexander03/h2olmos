<?php 
$icono = '';
if ($controldiario !== NULL) {
	$icono = $controldiario->icono;
}
?>

<div id="divMensajeError{!! $entidad !!}"></div>
{!! Form::open(array('url' => route('controldiario.exportExcelReport'), 'method' => 'GET')) !!}
{!! Form::hidden('listar', $listar, array('id' => 'listar')) !!}

<div class="form-group">

	{!! Form::label('fecha', 'Seleccione el rango del reporte', array('class' => 'col-lg-12 col-md-12 col-sm-12 control-label')) !!}

	<div class="col-12 form-group input-group">
		<div class="col-lg-6 col-md-6 col-sm-12 p-0 m-0 input-group">
			{!! Form::label('fecha', 'Fecha inicial: ', array('class' => 'mt-3 mb-2 col-lg-5 col-md-5 col-sm-6 control-label text-right')) !!}
			<input type="date" name="start_date" id='start_date' class="form-control input-xs">
		</div>
		<div class="col-lg-6 col-md-6 col-sm-12 p-0 m-0 input-group">
			{!! Form::label('fecha', 'Fecha final: ', array('class' => 'mt-3 mb-2 col-lg-5 col-md-5 col-sm-6 control-label text-right')) !!}
			<input type="date" name="end_date" id='end_date' class="form-control input-xs">
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
		getCurrentDate();

		

		endDate.addEventListener('change', (e) => {
			startDate.setAttribute('max', endDate.value);
			
			let start_date = new Date(startDate.value);
			let end_date = new Date(endDate.value);

			if ( start_date > end_date ) startDate.value = endDate.value;
		});

	});
</script>