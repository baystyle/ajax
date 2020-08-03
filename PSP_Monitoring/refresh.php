<?php
echo $_GET['content']." = ".$_GET['id'];
include 'import_class.php';
$query = new suchin_class();
$query->CnndB();

if($_GET['id'] == "#am"){
    $sql = "SELECT Refresh_Sec FROM [DRV].[AU].[V_PSP_DATA_AM]";
}elseif($_GET['id'] == "#mcl"){
    $sql = "SELECT Refresh_Sec FROM [DRV].[AU].[V_PSP_DATA_MCL]";
}

$query->GetdB($sql);
$psp_data = $query->result_array;

$check="0";
foreach($psp_data as $val){
    if($val == $_GET['content']){
        $check="1";
    }
}
echo $check;





?>