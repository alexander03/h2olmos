<?php 
$icono = '';
if ($controldiario !== NULL) {
	$icono = $controldiario->icono;
}
?>

<div id="divMensajeError{!! $entidad !!}"></div>
{!! Form::model($controldiario, $formData) !!}	
{!! Form::hidden('listar', $listar, array('id' => 'listar')) !!}

<div class="form-group">
	{!! Form::label('fecha', 'Fecha :', array('class' => 'col-lg-12 col-md-12 col-sm-12 control-label')) !!}
	<div class="col-lg-12 col-md-12 col-sm-12">
		{!! Form::date('fecha', null, array('class' => 'form-control input-xs', 'id' => 'fecha')) !!}
	</div>
</div>
<div class="form-group">
	{!! Form::label('equipo_id', 'Ua equipo:', array('class' => 'col-lg-12 col-md-12 col-sm-12 control-label')) !!}
	<div class="col-lg-12 col-md-12 col-sm-12">
		<div class="u-ua-style js-equipo-desc"></div>
		<input type="text" name="equipo_id" id="equipo_id" class="form-control js-equipo-id input-xs" 
		value="@if($controldiario){{$controldiario->equipo->codigo}}@endif">
		<small id="autoComplete_list4" class="text-danger"></small>
	</div>
</div>
<p class="h6 text-secondary ml-3 " style="display: inline;">Horarios</p> 
{!! Form::button('<i class="fa fa-plus fa-lg"></i>', array('class' => 'btn btn-success btn-sm', 'id' => 'btnAgregarHora', 'onclick' => 'nuevaFila(this);' , 'data-filas' => '1')) !!}
{!! Form::button('<i class="fa fa-minus fa-lg"></i>', array('class' => 'btn btn-success btn-sm', 'id' => 'btnAgregarHora', 'onclick' => 'quitarFila(this);' , 'data-filas' => '1')) !!}
<div id='filas-horarios'>
	<div class="item mt-3 col-lg-12 col-md-12 col-sm-12">
		<div class="form-group ">		
			{!! Form::label('ua_id', 'Ua :', array('class' => 'col-lg-12 col-md-12 col-sm-12 control-label')) !!}
			<div class="col-lg-12 col-md-12 col-sm-12">
				<div class="u-ua-style js-ua-desc">
					<?php if($controldiario && $controldiario->ua_id) echo $controldiario ->ua->descripcion; ?>
				</div>
				<input type="text" name="ua_id[]" id="ua_id" class="form-control js-ua-id input-xs" 
				value="@if($controldiario && $controldiario->ua_id ){{$controldiario->ua->codigo}}@endif">
				<small id="autoComplete_list1" class="text-danger"></small>
			</div>
		</div>
		<div class="form-row">
			<div class="form-group col-md-3 mt-4">
				{!! Form::label('hora_inicio', 'hora inicio:', array('class' => 'col-lg-12 col-md-12 col-sm-12 control-label')) !!}
				<div class="col-lg-12 col-md-12 col-sm-12 mt-2">
					{!! Form::time('hora_inicio[]', null, array('class' => 'form-control input-xs', 'id' => 'hora_inicio')) !!}
				</div>
			</div>
			<div class="form-group col-md-3 mt-4">
				{!! Form::label('hora_fin', 'hora Fin:', array('class' => 'col-lg-12 col-md-12 col-sm-12 control-label')) !!}
				<div class="col-lg-12 col-md-12 col-sm-12 mt-2">
					{!! Form::time('hora_fin[]', null, array('class' => 'form-control input-xs', 'id' => 'hora_fin')) !!}
				</div>
			</div>
			<div class="form-group col-md-6">
				{!! Form::label('tipohora_id', 'Tipo de hora:', array('class' => 'col-lg-12 col-md-12 col-sm-12 control-label')) !!}
				<div class="col-lg-12 col-md-12 col-sm-12">
					{!! Form::select('tipohora_id[]',$cboThoras, null, array('class' => 'form-control input-xs', 'id' => 'tipohora_id')) !!}
				</div>
			</div>
		</div>
		<hr>
	</div>

</div>


<div class="form-group">
	{!! Form::label('turno', 'Turno:', array('class' => 'col-lg-12 col-md-12 col-sm-12 control-label')) !!}
	<div class="col-lg-12 col-md-12 col-sm-12">
		{!! Form::select('turno', $cboTurnos ,null, array('class' => 'form-control input-xs', 'id' => 'turno')) !!}
	</div>
</div>
<div class="volquete d-none">
	<div class="form-group">
		{!! Form::label('inicio', 'Inicio:', array('class' => 'col-lg-12 col-md-12 col-sm-12 control-label')) !!}
		<div class="col-lg-12 col-md-12 col-sm-12">
			{!! Form::text('inicio', null, array('class' => 'form-control input-xs', 'id' => 'inicio')) !!}
		</div>
	</div>
	<div class="form-group">
		{!! Form::label('acceso', 'Acceso:', array('class' => 'col-lg-12 col-md-12 col-sm-12 control-label')) !!}
		<div class="col-lg-12 col-md-12 col-sm-12">
			{!! Form::text('acceso', null, array('class' => 'form-control input-xs', 'id' => 'acceso')) !!}
		</div>
	</div>
	<div class="form-group">
		{!! Form::label('uaorigen', 'Ua origen:', array('class' => 'col-lg-12 col-md-12 col-sm-12 control-label')) !!}
		<div class="col-lg-12 col-md-12 col-sm-12">
			{!! Form::text('uaorigen', null, array('class' => 'form-control input-xs', 'id' => 'uaorigen')) !!}
		</div>
	</div>
	<div class="form-group">
		{!! Form::label('destino', 'Destino:', array('class' => 'col-lg-12 col-md-12 col-sm-12 control-label')) !!}
		<div class="col-lg-12 col-md-12 col-sm-12">
			{!! Form::text('destino', null, array('class' => 'form-control input-xs', 'id' => 'destino')) !!}
		</div>
	</div>
	<div class="form-group">
		{!! Form::label('uadestino', 'Ua destino:', array('class' => 'col-lg-12 col-md-12 col-sm-12 control-label')) !!}
		<div class="col-lg-12 col-md-12 col-sm-12">
			{!! Form::text('uadestino', null, array('class' => 'form-control input-xs', 'id' => 'uadestino')) !!}
		</div>
	</div>
	<div class="form-group">
		{!! Form::label('distancia', 'Distancia recorrida:', array('class' => 'col-lg-12 col-md-12 col-sm-12 control-label')) !!}
		<div class="col-lg-12 col-md-12 col-sm-12">
			{!! Form::text('distancia', null, array('class' => 'form-control input-xs', 'id' => 'distancia')) !!}
		</div>
	</div>
	<div class="form-group">
		{!! Form::label('material', 'Tipo de material:', array('class' => 'col-lg-12 col-md-12 col-sm-12 control-label')) !!}
		<div class="col-lg-12 col-md-12 col-sm-12">
			{!! Form::text('material', null, array('class' => 'form-control input-xs', 'id' => 'material')) !!}
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
<script type="text/javascript">
	$(document).ready(function() {
		configurarAnchoModal('450');
		init(IDFORMMANTENIMIENTO+'{!! $entidad !!}', 'M', '{!! $entidad !!}');
		doSearchUA();
		doSearchUA();
		doSearchEquipo();

		nuevaFila = (boton) =>{
			let Num = Number(boton.getAttribute('data-filas'));
			Num = Num +1;

			const newFila = document.createElement('div');
			newFila.setAttribute('class' ,'item mt-3 col-lg-12 col-md-12 col-sm-12') ;

			newFila.innerHTML = ` 
					<div class="form-group ">	
						<label For="ua_id_${Num}" class="col-lg-12 col-md-12 col-sm-12 control-label">Ua :</label>
						<div class="col-lg-12 col-md-12 col-sm-12">
							<div class="u-ua-style js-ua-desc-${Num}">
							</div>
							<input type="text" name="ua_id[]" id="ua_id_${Num}" class="form-control js-ua-id-${Num} input-xs" >
							<small id="autoComplete_list1-${Num}" class="text-danger"></small>
						</div>
					</div>
					<div class="form-row">
						<div class="form-group col-md-3 mt-4">
							<label For="hora_inicio_${Num}" class="col-lg-12 col-md-12 col-sm-12 control-label">Hora inicio : </label>
							<div class="col-lg-12 col-md-12 col-sm-12 mt-2">
								<input type="time" class="form-control input-xs" name="hora_inicio[]" id='hora_inicio_${Num}'>
							</div>
						</div>
						<div class="form-group col-md-3 mt-4">
							<label For="hora_fin_${Num}" class="col-lg-12 col-md-12 col-sm-12 control-label">Hora fin : </label>
							<div class="col-lg-12 col-md-12 col-sm-12 mt-2">
								<input type="time" class="form-control input-xs" name="hora_fin[]" id='hora_fin_${Num}'>
							</div>
						</div>
						<div class="form-group col-md-6">
							<label for="tipohora_id_${Num}" class="col-lg-12 col-md-12 col-sm-12 control-label">Tipo de hora: : </label>
							<div class="col-lg-12 col-md-12 col-sm-12">
							</div>
						</div>
					</div>
					<hr>
			`;

			const selector = document.getElementById('tipohora_id').cloneNode(true);
			selector.setAttribute('id',`tipohora_id_${Num}`);
			console.log(newFila.querySelector(`label[for="tipohora_id_${Num}"]`));
			newFila.querySelector(`label[For="tipohora_id_${Num}"]`).nextElementSibling.appendChild(selector);

			document.getElementById('filas-horarios').appendChild(newFila);
			boton.setAttribute('data-filas',Num);
			boton.nextElementSibling.setAttribute('data-filas',Num);
			doSearchUA('.js-ua-id-'+Num,'.js-ua-desc-'+Num,'#autoComplete_list1-'+Num);

		}

		quitarFila = (boton) =>{
			let Num = Number(boton.getAttribute('data-filas'));
			if(Num > 1){
				Num = Num -1;
				document.getElementById('filas-horarios').lastChild.remove();
				boton.setAttribute('data-filas',Num);
				boton.previousElementSibling.setAttribute('data-filas',Num);
			}
		}
	}); 
</script>