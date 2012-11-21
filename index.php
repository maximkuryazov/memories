<!doctype html>
<html>
	<head>
		<meta charset="utf-8">
		<title>Демо скрипт закладок</title>
		<script data-main="js/main" src="js/require.js"></script>
		<link rel="stylesheet" href="css/bootstrap.min.css">
		<link rel="stylesheet" href="css/style.css">
	</head>
	<body>
		<br />
		<center>
			<h3>Личный кабинет</h3>
			<div id="content">
				<div id="authorization-div">
					<p><b>Авторизация</b></p>
					<span id="autho-error-message"> &nbsp; </span> <p />
					<form id="authorization" name="authorization" action="core.php" method="POST">
						<input type="text" name="login" placeholder="Логин" /> <br />
						<input type="password" name="password" placeholder="Пароль" /> <p />
						<input type="submit" value="Вход" />
					</form>
					<a href="#" id="registration-link">Регистрация</a>
				</div>
				<div id="registration-div">
			</div>
		</center>
	</body>
</html>