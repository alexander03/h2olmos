
<div id="divMensajeError{!! $entidad !!}"></div>
{!! Form::model($user, $formData) !!}	
{!! Form::hidden('listar', $listar, array('id' => 'listar')) !!}
<div class="form-group">
	{!! Form::label('tipousuario_id', 'Tipo de usuario:', array('class' => 'col-sm-12 control-label')) !!}
	<div class="col-sm-12">
		{{-- {!! Form::select('tipousuario_id', $cboUnidades, null, array('class' => 'form-control input-xs', 'id' => 'tipousuario_id')) !!} --}}
	</div>
</div>
<div class="form-group">
	{!! Form::label('name', 'Nombre de la persona:', array('class' => 'col-sm-12 control-label')) !!}
	<div class="col-sm-12">
		{!! Form::text('name', null, array('class' => 'form-control input-xs', 'id' => 'name')) !!}
	</div>
</div>
<div class="form-group">
	{!! Form::label('usuario', 'Usuario:', array('class' => 'col-sm-12 control-label')) !!}
	<div class="col-sm-12">
		{!! Form::text('usuario', null, array('class' => 'form-control input-xs', 'id' => 'usuario')) !!}
	</div>
</div>
<div class="form-group">
	{!! Form::label('password', 'Contraseña:', array('class' => 'col-sm-12 control-label')) !!}
	<div class="col-sm-12">
		{!! Form::password('password', null, array('class' => 'form-control input-xs', 'id' => 'password')) !!}
	</div>
</div>
<div class="form-group">
	<div class="col-sm-12 text-right">
		{!! Form::button('<i class="fa fa-check fa-lg"></i> '.$boton, array('class' => 'btn btn-success btn-sm', 'id' => 'btnGuardar', 'onclick' => 'guardar(\''.$entidad.'\', this)')) !!}
		{!! Form::button('<i class="fa fa-exclamation fa-lg"></i> Cancelar', array('class' => 'btn btn-warning btn-sm', 'id' => 'btnCancelar'.$entidad, 'onclick' => 'cerrarModal();')) !!}
	</div>
</div>
{!! Form::close() !!}
<script type="text/javascript">
	$(document).ready(function() {
		configurarAnchoModal('350');
		init(IDFORMMANTENIMIENTO+'{!! $entidad !!}', 'M', '{!! $entidad !!}');

		const inputCode = document.getElementById('codigo');
		inputCode.addEventListener('change', e => {
			if(isNaN(e.target.value)) e.target.value = '';
		})

		inputCode.addEventListener('keydown', e => {
			//TODO: que acepte las teclas: flecha left y right
			if(e.target.value.length > 6 && e.keyCode != 8) e.preventDefault();
			if(e.keyCode < 8 || (e.keyCode >9 && e.keyCode< 48) || (e.keyCode >57 && e.keyCode< 67) || (e.keyCode >67 && e.keyCode< 86) || (e.keyCode >86 && e.keyCode< 96) || e.keyCode> 105) e.preventDefault();
		})
	}); 
</script>