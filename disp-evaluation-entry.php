<html>
<head>
<title>Display evaluation entry records</title>
</head>

<body>
<table border="2">

<tr>
<th>Description</th>
</tr>

<?php
include("connection.php");
error_reporting(0);
$query = "select * from eventry";
$data = mysqli_query($conn,$query);
$total = mysqli_num_rows($data);


echo $result['descptn'];
//echo $total;

if($total !=0)
{    
    
    while(($result=mysqli_fetch_assoc($data))) 
    {
       echo "
       <tr>
       <td>".$result['descptn']."</td>
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