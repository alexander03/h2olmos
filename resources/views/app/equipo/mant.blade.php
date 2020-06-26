<?php 
$icono = '';
if ($equipo !== NULL) {
	$icono = $equipo->icono;
}
?>

<div id="divMensajeError{!! $entidad !!}"></div>
{!! Form::model($equipo, $formData) !!}	
{!! Form::hidden('listar', $listar, array('id' => 'listar')) !!}
<section class="form-row">
	<div class="form-group col-lg-6 col-md-6 col-sm-12">
		{!! Form::label('codigo', 'Codigo:', array('class' => 'col-lg-12 col-md-12 col-sm-12 control-label')) !!}
		<div class="col-lg-12 col-md-12 col-sm-12">
			{!! Form::text('codigo', null, array('class' => 'form-control input-xs', 'id' => 'codigo')) !!}
		</div>
	</div>
	<div class="form-group col-lg-6 col-md-6 col-sm-12">
		{!! Form::label('descripcion', 'Descripcion:', array('class' => 'col-lg-12 col-md-12 col-sm-12 control-label')) !!}
		<div class="col-lg-12 col-md-12 col-sm-12">
			{!! Form::text('descripcion', null, array('class' => 'form-control input-xs', 'id' => 'descripcion')) !!}
		</div>
	</div>
	<div class="form-group col-lg-6 col-md-6 col-sm-12">
		{!! Form::label('modelo', 'Modelo:', array('class' => 'col-lg-12 col-md-12 col-sm-12 control-label')) !!}
		<div class="col-lg-12 col-md-12 col-sm-12">
			{!! Form::text('modelo', null, array('class' => 'form-control input-xs', 'id' => 'modelo')) !!}
		</div>
	</div>
	<div class="form-group col-lg-6 col-md-6 col-sm-12">
		{!! Form::label('placa', 'Placa:', array('class' => 'col-lg-12 col-md-12 col-sm-12 control-label')) !!}
		<div class="col-lg-12 col-md-12 col-sm-12">
			{!! Form::text('placa', null, array('class' => 'form-control input-xs', 'id' => 'placa')) !!}
		</div>
	</div>
	<div class="form-group col-lg-6 col-md-6 col-sm-12">
		{!! Form::label('motor', 'Motor:', array('class' => 'col-lg-12 col-md-12 col-sm-12 control-label')) !!}
		<div class="col-lg-12 col-md-12 col-sm-12">
			{!! Form::text('motor', null, array('class' => 'form-control input-xs', 'id' => 'motor')) !!}
		</div>
	</div>
	<div class="form-group col-lg-6 col-md-6 col-sm-12">
		{!! Form::label('chasis', 'Chasis:', array('class' => 'col-lg-12 col-md-12 col-sm-12 control-label')) !!}
		<div class="col-lg-12 col-md-12 col-sm-12">
			{!! Form::text('chasis', null, array('class' => 'form-control input-xs', 'id' => 'chasis')) !!}
		</div>
	</div>
	<div class="form-group col-lg-6 col-md-6 col-sm-12">
		{!! Form::label('carroceria', 'Carrocería:', array('class' => 'col-lg-12 col-md-12 col-sm-12 control-label')) !!}
		<div class="col-lg-12 col-md-12 col-sm-12">
			{!! Form::text('carroceria', null, array('class' => 'form-control input-xs', 'id' => 'carroceria')) !!}
		</div>
	</div>
	<div class="form-group col-lg-6 col-md-6 col-sm-12">
		{!! Form::label('color', 'Color:', array('class' => 'col-lg-12 col-md-12 col-sm-12 control-label')) !!}
		<div class="col-lg-12 col-md-12 col-sm-12">
			{!! Form::text('color', null, array('class' => 'form-control input-xs', 'id' => 'color')) !!}
		</div>
	</div>
	<div class="form-group col-lg-6 col-md-6 col-sm-12">
		{!! Form::label('asientos', 'Asientos:', array('class' => 'col-lg-12 col-md-12 col-sm-12 control-label')) !!}
		<div class="col-lg-12 col-md-12 col-sm-12">
			{!! Form::text('asientos', null, array('class' => 'form-control input-xs', 'id' => 'asientos')) !!}
		</div>
	</div>
	<div class="form-group col-lg-6 col-md-6 col-sm-12">
		{!! Form::label('anio', 'Año de fabricación:', array('class' => 'col-lg-12 col-md-12 col-sm-12 control-label')) !!}
		<div class="col-lg-12 col-md-12 col-sm-12">
			{!! Form::text('anio', null, array('class' => 'form-control input-xs', 'id' => 'anio')) !!}
		</div>
	</div>
	<div class="form-group col-lg-6 col-md-6 col-sm-12">
		{!! Form::label('marca_id', 'Marca:', array('class' => 'col-lg-12 col-md-12 col-sm-12 control-label')) !!}
		<div class="col-lg-12 col-md-12 col-sm-12">
			{!! Form::select('marca_id', $cboMarca, null, array('class' => 'form-control input-xs', 'id' => 'marca_id')) !!}
		</div>
	</div>
	<div class="form-group col-lg-6 col-md-6 col-sm-12">
		{!! Form::label('contratista_id', 'Contratista:', array('class' => 'col-lg-12 col-md-12 col-sm-12 control-label')) !!}
		<div class="col-lg-12 col-md-12 col-sm-12">
			{!! Form::select('contratista_id', $cboContratista, null, array('class' => 'form-control input-xs', 'id' => 'contratista_id')) !!}
		</div>
	</div>
	<div class="form-group col-lg-6 col-md-6 col-sm-12">
		{!! Form::label('ua_id', 'UA:', array('class' => 'col-lg-12 col-md-12 col-sm-12 control-label')) !!}
		<div class="col-lg-12 col-md-12 col-sm-12">
			{!! Form::select('ua_id', $cboUa, null, array('class' => 'form-control input-xs', 'id' => 'ua_id')) !!}
		</div>
	</div>
	<div class="form-group col-lg-6 col-md-6 col-sm-12">
		{!! Form::label('area_id', 'Area:', array('class' => 'col-lg-12 col-md-12 col-sm-12 control-label')) !!}
		<div class="col-lg-12 col-md-12 col-sm-12">
			{!! Form::select('area_id', $cboArea, null, array('class' => 'form-control input-xs', 'id' => 'area_id')) !!}
		</div>
	</div>
	<div class="form-group col-lg-6 col-md-6 col-sm-12">
		{!! Form::label('fechavencimientosoat', 'Fecha V SOAT:', array('class' => 'col-lg-12 col-md-12 col-sm-12 control-label')) !!}
		<div class="col-lg-6 col-md-6 col-sm-12">
			{!! Form::date('fechavencimientosoat', null, array('class' => 'form-control input-xs', 'id' => 'fechavencimientosoat')) !!}
		</div>
	</div>
	<div class="form-group col-lg-6 col-md-6 col-sm-12">
		{!! Form::label('fechavencimientogps', 'Fecha V GPS:', array('class' => 'col-lg-12 col-md-12 col-sm-12 control-label')) !!}
		<div class="col-lg-6 col-md-6 col-sm-12">
			{!! Form::date('fechavencimientogps', null, array('class' => 'form-control input-xs', 'id' => 'fechavencimientogps')) !!}
		</div>
	</div>
	<div class="form-group col-lg-6 col-md-6 col-sm-12">
		{!! Form::label('fechavencimientortv', 'Fecha V RTV:', array('class' => 'col-lg-12 col-md-12 col-sm-12 control-label')) !!}
		<div class="col-lg-12 col-md-12 col-sm-12">
			{!! Form::date('fechavencimientortv', null, array('class' => 'form-control input-xs', 'id' => 'fechavencimientortv')) !!}
		</div>
	</div>
	<div class="form-group col-lg-12 col-md-12 col-sm-12">
		<div class="col-lg-12 col-md-12 col-sm-12 text-right">
			{!! Form::button('<i class="fa fa-check fa-lg"></i> '.$boton, array('class' => 'btn btn-success btn-sm', 'id' => 'btnGuardar', 'onclick' => 'guardar(\''.$entidad.'\', this)')) !!}
			{!! Form::button('<i class="fa fa-exclamation fa-lg"></i> Cancelar', array('class' => 'btn btn-warning btn-sm', 'id' => 'btnCancelar'.$entidad, 'onclick' => 'cerrarModal();')) !!}
		</div>
	</div>
</section>
{!! Form::close() !!}
<script type="text/javascript">
	$(document).ready(function() {
		configurarAnchoModal('800');
		init(IDFORMMANTENIMIENTO+'{!! $entidad !!}', 'M', '{!! $entidad !!}');
	}); 
</script>