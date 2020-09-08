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
			value="<?php if($abastecimiento) echo $abastecimiento -> fecha_abastecimiento; else echo date('yy-m-d')?>">
	</div>
	<div class="form-group col-12 col-md-6 p-3">
		<label for="id-grifo" class="pl-3">Grifo</label>
		<input type="text" 
			name="grifo_id" 
			id="id-grifo" 
			class="form-control js-grifo-id" 
			value="<?php if($abastecimiento) echo $abastecimiento -> grifo -> descripcion ?>">
		<small id="autoComplete_list2" class="text-danger"></small>
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
		<div class="u-ua-style js-conductor-desc">
			<?php if($abastecimiento) 
				if(isset($abastecimiento -> conductor)) 
				echo $abastecimiento -> conductor -> nombres.' '.$abastecimiento -> conductor -> apellidos; 
				else echo 'Sin dni';
			?>
		</div>
		<input type="text" 
			name="conductor_id" 
			id="id-conductor" 
			class="form-control js-conductor-id" 
			value="<?php if($abastecimiento) echo $abastecimiento -> conductor -> dni?>">
		<small id="autoComplete_list3" class="text-danger"></small>
	</div>
	<div class="form-group col-12 col-md-6 p-3 u-search-ua">
		<label for="id-ua" class="pl-3">Código Ua</label>
		<div class="u-ua-style js-ua-desc">
			<?php if($abastecimiento) if(isset($abastecimiento -> ua)) echo $abastecimiento -> ua -> descripcion; else echo 'Sin ua';?>
		</div>
		<input type="text" 
			name="ua_id" 
			id="id-ua" 
			class="form-control js-ua-id" 
			value="<?php if($abastecimiento) echo $abastecimiento -> ua -> codigo?>">
		<small id="autoComplete_list1" class="text-danger"></small>
	</div>
	<div class="form-group col-12 col-md-6 p-3">
		<label for="id-equipo" class="pl-3">Equipo - Vehículo</label>
		<div class="u-ua-style js-equipo-desc">
			<?php 
				if($abastecimiento) 
					if(isset($abastecimiento -> equipo)) echo $abastecimiento -> equipo -> descripcion;
					else if(isset($abastecimiento -> vehiculo)) echo $abastecimiento -> vehiculo -> modelo 
			?>
		</div>
		<input type="text" 
			name="equipo_id" 
			id="id-equipo" 
			class="form-control js-equipo-id" 
			value="<?php if($abastecimiento) if(isset($abastecimiento -> equipo)) echo $abastecimiento -> equipo -> codigo; else if(isset($abastecimiento -> vehiculo)) echo $abastecimiento -> vehiculo -> placa;?>">
		<input type="hidden" 
			name="equipo_tipo" 
			class="js-equipo-hidden"
			value="<?php if($abastecimiento) if(isset($abastecimiento -> equipo)) echo 'e'; else if(isset($abastecimiento -> vehiculo)) echo 'v';?>">
		<small id="autoComplete_list4" class="text-danger"></small>
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
		doSearchGrifo();
		doSearchConductor();
		doSearchEquipo();
	}); 
</script>