<?php
include 'import_class.php';
$query = new suchin_class();
$query->CnndB();

$sql = "SELECT convert(varchar(20) ,getdate(),120) as datetime,Refresh_Sec
FROM [DRV].[AU].[V_PSP_DATA_AM]";
    
$query->result_array = "";
$query->GetdB($sql);
$time_stamp = $query->result_array;

// echo "<pre>";
// print_r($time_stamp);
// exit;

?>