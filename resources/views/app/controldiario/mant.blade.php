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
		{!! Form::text('equipo_id', null, array('class' => 'form-control input-xs js-equipo', 'id' => 'equipo_id')) !!}
	</div>
</div>
<div class="form-group">
	{!! Form::label('ua_id', 'Ua :', array('class' => 'col-lg-12 col-md-12 col-sm-12 control-label')) !!}
	<div class="col-lg-12 col-md-12 col-sm-12">
		{!! Form::text('ua_id', null, array('class' => 'form-control js-ua-id input-xs', 'id' => 'ua_id')) !!}
	</div>
</div>
<div class="form-group">
	{!! Form::label('hora_inicio', 'hora de inicio:', array('class' => 'col-lg-12 col-md-12 col-sm-12 control-label')) !!}
	<div class="col-lg-12 col-md-12 col-sm-12">
		{!! Form::time('hora_inicio', null, array('class' => 'form-control input-xs', 'id' => 'hora_inicio')) !!}
	</div>
</div>
<div class="form-group">
	{!! Form::label('hora_fin', 'hora de finalización:', array('class' => 'col-lg-12 col-md-12 col-sm-12 control-label')) !!}
	<div class="col-lg-12 col-md-12 col-sm-12">
		{!! Form::time('hora_fin', null, array('class' => 'form-control input-xs', 'id' => 'hora_fin')) !!}
	</div>
</div>
<div class="form-group">
	{!! Form::label('tipohora_id', 'Tipo de hora:', array('class' => 'col-lg-12 col-md-12 col-sm-12 control-label')) !!}
	<div class="col-lg-12 col-md-12 col-sm-12">
		{!! Form::select('tipohora_id',$cboThoras, null, array('class' => 'form-control input-xs', 'id' => 'tipohora_id')) !!}
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
		configurarAnchoModal('350');
		init(IDFORMMANTENIMIENTO+'{!! $entidad !!}', 'M', '{!! $entidad !!}');
		doSearchUA();
		doSearchEquipo();
	}); 
</script>