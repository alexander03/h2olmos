
<div id="divMensajeError{!! $entidad !!}"></div>
{!! Form::model($regrepveh, $formData) !!}	
{!! Form::hidden('listar', $listar, array('id' => 'listar')) !!}
<section class="form-row">
	<div class="form-group col-lg-12 col-md-12 col-sm-12">
		{!! Form::label('concesionaria_id', 'Concesionaria Actual:', array('class' => 'col-lg-12 col-md-12 col-sm-12 control-label')) !!}
		<div class="col-lg-5 col-md-5 col-sm-5">
			{!! Form::select('concesionaria_id', $oConcesionarias, null, array('class' => 'form-control input-xs', 'id' => 'concesionaria_id')) !!}
		</div>
	</div>
	<div class="form-group col-lg-5 col-md-5 col-sm-5">
		{!! Form::label('consecion', 'Conseción:', array('class' => 'col-12 col-sm-12 control-label')) !!}
		<div class="col-12 col-sm-12">
			<input class='form-control input-xs' id='conces' maxlength='100' type='text' disabled value="Concesión Trasvase Olmos">
		</div>
	</div>
	<div class="form-group col-lg-7 col-md-7 col-sm-7">
		{!! Form::label('client', 'Cliente:', array('class' => 'col-lg-12 col-md-12 col-sm-12 control-label')) !!}
		<div class="col-lg-12 col-md-12 col-sm-12">
			{!! Form::text('cliente', null, array('class' => 'form-control input-xs', 'id' => 'cliente', 'maxlength' => '100')) !!}
		</div>
	</div>
	<div class="mt-8 mb-4 ml-6  col-lg-12 col-md-12 col-sm-12">
		<p class="text-warning"  style="margin-bottom: 0;">Datos Generales</p> 
	</div>
	<div class="form-group col-4 col-md-4 p-3 u-search-ua">
		<label for="ua" class="pl-3">Código Ua</label>
		<div class="u-ua-style js-ua-desc">
		</div>
		{!! Form::text('ua_id', null, array('class' => 'form-control input-xs js-ua-id', 'id' => 'ua_id', 'maxlength' => '15')) !!}
		
		<small id="autoComplete_list1" class="text-danger"></small>
	</div>
	
	<div class="form-group col-lg-4 col-md-4 col-sm-4">
		{!! Form::label('fin', 'Fecha Entrada:', array('class' => 'col-lg-12 col-md-12 col-sm-12 control-label')) !!}
		<div class="col-lg-12 col-md-12 col-sm-12">
			{!! Form::date('fechaentrada', null, array('class' => 'form-control input-xs', 'id' => 'fechaentrada', 'maxlength' => '100')) !!}
		</div>
	</div>
	<div class="form-group col-lg-4 col-md-4 col-sm-4">
		{!! Form::label('fin', 'Fecha Salida:', array('class' => 'col-lg-12 col-md-12 col-sm-12 control-label')) !!}
		<div class="col-lg-12 col-md-12 col-sm-12">
			{!! Form::date('fechasalida', null, array('class' => 'form-control input-xs', 'id' => 'fechasalida', 'maxlength' => '100')) !!}
		</div>
	</div>
	<div class="form-group col-lg-4 col-md-4 col-sm-4">
		{!! Form::label('kmmant', 'Km de mantenimiento:', array('class' => 'col-lg-12 col-md-12 col-sm-12 control-label')) !!}
		<div class="col-lg-12 col-md-12 col-sm-12">
			{!! Form::number('kmman', null, array('class' => 'form-control input-xs', 'id' => 'kmman', 'maxlength' => '100')) !!}
		</div>
	</div>
	<div class="form-group col-lg-4 col-md-4 col-sm-4">
		{!! Form::label('kmin', 'Km Inicial:', array('class' => 'col-lg-12 col-md-12 col-sm-12 control-label')) !!}
		<div class="col-lg-12 col-md-12 col-sm-12">
			{!! Form::number('kminicial', null, array('class' => 'form-control input-xs', 'id' => 'kminicial', 'maxlength' => '100')) !!}
		</div>
	</div>
	<div class="form-group col-lg-4 col-md-4 col-sm-4">
		{!! Form::label('kmfin', 'Km Final:', array('class' => 'col-lg-12 col-md-12 col-sm-12 control-label')) !!}
		<div class="col-lg-12 col-md-12 col-sm-12">
			{!! Form::number('kmfinal', null, array('class' => 'form-control input-xs', 'id' => 'kmfinal', 'maxlength' => '100')) !!}
		</div>
	</div>
	<div class="form-group col-lg-4 col-md-4 col-sm-4">
		{!! Form::label('tipo', 'Tipo de Mantenimiento:', array('class' => 'col-lg-12 col-md-12 col-sm-12 control-label')) !!}
		<div class="col-lg-12 col-md-12 col-sm-12">
			{!! Form::select('tipomantenimiento',array(''=>'Seleccione Tipo','1'=>'Preventivo','2'=>'Correctivo'), null, array('class' => 'form-control input-xs', 'id' => 'tipomantenimiento', 'maxlength' => '100')) !!}
		</div>
	</div>
	<div class="form-group col-lg-4 col-md-4 col-sm-4">
		{!! Form::label('telefono', 'Telefono:', array('class' => 'col-lg-12 col-md-12 col-sm-12 control-label')) !!}
		<div class="col-lg-12 col-md-12 col-sm-12">
			{!! Form::number('telefono', null, array('class' => 'form-control input-xs', 'id' => 'telefono', 'maxlength' => '100')) !!}
		</div>
	</div>
	<div class="mt-4 mb-2 ml-3  col-lg-10 col-md-10 col-sm-10">
		<p class="text-warning ">Observaciones {!! Form::button('<i class="fa fa-plus fa-lg table-add"></i>', array('class' => 'btn btn-success btn-sm', 'id' => 'btnAgregar', 'onclick' => 'agregarfila();')) !!}</p>
	</div>
	
	<div class="table-responsive">
		<table id="example1" class="table table-bordered table-striped table-condensed table-hover">
			<thead>
				<tr>
					<th colspan="1"  class="text-center" style="width:40px;">#</th>
					<th colspan="1"  class="text-center" style="width:80px;">Cantidad</th>
					<th colspan="1"  class="text-center" style="width:100px;">Unidad</th>
					<th colspan="1"  class="text-center" style="width:100px;">Código</th>
					<th colspan="1"  class="text-center" style="width:80px;">Monto</th>
					<th colspan="1"  class="text-center">Descripción</th>
					<th colspan="1"  class="text-center" style="width:100px;">Eliminar</th>
				</tr>
			</thead>
			<tbody id="tbody">
				<?php
				$contador = 1;
				?>
				@foreach ($oObservaciones as $key => $value)
				<tr>
					<p><input type="hidden" name="idid[]" id="ididid" value="{{ $value->id }}"></p>
					<td name="nnn" style="text-align:center;">{{ $contador }}</td>
					<td><input name="cantidad[]" class='form-control' type="number" value="{{ $value->cantidad }}" style="text-align:right;width:100px;"></td>
					<td><input name="unidad[]" class="form-control" type="text" value="{{ $value->unidad }}" style="width:100px;"></td>
					<td ><input name="codigo[]" class="form-control" type="text" value="{{ $value->codigo }}" style="width:100px;"></td>
					<td><input  name="monto[]"class='form-control' type="number" value="{{ $value->monto }}" style="text-align:right;width:100px;"></td>
					<td><input name="descripcion[]" class="form-control" type="text" value="{{ $value->descripcion }}"></td>
					<td onclick="if(confirm('¿Desea Eliminar la Observación?')){borrarfila({{ $value->id }});deleteRow(this);}" style="color:#ff0000;text-align:center;width:50px;"><i class="material-icons text-center">close</i></td>
				</tr>
				<?php
				$contador = $contador + 1;
				?>
				@endforeach
			</tbody>
		</table>
	</div>
	<div class="form-group">
		<div class="col-lg-12 col-md-12 col-sm-12 text-right">
			{!! Form::button('<i class="fa fa-check fa-lg"></i> '.$boton, array('class' => 'btn btn-success btn-sm', 'id' => 'btnGuardar', 'onclick' => 'guardar(\''.$entidad.'\', this)')) !!}
			{!! Form::button('<i class="fa fa-exclamation fa-lg"></i> Cancelar', array('class' => 'btn btn-warning btn-sm', 'id' => 'btnCancelar'.$entidad, 'onclick' => 'cerrarModal();')) !!}
		</div>
	</div>
</section>
{!! Form::close() !!}






<script type="text/javascript">

	


	var a = <?php echo $contador?> -1;
	$(document).ready(function() {
		configurarAnchoModal('900');
		init(IDFORMMANTENIMIENTO+'{!! $entidad !!}', 'M', '{!! $entidad !!}');
		doSearchUA();
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

	function buscarporUA(){

		var uanumero= document.getElementById('ua_id').value;

		var serviceURL = "mantcorrprev/buscarporua?ua="+uanumero;

            $.ajax({
                type: "GET",
                url: serviceURL,
                data: param = "",
                contentType: "application/json; charset=utf-8",
                dataType: "json",
                success: successFunc,
                error: errorFunc
            });

            function successFunc(data, status) {
            var str =  JSON.stringify(data['gg']);    
                alert(str.substr(1, str.length-2));
            }
            function errorFunc() {
                alert('borraron la columna ua_id de tabla equipos, rehacer funcion -buscarporua- de controller mantprevcorr');
            }

	}

	function evaluarcantidad(){
		var fff=document.getElementsByName('nnn');
		for (var i = 0; i < fff.length; i++) {

			fff[i].innerHTML=(1+i);
		}

	}



	function agregarfila(){
		a++;
		var tr = document.createElement("tr");
		tr.innerHTML = `
		<tr>
			<input type="hidden" name="idid[]" value="-1">
			<td name="nnn" style="text-align:center;">${a}</td>
			<td><input name="cantidad[]" class='form-control' type="number" value="" style="text-align:right;width:100px;"></td>
			<td><input name="unidad[]" class="form-control" type="text" value="" style="width:100px;"></td>
			<td><input name="codigo[]" class="form-control" type="text" value="" style="width:100px;"></td>
			<td><input  name="monto[]"class='form-control' type="number" value="" style="text-align:right;width:100px;"></td>
			<td><input name="descripcion[]" class="form-control" type="text" value=""></td>
			<td onclick="if(confirm('¿Desea Eliminar la Observación?')){deleteRow(this);}" style="color:#ff0000;text-align:center;width:50px;"><i class="material-icons text-center">close</i></td>
		</tr>`;
			document.getElementById("tbody").appendChild(tr);

   }

	   function deleteRow(btn) {
	   		a--;
			var row = btn.parentNode;
		  	row.parentNode.removeChild(row);
		  	evaluarcantidad();
	   	

	   /*	bootbox.dialog({
		message : '¿Eliminar Observación?',
		buttons: {
			'cancel': {
				label: 'Cancelar',
				className: 'btn btn-default btn-sm'
			},
			'confirm':{
				label: 'Eliminar',
				className: 'btn btn-danger btn-sm'
			}
		}, 
		callback: function(result) {
	   	if(result){
				var row = btn.parentNode;
		  		row.parentNode.removeChild(row);
	   		}

		}
		
	});*/
		  
	}

		function borrarfila(iddd){
	   		var input = document.createElement("input");

			input.setAttribute("type", "hidden");

			input.setAttribute("name", "idseliminados[]");

			input.setAttribute("value", iddd);

			document.getElementById("tbody").appendChild(input);

	   	}
	
</script>