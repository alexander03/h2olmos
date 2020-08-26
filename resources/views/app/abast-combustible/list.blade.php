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
			<td class="text-nowrap">{{ $value -> fecha_abastecimiento }}</td>
			<td class="text-nowrap">{{ $value -> grifo -> descripcion }}</td>
			<td class="text-nowrap">{{ $value -> tipo_combustible }}</td>
			<td class="text-nowrap">{{ $value -> conductor -> nombres }} {{ $value -> conductor -> apellidos }}</td>
            <td class="text-nowrap">{{ $value -> conductor -> dni }}</td>
            <td class="text-nowrap">{{ $value -> ua -> codigo }}</td>
            <td class="text-nowrap">{{ $value -> ua -> descripcion }}</td>
			<td class="text-nowrap">{{ $value -> equipo -> descripcion }}</td>
			<td class="text-nowrap">{{ $value -> equipo -> marca -> descripcion }}</td>
			<td class="text-nowrap">{{ isset($value -> equipo -> modelo) ? $value -> equipo -> modelo : 'No Asignado'  }}</td>
			<td class="text-nowrap">{{ isset($value -> equipo -> placa) ? $value -> equipo -> placa : 'No Asignado'}}</td>
			<td class="text-nowrap">{{ $value -> equipo -> contratista -> razonsocial }}</td>
			<td class="text-nowrap">{{ $value -> qtdgl }}</td>
			<td class="text-nowrap">{{ $value -> qtdl }}</td>
			<td class="text-nowrap">{{ $value -> km }}</td>
			<td class="text-nowrap">{{ $value -> abastecimiento_dia }}</td>
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