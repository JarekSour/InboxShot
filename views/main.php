<div class="container-fluid inicio marginTop-setenta">
	<div class="col-md-6 inicio1">
		<h3><span class="glyphicon glyphicon-play-circle" aria-hidden="true"></span>Elige el Tipo de Campaña</h3>
	</div>
	<div class="col-md-6 inicio2 hidden-xs">
		<p>Puede crear sus campañas de acuerdo al tipo de envío que necesite hacer ya sea para vender o promocionar un producto o servicio, así como para estrechar lazos con sus clientes o invitarlos a algun evento.</p>
	</div>
</div>
<div class="container-fluid">
	<div class="container" style="margin-top: 55px;">
		<div class="col-md-4" ng-controller="chart1">
			<center>
				<div class="loader" id="loaderFI">
					<p style="margin-top: 86px;">Cargando... <i class="fa fa-spinner fa-pulse fa-2x"></i></p>
				</div>
				<h3>Fidelizar</h3>
				<div easypiechart options="options" percent="percent">
					<span class="percent">{{porcent}}</span>
					<p class="aper">{{open}}<br>aperturas</p>
					<p><span>{{process}}</span> mensajes procesados</p>
				</div>
				<a href="campana.php?typ=fidelizar" class="btn btn-warning active" role="button">Crear campaña</a>
				<a href="fidelizar.php" class="btn btn-default" role="button">Ver reportes</a>
			</center>
		</div>

		<div class="col-md-4" ng-controller="chart2">
			<center>
				<div class="loader" id="loaderVE">
					<p style="margin-top: 86px;">Cargando... <i class="fa fa-spinner fa-pulse fa-2x"></i></p>
				</div>
				<h3>Vender</h3>
				<div easypiechart options="options" percent="percent">
					<span class="percent">{{porcent}}</span>
					<p class="aper">{{open}}<br>aperturas</p>
					<p><span>{{process}}</span> mensajes procesados</p>
				</div>
				<a href="campana.php?typ=vender" class="btn btn-warning active" role="button">Crear campaña</a>
				<a href="vender.php" class="btn btn-default" role="button">Ver reportes</a>
			</center>
		</div>

		<div class="col-md-4" ng-controller="chart3">
			<center>
				<div class="loader" id="loaderIN">
					<p style="margin-top: 86px;">Cargando... <i class="fa fa-spinner fa-pulse fa-2x"></i></p>
				</div>
				<h3>Invitar</h3>
				<div easypiechart options="options" percent="percent">
					<span class="percent">{{porcent}}</span>
					<p class="aper">{{open}}<br>aperturas</p>
					<p><span>{{process}}</span> mensajes procesados</p>
				</div>
				<a href="campana.php?typ=invitar" class="btn btn-warning active" role="button">Crear campaña</a>
				<a href="invitar.php" class="btn btn-default" role="button">Ver reportes</a>
			</center>
		</div>
	</div>
</div>