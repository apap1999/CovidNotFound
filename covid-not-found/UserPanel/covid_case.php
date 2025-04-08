<?php include_once 'user_header.php' ?>

            <main class="col-md-9 ml-sm-auto col-lg-10 px-md-4 py-4">
                <h1 class="h2">Covid Case</h1>
                <p class="col-12 col-md-6 bg-warning text-white text-center rounded p-2">Please fill the details bellow ONLY ONCE you have a positive Rapid Antigen test!</p>
                
                <div class="col-12 col-md-6 col-lg-6 my-3">
                  <div class="card">
                    <h5 class="card-header text-center text-lg-left">Confirm Covid Case</h5>
                    <div class="card-body">
                        <div class="d-flex align-items-center justify-content-center align-items-lg-start justify-content-lg-start" id="recent_case"></div>
                        <div class="row">
                            <div class="col-12 col-lg-6 d-flex align-items-center justify-content-center align-items-lg-start justify-content-lg-start m-2 m-lg-0">
                                <input type="date" id="confcase-date">
                            </div>
                            <div class="col-12 col-lg-6 d-flex align-items-center justify-content-center align-items-lg-end justify-content-lg-end m-2 m-lg-0">
                                <button class="btn-danger rounded" id="confcase-submit">Confirm case</button>
                            </div>
                        </div>
                    </div>
                  </div>
                </div>

                <div class="col-12 col-md-6 my-3">
                  <div class="card">
                    <h5 class="card-header text-center text-lg-left">My Previous Covid Cases</h5>
                    <div class="card-body">
                        <div id="my_cases"></div>
                    </div>
                  </div>
                </div>

                <?php include_once '../footer.php' ?>
            </main>
        </div>
    </div>

	<?php include '../requirements.php'; ?>

  <script src="../static_javascript/user_functions.js"></script>
  <script src="../static_javascript/my_profile_functions.js"></script>

</body>
</html>