<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <link rel="shortcut icon" href="homeicon.ico" >
        <title><?php echo $title; ?></title>
        <link rel="stylesheet" type="text/css" href="Styles/StyleSheet.css" />
    </head>
    <body>
        <div id="wrapper">
            <div id="banner">             
            </div>
            
            <nav id="navigation">
                <ul id="nav">
                    <li><a href="Home.php">Home</a></li>
                    <li><a href="LightControl.php">Lighting</a></li>
                    <li><a href="HvacControl.php">Heating & Ventilation</a></li>
                    <li><a href="Security.php">Security</a></li>
                    <li><a href="AddDevice.php">Add</a></li>
                    <li data-role="dropdown" ><a href="#">Manage</a>
                    	<ul class="dropdown">
                    		<li><a href="OverView.php">Devices</a></li>
                    		<li><a href="CameraImages.php">Camera Images</a></li>
                    	</ul>
                    </li>
                    <li><a href="index.php">Logout</a></li>
                </ul>
            </nav>
            
            <div id="content_area">
                <?php echo $content; ?>
            </div>
            
            <div id="sidebar">
                
            </div>
            
            <footer>
                <p>All rights reserved</p>
            </footer>
        </div>
    </body>
</html>