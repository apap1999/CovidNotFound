<?php include_once 'user_header.php' ?>

            <main class="col-md-9 ml-sm-auto col-lg-10 px-md-4 py-4">
                <h1 class="h2">Profile Settings</h1>
                
                <div class="col-12 my-3">
                  <div class="card">
                    <h5 class="card-header text-center text-lg-left">Edit Profile</h5>
                    <div class="card-body">
                      <div class="row">
                        <p class="col-6 col-lg-3 form-text">Change Name: </p>
                        <div class="col-6 col-lg-9 form-text"><input type="text" id="change-name" placeholder="Name..."></div>
                      </div>
                      <div class="row">
                        <p class="col-6 col-lg-3 form-text">Change Surname: </p>
                        <div class="col-6 col-lg-9 form-text"><input type="text" id="change-surname" placeholder="Surname..."></div>
                      </div>
                      <div class="row">
                        <p class="col-6 col-lg-3 form-text">Change Email: </p>
                        <div class="col-6 col-lg-9 form-text"><input type="text" id="change-email" placeholder="Email..."></div>
                      </div>
                      <div class="row">
                        <p class="col-6 col-lg-3 form-text">Change Password: </p>
                        <div class="col-6 col-lg-9 form-text"><input type="password" id="change-password" placeholder="Password..."></div>
                      </div>
                      <div class="row">
                        <p class="col-6 col-lg-3 form-text"></p>
                        <div class="col-6 col-lg-9 form-text"><input type="password" id="change-password-conf" placeholder="Password Confirmation..."></div>
                      </div>
                      <div class="m-2 d-flex align-items-center justify-content-center align-items-lg-start justify-content-lg-start mt-4"><button class="btn-primary rounded border-primary" id="submit-changes">Save</button></div>  
                    </div>
                  </div>
                </div>

                <div class="col-12 my-3">
                  <div class="card">
                    <h5 class="card-header text-center text-lg-left">My Visits</h5>
                    <div class="card-body" id="my_visits">                                             
                    </div>
                  </div>
                </div>

                <div class="col-12 my-3">
                  <div class="card">
                    <h5 class="card-header text-center text-lg-left">My Covid Cases</h5>
                    <div class="card-body" id="my_cases">                   
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
			    $('#settings').addClass("active");
		  })
	</script>

  <script src="../static_javascript/user_functions.js"></script>
  <script src="../static_javascript/my_profile_functions.js"></script>

</body>
</html>