<div ng-controller="contactoslista">
	<div class="container-fluid inicio marginTop-setenta">
		<div class="col-md-6 inicio1">
			<h3><span id="gly" class="glyphicon glyphicon-play-circle" aria-hidden="true"></span>Contactos que contiene su lista</h3>
		</div>
		<div class="col-md-6 inicio2">
			<p></p>
		</div>
	</div>

	<div class="container">
		<div ng-controller="contactolista_dos as showCase" class="marginTop-treinta">
			<h3 class="text-center">{{showCase.nomList}}</h3>

			<table datatable="" dt-options="showCase.dtOptions" dt-columns="showCase.dtColumns" class="table table-striped table-hover dataTable">
			</table>
		</div>
	</div>

</div>