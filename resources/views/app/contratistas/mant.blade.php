<div id="divMensajeError{!! $entidad !!}"></div>
{!! Form::model($contratista, $formData) !!}	
{!! Form::hidden('listar', $listar, array('id' => 'listar')) !!}
<div class="form-group">
	{!! Form::label('razonsocial', 'Razon Social:', array('class' => 'col-lg-12 col-md-12 col-sm-12 control-label')) !!}
	<div class="col-lg-12 col-md-12 col-sm-12">
		{!! Form::text('razonsocial', null, array('class' => 'form-control input-xs', 'id' => 'razonsocial', 'maxlength' => '150')) !!}
	</div>
</div>
<div class="form-group">
	{!! Form::label('ruc', 'RUC:', array('class' => 'col-lg-12 col-md-12 col-sm-12 control-label')) !!}
	<div class="col-lg-12 col-md-12 col-sm-12">
		{!! Form::text('ruc', null, array('class' => 'form-control input-xs', 'id' => 'ruc', 'maxlength' => '11')) !!}
	</div>
</div>
<div class="form-group">
	{!! Form::label('propietario', 'Propietario:', array('class' => 'col-lg-12 col-md-12 col-sm-12 control-label')) !!}
	<div class="col-lg-12 col-md-12 col-sm-12">
		{!! Form::text('propietario', null, array('class' => 'form-control input-xs', 'id' => 'propietario', 'maxlength' => '11')) !!}
	</div>
</div>
<div class="form-group">
	{!! Form::label('email', 'E-Mail:', array('class' => 'col-lg-12 col-md-12 col-sm-12 control-label')) !!}
	<div class="col-lg-12 col-md-12 col-sm-12">
		{!! Form::text('email', null, array('class' => 'form-control input-xs', 'id' => 'email', 'maxlength' => '11')) !!}
	</div>
</div>
<div class="form-group">
	{!! Form::label('telefono', 'Teléfono:', array('class' => 'col-lg-12 col-md-12 col-sm-12 control-label')) !!}
	<div class="col-lg-12 col-md-12 col-sm-12">
		{!! Form::text('telefono', null, array('class' => 'form-control input-xs', 'id' => 'telefono', 'maxlength' => '11')) !!}
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
		const inputCode = document.getElementById('ruc');
		inputCode.addEventListener('keydown', e => {
			if (e.keyCode < 48|| (e.keyCode > 57&&e.keyCode < 96)
			|| (e.keyCode > 105)){
				if(e.keyCode!=8&&e.keyCode!=13&&e.keyCode!=37&&e.keyCode!=39)
    			e.preventDefault();
  			}
  		})
	}); 
</script>