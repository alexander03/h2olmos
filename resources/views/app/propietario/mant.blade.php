<?php 
$icono = '';
if ($propietario !== NULL) {
	$icono = $propietario->icono;
}
?>

<div id="divMensajeError{!! $entidad !!}"></div>
{!! Form::model($propietario, $formData) !!}	
{!! Form::hidden('listar', $listar, array('id' => 'listar')) !!}
<section class="form-row">
	<div class="form-group col-md-6 p-3">
		<label for="descripcion" class="pl-3">Su descripción</label>
		<textarea name="descripcion" id="descripcion" class="form-control" rows="3">@php if($propietario) echo $propietario->descripcion @endphp</textarea>
	</div>
	<div class="form-group col-md-6 p-3">
		<label for="id-ua" class="pl-3">Su ua</label>
		<select name="ua_id" id="id-ua" class="form-control">
			<option value="0">Seleccione una ua</option>
			@foreach ($uaList as $ua)
			<option value="{{ $ua -> id }}" <?php if($propietario) if($propietario->ua_id == $ua->id) echo 'selected' ?>>{{ $ua -> descripcion }}</option>
			@endforeach
		</select>
	</div>
	<div class="form-group col-md-6 p-3">
	  <label for="id-date-begin" class="pl-3">Su fecha de llegada</label>
	  <input type="date" name="fecha_llegada" id="id-date-begin" class="form-control" value="<?php if($propietario) echo $propietario->fecha_llegada ?>">
	</div>
	<div class="form-group col-md-6 p-3">
	  <label for="id-date-end" class="pl-3">Su fecha de salida</label>
	  <input type="date" name="fecha_salida" id="id-date-end" class="form-control" value="<?php if($propietario) echo $propietario->fecha_salida ?>">
	</div>
	<div class="form-group col-md-6 p-3">
	  <label for="id-date-cont" class="pl-3">Su fecha de contrato</label>
	  <input type="date" name="fecha_contrato" id="id-date-cont" class="form-control" value="<?php if($propietario) echo $propietario->fecha_contrato ?>">
	</div>
	<div class="form-group col-md-6 p-3">
	  <label for="id-status" class="pl-3">Su status</label>
	  <input type="text" name="status" id="id-status" class="form-control" value="<?php if($propietario) echo $propietario->status ?>">
	</div>
	<div class="form-group col-md-6 p-3">
	  <label for="id-hra" class="pl-3">Su hra</label>
	  <input type="text" name="hra" id="id-hra" class="form-control" value="<?php if($propietario) echo $propietario->hra ?>">
	</div>
	<div class="form-group col-md-6 p-3">
	  <label for="id-hrb" class="pl-3">Su hrb</label>
	  <input type="text" name="hrb" id="id-hrb" class="form-control" value="<?php if($propietario) echo $propietario->hrb ?>">
	</div>
	<div class="form-group col-md-6 p-3">
	  <label for="id-hrc" class="pl-3">Su hrc</label>
	  <input type="text" name="hrc" id="id-hrc" class="form-control" value="<?php if($propietario) echo $propietario->hrc ?>">
	</div>
	<div class="form-group col-md-6 p-3">
	  <label for="id-km" class="pl-3">Su Km</label>
	  <input type="number" name="km" id="id-km" class="form-control" value="<?php if($propietario) echo $propietario->km ?>">
	</div>
	<div class="form-group col-md-6 p-3">
	  <label for="id-obs" class="pl-3">Su Observación</label>
	  <textarea name="observacion" id="id-obs" class="form-control" rows="1">@php if($propietario) echo $propietario->observacion @endphp</textarea>
	</div>
	<div class="form-group col-md-6 p-3">
		<label for="id-location" class="pl-3">Su Ubicación</label>
		<input type="text" name="ubicacion" id="id-location" class="form-control" value="<?php if($propietario) echo $propietario->ubicacion ?>">
	</div>
	<div class="form-group col-12 px-3">
		<div class="d-flex justify-content-end">
			{!! Form::button('<i class="fa fa-check fa-lg"></i> '.$boton, array('class' => 'btn btn-success mr-0 mr-sm-2', 'id' => 'btnGuardar', 'onclick' => 'guardar(\''.$entidad.'\', this)')) !!}
			{!! Form::button('<i class="fa fa-exclamation fa-lg"></i> Cancelar', array('class' => 'btn btn-warning', 'id' => 'btnCancelar'.$entidad, 'onclick' => 'cerrarModal();')) !!}
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