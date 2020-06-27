<?php 
$icono = '';
if ($unidad !== NULL) {
	$icono = $unidad->icono;
}
?>

<div id="divMensajeError{!! $entidad !!}"></div>
{!! Form::model($unidad, $formData) !!}	
{!! Form::hidden('listar', $listar, array('id' => 'listar')) !!}
<section class="form-row">
	<div class="form-group col-md-12 p-3">
		<label for="descripcion" class="pl-3">Su descripción</label>
		<textarea name="descripcion" id="descripcion" class="form-control" rows="3">@php if($unidad) echo $unidad->descripcion @endphp</textarea>
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
		configurarAnchoModal('600');
		init(IDFORMMANTENIMIENTO+'{!! $entidad !!}', 'M', '{!! $entidad !!}');
	}); 
</script>