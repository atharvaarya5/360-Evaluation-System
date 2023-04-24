<html>
<head>
<title>Delete position records</title>
</head>

<body>
<table border="2">

<tr>
<th>Position code</th>
<th>Description</th>
<th>Operations</th>
</tr>

<?php
include("connection.php");
error_reporting(0);
$query = "select * from createposition";

$data = mysqli_query($conn,$query);
$total = mysqli_num_rows($data);

echo $result['positioncode']." ".$result['dscription'];

//echo $total;

if($total !=0)
{    
    
    while(($result=mysqli_fetch_assoc($data))) 
    {
       echo "
       <tr>
       <td>".$result['positioncode']."</td>
       <td>".$result['dscription']."</td>
       <td><a href ='del-pos.php?rn=$result[positioncode]'>Delete</td>
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
