<!DOCTYPE html>
<!--
    browse.php
        Filters page. The user will select from various filters and input values to filter out the listings.
        Once the filters are selected, the Apply Filters button will load Listings.php
-->
<html class="no-js" lang="en">
    <head>
        <title>CSI3450 Website</title>
        <meta http-equiv="x-ua-compatible" content="ie=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
<!--Gets css stylesheets from cdn-->
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
        <link rel="stylesheet" href="css/styles.css">
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
                        <li class="nav-item">
                            <a class="nav-link" href="sell.php">Add a listing</a>
                        </li>
                        <li class="nav-item active">
                            <a class="nav-link" href="browse.php">Browse listings</a>
                        </li>
                    </ul>
                </div>
            </nav>
            <!--Extend dropdown menu width-->
            <style>
            .dropdown-menu {
                width: 350px;
            }
            </style>

    
<!--Second navbar for filtering the listings-->
            <nav class="navbar navbar-expand-lg navbar-light bg-light">
                    <span class="navbar-brand">Filters</a>
                    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                      <span class="navbar-toggler-icon"></span>
                    </button>
                  
                    <div class="collapse navbar-collapse" id="navbarSupportedContent">
                      <ul class="navbar-nav mr-auto">
                        <!--Dropdown for Lot Information-->
                        <li class="nav-item dropdown">
                          <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            Lot Information
                          </a>
                          <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                              <!--form tag with method GET allows to pass the values through the URL with the value
                                    from the 'name' tag, then loads the Listings.php file-->
                            <form method="GET" action="Listings.php">
                                    <div class="form-group">
                                            <label for="lot_street_number">Street Number</label>
                                            <input type="text" class="form-control" id="street_num" name="street_num" placeholder="12345">
                                        </div>
                                        <div class="dropdown-divider"></div>
                                        <div class="form-group">
                                                <label for="lot_street_name">Street Name</label>
                                                <input type="text" class="form-control" id="street_name" name="street_name" placeholder="Main St">
                                        </div>
                                        <div class="dropdown-divider"></div>



                                    <div class="form-group">
                                        <!--php code to establish a connection to the MySQL database-->
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
                                
                                        <label for="city_name">City Name</label>
                                    
                                        <!--select tag with a class of form control is a drop down style from bootstrap
                                            The php code queries the database and populates the dropdown option with all
                                            the possible options in the database for this specified field. -->
                                            <select class="form-control" id="city_name" name="city_name" >
                                                <option value="">Any City</option>
                                                <?php   
                                                $sql = "SELECT city_name FROM city";
                                                $result = $conn->query($sql);
                                                
                                                while ($row = $result->fetch_assoc()) {
                                                    echo "<option value='".$row['city_name']."'>".$row['city_name']."</option>";
                                                }
                                                    //Close the SQL connection when we don't need it anymore
                                                    $conn->close();
                                                ?>
                                        </select>
                                        </div>

                                        <div class="dropdown-divider"></div>
                                        <div class="form-group">
                                                <label for="lot_zip_code">Zip Code</label>
                                                <input type="text" class="form-control" id="zip" name="zip" placeholder="48309">
                                        </div>
                                        <div class="dropdown-divider"></div>
                                        <div class="form-group">
                                                <label for="lot_size">Lot Size</label>
                                                <input type="text" class="form-control" id="lot_size" name="lot_size" placeholder="3 Acres">
                                        </div>
                          </div>


                        </li>

                        <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                  School Information
                                </a>
                                <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                                    
                                    <div class="form-group">
                                        <label for="school_rank">School Rank:</label>
                                        <input type="text" class="form-control" id="school_rank" name="school_rank" placeholder="1">
                                    </div>
                                  <div class="dropdown-divider"></div>
                                  <div class="form-group">
                                        <label for="school_read">School SAT Reading Score:</label>
                                        <input type="text" class="form-control" id="school_read" name="school_sat_read" placeholder="603">
                                    </div>
                                    <div class="dropdown-divider"></div>
                                    <div class="form-group">
                                            <label for="school_math">School SAT Math Score:</label>
                                            <input type="text" class="form-control" id="school_math" name="school_sat_math" placeholder="755">
                                        </div>
                                        <div class="dropdown-divider"></div>
                                    <div class="form-group">
                                        <label for="school_name">School Name:</label>
                                        <input type="text" class="form-control" id="school_name" name="school_name" placeholder="Roseville High School">
                                    </div>
                                  
                                </div>
                              </li>

                              <li class="nav-item dropdown">
                                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                      City Information
                                    </a>
                                    <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                                          
                                        
                                                <div class="dropdown-divider"></div>
                                                <div class="form-group">
                                                        <label for="city_population">City Population:</label>
                                                        <input type="text" class="form-control" id="city_population" name="city_population" placeholder="500,000">
                                                </div>
                                        <div class="dropdown-divider"></div>
                                                <div class="form-group">
                                                        <label for="city_crime_v">City Crime Violent Rate:</label>
                                                        <input type="text" class="form-control" id="city_crime_v" name="city_crime_violent" placeholder="0.1%">
                                                </div>
                                            <div class="dropdown-divider"></div>
                                                <div class="form-group">
                                                        <label for="city_crime_p">City Crime Property Rate:</label>
                                                        <input type="text" class="form-control" id="city_crime_p" name="city_crime_property" placeholder="0.01%">
                                                </div>
                                        
                                    </div>
                                  </li>

                                  <li class="nav-item dropdown">
                                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                          House Type
                                        </a>
                                        <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                                          
                                        <div class="form-group">
                                                        <label for="price">Price:</label>
                                                        <input type="text" class="form-control" id="price" name="price" placeholder="$1,000,000.00">
                                                </div>
                                                <div class="dropdown-divider"></div>
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
                                                        <div class="bs-docs-example no-code">
                                                        <label for="htype_name">Home Type:</label>
                                                        
                                                        <select class="form-control" id="htype_name" name="htype_name">
                                                        <?php
                                                        $sql = "SELECT htype_name FROM home_type";
                                                        $result = $conn->query($sql);
                                                        while ($row = $result->fetch_assoc()) {
                                                            $sel = "";
                                                            if($row['htype_name'] == "Any"){
                                                                $sel = "selected";
                                                            }

                                                            echo "<option value='".$row['htype_name']."' ".$sel.">".$row['htype_name']."</option>";
                                                        }
                                                        $conn->close();
                                                        ?>
                                                        </select>
                                                        
                                                    
                                                    </div>
                                                    <div class="dropdown-divider"></div>
                                                    <div class="form-group">
                                                    <label for="hstyle_name">Home Style:</label>
                            
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
                                                            echo "<option value='".$row['hstyle_name']."'>".$row['hstyle_name']."</option>";
                                                        }
                                                        echo "</select>";
                                                        $conn->close();
                                                    ?>
                                                        </div>
                                                        <div class="dropdown-divider"></div>
                                                        <div class="form-group">
                                                            <label for="stype_name">Sale Type:</label>
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
                                      </li>


                                      <li class="nav-item dropdown">
                                            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                              Dwelling Specifications
                                            </a>
                                            <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                                                <div class="container container-sm">
                                              
                                                <div class="form-group">
                                                        <label for="dwell_bed_num">Number of Beds:</label>
                                                        <select class="form-control" id="dwell_bed_num" name="bed_num">
                                                            <option>1</option>
                                                            <option>2</option>
                                                            <option>3</option>
                                                            <option>4</option>
                                                            <option>5</option>
                                                        </select>
                                                    </div>
                                                
                                                
                                                    <div class="form-group">
                                                            <label for="dwell_bath_num">Number of Bathrooms:</label>
                                                            <select class="form-control" id="dwell_bath_num" name="bath_num">
                                                            <option>1</option>
                                                            <option>1.5</option>
                                                            <option>2</option>
                                                            <option>2.5</option>
                                                            <option>3</option>
                                                            <option>3.5</option>
                                                            <option>4</option>
                                                            </select>
                                                        </div>
                                                        
                                                        <div class="form-group">
                                                                <label for="dwell_floor_num">Number of Floors:</label>
                                                                <select class="form-control" id="dwell_floor_num" name="floor_num">
                                                                    <option>1</option>
                                                                    <option>2</option>
                                                                    <option>3</option>
                                                                    <option>4</option>
                                                                </select>
                                                            </div>
                                                            <div class="dropdown-divider"></div>
                                                            <h6>Basement: </h6>
                                                        <div class="form-check form-check-inline">
                                                            
                                                                <input class="form-check-input" type="radio" name="basement" id="dwell_basement" value="1">
                                                                <label class="form-check-label" for="dwell_basement_true">Yes</label>
                                                        </div>
                                                        <div class="form-check form-check-inline">
                                                                <input class="form-check-input" type="radio" name="basement" id="dwell_basement" value="0">
                                                                <label class="form-check-label" for="dwell_basement_false">No</label>
                                                        </div>
                                                        <div class="form-check form-check-inline">
                                                                <input class="form-check-input" type="radio" name="basement" id="dwell_basement" value="2" checked>
                                                                <label class="form-check-label" for="dwell_basement_false">Either</label>
                                                        </div>
                                                        <div class="dropdown-divider"></div>
                                                        <div class="form-group">
                                                                <label for="dwell_size">Dwell Size</label>
                                                                <input type="text" class="form-control" id="dwell_size" name="dwell_size" placeholder="1000 Square feet">
                                                        </div>
                                                        <div class="dropdown-divider"></div>
                                                        <div class="form-group">
                                                                <label for="dwell_unit">Unit Number</label>
                                                                <input type="text" class="form-control" id="dwell_unit" name="unit" placeholder="Apt 10">
                                                        </div>
                                                        <div class="dropdown-divider"></div>
                                                        <div class="form-group">
                                                                <label for="dwell_year">Year Built</label>
                                                                <input type="text" class="form-control" id="dwell_year" name="year_built" placeholder="2015">
                                                        </div>
                                                      
                                                        </div>
                                              
                                            </div>
                                            
                                          </li>
                                          <!--the input here submits the data in the <form> with the options specified in the form tag-->
                                          <input type="submit" class="btn btn-primary" name="apply_filter_button" value="Apply Filters">
                                                                </form>
                                                
                                        
                        
                    </div>
                <!--End of Filter Navbar-->
                </nav>
                                                                </ul>
                                                                <br><br>


            <!--End of container-->
        </div>
<!--Gets bootstrap javascript resources from CDN-->
        <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
    </body>
    
</html>