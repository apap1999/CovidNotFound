<?php include_once 'user_header.php' ?>

            <main class="col-md-9 ml-sm-auto col-lg-10 px-md-4 py-4">
                <h1 class="h2">Possible Contact</h1>
                
                <div class="col-12 my-3">
                  <div class="card">
                    <h5 class="card-header text-center text-lg-left">Are you considered a possible contact of a positive Covid Case?</h5>
                    <div class="card-body" id="possible_contact">                        
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
			    $('#contact').addClass("active");
		  })
	</script>

  <script src="../static_javascript/user_functions.js"></script>

</body>
</html>