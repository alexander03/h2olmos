@if(count($lista) == 0)
<h3 class="text-warning">No se encontraron resultados.</h3>
@else
{!! $paginacion !!}
<table id="example1" class="table table-bordered table-striped table-condensed table-hover">

	<thead>
		<tr>
			@foreach($cabecera as $key => $value)
	<th class="text-nowrap" @if((int)$value['numero'] > 1) colspan="{{ $value['numero'] }}" @endif class="text-center">{!! $value['valor'] !!}</th>
			@endforeach
		</tr>
	</thead>
	<tbody>
		<?php
		$contador = $inicio + 1;
		?>
		@foreach ($lista as $key => $value)
		<tr>
			<td>{{ $contador }}</td>
			<td>{{ $value->cliente }}</td>
			<td>{{ $value->ua_id }}</td>
			<td>{{ $value->kmman }}</td>
			<td>{{ $value->kminicial }}</td>
			<td>{{ $value->kmfinal }}</td>
			<td>{{ $value->fechaentrada }}</td>
			<td>{{ $value->fechasalida }}</td>
			@if ($value->tipomantenimiento==1)
			<td>Preventivo</td>
			@elseif ($value->tipomantenimiento==2)
			<td>Correctivo </td>
			@else
			<td>Indefinido </td>
			@endif
			<td>{{ $value->telefono }}</td>

			<td>{!! Form::button('<i class="material-icons">edit</i>', array('onclick' => 'modal (\''.URL::route($ruta["edit"], array($value->id, 'listar'=>'SI')).'\', \''.$titulo_modificar.'\', this);', 'class' => 'btn btn-primary btn-link btn-sm','rel'=>'tooltip','title'=>'Editar')) !!}</td>
			<td>
				<a href="{{ route('regrepveh.pdf.export') . '?id=' . $value->id }}" target="_blank" class="btn btn-sm btn-secondary" title="Exportar">
						<i class="material-icons">cloud_download</i>
				</a>
			</td>
			
			@if (!$value->deleted_at)
			<td>{!! Form::button('<i class="material-icons">close</i>', array('onclick' => 'modal (\''.URL::route($ruta["delete"], array($value->id, 'SI')).'\', \''.$titulo_eliminar.'\', this);', 'class' => 'btn btn-danger btn-link btn-sm','rel'=>'tooltip','title'=>'Eliminar')) !!}</td>
			@else
			<td>{!! Form::button('<i class="material-icons">done</i>', array('onclick' => 'modal (\''.URL::route($ruta["activar"], array($value->id, 'SI')).'\', \''.$titulo_activar.'\', this);', 'class' => 'btn btn-success btn-link btn-sm','rel'=>'tooltip','title'=>'Activar')) !!}</td>
			@endif
		</tr>
		<?php
		$contador = $contador + 1;
		?>
		@endforeach
	</tbody>
</table>
@endif