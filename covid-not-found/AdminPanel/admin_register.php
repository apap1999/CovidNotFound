<?php include_once 'admin_header.php' ?>

	<main class="col-md-9 ml-sm-auto col-lg-10 px-md-4 py-4" id="main_content">
				
				<h1 class="h2">Create a new Admin User</h1>

				<div class="col-12 col-md-6 col-lg-6 mb-4 mb-lg-0 my-2">
					<div class="card">
						<h5 class="card-header">Fill Admin credentials</h5>
						<div class="card-body">
							<div class="form-outline mb-4" id="register_alert"></div>
							
								<h2>Register</h2>
								<div class="row">
									<div class="col-12 col-md-6 col-lg-6 form-text"><input class="register" type="text" id="register-name" placeholder="Name..."></div>
									<div class="col-12 col-md-6 col-lg-6 form-text d-flex align-items-center justify-content-md-end"><input class="register" type="text" id="register-surname" placeholder="Surname..."></div>
								</div>
								<div class="form-text"><input class="register" type="text" id="register-email" placeholder="Email..."></div>
								<div class="row">
									<div class="col-12 col-md-6 col-lg-6 form-text"><input class="register" type="password" id="register-password" placeholder="Password..."></div>
									<div class="col-12 col-md-6 col-lg-6 form-text d-flex align-items-center justify-content-md-end"><input class="register" type="password" id="register-password-conf" placeholder="Password Confirmation..."></div>
								</div>
								<div class="m-2 d-flex align-items-center justify-content-center"><button class="btn-primary rounded border-primary" id="register-admin">Register</button></div>			
						</div>
					</div>
				</div>

				<!-- <div class="col-12 col-md-12 col-lg-12 mb-4 mb-lg-0 my-2">
					<div class="card">
						<h5 class="card-header">System Admins</h5>
						<div class="card-body">						
						</div>
					</div>
				</div> -->
            
				<?php include_once '../footer.php' ?>
			</main>
        </div>
    </div>

	<?php include '../requirements.php'; ?>
	
	<script>
		$(document).ready(function() {
			$('#create_admin').addClass("active");
		})
	</script>

</body>
</html>

