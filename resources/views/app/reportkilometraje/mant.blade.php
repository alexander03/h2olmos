


<table class="table table-bordered table-striped table-condensed table-hover">
	<tr>
		<th>Mantenimiento</th>
		<th>Km final</th>
		<th>Km actual</th>
		<th>Km recorrido</th>
		<th>Opciones</th>
	</tr>
	@foreach($ListaFinal as $value)
		<tr>
			<td>
				@if( $value->tipo == 1)
					Checklist de Mant Correct y Prev

				@elseif( $value->tipo == 2)
					Mantenimiento de Combustible
				@elseif( $value->tipo == 3)
					Registro de repuesto vehicular 
				@else( $value->tipo == 4)
					Registro de mantenimiento vehicular
				@endif
			</td>
			<td>
				{{ $value->kmfinal }}
			</td>
			<td>
				{{ $vehiculo->kilometraje_act }}
			</td>
			<td>
				{{ $value->kmfinal - $vehiculo->kilometraje_act }}
			</td>
			<td>
				<button class="btn btn-success btn-sm"  
					onclick="actualizarMantenimiento({{$value->id}},{{$vehiculo->id}},{{$value->tipo }});">
					<i class="fa fa-check fa-lg"></i>Seleccionar
				</button>
			</td>
		</tr>
	@endforeach

</table>



<button onclick='cerrarModal();' class="btn btn-warning btn-sm"> 
	<i class="fa fa-exclamation fa-lg"></i> Cancelar
</button>

<script type="text/javascript">
	$(document).ready(function() {
		configurarAnchoModal('600');
		init(IDFORMMANTENIMIENTO+'{!! $entidad !!}', 'M', '{!! $entidad !!}');
	}); 




	function actualizarMantenimiento(mante_id,vehiculo_id,tipo){

		let formData = new FormData();

		formData.append('tipo',tipo);
		formData.append('Mant_id',mante_id);
		formData.append('vehiculo_id',vehiculo_id);
		formData.append('_method','PUT');

		let data = $.ajax({	
							headers: {
							    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
							  },
							url : 'reportkilometraje/update',
							type: 'POST',
							data: formData,
							processData: false,
							contentType: false,
						});
		data.done(function(msg) {
			respuesta = msg;
		}).fail(function(xhr, textStatus, errorThrown) {
			respuesta = 'ERROR';
		}).always(function() {
			if(respuesta === 'ERROR'){
			}else{
				if (respuesta === 'OK') {
					md.showNotification('top','right','Guardado correctamente','info');
					buscarCompaginado('', 'Accion realizada correctamente', '{{ $entidad }}', 'OK');
				} else {
					mostrarErrores(respuesta, '#form-document', '{{ $entidad }}');

				}
			}
		});

	    
	}

</script>