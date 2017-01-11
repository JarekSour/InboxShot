<div ng-controller="addcontacto">

	<div ng-show="loading" class="dv-loading">
		<div class="text-center">
			<img src="images/logo.png" class="img-loading" />
			<br>
			<img src="images/loading.gif">
			<p class="text-loading">{{txtloading}}</p>
		</div>
	</div>

	<div class="container-fluid inicio marginTop-setenta">
		<div class="col-md-6 inicio1">
			<h3><span id="gly" class="glyphicon glyphicon-play-circle" aria-hidden="true"></span>Ingreso de contactos</h3>
		</div>
		<div class="col-md-6 inicio2">
			<p>Agregue sus contactos a una lista común, ya sea desde un archivo o manualmente</p>
		</div>
	</div>

	<div class="container" id="tabSelect1">
		<h2 class="text-center marginTop-cuarenta marginBot-treinta">  Seleccione como quiere agregar contactos</h2>
		<div class="hover06 column">
			<div class="col-md-4 col-md-offset-2 centerBrowser" >
				<figure><img src="images/base_archivo.png" class="img-responsive" ng-click="showCsv()" /></figure>
				<span style="padding: 15px;">Desde archivo</span>
				<p>Ingrese sus contactos desde un archivo CSV con sus cabezeras</p>
			</div>
			<div class="col-md-4 centerBrowser" >
				<figure><img src="images/base_manual.png" class="img-responsive" ng-click="showForm()" /></figure>
				<span style="padding: 15px;">Manual</span>
				<p>Ingrese sus contactos o subscriptores uno a uno por medio de un formulario</p>
			</div>
		</div>
	</div>


	<div class="container hid" id="tabSelect2" >
		<button class="btn btn-warning active btn-sm pull-right" ng-click="backMenu()">Volver a selección</button>
		<div class="tab-content">
			<div id="menu1">
				<div class="modal-dialog">
					<div class="modal-content">
						<div class="modal-body" style="background-color: #797979;color: white;">
							- Todos los datos son opcionales, excepto el EMAIL que es obligatorio.
							<br /> - Las fechas se deben ingresar como YYYY-MM-DD.
							<br /> - Los campos deben ser separados por una coma (,).
							<br /> - Campos : Email=email, Nombre=firstName, Apellido=lastName, Télefono=phone, Celular=mobileNumber, Grupo=notes, Sexo=gender, Fecha de nacimiento=birthDate, Ciudad=city, País=country, Empresa=organizationName, Web=website
						</div>
					</div>
				</div>
				<div class="col-md-10 col-md-offset-1">
					<form>
						<input type="file" ng-files="getTheFiles($files)" name="contactFile" on-read-file="showContent($fileContent)" class="filestyle glyfecha glyphicon input-sm" />
						<button type="submit" class="btn btn-success btn-block" ng-click="sendFormCsv()" style="margin-top: 10px;margin-bottom: 10px;">Guardar contactos</button>
					</form>
					<table class="table table-hover" style="background-color:#FFF;text-align:center;">
						<thead>
							<tr>
								<th class="text-center" ng-repeat="x in thead">{{x}}</th>
							</tr>
						</thead>
						<tbody id="tablaCsv">
							<tr ng-repeat="x in tbody">
								<td ng-repeat="z in thead">{{x[z]}}</td>
							</tr>
						</tbody>
					</table>
				</div>
			</div>
			<div id="menu2">
				<div class="col-md-8 col-md-offset-2">
					<div class="modal-dialog">
						<div class="modal-content">
							<div class="modal-body" style="background-color: #797979;color: white;">
								- Todos los datos son opcionales, excepto el EMAIL que es obligatorio.
								<br /> - Las fechas se deben ingresar como YYYY-MM-DD.
								<br /> - Los campos deben ser separados por una coma (,).
								<br /> - Campos : Email=email, Nombre=firstName, Apellido=lastName, Télefono=phone, Celular=mobileNumber, Grupo=notes, Sexo=gender, Fecha de nacimiento=birthDate, Ciudad=city, País=country, Empresa=organizationName, Web=website
							</div>
						</div>
					</div>
					<form role="form">
						<div class="form-group col-md-6">
							<label>Nombre(s)</label>
							<input type="text" class="form-control input-sm" ng-model="txtNombre" placeholder="Fabián">
						</div>
						<div class="form-group col-md-6">
							<label>Apellido(s)</label>
							<input type="text" class="form-control input-sm" ng-model="txtApellido" placeholder="Fuentes">
						</div>
						<div class="form-group col-md-6">
							<label>Correo electrónico</label>
							<input type="text" class="form-control input-sm" ng-model="txtCorreo" placeholder="contacto@inboxshot.com">
						</div>
						<div class="form-group col-md-6">
							<label>Sexo</label>
							<select class="form-control input-sm" ng-model="slcSexo">
								<option value=""></option>
								<option value="m">Masculino</option>
								<option value="f">Femenino</option>
							</select>
						</div>
						<div class="form-group col-md-6">
							<label>Fecha de nacimiento</label>
							<input type="text" class="form-control input-sm" ng-model="txtNacimiento" placeholder="21-05-1989">
						</div>
						<div class="form-group col-md-6">
							<label>Grupo</label>
							<input type="text" class="form-control input-sm" ng-model="txtGrupo" placeholder="Grupo A">
						</div>
						<div class="form-group col-md-6">
							<label>Número de télefono</label>
							<input type="text" class="form-control input-sm" ng-model="txtFijo" placeholder="2212345678">
						</div>
						<div class="form-group col-md-6">
							<label>Número de celular</label>
							<input type="text" class="form-control input-sm" ng-model="txtMovil" placeholder="56912345678">
						</div>
						<div class="form-group col-md-6">
							<label>País</label>
							<input type="text" class="form-control input-sm" ng-model="txtPais" placeholder="Chile">
						</div>
						<div class="form-group col-md-6">
							<label>Ciudad</label>
							<input type="text" class="form-control input-sm" ng-model="txtCiudad" placeholder="Santiago">
						</div>
						<div class="form-group col-md-6">
							<label>Nombre de empresa</label>
							<input type="text" class="form-control input-sm" ng-model="txtEmpresa" placeholder="InboxShot">
						</div>
						<div class="form-group col-md-6">
							<label>Web empresa</label>
							<input type="text" class="form-control input-sm" ng-model="txtWeb" placeholder="http://inboxshot.com/">
						</div>
						<div class="form-group col-md-12 marginTop-diez marginBot-treinta">
							<button type="button" class="btn btn-success btn-block" ng-click="sendForm()" >Guardar contacto</button>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>
</div>