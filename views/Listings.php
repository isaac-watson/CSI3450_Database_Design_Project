<!DOCTYPE html>
<html class="no-js" lang="en">
    <head>
        <title>CSI3450 Website</title>
        <meta http-equiv="x-ua-compatible" content="ie=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />

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
    ?>
       

<table class="table table-bordered table-hover">
  <thead class="table-primary">
    <tr>
      <th scope="col">Street</th>
      <th scope="col">St. Name</th>
      <th scope="col">City</th>
      <th scope="col">Zip</th>
      <th scope="col">Bathroom</th>
      <th scope="col">Beds</th>
      <th scope="col">Basement</th>
      <th scope="col">Size</th>
      <th scope="col">Type</th>
      <th scope="col">Price</th>

    </tr>
  </thead>
  <tbody>

      <?php

      $sql="select a.street_num, a.street_name, c.city_name, a.zip, d.bed_num, d.bath_num,d.basement, d.dwell_size, lis.stype_id, lis.price
      FROM listing as lis
      INNER JOIN (select * 
      from dwelling 
      where (bath_num >= @bath_num) 
          & (bed_num >= @bed_num)
          & (floor_num = @floor_num)
          & (dwell_size >= @dwell_size)
          & (year_built <= @year_built)
          & (if(@htype_name = 'Any', 1 , htype_id = (select htype_id from home_type where htype_name = @htype_name)))
          & (if(@hstyle_name = 'Any', 1 , hstyle_id = (select hstyle_id from home_style where hstyle_name = @hstyle_name)))
            )as d
          on lis.dwell_id = d.dwell_id
      INNER JOIN (select * 
      from lot 
      where (lot_size >= @lot_size)
      ) as l
          on d.lot_id = l.lot_id
      INNER JOIN (select * 
      from address
      where (street_name like concat('%', @street_name, '%'))
          & if(@street_num = '' or @street_num is null, 1, @street_num = street_num)
      ) as a
          on l.address_id = a.address_id
      INNER JOIN (select * 
      from city
      where (city_name like concat('%', @city_name, '%'))
           & if(city_population = -1, 1, @city_population <= city_population)
           & if(city_crime_violent = -1, 1, @city_crime_violent <= city_crime_violent)
           & if(city_crime_property = -1, 1, @city_crime_property <= @city_crime_property)
      ) as c
      on a.city_id = c.city_id
      where price <= @price limit 20";

    

    if(isset($_GET['apply_filter_button'])) {
        $htype_name = $_GET["htype_name"];
        $hstyle_name = $_GET["hstyle_name"];
        $street_num = $_GET["street_num"];
        $street_name = $_GET["street_name"];
        $city_name = $_GET["city_name"];
        $zip = $_GET["zip"];
        $lot_size = $_GET["lot_size"];
       // $basement = $_GET["basement"];
        $bed_num = $_GET["bed_num"];
        $bath_num = $_GET["bath_num"];
        $floor_num = $_GET["floor_num"];
        $dwell_size = $_GET["dwell_size"];
        $unit = $_GET["unit"];
        $year_built = $_GET["year_built"];
        $stype_name = $_GET["stype_name"];
        
        $result = $conn->query($sql);

    }
    while($row = $result->fetch_assoc()) 
    {
        echo "<tr>";
        echo "<td>" . $row['street_num'] . "</td>";
        echo "<td>" . $row['street_name'] . "</td>";
        echo "<td>" . $row['city_name'] . "</td>";
        echo "<td>" . $row['zip'] . "</td>";
        echo "<td>" . $row['bath_num'] . "</td>";
        echo "<td>" . $row['bed_num'] . "</td>";
        echo "<td>" . $row['basement'] . "</td>";
        echo "<td>" . $row['dwell_size'] . "</td>";
        echo "<td>" . $row['htype_name'] . "</td>";
        echo "<td>" . $row['price'] . "</td>"; 
        echo "</tr>";
    }
    ?>


  </tbody>
</table>

<?php
    $conn->close();
?>
        </div>
            <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
            <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
            <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
    </body>
</html>