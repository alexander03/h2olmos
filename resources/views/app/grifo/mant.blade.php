<?php 
$icono = '';
if ($grifo !== NULL) {
	$icono = $grifo->icono;
}
?>

<div id="divMensajeError{!! $entidad !!}"></div>
{!! Form::model($grifo, $formData) !!}	
{!! Form::hidden('listar', $listar, array('id' => 'listar')) !!}

<div class="form-group">
	{!! Form::label('descripcion', 'Descripcion:', array('class' => 'col-lg-12 col-md-12 col-sm-12 control-label')) !!}
	<div class="col-lg-12 col-md-12 col-sm-12">
		{!! Form::text('descripcion', null, array('class' => 'form-control input-xs', 'id' => 'descripcion')) !!}
	</div>
</div>
<div class="form-group">
	{!! Form::label('ubicacion', 'Ubicación:', array('class' => 'col-lg-12 col-md-12 col-sm-12 control-label')) !!}
	<div class="col-lg-12 col-md-12 col-sm-12">
		{!! Form::text('ubicacion', null, array('class' => 'form-control input-xs', 'id' => 'ubicacion')) !!}
	</div>
</div>
<div class="form-group ">
	{!! Form::label('abastecimiento_id', 'lugar de abastecimiento:', array('class' => 'col-lg-12 col-md-12 col-sm-12 control-label')) !!}
	<div class="col-lg-12 col-md-12 col-sm-12">
		{!! Form::select('abastecimiento_id', $cboAbastecimiento, null, array('class' => 'form-control input-xs', 'id' => 'abastecimiento_id')) !!}
	</div>
</div>
<div class="form-group">
	{!! Form::label('contacto', 'Nombre de contacto:', array('class' => 'col-lg-12 col-md-12 col-sm-12 control-label')) !!}
	<div class="col-lg-12 col-md-12 col-sm-12">
		{!! Form::text('contacto', null, array('class' => 'form-control input-xs', 'id' => 'contacto')) !!}
	</div>
</div>
<div class="form-group">
	{!! Form::label('telefono', 'teléfono de contacto:', array('class' => 'col-lg-12 col-md-12 col-sm-12 control-label')) !!}
	<div class="col-lg-12 col-md-12 col-sm-12">
		{!! Form::text('telefono', null, array('class' => 'form-control input-xs', 'id' => 'telefono')) !!}
	</div>
</div>
<div class="form-group">
	{!! Form::label('correo', 'correo de contacto:', array('class' => 'col-lg-12 col-md-12 col-sm-12 control-label')) !!}
	<div class="col-lg-12 col-md-12 col-sm-12">
		{!! Form::text('correo', null, array('class' => 'form-control input-xs', 'id' => 'correo')) !!}
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
	}); 
</script>