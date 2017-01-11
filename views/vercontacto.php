<div ng-controller="vercontacto as showCase">
	
	<script type="text/ng-template" id="modal-detail-contact">
		<div class="modal fade">
			<div class="modal-dialog">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" ng-click="close('Cancel')" data-dismiss="modal" aria-hidden="true">&times;</button>
						<h4 class="modal-title">Editar contacto</h4>
					</div>
					<div class="modal-body">
						<div class="row">
							<div class="col-md-12">
								<div class="form-group col-md-12">
									<img src="{{gra}}" class="img-circle" style="height: 70px;display: block;margin: 0 auto;">
								</div>
								<div class="form-group col-md-6">
									<label>Nombre(s)</label>
									<input type="text" class="form-control input-sm" placeholder="Jarek" ng-model="nom" value="{{nom}}">
								</div>
								<div class="form-group col-md-6">
									<label>Apellido(s)</label>
									<input type="text" class="form-control input-sm" placeholder="Castro" ng-model="ape" value="{{ape}}">
								</div>
								<div class="form-group col-md-6">
									<label>Correo electrónico</label>
									<input type="text" class="form-control input-sm" placeholder="j.castro@mail.com" ng-model="ema" value="{{ema}}">
								</div>
								<div class="form-group col-md-6">
									<label>Sexo</label>
									<select class="form-control input-sm">
										<option></option>
										<option value="m">Masculino</option>
										<option value="f">Femenino</option>
									</select>
								</div>
								<div class="form-group col-md-6">
									<label>Fecha de nacimiento</label>
									<input type="text" class="form-control input-sm" placeholder="21-05-1989" ng-model="fec" value="{{fec}}">
								</div>
								<div class="form-group col-md-6">
									<label>Grupo</label>
									<input type="text" class="form-control input-sm" placeholder="Grupo A" ng-model="gru" value="{{gru}}">
								</div>
								<div class="form-group col-md-6">
									<label>Número de télefono</label>
									<input type="text" class="form-control input-sm" placeholder="2212345678" ng-model="fon" value="{{fon}}">
								</div>
								<div class="form-group col-md-6">
									<label>Número de celular</label>
									<input type="text" class="form-control input-sm" placeholder="56912345678" ng-model="cel" value="{{cel}}">
								</div>
								<div class="form-group col-md-6">
									<label>País</label>
									<input type="text" class="form-control input-sm" placeholder="Chile" ng-model="pai" value="{{pai}}">
								</div>
								<div class="form-group col-md-6">
									<label>Ciudad</label>
									<input type="text" class="form-control input-sm" placeholder="Santiago" ng-model="ciu" value="{{ciu}}">
								</div>
								<div class="form-group col-md-6">
									<label>Nombre de empresa</label>
									<input type="text" class="form-control input-sm" placeholder="InboxShot" ng-model="emp" value="{{emp}}">
								</div>
								<div class="form-group col-md-6">
									<label>Web empresa</label>
									<input type="text" class="form-control input-sm" placeholder="http://inboxshot.com/" ng-model="web" value="{{web}}">
								</div>
							</div>
						</div>
					</div>
					<div class="modal-footer">
						<button type="button" ng-click="save()" class="btn btn-success btn-sm" data-dismiss="modal">Guardar cambios</button>
						<button type="button" ng-click="cancel()" class="btn btn-danger btn-sm" data-dismiss="modal">Eliminar contacto</button>
						<button type="button" class="btn btn-warning btn-sm" data-dismiss="modal">Cancelar</button>
					</div>
				</div>
			</div>
		</div>
	</script>

	<div class="container-fluid inicio marginTop-setenta">
		<div class="col-md-6 inicio1">
			<h3><span id="gly" class="glyphicon glyphicon-play-circle" aria-hidden="true"></span>Listas de clientes</h3>
		</div>
		<div class="col-md-6 inicio2">
			<p>Revise la lista completa de todos sus suscritos o contactos en su base de datos.</p>
		</div>
	</div>

	<div class="container">
		<div ng-controller="ServerSideProcessingCtrl as showCase">
			<h3 class="text-center">{{showCase.numContact}}</h3>

			<table datatable="" dt-options="showCase.dtOptions" dt-columns="showCase.dtColumns" class="table table-striped table-hover dataTable">
			</table>
		</div>
	</div>
</div>
