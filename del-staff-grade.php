<?php

include("connection.php");
error_reporting(0);

$rollno = $_GET['rn'];

$query = "DELETE FROM CREATESTAFF WHERE STAFFGRADECODE = '$rollno'";

$data = mysqli_query($conn,$query);

if($data)
{
   echo "<font color='red'> Record deleted from database";
}
else
{
   echo "<font color='red'> Failed to delete record from database";
}
?>