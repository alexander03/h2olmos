<?php 
$icono = '';
if ($vehiculo !== NULL) {
	$icono = $vehiculo->icono;
}
?>

<div id="divMensajeError{!! $entidad !!}"></div>
{!! Form::model($vehiculo, $formData) !!}	
{!! Form::hidden('listar', $listar, array('id' => 'listar')) !!}
<div class='form-row'>
	<div class="form-group col-md-6 mt-4">

		{!! Form::label('ua_id', 'Ua :', array('class' => 'col-lg-12 col-md-12 col-sm-12 control-label')) !!}
		<div class="col-lg-12 col-md-12 col-sm-12">
			<div class="u-ua-style js-ua-desc">
				<?php if($vehiculo && $vehiculo->ua_id) echo $vehiculo ->ua->descripcion; ?>
			</div>
			<input type="text" name="ua_id" id="ua_id" class="form-control js-ua-id input-xs" 
			value="@if($vehiculo && $vehiculo->ua_id ){{$vehiculo->ua->codigo}}@endif">
			<small id="autoComplete_list1" class="text-danger"></small>
		</div>
	</div>
	<div class="form-group col-md-6 mt-4">
		{!! Form::label('modelo', 'Modelo:', array('class' => 'col-lg-12 col-md-12 col-sm-12 control-label')) !!}
		<div class="col-lg-12 col-md-12 col-sm-12">
			{!! Form::text('modelo', null, array('class' => 'form-control input-xs', 'id' => 'modelo')) !!}
		</div>
	</div>
	<div class="form-group col-md-6 mt-4">
		{!! Form::label('anio', 'Año de fabricación:', array('class' => 'col-lg-12 col-md-12 col-sm-12 control-label')) !!}
		<div class="col-lg-12 col-md-12 col-sm-12">
			{!! Form::text('anio', null, array('class' => 'form-control input-xs', 'id' => 'anio')) !!}
		</div>
	</div>
	<div class="form-group col-md-6 mt-4">
		{!! Form::label('placa', 'Placa:', array('class' => 'col-lg-12 col-md-12 col-sm-12 control-label')) !!}
		<div class="col-lg-12 col-md-12 col-sm-12">
			{!! Form::text('placa', null, array('class' => 'form-control input-xs', 'id' => 'placa')) !!}
		</div>
	</div>
	<div class="form-group col-md-6 mt-4">
		{!! Form::label('motor', 'Motor:', array('class' => 'col-lg-12 col-md-12 col-sm-12 control-label')) !!}
		<div class="col-lg-12 col-md-12 col-sm-12">
			{!! Form::text('motor', null, array('class' => 'form-control input-xs', 'id' => 'motor')) !!}
		</div>
	</div>
	<div class="form-group col-md-6 mt-4">
		{!! Form::label('chasis', 'Chasis:', array('class' => 'col-lg-12 col-md-12 col-sm-12 control-label')) !!}
		<div class="col-lg-12 col-md-12 col-sm-12">
			{!! Form::text('chasis', null, array('class' => 'form-control input-xs', 'id' => 'chasis')) !!}
		</div>
	</div>
	<div class="form-group col-md-6 mt-4">
		{!! Form::label('color', 'Color:', array('class' => 'col-lg-12 col-md-12 col-sm-12 control-label')) !!}
		<div class="col-lg-12 col-md-12 col-sm-12">
			{!! Form::text('color', null, array('class' => 'form-control input-xs', 'id' => 'color')) !!}
		</div>
	</div>
	<div class="form-group col-md-6 mt-4">
		{!! Form::label('asientos', 'Asientos:', array('class' => 'col-lg-12 col-md-12 col-sm-12 control-label')) !!}
		<div class="col-lg-12 col-md-12 col-sm-12">
			{!! Form::text('asientos', null, array('class' => 'form-control input-xs', 'id' => 'asientos')) !!}
		</div>
	</div>
	<div class="form-group col-md-6  ">
		{!! Form::label('area_id', 'Area:', array('class' => 'col-lg-12 col-md-12 col-sm-12 control-label')) !!}
		<div class="col-lg-12 col-md-12 col-sm-12">
			{!! Form::select('area_id', $cboArea, null, array('class' => 'form-control input-xs', 'id' => 'area_id')) !!}
		</div>
	</div>
	<div class="form-group col-md-6 ">
		{!! Form::label('marca_id', 'Marca:', array('class' => 'col-lg-12 col-md-12 col-sm-12 control-label')) !!}
		<div class="col-lg-12 col-md-12 col-sm-12">
			{!! Form::select('marca_id', $cboMarca, null, array('class' => 'form-control input-xs', 'id' => 'marca_id')) !!}
		</div>
	</div>
	<div class="form-group col-md-6 ">
		{!! Form::label('contratista_id', 'Contratista:', array('class' => 'col-lg-12 col-md-12 col-sm-12 control-label')) !!}
		<div class="col-lg-12 col-md-12 col-sm-12">
			{!! Form::select('contratista_id', $cboContratista, null, array('class' => 'form-control input-xs', 'id' => 'contratista_id')) !!}
		</div>
	</div>
	<div class="form-group col-md-6 ">
		{!! Form::label('kilometraje_id', 'Regla kilometraje:', array('class' => 'col-lg-12 col-md-12 col-sm-12 control-label')) !!}
		<div class="col-lg-12 col-md-12 col-sm-12">
			{!! Form::select('kilometraje_id', $cboKilometraje, null, array('class' => 'form-control input-xs', 'id' => 'kilometraje_id')) !!}
		</div>
	</div>
	<div class="form-group col-md-6 mt-4">
		{!! Form::label('kilometraje_ref', 'Kilometraje: referencial', array('class' => 'col-lg-12 col-md-12 col-sm-12 control-label')) !!}
		<div class="col-lg-12 col-md-12 col-sm-12">
			{!! Form::text('kilometraje_ref', null, array('class' => 'form-control input-xs', 'id' => 'kilometraje_ref')) !!}
		</div>
	</div>
	<div class="form-group col-md-6 ">
		{!! Form::label('carroceria_id', 'Carrocería:', array('class' => 'col-lg-12 col-md-12 col-sm-12 control-label')) !!}
		<div class="col-lg-12 col-md-12 col-sm-12">
			{!! Form::select('carroceria_id', $cboCarroceria ,null, array('class' => 'form-control input-xs', 'id' => 'carroceria_id')) !!}
		</div>
	</div>
</div>
<div class="form-group ">
		{!! Form::button('<i class="fa fa-check fa-lg"></i> '.$boton, array('class' => 'btn btn-success btn-sm', 'id' => 'btnGuardar', 'onclick' => 'guardar(\''.$entidad.'\', this)')) !!}
		{!! Form::button('<i class="fa fa-exclamation fa-lg"></i> Cancelar', array('class' => 'btn btn-warning btn-sm', 'id' => 'btnCancelar'.$entidad, 'onclick' => 'cerrarModal();')) !!}
</div>
{!! Form::close() !!}
<script type="text/javascript">
	$(document).ready(function() {
		configurarAnchoModal('500');
		init(IDFORMMANTENIMIENTO+'{!! $entidad !!}', 'M', '{!! $entidad !!}');
		doSearchUA();
	}); 
</script>
