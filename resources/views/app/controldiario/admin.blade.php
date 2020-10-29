<div class="content">
  <div class="container-fluid">
    <div class="row">
      <div class="col-md-12">
        <div class="card">
          <div class="card-header card-header-info">
            <h4 class="card-title ">{{ $title }}</h4>
          </div>
          <div class="card-body">			
			{!! Form::open(['route' => $ruta["search"], 'method' => 'POST' ,'onsubmit' => 'return false;', 'class' => 'row', 'role' => 'form', 'autocomplete' => 'off', 'id' => 'formBusqueda'.$entidad]) !!}
			{!! Form::hidden('page', 1, array('id' => 'page')) !!}
			{!! Form::hidden('accion', 'listar', array('id' => 'accion')) !!}
			<div class="col-2 col-sm-2 col-md-2 col-lg-2">
				{!! Form::label('equipo_ua', 'Ua de equipo:') !!}
				{!! Form::text('equipo_ua', '', array('class' => 'form-control', 'id' => 'equipo_ua')) !!}
			</div>
			<div class="col-2 col-sm-2 col-md-2 col-lg-2">
				{!! Form::label('descripcion', 'Descripcion:') !!}
				{!! Form::text('descripcion', '', array('class' => 'form-control', 'id' => 'descripcion')) !!}
			</div>
			<div class="col-2 col-sm-2 col-md-2 col-lg-2">
				{!! Form::label('ua', 'Ua de proyecto:') !!}
				{!! Form::text('ua', '', array('class' => 'form-control', 'id' => 'ua')) !!}
			</div>
			<div class="col-lg-2 col-md-2 col-sm-2 col-6 ">
					{!! Form::label('fecha_registro_inicial', 'Fecha inicial') !!}
					{!! Form::date('fecha_registro_inicial', date('Y-m-d', strtotime('first day of this month', time())) , array('class' => 'form-control input-xs', 'id' => 'fecha_registro_inicial', 'onchange' => 'EditbtnExelHEU()')) !!}			
				</div>
			<div class="col-lg-2 col-md-2 col-sm-2 col-6 ">
					{!! Form::label('fecha_registro_final', 'Fecha final') !!}
					{!! Form::date('fecha_registro_final', '', array('class' => ' form-control input-xs', 'id' => 'fecha_registro_final', 'onchange' => 'EditbtnExelHEU()')) !!}
				</div>
			<div class="col-2 col-sm-2 col-md-2 col-lg-2">
				{!! Form::label('filas', 'Filas a mostrar:')!!}
				{!! Form::selectRange('filas', 1, 30, 20, array('class' => 'form-control', 'onchange' => 'buscar(\''.$entidad.'\')')) !!}
			</div>

			<div class="form-group">
				{!! Form::button('<i class="material-icons">search</i>Buscar', array('class' => 'btn btn-success btn-sm', 'id' => 'btnBuscar', 'onclick' => 'buscar(\''.$entidad.'\')')) !!}
				{!! Form::button('<i class="material-icons">add</i>Nuevo', array('class' => 'btn btn-info btn-sm', 'id' => 'btnNuevo', 'onclick' => 'modal (\''.URL::route($ruta["create"], array('listar'=>'SI')).'\', \''.$titulo_registrar.'\', this);')) !!}

				

				<a href="{{ route('controldiario.hequipoxua') }}?" target="_blank" id="btnExelHEU" class="btn btn-sm btn-primary">
					<i class="material-icons">cloud_download</i> Report H.ExU .xlsx
				</a>
				<a href="{{ route('controldiario.hequipoxuapdf') }}?" target="_blank" id="btnPDFHEU" class="btn btn-sm btn-primary">
					<i class="material-icons">cloud_download</i> Report H.ExU .pdf
				</a>

				{!! Form::button('<i class="material-icons">cloud_download</i> Reporte H. Trabs', array('class' => 'btn btn-primary btn-sm', 'id' => 'btnGenerateReportHorasTrab', 'onclick' => 'modal (\''.URL::route($ruta["generateReport"], array('listar'=>'NO')).'\', \''.$titulo_generar.'\', this);')) !!}
				{!! Form::button('<i class="material-icons">cloud_download</i> Reporte de Medicion de Equipos', array('class' => 'btn btn-primary btn-sm', 'id' => 'btnGenerateReportMedicionEquipos', 'onclick' => 'modal (\''.URL::route($ruta["generateReportMedicionEquipos"], array('listar'=>'NO')).'\', \''.$titulo_generar_reporte_medicion_equipos.'\', this);')) !!}



			</div>	
			{!! Form::close() !!}	
            <div class="table-responsive" id="listado{{ $entidad }}">
			</div>
		</div>
	</div>
</div>

<script>
	$(document).ready(function () {
		buscar('{{ $entidad }}');
		init(IDFORMBUSQUEDA+'{{ $entidad }}', 'B', '{{ $entidad }}');
		$(IDFORMBUSQUEDA + '{{ $entidad }} :input[id="descripcion"]').keyup(function (e) {
			var key = window.event ? e.keyCode : e.which;
			if (key == '13') {
				buscar('{{ $entidad }}');
			}
		});
	});

	var EditbtnExelHEU = () =>{
		
		const fecha1 = document.getElementById('fecha_registro_inicial').value;
		const fecha2 = document.getElementById('fecha_registro_final').value;

		let rutaExel = document.getElementById('btnExelHEU').getAttribute('href');
		let rutaPDF = document.getElementById('btnPDFHEU').getAttribute('href');

		rutaExel = rutaExel.split('?')[0];
		rutaPDF = rutaPDF.split('?')[0];
		
		let newRutaExel = rutaExel + `?fecha_registro_inicial=${fecha1}&fecha_registro_final=${fecha2}`;
		let newRutaPDF = rutaPDF + `?fecha_registro_inicial=${fecha1}&fecha_registro_final=${fecha2}`;

		document.getElementById('btnExelHEU').setAttribute('href',newRutaExel);
		document.getElementById('btnPDFHEU').setAttribute('href',newRutaPDF);
	};

	
/*
	function DescargarEHEU(){
		
		const formData = new FormData();
		formData.append('fecha_registro_inicial', document.querySelector('#fecha_registro_inicial').value);
		formData.append('fecha_registro_final', document.querySelector('#fecha_registro_final').value);
		const headers = new Headers();
	    headers.append('X-CSRF-TOKEN', document.querySelector('meta[name="csrf-token"]').content);
		const config = {
				headers,
		       	method:'POST',
		       	body:formData
			};
		
		fetch('controldiario/hequipoxua',config)
		.then(data => console.log(data.text()));
		
	}
*/
</script>