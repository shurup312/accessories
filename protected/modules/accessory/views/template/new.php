<div ng-controller="AccessoryNewCtrl">
	<div class="widget-breadcrumbs border-all bg-45">
		<span ng-repeat="bc in breadcrumbs" breadcrumbs-element>{{bc}}</span>
	</div>
	<div class="bg-25 border-all">
		<div ng-show="errorMessage" class="error">{{errorMessage}}</div>
		<div ng-show="okMessage" class="ok">{{okMessage}}</div>
		<div class="padding-10-20"><legend>Создание</legend></div>
		<div ng-repeat="tab in data" class="padding-10-20">

			<div class="border-all">
				<div class="bg-45 border-bottom padding-10-20">{{tab.tab_name}}</div>
				<div class="bg-10 padding-10-20">
					<div class="edit-form-row" ng-repeat="param in tab.params">
						<div class="width-25 float-left">
							<label class="control-label" for="{{param.field}}">{{param.name}}</label>
						</div>
						<div class="width-75 float-left">
							<div class="form-group" visual-element></div>
						</div>
						<div class="clearfix"></div>
					</div>
				</div>
			</div>
		</div>

		<div class="padding-10-20">
			<input type="button" class="btn btn-primary" value="Сохранить" ng-click="create()"/>
		</div>
	</div>
</div>