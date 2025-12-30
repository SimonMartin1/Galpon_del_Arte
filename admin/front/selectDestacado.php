<?php
session_start();


if (!isset($_SESSION['user_id'])) {
    header("Location: /Galpon_del_Arte/admin/front/login.html");
    exit(); 
}
?>


<!DOCTYPE HTML>

<html>
	<head>
		<link rel="icon" href="../../front/assets/images/icono3.png">
		<title>Galpon Del Arte</title>
		<meta charset="utf-8" lang="es" />
		<meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no" />
		<link rel="stylesheet" href="../../front/assets/css/main.css" />
		<noscript><link rel="stylesheet" href="../../front/assets/css/noscript.css" /></noscript>
	</head>
	<body class="is-preload">
		<!-- Page Wrapper -->
		<div id="page-wrapper">
				<!-- Header -->
			<header id="header" style="display: flex; align-items: center; justify-content: space-between; padding-right:.6em">
    <div style="display: flex; align-items: center;">
        <img src="../../front/assets/images/icono3.png" alt="" class="navegacion">
        <h1><a href="../../front/index.html" class="title1">Galpon Del Arte</a></h1>
    </div>
    <button style="display: flex; align-items: center; justify-content: center; height: 3em; padding: 0 1em; background: none; border: none; cursor: pointer;" id="log-out">
        <img style="margin-right: 0.5em;" src="../../front/assets/images/logout.png" alt="">
        <h5 style="display: inline-block; box-shadow: none; padding: 0; letter-spacing: .4em; margin: 0;">Cerrar Sesion</h5>
    </button>
</header>
				<!-- Main -->
			<article id="main">
				<header>
					<h2>Edicion</h2>
				</header>
				<section class="wrapper style5">
					<div class="inner">
						<section>
							<h4>Imagenes Destacadas</h4>
								<div class="row gtr-uniform">
									<div class="col-6 col-12-xsmall">
										<select id="select-item">
                                        </select>
									</div>
									<div class="col-12 hide" id="response" >
										<div class="col-6 col-12-xsmall">
											<input style="margin-bottom: 1.5em;" type="text" name="asunto" id="selected-titt"  placeholder="Titulo" required /> 
										</div>
										
										<div class="col-6 col-12-xsmall">
											<select style="margin-bottom: 1.5em;" id="select-img">
												<option selected disabled>Imagen</option>
											</select>
										</div>

										<div class="col-12">
											<textarea id="selected-description" placeholder="Descripcion" rows="6" required></textarea>
										</div>
									</div>
									<div class="col-12">
										<ul class="actions">
											<li><input type="submit" id="aplicar" value="Aplicar" class="primary"></li>
										</ul>
									</div>
								</div>
						</section>
						<section style="margin-top: 2em;">
							<h4>Cargar Imagenes Galeria</h4>
							<div class="row gtr-uniform">
								<div class="col-12">
									<label for="file-input" class="button" style="margin-bottom: 1.5em;">Seleccionar Archivos</label>
									<input type="file" id="file-input" multiple accept="image/*" style="display: none;" />
								</div>
								<div class="col-12" id="preview-container" style="display: none;">
									<h5>Preview de Imágenes:</h5>
									<div id="image-preview" class="row gtr-uniform"></div>
								</div>
								<div class="col-12">
									<ul class="actions">
										<li><input type="button" id="upload-btn" value="Subir Imágenes" class="primary" disabled /></li>
									</ul>
								</div>
							</div>
						</section>
					</div>
				</section>
			</article>
		<!-- Scripts -->
			<script src="../../front/assets/js/jquery.min.js"></script>
			<script src="js/main.js"></script>
	</body>
</html>
