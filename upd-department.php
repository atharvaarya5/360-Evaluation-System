<?php

include("connection.php");
error_reporting(0);
$rn = $_GET['rn'];
$ds = $_GET['ds'];
?>

<!DOCTYPE html>
<html>
<body>
<br><br><br><br><br>

<form>
<table border="0" bgcolor="white" align="center" cellspacing="20">

<tr>
<td>Dept Code:</td>
<td><input type="text" value="<?php echo "$rn" ?>" name="dept" required></td>
</tr>

<tr>
<td>Description:</td>
<td><input type="text" value="<?php echo "$ds" ?>" name="desc" required></td>
</tr>

<tr>
<td colspan="2" align="center"><input type="submit" id="button" name="submit"></td>
</tr>
</form>
</table>
</body>
</html>


<?php

if($_GET['submit'])
{  

$un = $_GET['dept'];
$em = $_GET['desc'];


$query = "UPDATE SCHOOL SET deptcode='$un', description='$em' WHERE deptcode='$un' ";

$data = mysqli_query($conn,$query);

if($data)
{
   echo "<script>alert('Record Updated')</script>";
}
else
{
   echo "failed to update record";
}
}
?>