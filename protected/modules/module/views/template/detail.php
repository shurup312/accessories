<div ng-controller="ModuleDetailCtrl">
	<div class="widget-breadcrumbs border-all bg-45">
		<span ng-repeat="bc in breadcrumbs" breadcrumbs-element>{{bc}}</span>
	</div>
	<div class="padding-10-20 bg-25 border-all">
		<table class="width-100">
			<thead>
				<tr>
					<th colspan="2"></th>
				</tr>
			</thead>
			<tfoot>
				<tr>
					<th colspan="5"></th>
				</tr>
			</tfoot>
			<tbody>
				<tr ng-repeat="detail in details">
					<td class="width-25">{{detail.title}}</td>
					<td class="width-75">{{detail.value | isempty}}</td>
				</tr>
			</tbody>
		</table>
	</div>
</div>

