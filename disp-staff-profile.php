<html>
<head>
<title>Display Staff profile records</title>
</head>

<body>
<table border="2">

<tr>
<th>Staff id</th>
<th>First name</th>
<th>Last name</th>
<th>Dept Code</th>
<th>Dept description</th>
<th>Staff grade code</th>
<th>Staff code description</th>
<th>Position Code</th>
<th>Position description</th>
<th>Supervisor id</th>
<th>Supervisor first name</th>
<th>Supervisor last name</th>
<th>Employeement date</th>
<th>Probation end date</th>
<th>Employee Status</th>
<th>Gender</th>
<th>Birthday</th>
<th>Email</th>
<th>Telephone</th>
<th>Mobile</th>
</tr>

<?php
include("connection.php");
error_reporting(0);
$query = "select * from staffprofile";
$data = mysqli_query($conn,$query);
$total = mysqli_num_rows($data);

echo $result['id']." ".$result['firstname']." ".$result['lastname']." ".$result['deptcode']." ".$result['deptdes']." ".$result['staffgradecode']." ".$result['staffcodedes']." ".$result['positioncode']." ".$result['poscodedes']." ".$result['suprvsorid']." ".$result['sfirstname']." ".$result['slastname']." ".$result['empdt']." ".$result['pedt']." ".$result['empstatus']." ".$result['gender']." ".$result['birthday']." ".$result['email']." ".$result['telephone']." ".$result['mobile'];
//echo $total;

if($total !=0)
{    
    
    while(($result=mysqli_fetch_assoc($data))) 
    {
       echo "
       <tr>
       <td>".$result['id']."</td>
       <td>".$result['firstname']."</td>
       <td>".$result['lastname']."</td>
       <td>".$result['deptcode']."</td>
       <td>".$result['deptdes']."</td>
       <td>".$result['staffgradecode']."</td>
       <td>".$result['staffcodedes']."</td>
       <td>".$result['positioncode']."</td>
       <td>".$result['poscodedes']."</td>
       <td>".$result['suprvsorid']."</td>
       <td>".$result['sfirstname']."</td>
       <td>".$result['slastname']."</td>
       <td>".$result['empdt']."</td>
       <td>".$result['pedt']."</td>
       <td>".$result['empstatus']."</td>
       <td>".$result['gender']."</td>
       <td>".$result['birthday']."</td>
       <td>".$result['email']."</td>
       <td>".$result['telephone']."</td>
       <td>".$result['mobile']."</td>
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




















