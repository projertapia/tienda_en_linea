<section id="boletin">
	<div class="container" id="box-boletin">
		<div class="row h-100">
			<div class="col-md-6 col-sm-12">
				<h4>BOLETÍN INFORMATIVO</h4>
				<p>Lo mejor de <strong>Ecommerce</strong> directo en tu correo.<br>
Puedes darte de baja en cualquier momento,  con sólo avisarnos.</p>
			</div>
			<div class="col-md-6 col-sm-12">
				<form id="boletin-form" accept-charset="UTF-8" method="post">
					<input type="email" name="emailboletin" id="emailboletin" class="form-control shadow-none" placeholder="Tu correo electrónico" required>
					<button type="submit">Suscríbete</button>
				</form>
				<script>
					$( "#boletin-form" ).submit(function( event ) {
						event.preventDefault();
						$("#boletin-form").validate();
						var url ='<?php echo $urlserver."parts/newsletter.php"?>';
						var formData = $('#boletin-form').serializeArray();
						$.ajax({                    
						  url: url,     
						  type: 'post', // performing a POST request
						  data : formData,           
						  success: function(data){
							  alert("Gracias por suscribirte.");
							   document.getElementById("boletin-form").reset(); 
						  },
							error: function(data){
								console.log(data)
							}
						});
					});
				</script>
			</div>
		</div>
	</div>
</section>