<?php
    session_start();
    if (!empty($_SERVER['HTTPS']) && ('on' == $_SERVER['HTTPS'])) {
        $uri = 'https://';
    } else {
        $uri = 'http://';
    }
    $uri .= $_SERVER['HTTP_HOST'];
    if(!isset($_SESSION['user_id'])) {
        header('Location: '.$uri.'/covid-not-found/login/login.php');
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Panel</title>

    <link rel="shortcut icon" href="#">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/5.0.0-alpha1/css/bootstrap.min.css" integrity="sha384-r4NyP46KrjDleawBgD5tp8Y7UzmLA05oM1iAEQ17CSuDqnUK2+k9luXQOfXJCJ4I" crossorigin="anonymous">
    <link rel="stylesheet" href="../static_css/style-sidebar.css">

	  <!-- leaflet css  -->
	  <link rel="stylesheet" href="https://unpkg.com/leaflet@1.8.0/dist/leaflet.css"
   		integrity="sha512-hoalWLoI8r4UszCkZ5kL8vayOGVae1oxXe/2A4AO6J9+580uKHDO3JdHb7NzwwzK5xr/Fs0W40kiNHxM9vyTtQ=="
   		crossorigin=""/>
    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/1.5.2/css/ionicons.min.css">
    <link rel="stylesheet" href="../static_css/leaflet.awesome-markers.css">

    <!-- Configure Map Height -->
    <style>
      #map { height: 80vh; }
    </style>

</head>
<body>
    <nav class="navbar navbar-light bg-light p-3">
        <div class="d-flex col-12 col-md-3 col-lg-2 mb-2 mb-lg-0 flex-wrap flex-md-nowrap justify-content-between">
            <a class="navbar-brand" href="#">
                Covid Not Found!
            </a>
            <button class="navbar-toggler d-md-none collapsed mb-3" type="button" data-toggle="collapse" data-target="#sidebar" aria-controls="sidebar" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
        </div>
        <div class="col-12 col-md-4 col-lg-4 d-flex align-items-lg-center justify-content-lg-end" id="covid_alert"></div>
        <div class="col-12 col-md-5 col-lg-4 d-flex align-items-center justify-content-md-end mt-3 mt-md-0">
            <div class="dropdown">
                <button class="btn btn-primary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-expanded="false">
                  Hello, <i><?php echo isset($_SESSION["user_name"]) ? $_SESSION["user_name"] : 'Noname'; ?></i>
                </button>
                <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton" id="user_menu">
                  <li id="log_admin"><a class="dropdown-item" href="../AdminPanel/admin.php">Log in as Admin</a></li>
                  <li><a class="dropdown-item" id="logout">Sign out</a></li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container-fluid">
        <div class="row">
            <nav id="sidebar" class="col-md-3 col-lg-2 d-md-block bg-light sidebar collapse">
                <div class="position-sticky pt-md-5">
                    <ul class="nav flex-column">                        
                        <li class="nav-item m-3">
                          <button class="btn-danger p-2 rounded" type="button" onclick=" document.location = 'covid_case.php'">
                              <svg xmlns="http://www.w3.org/2000/svg" width="24px" height="24px" viewBox="0 0 24 24" fill="none"><path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 12a7 7 0 0 1 7-7m-7 7H2m3 0c0 1.933.784 3.683 2.05 4.95L4.5 19.5M12 5V2m0 3c1.933 0 3.683.784 4.95 2.05L19.5 4.5M12 2h2m-2 0h-2M2 12v-2m0 2v2m17.5-9.5L18 3m1.5 1.5L21 6M4.5 4.5 6 3M4.5 4.5 3 6m1.5-1.5L7 7M4.5 19.5 6 21m-1.5-1.5L3 18m13 1h.001M9 10.5A1.5 1.5 0 0 1 10.5 9m5.501 7L16 13m6 3a6 6 0 1 1-12 0 6 6 0 0 1 12 0z"/></svg>
                              <span class="ml-2">Covid Case</span>
                          </button>
                        </li>
                        <li class="nav-item">
                          <a class="nav-link" id="dashboard" aria-current="page" href="user.php">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-home">
                                <path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path>
                                <polyline points="9 22 9 12 15 12 15 22"></polyline>
                            </svg>
                            <span class="ml-2">Dashboard</span>
                          </a>
                        </li>
                        <li class="nav-item">
                          <a class="nav-link" id="contact" href="possible_contact.php">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-users"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path><circle cx="9" cy="7" r="4"></circle><path d="M23 21v-2a4 4 0 0 0-3-3.87"></path><path d="M16 3.13a4 4 0 0 1 0 7.75"></path></svg>
                            <span class="ml-2">Possible Contact</span>
                          </a>
                        </li>
                        <li class="nav-item">
                          <a class="nav-link" id="settings" href="user_settings.php">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-layers"><polygon points="12 2 2 7 12 12 22 7 12 2"></polygon><polyline points="2 17 12 22 22 17"></polyline><polyline points="2 12 12 17 22 12"></polyline></svg>
                            <span class="ml-2">Profile Settings</span>
                          </a>
                        </li>
                    </ul>
                </div>
            </nav>