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
		<label class="pl-3">Estado</label>
		<input type="text" class="form-control" style="display: none">
		<section class="d-flex mt-1"> 
			<select class="form-control" name="habilitada">
				<option value="">Seleccione estado de ua</option>
				<option value="1" <?php if($ua) if($ua->habilitada) echo 'selected' ?>>Habilitada</option>
				<option value="0" <?php if($ua) if(!$ua->habilitada) echo 'selected' ?>>Deshabilitada</option>
			</select>
		</section>	
	</div>
	<div class="form-group col-md-6 p-3">
		<label class="pl-3">Pertenece a UA Padre</label>
		<input type="text" class="form-control" style="display: none">
		<section class="d-flex mt-1"> 
			<select class="form-control" name="espadre" onchange="if(this.value=='N'){$('.u-search-ua').css('display','none');}else{$('.u-search-ua').css('display','');}">
				<option value="S" <?php if($ua) if($ua->ua_padre_id /*|| count($ua->uaHija($ua->id))>0*/) echo 'selected' ?>>ACTIVADO</option>
				<option value="N" <?php if($ua) if(!$ua->ua_padre_id>0 /*&& count($ua->uaHija($ua->id))==0*/) echo 'selected' ?>>DESACTIVADO</option>
			</select>
		</section>	
	</div>
	
	<div class="form-group col-md-6 p-3 u-search-ua" style="<?php if(!is_null($ua) && !is_null($ua->ua_padre_id)){echo '';}else{'display:none;';}?>">
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
		<label for="id-f-init" class="pl-3">Fecha de inicio</label>
		<input type="date" name="fecha_inicio" id="id-f-init" class="form-control" value="<?php if($ua) echo $ua->fecha_inicio; else echo date('yy-m-d'); ?>">
	</div>
	<div class="form-group col-md-6 p-3">
		<label for="id-f-fin" class="pl-3">Fecha de fin</label>
		<div class="u-ua-style js-ua-desc">
			<?php if($ua) if(!$ua -> fecha_fin)echo 'Sin fecha de fin';?>
		</div>
		<input type="date" name="fecha_fin" id="id-f-fin" class="form-control" value="<?php if($ua) echo $ua->fecha_fin; ?>">
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
