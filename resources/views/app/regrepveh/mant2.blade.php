
<div id="divMensajeError{!! $entidad !!}"></div>
{!! Form::model($regrepveh, $formData) !!}	
{!! Form::hidden('listar', $listar, array('id' => 'listar')) !!}
<section class="form-row" id="inicioregrepveh">
	<div class="form-group col-lg-12 col-md-12 col-sm-12">
		<h4 name="idconc" id="oConcesionaria">Concesionaria: {{ $oConcesionaria }}</h4>
		<input type="hidden" name="concesionaria_id" id="concesionaria_id" value="{{ $idconc }}">
	</div>
	<div class="form-group col-lg-7 col-md-7 col-sm-7">
		{!! Form::label('client', 'Cliente:', array('class' => 'col-lg-12 col-md-12 col-sm-12 control-label')) !!}
		<div class="col-lg-12 col-md-12 col-sm-12">
			{!! Form::text('cliente', null, array('class' => 'form-control input-xs', 'id' => 'cliente', 'maxlength' => '100')) !!}
		</div>
	</div>
	<div class="form-group col-lg-5 col-md-5 col-sm-5">
		{!! Form::label('ordencompra', 'DOCMAT:', array('class' => 'col-lg-12 col-md-12 col-sm-12 control-label')) !!}
		<div class="col-lg-12 col-md-12 col-sm-12">
			{!! Form::text('ordencompra', null, array('class' => 'form-control input-xs', 'id' => 'ordencompra', 'maxlength' => '100')) !!}
		</div>
	</div>
	<div class="mt-8 mb-4 ml-6  col-lg-12 col-md-12 col-sm-12">
		<p class="text-warning"  style="margin-bottom: 0;">Datos Generales</p> 
	</div>
	<div class="form-group col-4 col-md-4 p-3 u-search-ua">
		<label for="ua" class="pl-3">Código Ua</label>
		<div class="u-ua-style js-vehiculo-desc">
			{{$placa}}
		</div>
		<input class="js-vehiculo-hiddenid" id="vehiculo_id" name="vehiculo_id" type="hidden" value="{{$vehiculo_id}}">
		<input class="form-control input-xs js-vehiculo-id" id="uades" name="uades" type="text" value="{{$uades}}">
		
		<small id="autoComplete_listve" class="text-danger"></small>
	</div>
	
	<div class="form-group col-lg-4 col-md-4 col-sm-4">
		{!! Form::label('fin', 'Fecha Entrada:', array('class' => 'col-lg-12 col-md-12 col-sm-12 control-label')) !!}
		<div class="col-lg-12 col-md-12 col-sm-12" style="margin-top: 15px">
			{!! Form::date('fechaentrada', null, array('class' => 'form-control input-xs', 'id' => 'fechaentrada', 'maxlength' => '100')) !!}
		</div>
	</div>
	<div class="form-group col-lg-4 col-md-4 col-sm-4">
		{!! Form::label('fin', 'Fecha Salida:', array('class' => 'col-lg-12 col-md-12 col-sm-12 control-label')) !!}
		<div class="col-lg-12 col-md-12 col-sm-12" style="margin-top: 15px">
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
	<div class="form-group col-lg-4 col-md-4 col-sm-4" style="margin-top: 21px">
		{!! Form::label('telefono', 'Telefono:', array('class' => 'col-lg-12 col-md-12 col-sm-12 control-label')) !!}
		<div class="col-lg-12 col-md-12 col-sm-12" style="margin-top: 20px">
			{!! Form::number('telefono', null, array('class' => 'form-control input-xs', 'id' => 'telefono', 'maxlength' => '100')) !!}
		</div>
	</div>
	<div class="mt-4 mb-2 ml-3  col-lg-10 col-md-10 col-sm-10">
		<p class="text-warning ">Observaciones </p>
	</div>
	<div class="form-group col-12 col-md-6 p-3">
		<label for="id-repuesto" class="pl-3">Repuesto</label>
		<input type="hidden" 
			name="repuesto_hiddenid" 
			id="hiddenid-repuesto" 
			class="form-control js-repuesto-hiddenid" 
			value="">
			<input type="hidden" 
			name="repuesto_hiddenunidad" 
			id="hiddenunidad-repuesto" 
			class="form-control js-repuesto-unidad" 
			value="">
			<input type="hidden" 
			name="hiddendescripcion" 
			id="hiddendescripcion-repuesto" 
			class="form-control js-repuesto-hiddendescripcion" 
			value="">
		<div class="u-ua-style js-repuesto-desc" id="descripciongeneral"></div>
		<input type="text" 
			name="repuesto_id" 
			id="id-repuesto" 
			class="form-control js-repuesto-id" 
			value="">
		<small id="autoComplete_list3" class="text-danger"></small>
	</div>{!! Form::button('<i class="fa fa-plus fa-lg table-add"></i>', array('class' => 'btn btn-success btn-sm', 'id' => 'btnAgregar', 'onclick' => 'agregarfila();')) !!}
	<div class="table-responsive">
		<table id="example1" class="table table-bordered table-striped table-condensed table-hover">
			<thead>
				<tr>
					<th colspan="1"  class="text-center" style="width:40px;">#</th>
					<th colspan="1"  class="text-center" style="width:80px;">Cantidad</th>
					<th colspan="1"  class="text-center" style="width:100px;">Unidad</th>
					<th colspan="1"  class="text-center" style="width:100px;">Código</th>
					<th colspan="1"  class="text-center">Descripción</th>
					<th colspan="1"  class="text-center" style="width:80px;">Monto</th>
					<th colspan="1"  class="text-center" style="width:80px;">Subtotal</th>
					<th colspan="1"  class="text-center" style="width:60px;">Elim.</th>
				</tr>
			</thead>
			<tbody id="tbody">
				<?php
				$contador = 1;
				?>
				@foreach ($oObservaciones as $key => $value)
				@if($value->id>=0)
				<tr>
					
					<td name="nnn" style="text-align:center;">{{ $contador }}</td>
					<td><input name="cantidad[]" onkeyup="evaluartotal()" class='form-control' type="number" value="{{ $value->cantidad }}" style="text-align:right;width:100px;"></td>
					<td><input disabled name="unidad[]" class="form-control" type="text" value="{{ $value->unidad }}" style="width:100px;"></td>
					<td><input disabled name="codigo[]" class="form-control" type="text" value="{{ $value->codigo }}" style="width:100px;"></td>
					<td><input disabled name="descripcion[]" class="form-control" type="text" value="{{ $value->descripcion }}"></td>
					<td><input  name="monto[]" onkeyup="evaluartotal()" class='form-control' type="number" value="{{ $value->monto }}" style="text-align:right;width:100px;"></td>
					<td><input disabled name="monto2[]" class='form-control' type="number" value="{{ $value->monto*$value->cantidad }}" style="text-align:right;width:100px;"></td>
					<td onclick="if(confirm('¿Desea Eliminar la Observación?')){borrarfila({{ $value->id }});deleteRow(this);}" style="color:#ff0000;text-align:center;width:50px;"><i class="material-icons text-center">close</i></td>
					<p name	="datos{{$value->id}}" type="hidden"><input type="hidden" name="idobservacion[]" id="ididid" value="{{ $value->id }}">
					<input type="hidden" name="repuestoid[]" id="rep" value="{{ $value->repuesto_id }}">
					<input type="hidden" name="unidad[]" id="uni" value="{{ $value->unidad }}"></p>
				</tr>
				<?php
				$contador = $contador + 1;
				?>
				@else
				<?php
				if(count($oObservaciones)<=1)$oObservaciones=array();?>
				@endif
				@endforeach
			</tbody>
		</table>
		<input  name="montofinal" disabled id="totalponer" class='form-control' type="number" value="" style="float:right; text-align:right;width:100px;">
		<div  class='control-label' type="label" style="float:right; text-align:right;width:50px;padding:10px">Total</div>
		<?php $items=''; if(count($oObservaciones)>=1){ $items='1';}?>
		<input type="hidden" name="cuantasdescripciones" id="cuantasdescripciones" value="{{ $items }}"></p>
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
		doSearchRepuesto();
		doSearchVehiculo();
		evaluartotal();
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



	function evaluarcantidad(){
		var fff=document.getElementsByName('nnn');
		for (var i = 0; i < fff.length; i++) {

			fff[i].innerHTML=(1+i);
			fff[i].className="probarcambiodeclase";

		}

	}

	function evaluartotal(){
		var monto=document.getElementsByName('monto[]');
		var subtotal=document.getElementsByName('monto2[]');
		var cantidad=document.getElementsByName('cantidad[]');
		var total=0;
		for (var i = 0; i < monto.length; i++) {
			if(monto[i].value.length>0 && cantidad[i].value.length>0){
				subtotal[i].value=monto[i].value*cantidad[i].value;
			total+=parseFloat(monto[i].value*cantidad[i].value);}
			else{
				subtotal[i].value="";
			}
		}
		//alert(total);
		document.getElementById('totalponer').value=total;
	}

	

	function agregarfila(){
		if(document.getElementById('descripciongeneral').innerHTML.length>0){
		a++;
		document.getElementById('cuantasdescripciones').value='1';
		var idrepuesto=document.getElementById("hiddenid-repuesto").value;
		var unidad=document.getElementById("hiddenunidad-repuesto").value;
		var codigo=document.getElementById("id-repuesto").value;
		var descripcion=document.getElementById("hiddendescripcion-repuesto").value;
		var tr = document.createElement("tr");
		tr.innerHTML = `
			<tr>
				<td name="nnn" style="text-align:center;">${a}</td>
				<td><input onkeyup="evaluartotal();" name="cantidad[]" class='form-control' type="number" value="" style="text-align:right;width:100px;"></td>
				<td><input disabled name="unidad[]" class="form-control" type="text" value="${unidad}" style="width:100px;"></td>
				<td ><input disabled name="codigo[]" class="form-control" type="text" value="${codigo}" style="width:100px;"></td>
				<td><input disabled name="descripcion[]" class="form-control" type="text" value="${descripcion}"></td>
				<td><input  onkeyup="evaluartotal()" name="monto[]"class='form-control' type="number" value="" style="text-align:right;width:100px;"></td>
				<td><input disabled name="monto2[]"class='form-control' type="number" value="" style="text-align:right;width:100px;"></td>
				<td onclick="if(confirm('¿Desea Eliminar la Observación?')){deleteRow(this);}" style="color:#ff0000;text-align:center;width:50px;"><i class="material-icons text-center">close</i></td>
				<p><input type="hidden" name="idobservacion[]" id="ididid" value="-1"></p>
				<p><input type="hidden" name="repuestoid[]" id="rep" value="${idrepuesto}"></p>
				<p><input type="hidden" name="unidad[]" id="uni" value="${unidad}"></p>
			</tr>`;
		document.getElementById("tbody").appendChild(tr);

		}else{
			alert('no se puede garegar vacío, seleccione Repuesto');
		}

   }

	   function deleteRow(btn) {
	   		a--;
	   		if (document.getElementsByName('monto[]').length>1) {
	   			document.getElementById('cuantasdescripciones').value='1';
	   		}else{
	   			document.getElementById('cuantasdescripciones').value='';
	   		}
			var row = btn.parentNode;
		  	row.parentNode.removeChild(row);
		  	evaluarcantidad();
		  	evaluartotal();
		  
	}

		function borrarfila(iddd){

	   		var input = document.createElement("input");

			input.setAttribute("type", "hidden");

			input.setAttribute("name", "idseliminados[]");

			input.setAttribute("value", iddd);

			document.getElementById("tbody").appendChild(input);


			var fff=document.getElementsByName('datos'+iddd);
			for (var i = 0; i < fff.length; i++) {
				fff[i].innerHTML='';
			}

	   	}
	
</script>