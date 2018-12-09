<!DOCTYPE html>
<!--
    sell.php
        The form for realtors to input a new listing into the database.
-->
<html class="no-js" lang="en">
    <head>
        <title>CSI3450 Website</title>
        <meta http-equiv="x-ua-compatible" content="ie=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
<!--Gets css stylesheets from cdn-->
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
        <link rel="stylesheet" href="css/styles.css">
        <script src="js/bootstrap-slider.js"></script>
        
    </head>

    
    <body>

        <div class="container">
            <nav class="navbar navbar-expand-lg navbar-dark bg-primary">
                <a class="navbar-brand" href="index.html">CSI3450 Project Site</a>
            
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav ml-auto">
                        <li class="nav-item">
                            <a class="nav-link" href="index.html">Home</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="about.html">About</a>
                        </li>
                        <li class="nav-item active">
                            <a class="nav-link" href="sell.php">Add a listing</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="browse.php">Browse listings</a>
                        </li>
                    </ul>
                </div>
            </nav>
        <br>

       
<?php
 $servername = "localhost";
 $username = "root";
 $password = "root";
 $dbname = "finaldb";   
 
 $conn = new mysqli($servername, $username, $password, $dbname);

 if ($conn->connect_error) {
     die("Connection failed: " . $conn->connect_error);
 }

$conn->close();
?>
            <div class="row">
                <div class="col">
                    <h3>Form to add a listing</h3> <br>
                </div>
            </div>
            <div class="row">
                    
                    <h4>Home Info</h4>
                </div>    
                
                <div class="col">
                    
                    <form action="submit.php" method='get' id="myForm">
                  
 
                        <div class="form-group">
                            <label for="htype_name">Home Type:</label>
                        <!-- Populating drop down with home type possibilities from database -->
                            <?php   
                                $servername = "localhost";
                                $username = "root";
                                $password = "root";
                                $dbname = "finaldb";   
                                
                                $conn = new mysqli($servername, $username, $password, $dbname);

                                if ($conn->connect_error) {
                                    die("Connection failed: " . $conn->connect_error);
                                }

                                $sql = "SELECT htype_name FROM home_type";
                                $result = $conn->query($sql);
                                echo "<select class='form-control' id='htype_name' name='htype_name'>";
                                while ($row = $result->fetch_assoc()) {
                                
                                        if($row['htype_name'] != "Any"){
                                            echo "<option value='".$row['htype_name']."'>".$row['htype_name']."</option>";
                                        }
                                    
                                }
                                echo "</select>";
                                $conn->close();
                            ?>

                        </div>
                    

                </div>
                
                <div class="col">
                    
                        <div class="form-group">
                            <label for="hstyle_name">Home Style:</label>
                            <!-- Populating drop down with home style possibilities from database -->
                            <?php   
                                $servername = "localhost";
                                $username = "root";
                                $password = "root";
                                $dbname = "finaldb";   
                                
                                $conn = new mysqli($servername, $username, $password, $dbname);

                                if ($conn->connect_error) {
                                    die("Connection failed: " . $conn->connect_error);
                                }

                                $sql = "SELECT hstyle_name FROM home_style";
                                $result = $conn->query($sql);
                                echo "<select class='form-control' id='hstyle_name' name='hstyle_name'>";
                                while ($row = $result->fetch_assoc()) {
                                    if($row['hstyle_name'] != "Any"){
                                        echo "<option value='".$row['hstyle_name']."'>".$row['hstyle_name']."</option>";
                                    }
                                    
                                }
                                echo "</select>";
                                $conn->close();
                            ?>

                        </div>
                    
                    
                </div>
                <!-- Test code for populating drop down with loop -->
               <!--   var select = document.getElementById("hstyle_name");
                                    var array = ["html","css"];
                                    for(var i = 0; i < array.length; i++) {
                                        var opt = array[i];
                                        var el = document.createElement("OPTION")
                                        el.appendChild(document.createTextNode(opt));
                                        el.text = opt;
                                        el.value = opt;
                                        select.appendChild(el);

                                    } -->
            <br>
            <div class="row">
                
                    <h4>Lot Info</h4>
                </div>
                <div class="col">
                        
                            <div class="form-group">
                                <label for="street_num">Street Number</label>
                                <input type="text" class="form-control" id="street_num" name="street_num" placeholder="12345">
                            </div>
                            <div class="form-group">
                                    <label for="street_name">Street Name</label>
                                    <input type="text" class="form-control" id="street_name" name="street_name" placeholder="Main St">
                            </div>
                            <div class="form-group">
                                <!-- Populating drop down with city name possibilities from database -->
                                <?php   
                                    $servername = "localhost";
                                    $username = "root";
                                    $password = "root";
                                    $dbname = "finaldb";   
                                    
                                    $conn = new mysqli($servername, $username, $password, $dbname);

                                    if ($conn->connect_error) {
                                        die("Connection failed: " . $conn->connect_error);
                                    }
                                ?>
                                <div class="bs-docs-example no-code">
                                    <label for="city_name">City Name</label>
                                    
                                        
                                            <select class="form-control" id="city_name" name="city_name" data_live_search="true">
                                                
                                                <?php   
                                                $sql = "SELECT city_name FROM city";
                                                $result = $conn->query($sql);
                                                
                                                while ($row = $result->fetch_assoc()) {
                                                    echo "<option value='".$row['city_name']."'>".$row['city_name']."</option>";
                                                }
                                                    
                                                    $conn->close();
                                                ?>
                                        </select>
                                        
                                            </div>  
                            </div>

                            <div class="form-group">
                                    <label for="zip">Zip Code</label>
                                    <input type="text" class="form-control" id="zip" name="zip" placeholder="48309">
                            </div>
                        

                            <div class="form-group">
                                    <label for="lot_size">Lot Size</label>
                                    <input type="text" class="form-control" id="lot_size" name="lot_size" placeholder="2 (Acres)">
                            </div>
                        
                    </div>
            
            <br>
            <div class="row">
                <h4>Dwelling Info</h4>
            </div>    
                <div class="col">
                    <label>Basement</label>
                        
                            <div class="form-check form-check-inline">
                                <!-- radio buttons and setting default checked option as no -->
                                <input class="form-check-input" type="radio" name="basement" id="dwell_basement_true" value="1">
                                <label class="form-check-label" for="dwell_basement_true">Yes</label>
                            </div>
                                <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="basement" id="dwell_basement_false" value="0" checked>
                                <label class="form-check-label" for="dwell_basement_false">No</label>
                            </div>
                        
                    </div>
                    <br>
                    <div class="col">
            <!--These values are hard coded in because it is unlikely for them to go beyond these values -->               
                                <div class="form-group">
                                    <label for="bed_num">Number of Bedrooms:</label>
                                    <select class="form-control" id="bed_num" name="bed_num">
                                        <option>1</option>
                                        <option>2</option>
                                        <option>3</option>
                                        <option>4</option>
                                        <option>5</option>
                                    </select>
                                </div>
                            
                        </div>
                        <div class="col">
                               <!-- Some bathrooms don't have a shower so it is half  -->
                                    <div class="form-group">
                                        <label for="bath_num">Number of Bathrooms:</label>
                                        <select class="form-control" id="bath_num" name="bath_num">
                                            <option>1</option>
                                            <option>1.5</option>
                                            <option>2</option>
                                            <option>2.5</option>
                                            <option>3</option>
                                            <option>3.5</option>
                                            <option>4</option>
                                        </select>
                                    </div>
                               
                            </div>
                            <div class="col">
                                    
                                        <div class="form-group">
                                            <label for="floor_num">Number of Floors:</label>
                                            <select class="form-control" id="floor_num" name="floor_num">
                                                <option>1</option>
                                                <option>2</option>
                                                <option>3</option>
                                                <option>4</option>
                                            </select>
                                        </div>
                                    
                                </div>
                                <div class="col">
                                        
                                            <div class="form-group">
                                                    <label for="dwell_size">Dwell Size</label>
                                                    <input type="text" class="form-control" id="dwell_size" placeholder="1000 (sqft.)" name="dwell_size">
                                            </div>
                                            <div class="form-group">
                                                    <label for="unit">Unit Number</label>
                                                    <input type="text" class="form-control" id="unit" placeholder="Apartment 10" name="unit">
                                            </div>
                                            <div class="form-group">
                                                    
                                                    <div class="form-group">
                                                    <label for="year_built">Year Built: <span id="demo"></span></label>
                                                        <input type="range" class="form-control-range" id="year_built" name="year_built" min="1776" value="1776" max="2018">
                                                    </div>
                                                    <!-- Javascript code to set and view the value of the year built slider -->
                                                    <script>
                                                        var slider = document.getElementById("year_built");
                                                        var output = document.getElementById("demo");
                                                        output.innerHTML = slider.value;

                                                        slider.oninput = function() {
                                                        output.innerHTML = this.value;
                                                        }
                                                        </script>
                                            </div>
                                         
    
                                        
                                    </div>
                                    
            <br>
            <div class="row">
                
                    <h4>Sale Type</h4>
                
                <div class="col">
                        <!-- Populating drop down with sale type possibilities from database -->
                            <div class="form-group">
                            <?php   
                                $servername = "localhost";
                                $username = "root";
                                $password = "root";
                                $dbname = "finaldb";   
                                
                                $conn = new mysqli($servername, $username, $password, $dbname);

                                if ($conn->connect_error) {
                                    die("Connection failed: " . $conn->connect_error);
                                }
                                ?>
                                <select class="form-control" id="stype_name" name="stype_name">
                                    
                                <?php   
                                    $sql = "SELECT stype_name FROM sale_type";
                                    $result = $conn->query($sql);
                                    
                                    while ($row = $result->fetch_assoc()) {
                                        echo "<option value='".$row['stype_name']."'>".$row['stype_name']."</option>";
                                    }
                                        
                                        $conn->close();
                                    ?>
                                </select>
                            </div>
                        
                    </div>
                
            </div>
            <br>
            <div class="row">
                
                    <h4>Price</h4>
                
                <div class="col">
                        
                            <div class="form-group">
                                    
                                    <input type="text" class="form-control" id="price" name="price" placeholder="$1,000,000">
                            </div>
                        
                    </div>
            </div>
            <br>
            <div class="row">
                
                    <h4>Realtor Information</h4>
                </div>
                <div class="col">
                        
                            <div class="form-group">
                                    <label for="real_fname">First Name:</label>
                                    <input type="text" class="form-control" id="realtor_fname" name="realtor_fname" placeholder="John">
                            </div><div class="form-group">
                                    <label for="real_lname">Last Name:</label>
                                    <input type="text" class="form-control" id="realtor_lname" name="realtor_lname" placeholder="Doe">
                            </div><div class="form-group">
                                    <label for="real_init">Middle Initial (if applicable):</label>
                                    <input type="text" class="form-control" id="realtor_init" name="realtor_init" placeholder="B.">
                            </div><div class="form-group">
                                    <label for="real_email">Email:</label>
                                    <input type="email" class="form-control" id="realtor_email" name="realtor_email" placeholder="name@example.com">
                            </div><div class="form-group">
                                    <label for="real_phone">Phone Number:</label>
                                    <input type="tel" class="form-control" id="realtor_phone" name="realtor_phone" placeholder="(555)-123-4567">
                         <!--   </div><div class="form-group">
                                    <label for="real_area">Area: </label>
                                    <input type="text" class="form-control" id="real_area" placeholder="12345">
                            </div> -->
                       
                    </div>
                   
                                        
            
            <br>
            <div class="text-center">
                    <input type="submit" class="btn btn-primary" name="button_add_listing" value="Submit" id="sub">
            </div>
                                </form>
            <br>
<!--End of container-->
        </div> 
       <!--Gets bootstrap javascript resources from CDN-->
        <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
        <script src="/src/js/db_connection.js"></script>
    </body>
    
</html>