@if(count($lista) == 0)
<h3 class="text-warning">No se encontraron resultados.</h3>
@else
{!! $paginacion !!}
<table id="example1" class="table table-bordered table-striped table-condensed table-hover">

	<thead>
		<tr>
			@foreach($cabecera as $key => $value)
				<th @if((int)$value['numero'] > 1) colspan="{{ $value['numero'] }}" @endif>{!! $value['valor'] !!}</th>
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
			<td>{{ $value->fecha }}</td>
			<td>{{ $value->equipo->codigo }}</td>
			<td>{{ $value->equipo->descripcion }}</td>
			<td>{{ $value->equipo->contratista->razonsocial }}</td>
			<td>
				@if($value->ua)
					{{ $value->ua->codigo }}
				@endif
			</td>
			<td>
				@if($value->tipohora)
					{{ $value->tipohora->codigo }}
				@endif
			</td>
			<td>
				@if($value->ua)
					{{ $value->ua->descripcion }}
				@else
					{{ $value->tipohora->descripcion }}
				@endif
			</td>
			<td>
				@if($value->tipohora)
					{{ $value->tipohora->descripcion }}
				@endif
			</td>
			<td>{{ $value->turno }}</td>
			<td>{{ $value->viajes }}</td>
			<td>{{ $value->inicio }}</td>
			<td>{{ $value->acceso }}</td>
			<td>
				@if($value->ua_origen)
					{{ $value->ua_origen->codigo }}
				@endif
			</td>
			<td>
				@if( $value->ua_origen)
					{{ $value->ua_origen->descripcion }}
				@endif
			</td>
			<td>{{ $value->destino }}</td>
			<td>
				@if($value->ua_destino)
					{{ $value->ua_destino->codigo }}
				@endif
			</td>
			<td>
				@if($value->ua_destino)
					{{ $value->ua_destino->descripcion }}
				@endif
			</td>
			<td>{!! Form::button('<i class="material-icons">edit</i>', array('onclick' => 'modal (\''.URL::route($ruta["edit"], array($value->id, 'listar'=>'SI')).'\', \''.$titulo_modificar.'\', this);', 'class' => 'btn btn-primary btn-link btn-sm','rel'=>'tooltip','title'=>'Editar')) !!}</td>
			<td>{!! Form::button('<i class="material-icons">close</i>', array('onclick' => 'modal (\''.URL::route($ruta["delete"], array($value->id, 'SI')).'\', \''.$titulo_eliminar.'\', this);', 'class' => 'btn btn-danger btn-link btn-sm','rel'=>'tooltip','title'=>'Eliminar')) !!}</td>
		</tr>
		<?php
		$contador = $contador + 1;
		?>
		@endforeach
	</tbody>
</table>
@endif
