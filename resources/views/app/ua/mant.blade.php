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
		<label for="id-codigo" class="pl-3">Código</label>
		<input type="text" name="codigo" id="id-codigo" class="form-control" value="<?php if($ua) echo $ua->codigo ?>">
	</div>
	<div class="form-group col-md-6 p-3">
		<label for="id-desc" class="pl-3">Descripción</label>
		<textarea name="descripcion" id="id-desc" class="form-control" rows="1">@php if($ua) echo $ua->descripcion @endphp</textarea>
	</div>
	<div class="form-group col-md-6 p-3">
		<label for="id-tipo" class="pl-3">Tipo</label>
		<input type="text" name="tipo" id="id-tipo" class="form-control" value="<?php if($ua) echo $ua->tipo ?>">
	</div>
	<div class="form-group col-md-6 p-3">
		<label class="pl-3">Fondos</label>
		<input type="text" class="form-control" style="display: none">
		<section class="d-flex mt-1"> 
			<select class="form-control" name="fondos">
				<option value="">Seleccione si posee fondos</option>
				<option value="1" <?php if($ua) if($ua->fondos) echo 'selected' ?>>Sí</option>
				<option value="0" <?php if($ua) if(!$ua->fondos) echo 'selected' ?>>No</option>
			</select>
		</section>	
	</div>
	<div class="form-group col-md-6 p-3">
		<label for="id-responsable" class="pl-3">Responsable</label>
		<input type="text" name="responsable" id="id-responsable" class="form-control" value="<?php if($ua) echo $ua->responsable ?>">
	</div>
	<div class="form-group col-md-6 p-3">
		<label for="id-t-costo" class="pl-3">Tipo de costo</label>
		<input type="text" name="tipo_costo" id="id-t-costo" class="form-control" value="<?php if($ua) echo $ua->tipo_costo ?>">
	</div>
	<div class="form-group col-md-6 p-3 u-search-ua">
		<label for="autoComplete" class="pl-3">Código Ua Padre</label>
		<div class="u-ua-style js-ua-desc">
			<?php if($ua) if($ua -> ua_padre_id)echo $ua -> uaPadre($ua -> ua_padre_id)[0] -> descripcion; else echo 'Sin padre';?>
		</div>
		<input type="text" 
			tabindex="1"
			name="ua_padre_id"
			class="form-control js-ua-id" 
			value="<?php if($ua) if($ua -> ua_padre_id)echo $ua -> uaPadre($ua -> ua_padre_id)[0] -> codigo; else echo '';?>">
		<small id="autoComplete_list1" class="text-danger"></small>
	</div>
	<div class="form-group col-md-6 p-3">
		<label for="id-unidad" class="pl-3">Unidad</label>
		<input type="text" class="form-control" style="display: none">
		<select name="unidad_id" id="id-unidad" class="form-control">
			<option value="0">Seleccione una unidad</option>
			@foreach ($unidadList as $unidad)
			<option value="{{ $unidad -> id }}" <?php if($ua) if($ua->unidad_id == $unidad->id) echo 'selected' ?>>{{ $unidad -> descripcion }}</option>
			@endforeach
		</select>
	</div>
	<div class="form-group w-100">
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
		doSearchUA();
	}); 
</script>
