<html>
<head>
<title>Delete vendor records</title>
</head>

<body>
<table border="2">

<tr>
<th>Vendorid</th>
<th>Organisation Name</th>
<th>SContact Person</th>
<th>Phone</th>
<th>Email</th>
<th>Operations</th>
</tr>

<?php
include("connection.php");
error_reporting(0);
$query = "select * from vendor";
$data = mysqli_query($conn,$query);
$total = mysqli_num_rows($data);

echo $result['vendorid']." ".$result['orgname']." ".$result['contactperson']." ".$result['phone']." ".$result['email'];
//echo $total;

if($total !=0)
{    
    
    while(($result=mysqli_fetch_assoc($data))) 
    {
       echo "
       <tr>
       <td>".$result['vendorid']."</td>
       <td>".$result['orgname']."</td>
       <td>".$result['contactperson']."</td>
       <td>".$result['phone']."</td>
       <td>".$result['email']."</td>
       <td><a href ='del-vendor.php?rn=$result[vendorid]'>Delete</td>
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


