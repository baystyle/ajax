<?php

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "edoc";

$conn = new mysqli($servername, $username, $password, $dbname);

$sql = "SELECT * from position ";
$result = mysqli_query($conn,$sql);

$DATA_FILL = "";

$DATA_FILL.="<table border='1' style='background-color:black;color:white'>".
            "<thead>".
            "<tr>".
            "<th>#</th>".
            "<th>position</th>".
            "</tr>".
            "</thead>";

while($row = mysqli_fetch_assoc($result)){
    $DATA_FILL.="<tr>".
                "</tbody>".
                "<td>".$row['pos_id']."</td>".
                "<td>".$row['pos_name']."</td>".
                "</tr>".
                "</tbody>";
} 

$DATA_FILL.="</table>";

echo $DATA_FILL;
?>
