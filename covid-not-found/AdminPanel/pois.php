<?php include_once 'admin_header.php' ?>

	<main class="col-md-9 ml-sm-auto col-lg-10 px-md-4 py-4" id="main_content">
				
				<h1 class="h2">POI Manipulation</h1>

				<div class="col-12 col-md-12 mb-4 mb-lg-0 col-lg-12 my-2">
					<div class="card">
						<h5 class="card-header">Insert POIs</h5>
						<div class="card-body">
						
							Upload a JSON file with POI info: 
							<input type="file" id="jsonfileinput" name="jsonfileinput" />
							<button id="save">Save</button>
						
						</div>
					</div>
				</div>

				<div class="col-12 col-md-12 mb-4 mb-lg-0 col-lg-12 my-2">
					<div class="card">
						<h5 class="card-header">DELETE ALL DATA</h5>
						<div class="card-body">
						
						<button id="delete">Delete ALL DATA</button>
						
						</div>
					</div>
				</div>
            
				<?php include_once '../footer.php' ?>
			</main>
        </div>
    </div>

	<?php include '../requirements.php'; ?>
	
	<script>
		$(document).ready(function() {
			$('#pois').addClass("active");
		})
	</script>

	<script src="../static_javascript/poi_functions.js"></script>

</body>
</html>