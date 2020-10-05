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
			<th>PLACA</th>
			<th>GALONES</th>
			<th>H-INICIO</th>
			<th>H-TERMINO</th>
		</tr>

		@foreach($data as $index=>$value)

			<tr>
				<td class="num">{{$index + 1 }}</td>
				<td class="nombres" >{{ $value->nombre }}</td>
				<td>{{ $value->dni }}</td>
				<td>{{ $value->ua }}</td>
				<td>{{ $value->equipo }}</td>
				<td>{{ $value->placa }}</td>
				<td>{{ $value->galones }}</td>
				<td>{{ $value->h_inicio }}</td>
				<td>{{ $value->h_fin }}</td>
			</tr>



		@endforeach

	</table>
</body>