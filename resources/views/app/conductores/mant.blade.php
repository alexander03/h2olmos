//TODO: TENGO QUE VALIDAR CAMPOS A MOSTAR CUANDO SEA CREATE O EDIT
<div id="divMensajeError{!! $entidad !!}"></div>
{!! Form::model($conductor, $formData) !!}	
{!! Form::hidden('listar', $listar, array('id' => 'listar')) !!}
<div class="form-row">
	<div class="form-group col-5 col-sm-3">
		{!! Form::label('dni', 'DNI:', array('class' => 'col-lg-12 col-md-12 col-sm-12 control-label')) !!}
		<div class="col-lg-12 col-md-12 col-sm-12">
			{!! Form::text('dni', null, array('class' => 'form-control input-xs', 'id' => 'dni')) !!}
		</div>
	</div>
	<div class="form-group col-7 col-sm-9">
		{!! Form::button('<i class="fa fa-search"></i> Buscar', array('class' => 'btn btn-info p-2 pl-1 pr-1', 'id' => 'btnGuardar', 'onclick' => 'guardar(\''.$entidad.'\', this)')) !!}
		{!! Form::button('<i class="fa fa-search"></i> Limpiar', array('class' => 'btn btn-danger p-2 pl-1 pr-1', 'id' => 'btnGuardar', 'onclick' => 'guardar(\''.$entidad.'\', this)')) !!}
	</div>
</div>
<div class="form-row">
	<div class="form-group col-6  col-sm-7">
		{!! Form::label('apellidos', 'Apellidos:', array('class' => 'col-lg-12 col-md-12 col-sm-12 control-label')) !!}
		<div class="col-lg-12 col-md-12 col-sm-12">
			{!! Form::text('apellidos', null, array('class' => 'form-control input-xs', 'id' => 'apellidos', 'disabled' => 'true')) !!}
		</div>
	</div>
	<div class="form-group col-6  col-sm-5">
		{!! Form::label('nombres', 'Nombres:', array('class' => 'col-lg-12 col-md-12 col-sm-12 control-label')) !!}
		<div class="col-lg-12 col-md-12 col-sm-12">
			{!! Form::text('nombres', null, array('class' => 'form-control input-xs', 'id' => 'nombres', 'disabled' => 'true')) !!}
		</div>
	</div>
</div>
<div class="form-row">
	<div class="form-group col-12  col-sm-5">
		{!! Form::label('licencia_letra', 'Licencia:', array('class' => 'col-lg-12 col-md-12 col-sm-12 control-label')) !!}
		<div class="form-row col-sm-12">
			<div class="col-3 col-sm-3">
				{!! Form::text('licencia_letra', null, array('class' => 'form-control input-xs', 'id' => 'licencia_letra')) !!}
			</div>
			<div class="col-9 col-sm-9">
				{!! Form::text('licencia_num', '74757559', array('class' => 'pt-1 pb-1', 'id' => 'licencia_num', 'disabled' => 'true', 'style' => 'background-color: transparent;border:none')) !!}
				{{-- border-bottom: 1.5px solid #9c27b0 --}}
			</div>
		</div>
	</div>
	<div class="form-group col-6  col-sm-4">
		<div class="col-lg-12 col-md-12 col-sm-12">
			{!! Form::select('categoria', $arrCategorias, null, array('class' => 'form-control input-xs', 'id' => 'categoria')) !!}
		</div>
	</div>
	<div class="form-group col-6  col-sm-3">
		{!! Form::label('fechavencimiento', 'F.Vencimiento:', array('class' => 'col-lg-12 col-md-12 col-sm-12 control-label')) !!}
		<div class="col-lg-12 col-md-12 col-sm-12">
			{!! Form::date('fechavencimiento', null, array('class' => 'form-control input-xs', 'id' => 'fechavencimiento')) !!}
		</div>
	</div>
</div>
<div class="form-row">
	<div class="form-group col-12  col-sm-8">
		{!! Form::label('contratista_id', 'Contratista:', array('class' => 'col-lg-12 col-md-12 col-sm-12 control-label')) !!}
		<div class="col-lg-12 col-md-12 col-sm-12">
			{!! Form::select('contratista_id', $cboContratista, null, array('class' => 'form-control input-xs', 'id' => 'contratista_id')) !!}
		</div>
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
		configurarAnchoModal('700');
		init(IDFORMMANTENIMIENTO+'{!! $entidad !!}', 'M', '{!! $entidad !!}');
	}); 
</script>