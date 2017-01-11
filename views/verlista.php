<div ng-controller="verlista">
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
			<h3><span id="gly" class="glyphicon glyphicon-play-circle" aria-hidden="true"></span>Ver Listas</h3>
		</div>
		<div class="col-md-6 inicio2">
			<p>Cree o elimine sus listas de contactos.<br><i>*Al eliminar, no elimina los contactos, solo la lista</i></p>
		</div>
	</div>
	
	<div class="col-md-8 col-md-offset-2">
		<button type="button" class="btn btn-warning active btn-block marginTop-veinte" ng-click="newList()">Crear una nueva lista</button>
		<table class="table table-hover table-striped marginTop-cuarenta">
			<thead>
				<th>Nombre de lista</th>
				<th>Num. de contactos</th>
				<th>Fecha de creación</th>
				<th>Detalle</th>
			</thead>
			<tbody>
				<tr ng-repeat="x in list">
					<td>{{x.listname}}</td>
					<td>{{x.count}}</td>
					<td>{{x.dateadded}}</td>
					<td>
						<div class="dropdown">
							<button class="btn btn-primary dropdown-toggle btn-sm" type="button" data-toggle="dropdown">
								<i class="fa fa-ellipsis-v" aria-hidden="true"></i></button>
								<ul class="dropdown-menu">
									<li><a href="#contactoslista/{{x.listname}}">Ver contactos</a></li>
									<li><a data-name={{x.listname}} ng-click="deleteList($event)">Eliminar lista</a></li>
								</ul>
							</div>
						</td>
					</tr>
				</tbody>
			</table>
		</div>
	</div>