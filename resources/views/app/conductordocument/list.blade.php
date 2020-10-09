@if(count($lista) == 0)
<h3 class="text-warning">No se encontraron resultados.</h3>
@else
{!! $paginacion !!}
<table id="example1" class="table table-bordered table-striped table-condensed table-hover">

	<thead>
		<tr>
			@foreach($cabecera as $key => $value)
				<th class="text-nowrap" @if((int)$value['numero'] > 1) colspan="{{ $value['numero'] }}" @endif>{!! $value['valor'] !!}</th>
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
			<td>{{ date('d/m/Y', strtotime($value->created_at)) }}</td>
			@switch($value->tipo)
					@case('imagen-firma')
							<td data-tipo="{{$value->tipo}}">Imagen de firma</td>
							<td><a target="_blank" href="{{asset('files/documento_conductor/imagenes_firmas')}}/{{$value->archivo}}">Archivo</a></td>
							@break
					@case('conformidad-firma')
							<td data-tipo="{{$value->tipo}}">Doc. conformidad</td>
							<td><a target="_blank" href="{{asset('files/documento_conductor/documentos_conformidad_firmas')}}/{{$value->archivo}}">Archivo</a></td>
							@break
					@default
						<td>Otro doc.</td>			
			@endswitch
			
			{{-- <td>{!! Form::button('<i class="material-icons">edit</i>', array('onclick' => 'editar_document (\''.$value->id.'\', this);', 'class' => 'btn btn-primary btn-link btn-sm','rel'=>'tooltip','title'=>'Editar')) !!}</td> --}}
			<td>{!! Form::button('<i class="material-icons">close</i>', array('onclick' => 'modal (\''.URL::route($ruta["delete"], array($value->id, 'SI')).'\', \''.$titulo_eliminar.'\', this);', 'class' => 'btn btn-danger btn-link btn-sm','rel'=>'tooltip','title'=>'Eliminar')) !!}</td>
		</tr>
		<?php
		$contador = $contador + 1;
		?>
		@endforeach
	</tbody>
</table>
@endif