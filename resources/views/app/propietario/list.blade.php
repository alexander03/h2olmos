@if(count($lista) == 0)
<h3 class="text-warning">No se encontraron resultados.</h3>
@else
{!! $paginacion !!}
<table id="example1" class="table table-striped table-hover mt-2">

	<thead>
		<tr class="text-center">
			@foreach($cabecera as $key => $value)
				<th class="text-nowrap" @if((int)$value['numero'] > 1) colspan="{{ $value['numero'] }}" @endif>{!! $value['valor'] !!}</th>
			@endforeach
		</tr>
	</thead>
	<tbody class="text-center">
		<?php
		$contador = $inicio + 1;
		?>
		@foreach ($lista as $key => $value)
		<tr>
			<td class="text-nowrap">{{ $contador }}</td>
			<td class="text-nowrap">{{ $value->	descripcion }}</td>
			<td class="text-nowrap">{{ $value->	fecha_llegada }}</td>
			<td class="text-nowrap">{{ $value->	fecha_salida }}</td>
			<td class="text-nowrap">{{ $value->	fecha_contrato }}</td>
			<td class="text-nowrap">{{ $value->	status }}</td>
			<td class="text-nowrap">{{ $value->	hra }}</td>
			<td class="text-nowrap">{{ $value->	hrb }}</td>
			<td class="text-nowrap">{{ $value->	hrc }}</td>
			<td class="text-nowrap">{{ $value->	km }}</td>
			<td class="text-nowrap">{{ $value->	observacion }}</td>
			<td class="text-nowrap">{{ $value->	ubicacion }}</td>
			<td class="text-nowrap">{{ $value->	ua -> descripcion }}</td>
			<td class="text-nowrap">{!! Form::button('<i class="material-icons">edit</i>', array('onclick' => 'modal (\''.URL::route($ruta["edit"], array($value->id, 'listar'=>'SI')).'\', \''.$titulo_modificar.'\', this);', 'class' => 'btn btn-primary btn-link btn-sm','rel'=>'tooltip','title'=>'Editar')) !!}</td>
			<td class="text-nowrap">{!! Form::button('<i class="material-icons">close</i>', array('onclick' => 'modal (\''.URL::route($ruta["delete"], array($value->id, 'SI')).'\', \''.$titulo_eliminar.'\', this);', 'class' => 'btn btn-danger btn-link btn-sm','rel'=>'tooltip','title'=>'Eliminar')) !!}</td>
		</tr>
		<?php
		$contador = $contador + 1;
		?>
		@endforeach
	</tbody>
</table>
@endif