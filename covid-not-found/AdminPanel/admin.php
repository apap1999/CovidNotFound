<?php include_once 'admin_header.php' ?>

	<main class="col-md-9 ml-sm-auto col-lg-10 px-md-4 py-4" id="main_content">
				<h1 class="h2">Dashboard</h1>
                <p>This is the homepage of a simple admin interface which is part of a tutorial written on Themesberg</p>
                
                <!-- Card Widgets -->
                <div class="row my-4">
                    <div class="col-12 col-md-4 mb-4 mb-lg-0 col-lg-4">
                        <div class="card">
							<h5 class="card-header">Total Visits</h5>
                            <div class="card-body">
                            	<div class="d-flex align-items-center justify-content-center">
                                	<h1 id="chart-1"></h1>                                	
                              	</div>
								<div class = "row">
								<div class = "clot-12 col-md-12 col-lg-8 my-2">	
									<p class ="card-text text">Count of Total Visits.</p>
								</div>
								
								<div class="col-12 col-md-12 col-lg-4 d-flex align-items-center justify-content-center align-items-lg-end justify-content-lg-end">
									<button id="refresh-chart-1">Refresh</button>
								</div>
								</div>							  
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-md-4 mb-4 mb-lg-0 col-lg-4">
                      	<div class="card">
                          	<h5 class="card-header">Confirmed Cases</h5>
						  
                          	<div class="card-body">
							  <div class="d-flex align-items-center justify-content-center">
									<h1 id="chart-2"></h1>
                            	</div>
								<div class="row">
								<div class="col-12 col-md-12 col-lg-8 my-2">
										<p class="card-text text">Count of Confirmed Cases.</p>		
									</div>
									<div class="col-12 col-md-12 col-lg-4 d-flex align-items-center justify-content-center align-items-lg-end justify-content-lg-end">
										<button id="refresh-chart-2">Refresh</button>
									</div>
							  	</div>                            
                          	</div>
                      	</div>
                    </div>
                    <div class="col-12 col-md-4 mb-4 mb-lg-0 col-lg-4">
                        <div class="card">
                            <h5 class="card-header">Total Visits of Confirmed Cases</h5>
                            <div class="card-body">
							<div class="d-flex align-items-center justify-content-center">
                                	<h1 id="chart-3"></h1>
                              	</div>
								<div class="row">
									<div class="col-12 col-md-12 col-lg-8 my-2">
										<p class="card-text text">Count of Covid Visits.</p>		
									</div>
									<div class="col-12 col-md-12 col-lg-4 d-flex align-items-center justify-content-center align-items-lg-end justify-content-lg-end">
										<button id="refresh-chart-3">Refresh</button>
									</div>
							  	</div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row my-4">
                  <div class="col-12 col-md-12 col-lg-6 mb-4 mb-lg-0">
                    <div class="card">
                        <h5 class="card-header">POIs' Categories</h5>
                        <div class="card-body">
                          	<div class="chart-container pie-chart">
                            	<canvas id="chart-4"></canvas>
                          	</div>
							<div class="row">
								<div class="col-8 col-md-8 col-lg-8">
									<p class="card-text text">POIs types from Visits!</p>		
								</div>
								<div class="col-4 col-md-4 col-lg-4 d-flex align-items-end justify-content-end">
									<button id="refresh-chart-4">Refresh</button>
								</div>
							</div>
                        </div>
                    </div>
                  </div>   
                  <div class="col-12 col-md-12 col-lg-6 mb-4 mb-lg-0">
                    <div class="card">
                        <h5 class="card-header">POIs' Categories</h5>
                        <div class="card-body">
                          	<div class="chart-container">
                            	<canvas id="chart-5"></canvas>
                        	</div>
							<div class="row">
								<div class="col-8 col-md-8 col-lg-8">
									<p class="card-text text">POIs types from Covid Visits!</p>		
								</div>
								<div class="col-4 col-md-4 col-lg-4 d-flex align-items-end justify-content-end">
									<button id="refresh-chart-5">Refresh</button>
								</div>
							</div>
                        </div>
                    </div>
                  </div>
                </div>
                
				<div class="row">
					<div class="col-12 col-md-12 col-lg-6 mb-4 mb-lg-0">
						<div class="card">
							<h5 class="card-header">Daily Diagram</h5>
							<div class="card-body">
								<div class="row">
									<div class="col-3">
										<input type="checkbox" id="chart-6-visits" name="chart-6-visits" checked>
										<label for="chart-6-visits">Visits</label>
									</div>
									<div class="col-6">
										<input type="checkbox" id="chart-6-confcases" name="chart-6-confcases">
										<label for="chart-6-confcases">Confirmed Cases</label>
									</div>
								</div>
								<div class="chartCard">
									<div class="chartBox">
										<canvas id="chart-6"></canvas>
									</div>
									<div>
										Start: <input id="chart6-minDate" type="date" min="2022-01-01" max="2022-12-31"> 
										End: <input id="chart6-maxDate" type="date" min="2022-01-01" max="2022-12-31">
										<button id="filter-chart-6">Filter</button><br>
									</div>
								</div>
								<div class="row">
									<div class="col-8 col-md-8 col-lg-8">
										<p class="card-text text">Visitors or Confirmed Cases per day.</p>		
									</div>
								</div>
							</div>
						</div>
					</div>
                
					<div class="col-12 col-md-12 col-lg-6 mb-4 mb-lg-0">
						<div class="card">
						<h5 class="card-header">Hourly Diagram</h5>
						<div class="card-body">
							<div class="row">
								<div class="col-3">
									<input type="checkbox" id="chart-7-visits" name="chart-7-visits" checked>
									<label for="chart-7-visits">Visits</label>
								</div>
								<div class="col-6">
									<input type="checkbox" id="chart-7-confcases" name="chart-7-confcases">
									<label for="chart-7-confcases">Confirmed Cases</label>
								</div>
							</div>
							<div class="chartCard">
								<div class="chartBox">
									<canvas id="chart-7"></canvas>
								</div>
								<div>
									Choose a date: <input id="chart7-myDate" type="date" min="2022-01-01" max="2022-12-31"> 
									<button id="filter-chart-7">Filter</button><br>
								</div>
							
							</div>
								<div class="row">
									<div class="col-8 col-md-8 col-lg-8">
										<p class="card-text text">Visitors or Confirmed Cases per hour.</p>		
									</div>
								</div>
								
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
			$('#statistics').addClass("active");
		})
	</script>

	<script src="../static_javascript/statistics.js"></script>

</body>
</html>