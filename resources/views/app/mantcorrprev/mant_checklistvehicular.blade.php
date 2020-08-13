
<div id="divMensajeError{!! $entidad !!}"></div>
{!! Form::model($repuesto, $formData) !!}	
{!! Form::hidden('listar', $listar, array('id' => 'listar')) !!}
<div class="form-row">
	<div class="form-group col-4">
		{!! Form::label('fecharegistro', 'F. Registro:', array('class' => 'col-lg-12 col-md-12 col-sm-12 control-label')) !!}
		<div class="col-lg-12 col-md-12 col-sm-12">
			{!! Form::date('fecharegistro', null, array('class' => 'form-control input-xs', 'id' => 'fecharegistro', 'min' => date('Y-m-d') )) !!}
		</div>
	</div>
	<div class="form-group col-4">
		<div class="col-lg-12 col-md-12 col-sm-12">
			{!! Form::select('categoria', array('' => 'Seleccione Tipo Unidad', 'equipo'=> 'EQUIPO', 'vehiculo' => 'VEHICULO'), null, array('class' => 'form-control input-xs', 'id' => 'categoria')) !!}
		</div>
	</div>
	<div class="form-group col-4">
		<div class="col-lg-12 col-md-12 col-sm-12">
			{!! Form::select('categoria', array('' => 'Seleccione Unidad', '1'=> 'CAMION VOLQUETE', '2' => 'COMPACTADORA'), null, array('class' => 'form-control input-xs', 'id' => 'categoria')) !!}
		</div>
	</div>
</div>
<div class="form-row">
	<div class="form-group col-3">
		{!! Form::label('kilometrajeinicial', 'Kilometraje inicial:', array('class' => 'col-lg-12 col-md-12 col-sm-12 control-label')) !!}
		<div class="col-lg-12 col-md-12 col-sm-12">
			{!! Form::text('kilometrajeinicial', null, array('class' => 'form-control input-xs solo-lectura', 'id' => 'kilometrajeinicial')) !!}
		</div>
	</div>
	<div class="form-group col-3">
		{!! Form::label('kilometrajefinal', 'Kilometraje final:', array('class' => 'col-lg-12 col-md-12 col-sm-12 control-label')) !!}
		<div class="col-lg-12 col-md-12 col-sm-12">
			{!! Form::text('kilometrajefinal', null, array('class' => 'form-control input-xs solo-lectura', 'id' => 'kilometrajefinal')) !!}
		</div>
	</div>
	<div class="form-group col-6">
		{!! Form::label('liderarea', 'Lider del área:', array('class' => 'col-lg-12 col-md-12 col-sm-12 control-label')) !!}
		<div class="col-lg-12 col-md-12 col-sm-12">
			{!! Form::text('liderarea', null, array('class' => 'form-control input-xs solo-lectura', 'id' => 'liderarea')) !!}
		</div>
	</div>
</div>
<div class="form-row">
	<div class="form-group col-6">
		{!! Form::label('conductor_id', 'Conductor:', array('class' => 'col-lg-12 col-md-12 col-sm-12 control-label')) !!}
		<div class="col-lg-12 col-md-12 col-sm-12">
			{!! Form::select('conductor_id', array(''=>'Seleccione', '1' => 'PACHERREZ PUYEN ERICK STALYN', '2' => 'TORRES BERNAL ELIAS'), null, array('class' => 'form-control input-xs', 'id' => 'conductor_id')) !!}
		</div>
	</div>
</div>
<div class="form-row">
	<div class="container">
		<h5>Revisión de accesorios</h5>
		<div class="row">
			<div class="col-4 d-flex justify-content-center">
				<table class="table-sm">
					<thead>
						<th class="">SISTEMA ELECTRICO</th>
						<th class="text-center">SI</th>
						<th class="text-center">NO</th>
					</thead>
					<tbody class="table__personal-body">
						<tr>
							<td>Freno de emergencia</td>
							<td class="text-center">
								{!! Form::radio('freno_emergencia', 'si',false) !!}
							</td>
							<td class="text-center">
								{!! Form::radio('freno_emergencia', 'no',false) !!}
							</td>
						</tr>
						<tr>
							<td>Funcionamiento de tablero</td>
							<td class="text-center">
								{!! Form::radio('funcionamiento_tablero', 'si',false) !!}
							</td>
							<td class="text-center">
								{!! Form::radio('funcionamiento_tablero', 'no',false) !!}
							</td>
						</tr>
						<tr>
							<td>Estado de bateria y funcionamiento</td>
							<td class="text-center">
								{!! Form::radio('estado_bateria', 'si',false) !!}
							</td>
							<td class="text-center">
								{!! Form::radio('estado_bateria', 'no',false) !!}
							</td>
						</tr>
						<tr>
							<td>Funcionamiento de claxon</td>
							<td class="text-center">
								{!! Form::radio('funcionamiento_claxon', 'si',false) !!}
							</td>
							<td class="text-center">
								{!! Form::radio('funcionamiento_claxon', 'no',false) !!}
							</td>
						</tr>
						<tr>
							<td>Luces de retroceso pirata</td>
							<td class="text-center">
								{!! Form::radio('luces_retroceso_pirata', 'si',false) !!}
							</td>
							<td class="text-center">
								{!! Form::radio('luces_retroceso_pirata', 'no',false) !!}
							</td>
						</tr>
						<tr>
							<td>Luz direccional</td>
							<td class="text-center">
								{!! Form::radio('luz_direccional', 'si',false) !!}
							</td>
							<td class="text-center">
								{!! Form::radio('luz_direccional', 'no',false) !!}
							</td>
						</tr>
						<tr>
							<td>Faros neblineros</td>
							<td class="text-center">
								{!! Form::radio('faros_neblineros', 'si',false) !!}
							</td>
							<td class="text-center">
								{!! Form::radio('faros_neblineros', 'no',false) !!}
							</td>
						</tr>
						<tr>
							<td>Faros delanteros</td>
							<td class="text-center">
								{!! Form::radio('faros_delanteros', 'si',false) !!}
							</td>
							<td class="text-center">
								{!! Form::radio('faros_delanteros', 'no',false) !!}
							</td>
						</tr>
						<tr>
							<td>Faros posteriores</td>
							<td class="text-center">
								{!! Form::radio('faros_posteriores', 'si',false) !!}
							</td>
							<td class="text-center">
								{!! Form::radio('faros_posteriores', 'no',false) !!}
							</td>
						</tr>
						<tr>
							<td>Alarma de retroceso</td>
							<td class="text-center">
								{!! Form::radio('alarma_retroceso', 'si',false) !!}
							</td>
							<td class="text-center">
								{!! Form::radio('alarma_retroceso', 'no',false) !!}
							</td>
						</tr>
					</tbody>
				</table>
			</div>
			<div class="col-4 d-flex justify-content-center">
				<table class="table-sm">
					<thead>
						<th class="text-uppercase">Sistema Mecanico</th>
						<th class="text-uppercase text-center">Si</th>
						<th class="text-uppercase text-center">No</th>
					</thead>
					<tbody class="table__personal-body">
						<tr>
							<td>Nivel liquido de freno</td>
							<td class="text-center">
								{!! Form::radio('nivel_liquido_freno', 'si',false) !!}
							</td>
							<td class="text-center">
								{!! Form::radio('nivel_liquido_freno', 'no',false) !!}
							</td>
						</tr>
						<tr>
							<td>Sistema de dirección</td>
							<td class="text-center">
								{!! Form::radio('sistema_direccion', 'si',false) !!}
							</td>
							<td class="text-center">
								{!! Form::radio('sistema_direccion', 'no',false) !!}
							</td>
						</tr>
						<tr>
							<td>Palancas de cambios</td>
							<td class="text-center">
								{!! Form::radio('palancas_cambios', 'si',false) !!}
							</td>
							<td class="text-center">
								{!! Form::radio('palancas_cambios', 'no',false) !!}
							</td>
						</tr>
						<tr>
							<td>Estado de neumáticos</td>
							<td class="text-center">
								{!! Form::radio('estado_neumaticos', 'si',false) !!}
							</td>
							<td class="text-center">
								{!! Form::radio('estado_neumaticos', 'no',false) !!}
							</td>
						</tr>
						<tr>
							<td>LLantas de repuesto</td>
							<td class="text-center">
								{!! Form::radio('llantas_repuesto', 'si',false) !!}
							</td>
							<td class="text-center">
								{!! Form::radio('llantas_repuesto', 'no',false) !!}
							</td>
						</tr>
						<tr>
							<td>Ajustes de tuercas</td>
							<td class="text-center">
								{!! Form::radio('ajustes_tuercas', 'si',false) !!}
							</td>
							<td class="text-center">
								{!! Form::radio('ajustes_tuercas', 'no',false) !!}
							</td>
						</tr>
						<tr>
							<td>Presion de llantas en libras</td>
							<td class="text-center">
								{!! Form::radio('presion_llantas_libras', 'si',false) !!}
							</td>
							<td class="text-center">
								{!! Form::radio('presion_llantas_libras', 'no',false) !!}
							</td>
						</tr>
						<tr>
							<td>Cinturon de seguridad conductor</td>
							<td class="text-center">
								{!! Form::radio('cinturon_seguridad_conductor', 'si',false) !!}
							</td>
							<td class="text-center">
								{!! Form::radio('cinturon_seguridad_conductor', 'no',false) !!}
							</td>
						</tr>
						<tr>
							<td>Cinturón de seguridad pasajeros</td>
							<td class="text-center">
								{!! Form::radio('cinturon_seguridad_pasajeros', 'si',false) !!}
							</td>
							<td class="text-center">
								{!! Form::radio('cinturon_seguridad_pasajeros', 'no',false) !!}
							</td>
						</tr>
						<tr>
							<td>Suspensión</td>
							<td class="text-center">
								{!! Form::radio('suspension', 'si',false) !!}
							</td>
							<td class="text-center">
								{!! Form::radio('suspension', 'no',false) !!}
							</td>
						</tr>
					</tbody>
				</table>
			</div>
			<div class="col-4 d-flex justify-content-center">
				<table class="table-sm">
					<thead>
						<th class="text-uppercase">Sistema Mecanico</th>
						<th class="text-uppercase text-center">Si</th>
						<th class="text-uppercase text-center">No</th>
					</thead>
					<tbody class="table__personal-body">
						<tr>
							<td>Sistema de freno</td>
							<td class="text-center">
								{!! Form::radio('sistema_freno', 'si',false) !!}
							</td>
							<td class="text-center">
								{!! Form::radio('sistema_freno', 'no',false) !!}
							</td>
						</tr>
						<tr>
							<td>Pernos de neumáticos</td>
							<td class="text-center">
								{!! Form::radio('pernos_neumaticos', 'si',false) !!}
							</td>
							<td class="text-center">
								{!! Form::radio('pernos_neumaticos', 'no',false) !!}
							</td>
						</tr>
						<tr>
							<td>Nivel de aceite</td>
							<td class="text-center">
								{!! Form::radio('nivel_aceite', 'si',false) !!}
							</td>
							<td class="text-center">
								{!! Form::radio('nivel_aceite', 'no',false) !!}
							</td>
						</tr>
						<tr>
							<td>Espejos int y ext</td>
							<td class="text-center">
								{!! Form::radio('espejos_int_ext', 'si',false) !!}
							</td>
							<td class="text-center">
								{!! Form::radio('espejos_int_ext', 'no',false) !!}
							</td>
						</tr>
						<tr>
							<td>Parachoques</td>
							<td class="text-center">
								{!! Form::radio('parachoques', 'si',false) !!}
							</td>
							<td class="text-center">
								{!! Form::radio('parachoques', 'no',false) !!}
							</td>
						</tr>
						<tr>
							<td>Parabrisas y ventanas</td>
							<td class="text-center">
								{!! Form::radio('parabrisas_ventanas', 'si',false) !!}
							</td>
							<td class="text-center">
								{!! Form::radio('parabrisas_ventanas', 'no',false) !!}
							</td>
						</tr>
						<tr>
							<td>Puertas de cabina</td>
							<td class="text-center">
								{!! Form::radio('pernos_neumaticos', 'si',false) !!}
							</td>
							<td class="text-center">
								{!! Form::radio('pernos_neumaticos', 'no',false) !!}
							</td>
						</tr>
						<tr>
							<td>Puertas de tolva</td>
							<td class="text-center">
								{!! Form::radio('puertas_tolva', 'si',false) !!}
							</td>
							<td class="text-center">
								{!! Form::radio('puertas_tolva', 'no',false) !!}
							</td>
						</tr>
						<tr>
							<td>Plumillas</td>
							<td class="text-center">
								{!! Form::radio('plumillas', 'si',false) !!}
							</td>
							<td class="text-center">
								{!! Form::radio('plumillas', 'no',false) !!}
							</td>
						</tr>
						<tr>
							<td>Estado de carrocería</td>
							<td class="text-center">
								{!! Form::radio('estado_carroceria', 'si',false) !!}
							</td>
							<td class="text-center">
								{!! Form::radio('estado_carroceria', 'no',false) !!}
							</td>
						</tr>
					</tbody>
				</table>
			</div>
			<div class="col-4 d-flex justify-content-center">
				<table class="table-sm">
					<thead>
						<th class="text-uppercase">Accesorios</th>
						<th class="text-uppercase text-center">Si</th>
						<th class="text-uppercase text-center">No</th>
					</thead>
					<tbody class="table__personal-body">
						<tr>
							<td>Estuche de herramientas</td>
							<td class="text-center">
								{!! Form::radio('estuche_herramientas', 'si',false) !!}
							</td>
							<td class="text-center">
								{!! Form::radio('estuche_herramientas', 'no',false) !!}
							</td>
						</tr>
						<tr>
							<td>Estado y carga de extintor</td>
							<td class="text-center">
								{!! Form::radio('estado_carga_extintor', 'si',false) !!}
							</td>
							<td class="text-center">
								{!! Form::radio('estado_carga_extintor', 'no',false) !!}
							</td>
						</tr>
						<tr>
							<td>Botiquin</td>
							<td class="text-center">
								{!! Form::radio('botiquin', 'si',false) !!}
							</td>
							<td class="text-center">
								{!! Form::radio('botiquin', 'no',false) !!}
							</td>
						</tr>
						<tr>
							<td>Cable de remolque</td>
							<td class="text-center">
								{!! Form::radio('cable_remolque', 'si',false) !!}
							</td>
							<td class="text-center">
								{!! Form::radio('cable_remolque', 'no',false) !!}
							</td>
						</tr>
						<tr>
							<td>Tacos de seguridad cuña (2)</td>
							<td class="text-center">
								{!! Form::radio('tacos_seguridad', 'si',false) !!}
							</td>
							<td class="text-center">
								{!! Form::radio('tacos_seguridad', 'no',false) !!}
							</td>
						</tr>
						<tr>
							<td>LLave de ruedas</td>
							<td class="text-center">
								{!! Form::radio('llave_ruedas', 'si',false) !!}
							</td>
							<td class="text-center">
								{!! Form::radio('llave_ruedas', 'no',false) !!}
							</td>
						</tr>
						<tr>
							<td>Kit antiderrames</td>
							<td class="text-center">
								{!! Form::radio('kit_antiderrames', 'si',false) !!}
							</td>
							<td class="text-center">
								{!! Form::radio('kit_antiderrames', 'no',false) !!}
							</td>
						</tr>
						<tr>
							<td>Limpieza de la unidad</td>
							<td class="text-center">
								{!! Form::radio('limpieza_unidad', 'si',false) !!}
							</td>
							<td class="text-center">
								{!! Form::radio('limpieza_unidad', 'no',false) !!}
							</td>
						</tr>
					</tbody>
				</table>
			</div>
			<div class="col-4 d-flex justify-content-center">
				<table class="table-sm">
					<thead>
						<th class="text-uppercase">Documentos</th>
						<th class="text-uppercase text-center">Si</th>
						<th class="text-uppercase text-center">No</th>
					</thead>
					<tbody class="table__personal-body">
						<tr>
							<td>Tarjeta de propiedad</td>
							<td class="text-center">
								{!! Form::radio('estuche_herramientas', 'si',false) !!}
							</td>
							<td class="text-center">
								{!! Form::radio('estuche_herramientas', 'no',false) !!}
							</td>
						</tr>
						<tr>
							<td>SOAT</td>
							<td class="text-center">
								{!! Form::radio('soat', 'si',false) !!}
							</td>
							<td class="text-center">
								{!! Form::radio('soat', 'no',false) !!}
							</td>
						</tr>
						<tr>
							<td>Licencia de conducir</td>
							<td class="text-center">
								{!! Form::radio('licencia_conducir', 'si',false) !!}
							</td>
							<td class="text-center">
								{!! Form::radio('licencia_conducir', 'no',false) !!}
							</td>
						</tr>
						<tr>
							<td>Revisión técnica</td>
							<td class="text-center">
								{!! Form::radio('revision_tecnica', 'si',false) !!}
							</td>
							<td class="text-center">
								{!! Form::radio('revision_tecnica', 'no',false) !!}
							</td>
						</tr>
					</tbody>
				</table>
			</div>
			<div class="col-4">
				<h5>Observaciones e incidentes</h5>
				<textarea name="observaciones_incidentes" class="form-control" rows="9" cols="26"></textarea>
			</div>
		</div>
	</div>
</div>






<div class="form-group">
	<div class="col-lg-12 col-md-12 col-sm-12 text-right">
		{!! Form::button('<i class="fa fa-check fa-lg"></i> '.$boton, array('class' => 'btn btn-success btn-sm', 'id' => 'btnGuardar', 'onclick' => 'guardar(\''.$entidad.'\', this)')) !!}
		{!! Form::button('<i class="fa fa-exclamation fa-lg"></i> Cancelar', array('class' => 'btn btn-warning btn-sm', 'id' => 'btnCancelar'.$entidad, 'onclick' => 'cerrarModal();')) !!}
	</div>
</div>
{!! Form::close() !!}
<script type="text/javascript">
	$(document).ready(function() {
		configurarAnchoModal('900');
		init(IDFORMMANTENIMIENTO+'{!! $entidad !!}', 'M', '{!! $entidad !!}');


	}); 
</script>
<style>
	.table__personal-body {
		font-size: .85em; !important
	}
</style>