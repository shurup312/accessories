<html>
<head>
	<title></title>
	<script type="text/javascript" src="/js/angular-1.0.6/angular.min.js"></script>
	<script type="text/javascript" src="/js/angular-1.0.6/angular-resource.min.js"></script>
	<script type="text/javascript" src="/js/angular-1.0.6/angular-cookies.min.js"></script>
	<link rel="stylesheet" href="/js/angular-1.0.6/docs/css/bootstrap.min.css"/>
	<link rel="stylesheet" href="/css/module/style.css"/>
	<script type="text/javascript" src="/js/jquery-2.0.3.js"></script>
	<script type="text/javascript" src="/js/jquery.json-2.4.js"></script>
</head>
<body>
	<div class="admin-title border-bottom bg-45">
		<div class="padding-10-20">Административная панель
			<div class="admin-title-login float-right clear-both">
				<div>Здравствуйте, Олег.</div>
			</div>
		</div>
	</div>

	<div class="page_content">

		<div class="admin-left-panel">
			<div class="admin-left-panel-title border-all bg-45">
				<div>Меню</div>
			</div>
			<div class="admin-left-panel-menu border-all bg-25">
				<div class="padding-10-20">
					<a href="/module/">Модули</a><br/>
					<a href="/accessory/">Товары</a>
				</div>
			</div>
		</div>
		<div class="admin-right-panel clear-both">
			<?php echo $content; ?>
		</div>
	</div>
</body>
</html>