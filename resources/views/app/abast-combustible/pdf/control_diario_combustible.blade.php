<style type="text/css">
	
	table {
	   border: 1px solid #000;
	   background: #000;
	}
	th, td {
	   width: 150px; 
	   text-align: center;
	   border: 0px ;
	   border-collapse: collapse;
	   padding: 0.3em;
	   background: #fff;
	}
	th {
	   background: #eee;
	}
	.num{
		width: 70px;
	}

	.nombres{
		width: 300px;
	}

	.sh-dni{
		border: 1px solid #000;
	}

</style>


<body>
	
	<h1>CONTROL DIARIO DE COMBUSTIBLE</h1>

	<table>
		<tr>
			<th class="num">N° </th>
			<th class="nombres">NOMBRES Y APELLIDOS</th>
			<th>DNI</th>
			<th>UA</th>
			<th>VEHICULO</th>
			<th>MARCA</th>
			<th>PLACA</th>
			<th>GALONES</th>
			<th>H-INICIO</th>
			<th>H-TERMINO</th>
			<th>EMPRESA</th>
		</tr>

		@foreach($data as $index=>$value)
			<tr>
				<td class="num">{{$index + 1 }}</td>
				<td class="nombres" >{{ $value->res }}</td>
				<td>{{ $value->dni }}</td>
				<td>{{ $value->code }}</td>
				<td>{{ $value->desceq }}</td>
				<td>{{ $value->descmc }}</td>
				<td>{{ $value->km }}</td>
				<td>{{ $value->qtdgl }}</td>
				<td>{{ $value->hora_inicio }}</td>
				<td>{{ $value->hora_fin }}</td>
				<td>{{ $value->crza }}</td>
			</tr>
		@endforeach

	</table>
</body>