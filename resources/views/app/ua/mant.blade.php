<?php 
$icono = '';
if ($ua !== NULL) {
	$icono = $ua->icono;
}
?>

<div id="divMensajeError{!! $entidad !!}"></div>
{!! Form::model($ua, $formData) !!}	
{!! Form::hidden('listar', $listar, array('id' => 'listar')) !!}
<section class="form-row">
	<div class="form-group col-md-6 p-3">
		<label for="id-codigo" class="pl-3">Su código</label>
		<input type="number" name="codigo" id="id-codigo" class="form-control" value="<?php if($ua) echo $ua->codigo ?>">
	</div>
	<div class="form-group col-md-6 p-3">
		<label for="id-desc" class="pl-3">Su descripción</label>
		<textarea name="descripcion" id="id-desc" class="form-control" rows="1">@php if($ua) echo $ua->descripcion @endphp</textarea>
	</div>
	<div class="form-group col-md-6 p-3">
		<label for="id-tipo" class="pl-3">Su tipo</label>
		<input type="text" name="tipo" id="id-tipo" class="form-control" value="<?php if($ua) echo $ua->tipo ?>">
	</div>
	<div class="form-group col-md-6 p-3">
		<label class="pl-3">¿Posee fondos?</label>
		<input type="text" class="form-control" style="display: none">
		<section class="d-flex mt-1"> 
			<div style="width: 50%;" class="d-flex">
				<input style="height:25px; width:25px" class="form-control mr-2" type="radio" id="id-tipo1" name="fondos" value="1" <?php if($ua) if($ua->fondos) echo 'checked' ?>>
				Sí
			</div>
			<div style="width: 50%;" class="d-flex">
				<input style="height:25px; width:25px" class="form-control mr-2" type="radio" id="id-tipo2" name="fondos" value="0" <?php if($ua) if(!$ua->fondos) echo 'checked' ?>>
				No
			</div>
		</section>	
	</div>
	<div class="form-group col-md-6 p-3">
		<label for="id-responsable" class="pl-3">Su responsable</label>
		<input type="text" name="responsable" id="id-responsable" class="form-control" value="<?php if($ua) echo $ua->responsable ?>">
	</div>
	<div class="form-group col-md-6 p-3">
		<label for="id-t-costo" class="pl-3">Su tipo de costo</label>
		<input type="text" name="tipo_costo" id="id-t-costo" class="form-control" value="<?php if($ua) echo $ua->tipo_costo ?>">
	</div>
	<div class="form-group col-md-12 p-3">
		<label for="id-unidad" class="pl-3">Su unidad</label>
		<select name="unidad_id" id="id-unidad" class="form-control">
			<option value="0">Seleccione una unidad</option>
			@foreach ($unidadList as $unidad)
			<option value="{{ $unidad -> id }}" <?php if($ua) if($ua->unidad_id == $unidad->id) echo 'selected' ?>>{{ $unidad -> descripcion }}</option>
			@endforeach
		</select>
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