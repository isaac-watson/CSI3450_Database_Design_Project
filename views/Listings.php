<!DOCTYPE html>
<html class="no-js" lang="en">
    <!--
        Listings.php
            After the Apply filters button is pressed in browse.php, this page is loaded and takes the data from the filters
            from the client to process and output the listings in table format with the specified filters
    -->
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
            <br>
<!-- Connect to database through php -->
<?php
    $servername = "localhost";
    $username = "root";
    $password = "root";
    $dbname = "finaldb";   
    
    
    
    $conn = new mysqli($servername, $username, $password, $dbname);
    //Ensure the connection is valid otherwise don't load anything else
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
?>
       
<!-- Create a table with bootstrap HTML/CSS -->
<table class="table table-bordered table-hover">
  <thead class="table-primary">
    <tr>
      <th scope="col">Street</th>
      <th scope="col">St. Name</th>
      <th scope="col">City</th>
      <th scope="col">Zip</th>
      <th scope="col">Bathrooms</th>
      <th scope="col">Beds</th>
      <th scope="col">Basement</th>
      <th scope="col">Size</th>
      <th scope="col">Type</th>
      <th scope="col">Price</th>

    </tr>
  </thead>
  <tbody>

    <?php

    if(isset($_GET['apply_filter_button'])) {
        $htype_name = $_GET["htype_name"];
        $hstyle_name = $_GET["hstyle_name"];
        $street_num = $_GET["street_num"];
        $street_name = $_GET["street_name"];
        $city_name = $_GET["city_name"];
        $zip = $_GET["zip"];
        $lot_size = $_GET["lot_size"];
        $basement = $_GET["basement"];
        $bed_num = $_GET["bed_num"];
        $bath_num = $_GET["bath_num"];
        $floor_num = $_GET["floor_num"];
        $dwell_size = $_GET["dwell_size"];
        $unit = $_GET["unit"];
        $year_built = $_GET["year_built"];
        $stype_name = $_GET["stype_name"]; 
        $city_population = $_GET["city_population"];
        $city_crime_property = $_GET["city_crime_property"];
        $city_crime_violent = $_GET["city_crime_violent"];
        $price = $_GET["price"];
        $school_sat_math = $_GET["school_sat_math"];
        $school_sat_read = $_GET["school_sat_read"];
        $school_rank = $_GET["school_rank"];

        $sql="select a.street_num, a.street_name, c.city_name, a.zip, d.bed_num, d.bath_num,d.basement, d.dwell_size, st.stype_name, lis.price
        from listing as lis
        inner join (select * 
        from dwelling 
        where (bath_num >= '$bath_num') 
            & (bed_num >= '$bed_num')
            & (basement = '$basement' or '$basement' = 2)
            & (floor_num >= '$floor_num')
            & (dwell_size >= '$dwell_size')
            & (year_built >= '$year_built')
            & ('$htype_name' = 'Any' or (htype_id = (select htype_id from home_type where htype_name = '$htype_name')))
            & ('$hstyle_name' = 'Any' or (hstyle_id = (select hstyle_id from home_style where hstyle_name = '$hstyle_name')))
              )as d
            on lis.dwell_id = d.dwell_id
        inner join (select * from sale_type)as st on lis.stype_id = st.stype_id
        inner join (select * 
        from lot 
        where (lot_size >= '$lot_size')
        ) as l
            on d.lot_id = l.lot_id
        inner join ((select * 
        from address
        where (concat('%', street_name, '%') like concat('%', '$street_name', '%'))
            & (('$street_num' = '' or '$street_num' is null) or '$street_num' = street_num)) as a
            inner join
            (select * from school where 
                  (school_sat_math >= '$school_sat_math')
                & (school_sat_read >= '$school_sat_read')
                & (school_rank <= '$school_rank' or '$school_rank' = '')
            ) as sc
            on sc.school_id = a.school_id
        )
            on l.address_id = a.address_id
        inner join (select * 
        from city
        where ((city_name like concat('%', '$city_name', '%')) 
            or ('$city_name' is null))
             & (city_population = -1 or '$city_population' >= city_population or '$city_population' = '')
             & (city_crime_violent = -1 or '$city_crime_violent' >= city_crime_violent or '$city_crime_violent' = '')
             & (city_crime_property = -1 or '$city_crime_property' >= city_crime_property or '$city_crime_property' = '')
        ) as c
        on a.city_id = c.city_id
        where 
              (price <= '$price' or '$price' = '')
            & (lis.stype_id = (select stype_id from sale_type where stype_name = '$stype_name') or '$stype_name' = 'Any')
        limit 20";
        
        //$result = $conn->query($sql);

    }
    //Loop through the pulled data, insert the values in the row under, should be in the same order as the 
    //hardcoded in headers
if ($result = $conn->query($sql)) {
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
        echo "<td>" . $row['dwell_size'] . " sqft.</td>";
        echo "<td>" . $row['stype_name'] . "</td>";
        echo "<td>$" . $row['price'] . "</td>"; 
        echo "</tr>";
    }
    $result->free();
}
    ?>


  </tbody>
</table>

<?php
    $conn->close();
?>
        </div>
        <!--Gets bootstrap javascript resources from CDN-->
            <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
            <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
            <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
    </body>
</html>