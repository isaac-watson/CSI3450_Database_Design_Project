<?php
 $servername = "localhost";
 $username = "root";
 $password = "root";
 $dbname = "finaldb"; 
 
 
 
 $conn = new mysqli($servername, $username, $password, $dbname);

 if ($conn->connect_error) {
     die("Connection failed: " . $conn->connect_error);
 }
//print_r($_GET);
//var_dump($GLOBALS);
 if(isset($_GET['button_add_listing'])) {
    echo("check2");
    $htype_name = $_GET["htype_name"];
    $hstyle_name = $_GET['hstyle_name'];
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
    $price = $_GET["price"];
    $realtor_fname = $_GET["realtor_fname"];
    $realtor_lname = $_GET["realtor_lname"];
    $realtor_init = $_GET["realtor_init"];
    $realtor_email = $_GET["realtor_email"];
    $realtor_phone = $_GET["realtor_phone"]; 
    
  

    $conn->query("set @lot_next_id =(select max(lot_id) + 1 from lot)");

    $conn->query("insert into lot (lot_id, address_id, lot_size) 
    values(@lot_next_id, (select address_id from address where (street_num = '$street_num') & (street_name like '$street_name') & (zip = $zip) limit 1), $lot_size )");

    $conn->query("set @dwell_next_id = (select max(dwell_id) + 1 from dwelling)");

   $conn->query("insert into dwelling values(@dwell_next_id, @lot_next_id, '$unit', (select htype_id from home_type where htype_name like '%$htype_name%' limit 1),
    (select hstyle_id from home_style where hstyle_name like '%$hstyle_name%' limit 1), $dwell_size, $floor_num, $basement, $bath_num, $bed_num, $year_built)");

    $conn->query("set @real_next_id = (select max(realtor_id) + 1 from realtor);");

    $conn->query("insert into realtor select @real_next_id, '$realtor_lname', '$realtor_init', '$realtor_fname', $realtor_phone, '$realtor_email' from dual where 
    not exists (select * from realtor where (realtor_lname like '$realtor_lname') & (realtor_fname like '$realtor_fname') & (realtor_email like '$realtor_email'))");

    $conn->query("set @list_next_id = (select max(list_id) + 1 from listing)");

    $conn->query("insert into listing values(@list_next_id, @dwell_next_id, (select stype_id from sale_type where stype_name = '$stype_name' limit 1), 
    $price, @real_next_id, curdate(), curdate(), date_add(curdate(), interval 99 year))");
 }

$conn->close();
 
?>