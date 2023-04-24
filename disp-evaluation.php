<html>
<head>
<title>Display evaluation records</title>
</head>

<body>
<table border="2">

<tr>
<th>Evaluation code</th>
<th>Description</th>
<th>Start date</th>
<th>End date</th>
<th>Probation end date</th>
<th>Reminder Start date</th>
<th>Reminder End Date</th>
</tr>

<?php
include("connection.php");
error_reporting(0);
$query = "select * from createevaluation";
$data = mysqli_query($conn,$query);
$total = mysqli_num_rows($data);

echo $result['evaluationcode']." ".$result['descrption']." ".$result['startdate']." ".$result['enddate']." ".$result['probationenddate']." ".$result['reminderstartdate']." ".$result['reminderenddate'];
//echo $total;

if($total !=0)
{    
    
    while(($result=mysqli_fetch_assoc($data))) 
    {
       echo "
       <tr>
       <td>".$result['evaluationcode']."</td>
       <td>".$result['descrption']."</td>
       <td>".$result['startdate']."</td>
       <td>".$result['enddate']."</td>
       <td>".$result['probationenddate']."</td>
       <td>".$result['reminderstartdate']."</td>
       <td>".$result['reminderenddate']."</td>
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