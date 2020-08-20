<?php 
$icono = '';
if ($abastecimiento !== NULL) {
	$icono = $abastecimiento->icono;
}
?>

<div id="divMensajeError{!! $entidad !!}"></div>
{!! Form::model($abastecimiento, $formData) !!}	
{!! Form::hidden('listar', $listar, array('id' => 'listar')) !!}
<section class="form-row">
	<div class="form-group col-12 col-md-6 p-3">
		<label for="id-fa" class="pl-3">Fecha de abastecimiento</label>
		<input type="date" 
			name="fecha_abastecimiento" 
			id="id-fa" 
			class="form-control" 
			value="<?php if($abastecimiento) echo $abastecimiento -> fecha_abastecimiento ?>">
	</div>
	<div class="form-group col-12 col-md-6 p-3">
		<label for="id-grifo" class="pl-3">Grifo</label>
		<input type="text" 
			name="grifo_id" 
			id="id-grifo" 
			class="form-control" 
			value="<?php if($abastecimiento) echo $abastecimiento -> grifo -> descripcion ?>">
	</div>
	<div class="form-group col-12 col-md-6 p-3">
		<label for="id-tipo-comb" class="pl-3">Tipo de combustible</label>
		<input type="text" 
			name="tipo_combustible" 
			id="id-tipo-comb" 
			class="form-control" 
			value="<?php if($abastecimiento) echo $abastecimiento -> tipo_combustible ?>">
	</div>
	<div class="form-group col-12 col-md-6 p-3">
		<label for="id-conductor" class="pl-3">Conductor</label>
		<input type="text" 
			name="conductor_id" 
			id="id-conductor" 
			class="form-control" 
			value="<?php if($abastecimiento) echo $abastecimiento -> conductor -> nombres.' '.$abastecimiento -> conductor -> apellidos?>">
	</div>
	<div class="form-group col-12 col-md-6 p-3">
		<label for="id-ua" class="pl-3">Ua</label>
		<input type="text" 
			name="ua_id" 
			id="id-ua" 
			class="form-control" 
			value="<?php if($abastecimiento) echo $abastecimiento -> ua -> descripcion?>">
	</div>
	<div class="form-group col-12 col-md-6 p-3">
		<label for="id-equipo" class="pl-3">Equipo</label>
		<input type="text" 
			name="equipo_id" 
			id="id-equipo" 
			class="form-control" 
			value="<?php if($abastecimiento) echo $abastecimiento -> equipo -> descripcion?>">
	</div>
	<div class="form-group col-12 col-md-6 p-3">
		<label for="id-qtdgl" class="pl-3">QTD(GL)</label>
		<input type="number" 
			name="qtdgl" 
			id="id-qtdgl" 
			class="form-control" 
			value="<?php if($abastecimiento) echo $abastecimiento -> qtdgl?>">
	</div>
	<div class="form-group col-12 col-md-6 p-3">
		<label for="id-qtdl" class="pl-3">QTD(L)</label>
		<input type="number" 
			name="qtdl" 
			id="id-qtdl" 
			class="form-control" 
			value="<?php if($abastecimiento) echo $abastecimiento -> qtdl?>">
	</div>
	<div class="form-group col-12 col-md-6 p-3">
		<label for="id-km" class="pl-3">km</label>
		<input type="number" 
			name="km" 
			id="id-km" 
			class="form-control" 
			value="<?php if($abastecimiento) echo $abastecimiento -> km?>">
	</div>
	<div class="form-group col-12 col-md-6 p-3">
		<label for="id-abast-dia" class="pl-3">Abastecimiento por día</label>
		<input type="number" 
			name="abastecimiento_dia" 
			id="id-abast-dia" 
			class="form-control" 
			value="<?php if($abastecimiento) echo $abastecimiento -> abastecimiento_dia?>">
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