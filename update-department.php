<html>
<head>
<title>UPDATE department records</title>
</head>

<body>
<table border="2" cellspacing="12">

<tr>
<th>Dept code</th>
<th>Description</th>
<th colspan="2" align="center">Operations</th>
</tr>

<?php
include("connection.php");
error_reporting(0);
$query = "select * from school";
$data = mysqli_query($conn,$query);
$total = mysqli_num_rows($data);


echo $result['deptcode']." ".$result['description'];
//echo $total;

if($total !=0)
{    
    
    while(($result=mysqli_fetch_assoc($data))) 
    {
       echo "
       <tr>
       <td>".$result['deptcode']."</td>
       <td>".$result['description']."</td>
       <td><a href ='upd-department.php?rn=$result[deptcode]&ds=$result[description]'>Update</td>
       <td><a href ='delete.php?rn=$result[deptcode]'>Delete</td>
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