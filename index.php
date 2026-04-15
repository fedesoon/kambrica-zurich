<!doctype html>
<html lang="">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Zurich – Maquetas</title>
	<style>
		* { margin: 0; padding: 0; box-sizing: border-box; }
		html, body {
			width: 100%;
			height: 100%;
			background-color: #ffffff;
		}
		body {
			min-height: 100vh;
			display: flex;
			align-items: center;
			justify-content: center;
			font-family: Arial, sans-serif;
			padding-bottom: 20vh;
		}
		.splash {
			text-align: center;
			padding: 40px;
		}
		.splash img {
			max-width: 280px;
			margin-bottom: 48px;
			display: block;
			margin-left: auto;
			margin-right: auto;
		}
		.cards {
			display: flex;
			gap: 24px;
			justify-content: center;
		}
		.card {
			background: #ffffff;
			border-radius: 10px;
			box-shadow: 0 4px 16px rgba(0,0,0,0.10);
			padding: 40px 0;
			width: 196px;
			text-align: center;
			text-decoration: none;
			color: #1d6eb5;
			font-size: 20px;
			font-weight: 800;
			letter-spacing: 0.5px;
			transition: box-shadow 0.2s, transform 0.2s;
		}
		.card:hover {
			box-shadow: 0 8px 28px rgba(0,0,0,0.16);
			transform: translateY(-2px);
		}
		@media (max-width: 768px) {
			body {
				align-items: flex-start;
				padding-top: 20vw;
				padding-bottom: 0;
			}
			.splash {
				width: 100%;
				padding: 24px 20px;
			}
			.splash img {
				max-width: 180px;
				margin-bottom: 36px;
			}
			.cards {
				flex-direction: column;
				align-items: stretch;
				gap: 16px;
			}
			.card {
				width: 100%;
				max-width: none;
				padding: 28px 0;
				font-size: 18px;
			}
		}
	</style>
</head>
<body>
<div class="splash">
	<img src="img/logos/zurich-logo-horizontal.png" alt="Zurich">
	<div class="cards">
		<a href="index-ahorro.php" class="card">Ahorro</a>
		<a href="index-inversion.php" class="card">Inversión</a>
		<a href="index-proteccion.php" class="card">Protección</a>
	</div>
</div>
</body>
</html>
