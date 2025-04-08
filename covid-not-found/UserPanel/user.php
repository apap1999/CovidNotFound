<?php include_once 'user_header.php' ?>

            <main class="col-md-9 ml-sm-auto col-lg-10 px-md-4 py-4">
                <h1 class="h2">My View</h1>
                <p>Please Search by Name or Type the Point that you are intrestied in:</p>
                
                <div class="row">
                    <div class="col-12 col-md-6 col-lg-4">
                        <input class="form-control form-control-dark" type="text" placeholder="Search by Name" id="searchbyname">
                    </div>
                    <div class="col-12 col-md-6 col-lg-4 d-flex align-items-end justify-content-end">
                        <input class="form-control form-control-dark" type="text" placeholder="Search by Type" id="searchbytype">
                    </div>
                </div>

                <div class="col-12 col-md-12 col-lg-12 my-3">
                  <div class="card">
                    <h5 class="card-header">Points of Interest:</h5>
                    <div class="card-body">
                      <div class="chartCard">
                        <div id="map"></div>								
                      </div>
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
			    $('#dashboard').addClass("active");
		  })
	</script>

  <script src="../static_javascript/map_functions.js"></script>
  <script src="../static_javascript/user_functions.js"></script>

</body>
</html>