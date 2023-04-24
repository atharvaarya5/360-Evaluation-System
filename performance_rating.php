<?php

include("connection.php");
error_reporting(0);
?>


<!DOCTYPE html>
<html>
<body>
<br><br><br><br><br>

<form>
<table border="0" bgcolor="white" align="center" cellspacing="20">
<tr>
<td>Username:</td>
<td><input type="text" placeholder="Username" name="username" required></td>
</tr>
<tr>
<td>Employee id:</td>
<td><input type="text" placeholder="Employeeid" name="empid" required></td>
</tr>
<tr>
<td>Rating:</td>
<td><input type="number" placeholder="Rating" name="rating" required></td>
</tr>
<tr>
<td colspan="2" align="center"><input type="submit" id="button" name="submit"></td>
</tr>
</form>
</table>
</body>
</html>

<?php

$un=$_GET['username'];
$em=$_GET['empid'];
$rt=$_GET['rating'];

$query="INSERT INTO PERFORMANCE VALUES ('$un','$em','$rt')";

$data=mysqli_query($conn,$query);

if($data)
{
   //echo "data inserted into database";
}
else
{
   echo "failed to insert data into database";
}

?>