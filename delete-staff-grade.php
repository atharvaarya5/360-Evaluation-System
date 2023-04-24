<html>
<head>
<title>Delete staff grade records</title>
</head>

<body>
<table border="2">

<tr>
<th>Staff Grade Code  code</th>
<th>Description</th>
<th>Operations</th>
</tr>

<?php
include("connection.php");
error_reporting(0);
$query = "select * from createstaff";
$data = mysqli_query($conn,$query);
$total = mysqli_num_rows($data);

echo $result['staffgradecode']." ".$result['descriptn'];
//echo $total;

if($total !=0)
{    
    while(($result=mysqli_fetch_assoc($data))) 
    {
       echo "
       <tr>
       <td>".$result['staffgradecode']."</td>
       <td>".$result['descriptn']."</td>
       <td><a href ='del-staff-grade.php?rn=$result[staffgradecode]'>Delete</td>
     ";
         
      }
}
else
{
    echo "no record found";
}

?>

</table>
</body>
</html>