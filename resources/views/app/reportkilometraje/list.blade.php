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
		    <?php
		    if( $value->kilometraje_rec < $value->kilometraje2->limite_inf ){
		        $color="";
		        $background="";
		    }elseif( $value->kilometraje_rec < $value->kilometraje2->limite_sup ){
		        $color="bg-warning";
		        $background="";
		    }else{
		        $background="background:#f44336a8";
		        $color="";
		    }
		    ?>
		<tr class="{{ $color }}" style="{{ $background }}">
			<td>{{ $contador }}</td>
			<td>{{ $value->modelo }}</td>
			<td>{{ $value->placa }}</td>
			<td>{{ $value->kilometraje_ini }}</td>
			<td>{{ $value->kilometraje_rec }}</td>
			<td>{{ number_format($value->kilometraje_ini + $value->kilometraje_rec,2,'.','') }}</td>
			@if( $value->kilometraje_rec < $value->kilometraje2->limite_inf )
				<td > Normal </td>
			@elseif( $value->kilometraje_rec < $value->kilometraje2->limite_sup )
				<td class=""> Observación </td>
			@else
				<td class=""> Desgastado </td>
			@endif
			<td>{!! Form::button('<i class="material-icons">edit</i>', array('onclick' => 'modal (\''.URL::route($ruta["edit"], array($value->id, 'listar'=>'SI')).'\', \''.$titulo_modificar.'\', this);', 'class' => 'btn btn-primary btn-link btn-sm','rel'=>'tooltip','title'=>'Editar')) !!}</td>
		</tr>
		<?php
		$contador = $contador + 1;
		?>
		@endforeach
	</tbody>
</table>
@endif