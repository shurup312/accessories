<div ng-controller="AccessoryListCtrl">
	<div class="widget-breadcrumbs border-all bg-45">
		<span ng-repeat="bc in breadcrumbs" breadcrumbs-element>{{bc}}</span>
	</div>
	<div class="list-table-menu border-all border-botton-none bg-45">
		Создать:
		<span ng-repeat="i in addItem">
			<!-- первый параметр - ID родительского объекта, второй  ID типа создаваемого объекта -->
			<a href="#/accessory/new/{{id}}/{{i.id}}">{{i.name}}</a>
		</span>
		<span ng-show="massDelete"><span class="separator">!</span><button ng-click="goMassDelete()"
																				  class="btn btn-warning btn-sm">Удалить
				выбранные
			</button></span>


	</div>
	<div class="list-content bg-25 border-all">
		<div class="list-table-panel">Показывать
			<select ng-model="onPage" class="list-onPage-select">
				<option value="5">5</option>
				<option value="10">10</option>
				<option value="20">20</option>
				<option value="50">50</option>
				<option value="100">100</option>
			</select>
			записей
			<div class="list-table-search float-right clear-both">
				Search:
				<input ng-model="query" class="bg-25 border-all"/>
			</div>
		</div>
		<table class="width-100">
			<thead>
			<tr ng-repeat="title in header">
				<th class="dataTable-checkboxes"><input ng-show="checkAllBox.visible" type="checkbox" ng-click="checkAll()"
														ng-model="checkAllBox.check"/></th>
				<th class="dataTable-id"><a href="javascript:void(0)" ng-click="setValue('orderProp','id')">{{title.id}}</a>&nbsp;<span
						ng-show="orderProp=='id'" class="icon-chevron-down"></span></th>
				<th><a href="javascript:void(0)"
					   ng-click="setValue('orderProp','name')">{{title.name}}</a>&nbsp;<span
						ng-show="orderProp=='name'" class="icon-chevron-down"></span></th>
				<th class="dataTable-sort">&nbsp;</th>
				<th class="dataTable-actions">Действия</th>
			</tr>
			</thead>
			<tfoot>
			<tr>
				<th colspan="5"></th>
			</tr>
			</tfoot>
			<tbody>
			<tr ng-repeat="element in elementsInTable | filter:query | orderBy:orderProp">
				<td><input type="checkbox" ng-checked="checkBoxes[element.id].check"
						   ng-click="checkElement(element.id)" ng-show="element.can_delete">&nbsp;</td>
				<td ng-bind-template="{{element.id}}"></td>
				<td list-link></td>
				<td>{{element.sort}}&nbsp;</td>
				<td>
					<a href="#/accessory/detail/{{element.id}}">
						<button class="btn btn-sm btn-primary"> Detail</button>
					</a>
					<a href="#/accessory/edit/{{element.id}}">
						<button class="btn btn-sm btn-info"> Edit</button>
					</a>
					<a ng-show="element.can_delete" ng-click="delete(element.id)">
						<button class="btn btn-sm btn-warning"> Delete</button>
						</span></a>
				</td>

			</tr>
			</tbody>
		</table>
		<div ng-show="isPagination">
			Страницы:
					<span ng-repeat="p in pages">
						<button ng-click="setPage(p)" class="list-pagination-button list-pagination-button{{p}} bg-10 border-all">{{p}}
						</button>
					</span>
		</div>
		<div ng-show="errorMessage" class="error">{{errorMessage}}</div>
		<div ng-show="okMessage" class="ok">{{okMessage}}</div>
	</div>
</div>