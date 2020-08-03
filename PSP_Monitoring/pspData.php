<?php
include 'import_class.php';
$query = new suchin_class();
$query->CnndB();

date_default_timezone_set("Asia/Bangkok");
$date = date("d-m-Y h:i:s");
// echo $date;
// exit;
$header;
$body;
$product = 0;
$part = 0;
$next = 0;

if($_GET['pspData']=="am"){
    $sql = "SELECT *, FORMAT([LEFT_TIME(EST)], 'dd-MM-yy H:mm') as [LEFT_TIME(EST)], FORMAT([PART_LEFT_TIME(EST)], 'dd-MM-yy H:mm') as [PART_LEFT_TIME(EST)]
			FROM [DRV].[AU].[V_PSP_DATA_AM]
			ORDER BY Part_Remain";
		
	$query->result_array = "";
	$query->GetdB($sql);
	$psp_data = $query->result_array;
	$header = array_keys($psp_data[0]);
	$body = array_values($psp_data);
}else if($_GET['pspData']=="mcl"){
	$sql = "SELECT * , FORMAT([LEFT_TIME(EST)], 'dd-MM-yy H:mm') as [LEFT_TIME(EST)], FORMAT([PART_LEFT_TIME(EST)], 'dd-MM-yy H:mm') as [PART_LEFT_TIME(EST)]
			FROM [DRV].[AU].[V_PSP_DATA_MCL]
			ORDER BY Part_Remain";
		
	$query->result_array = "";
	$query->GetdB($sql);
	$query->result_array = "";
	$query->GetdB($sql);
	$psp_data = $query->result_array;
	$header = array_keys($psp_data[0]);
	$body = array_values($psp_data);
}

$i=0;
foreach ($header as $rs_header) {
	if($rs_header =="ITEM_NO"){
		$product = $i;
		$i=0;
	}
		
	if($rs_header =="NEXT_MODEL"){	
		$part = $i;
		$i=0;
	}
	$i++;
}

$psp_data['product'] = $product;
$psp_data['part'] = $part;
$psp_data['next'] = $i;
$psp_data['header'] = $header;
$psp_data['body'] = $body;
$psp_data['sql'] = $sql;
$psp_data['dbserver_ip'] = '43.72.52.24';
$psp_data['db_name'] = 'STD';

echo json_encode($psp_data);
?>