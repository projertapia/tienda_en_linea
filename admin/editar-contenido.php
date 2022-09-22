<?php
	session_start();
	require('connect/conect_usrer.php');
	include('functions/hacecuanto.php');	
	if (!isset($_SESSION['adminuser']) OR $_SESSION['adminuser']=="") {
		header('location:'.SITE.'admin/entrar');
	}
if(isset($_GET['id']) AND $_GET['id']!=""){
	$idpage=$_GET['id'];
	$title=$_GET['title'];
	$SQLPage="SELECT id_page, titulo_page, contenido_page FROM contenido_page WHERE id_page=$idpage";
	$reqPage=mysqli_query($conex, $SQLPage);
	while($resulPage = mysqli_fetch_object($reqPage)){
		$id_page = $resulPage->id_page;
		$titulo_page = $resulPage->titulo_page;
		$contenido_page = $resulPage->contenido_page;
	}
}else{
	header('location:'.SITE.'admin/contenido');
}
if(isset($_GET['mod']) AND $_GET['mod']!=""){
	$mod=$_GET['mod'];
	if($mod=="true"){
		$txtUpdate="Actualizado";
	}else{
		$txtUpdate="Error al actualizar";
	}
}else{
	$txtUpdate="";
}
?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Contenido | Ecommerce</title>
<?php include("parts/header.php");?>
<script src="<?php echo SITE?>admin/js/ckeditor.js"></script>
<script src="<?php echo SITE?>admin/js/ckfinder/ckfinder.js"></script>
</head>

<body id="panel">
	<section id="home-mi-escaparate" class="d-flex">
		<?php include("parts/navlateral.php");?>
		<div id="content-info">
			<nav class="navbar navbar-yellow navbar-expand-md bg-light right-content">
				<div class="container">
					<div class="nav justify-content-end w-100" id="collapsingNavbar2">
						<a href="<?php echo SITE.'admin'?>" class="navbar-brand" style="display: block; margin-right: auto!important; margin-left: auto!important"><img src="<?php echo SITE?>img/ecommerce_logo.svg" alt="Ecommerce" width="82px"></a> 
					</div>
					<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#lateralpanel" aria-controls="lateralpanel" aria-expanded="false" aria-label="Toggle navigation">
						<span class="navbar-toggler-icon"></span>
					</button>
					<a href="<?php echo SITE ?>admin/salir"><i class="fas fa-sign-out-alt"></i> Salir</a>
				</div>
			</nav>
			<section id="info-content">
				<div class="row">
					<div class="col-12 p-2">
						<h1 id="titlesection">Pagina:</h1>
					</div>
					<hr>
					<div class="col-12 col-lg-9">
						<div class="card lista-prodcutos">
							<div class="card-header ">
								<h5 class="card-title"><?php echo $titulo_page?></h5>
							</div>
							<div class="card-body">
								<form accept-charset="UTF-8" enctype="multipart/form-data" method="post" id="form-page" action="../functions/update-contenido.php">
									<input type="hidden" name="idpage" value="<?php echo $idpage?>">
									<div class="form-group">
										<label for="title">Título de la página</label>
										<input type="text" name="title" class="form-control" value="<?php echo $titulo_page?>" required>
									</div>
									<hr>
									<div class="form-group">
										<label for="contenido">Contenido de página</label>
										<div id="toolbar-container"></div>
										<textarea name="contenido" id="contenido"><?php echo $contenido_page?></textarea>
									</div>
								</form>
							</div>
						</div>
					</div>
					<div class="col-12 col-lg-3">
						<div class="card lista-prodcutos">
							<div class="card-header ">
								 <h5 class="card-title">Publicar</h5>
							</div>
							<div class="card-body">
								<p><?php echo $txtUpdate?></p>
								<button type="button" name="guardar" id="guardar" class="btn btn-success" onClick="guardar()">Guardar</button>
								<a href="<?php echo SITE.'admin/contenido'?>" class="btn btn-info" id="regresar">Regresar</a>
							</div>
						</div>
					</div>
				</div>
			</section>
		</div>
	</section>
	<script>
		function guardar(){
			document.getElementById("form-page").submit();
		}
		ClassicEditor
			.create( document.querySelector( '#contenido' ), {	
			 minHeight: '500px',
				toolbar: {
					items: [
						'heading',
						'|',
						'fontColor',
						'fontSize',
						'bold',
						'italic',
						'link',
						'bulletedList',
						'numberedList',
						'horizontalLine',
						'|',
						'indent',
						'outdent',
						'|',
						'imageUpload',
						'blockQuote',
						'insertTable',
						'undo',
						'redo',
						'|',
						'CKFinder'
					]
				},
				language: 'es',
				image: {
					toolbar: [
						'imageTextAlternative',
						'imageStyle:full',
						'imageStyle:side'
					]
				},
				table: {
					contentToolbar: [
						'tableColumn',
						'tableRow',
						'mergeTableCells',
						'tableCellProperties',
						'tableProperties'
					]
				},
				
				ckfinder: {
					 options: {
						resourceType: 'Images'
					},
				// Upload the images to the server using the CKFinder QuickUpload command.
				uploadUrl: '<?php echo SITE.'admin/js/ckfinder/core/connector/php/connector.php'?>?command=QuickUpload&type=Images&responseType=json'
			}
				
			} )
			.then( editor => {
				window.editor = editor;
			} )
			.catch( error => {
				console.error( '¡Huy! Algo salió mal!' );
				console.error( 'Por favor, informe el siguiente error en https://github.com/ckeditor/ckeditor5/issues con el ID de compilación y el seguimiento de la pila de errores:' );
				console.warn( 'Id de compilación: i1nydytwypdf-kp9cd8f5tiyd' );
				console.error( error );
			} );
	</script>
</body>
</html>