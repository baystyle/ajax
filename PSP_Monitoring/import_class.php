<?php
class suchin_class {

	var 	$result_array=array();//result data from data base
	var 	$problem_info=array();//Current M/C Down time
	var 	$db='';//connection db
	var 	$conn_sttc='';//connection sttc trace db
	var 	$conn_stta='';//connection stta trace db
	var 	$col_name=array();//connection db
	var 	$sql_array=array();
	var 	$Num_Rows;

    /** INTERNAL: The start time, in miliseconds.*/
    var 	$mtStart;
	//$this->mtStart    = $this->getMicroTime();
	
	var 	$line_problem_record_view=array();//record down time
	var 	$total_mc_down='';	
	
	var 	$delete_target=array();	
	var 	$delete_target_flag='';//for fillter column not need for some sql / som table
	
	var 	$host='';
	var 	$user='';
	var	$password='';
	var 	$dbname='';
	
	var 	$gbl_search='';
	var 	$where='';
	var 	$result_separate='';
	
	var 	$output_hr='';
	var 	$total_output='';
	var 	$work_time='';
	var 	$target_shift='';
	var 	$plan_target_shift=array();//get plan target_shift ,work_time ,output_hr from 43.72.52.84
	var 	$prod_real_time=array();//get output detail from MySql 43.72.52.84
	var 	$tbl_master_data_temp=array();//get output detail from MySql packing pc all line
	var 	$total_target_shift='';//total_target_shift
	var 	$index='';
	
	var 	$line='';
	var 	$ef_card='';
	var 	$shift='';
	var 	$shift_date='';
	var 	$hour='';




	function hello($str){
		echo " 
		<script type='text/javascript'> 
			alert('$str'); 
		</script> 
		";		
		
	}


	function show_data_org()
	{
			$Num_Rows=count($this->result_array);
			if($this->result_array){
				foreach($this->result_array as $key=>$row){
					@$this->col_name=array_keys($row);
					break;				
				}
			}			
			
			
			//$myfield = array('shift_date','business','chassis','line','shift','target','actual','diff','mc_down','freq');
			
			//$myfield = array('business','chassis','line','target','actual','diff','feel','mc_down','freq','current');
			//$myfield = array('business','chassis','line','shift','target','actual','diff','feel','mc_down','freq','current_down');
			$myfield = array('business','chassis','line','target','actual','diff','mc_down','freq','feel');
			
			if($this->col_name)
			foreach  ($this->col_name as $field_name=>$field_data) {	
				if(in_array($field_data, $myfield))$row[]=$field_data;
			}
			
			$this->col_name='';
			$this->col_name =$myfield;
			
			echo "<span align='left' id='search_condition'><b>Search Condition :</b><font color=blue>  ".$this->where." </font><br>(Total result <font color=blue> $Num_Rows </font>record)</span>";	
			
			$width='100%';
			echo "<table align ='center' border='0' width='$width'>";
			echo "<tr>";
			
			//start print header hear
			$colspan=1;
			
			if($this->col_name){
				foreach ($this->col_name as $key=>$fname) { //create columm header of table
					/*
					if((trim($glb_orderby)==trim($fname)) && (trim($glb_sort_direction)=="ASC")){
						$glb_sort_direction="DESC";
					}else if(($glb_orderby==$fname) && (trim($glb_sort_direction)=="DESC")){
						$glb_sort_direction="ASC";
					}
					*/
					if($fname!="data_id" && $fname!='FontColor' && $fname!='output'){
						//echo "<td id='column_header' align=right class='header'><a href=\"?send=search&search=$this->gbl_search&new=$gbl_new&Page=$Page&Per_Page=$Per_Page&$gbl_link_var&glb_orderby=$fname&glb_sort_direction=$glb_sort_direction\" title='sort by ".strtolower($field_name_header[0][$fname])."'>".$fname."</a></td>";
						echo "<td align='center' id='h_sec'>".$fname."</td>";
						
					}else if($fname=='output'){
						//echo "<td id='column_header' align=right class='header'><a href=\"?send=search&search=$this->gbl_search&new=$gbl_new&Page=$Page&Per_Page=$Per_Page&$gbl_link_var&glb_orderby=$fname&glb_sort_direction=$glb_sort_direction\" title='sort by ".strtolower($field_name_header[0][$fname])."'>".$fname."</a></td>";
						echo "<td align='center' id='h_sec'>".$fname."</td>";
					}
				}
			}
			
			echo "</tr>";
			echo "<tr>";
			
		//start print data detail
			
			
			
			
			
			
			$total_qty=0;
			$sendSound=0;
			//print "<pre>";
			//print_r ($this->result_array);
			//print_r ($this->problem_info);
			//print "</pre>";
			if($this->result_array){
			
				foreach ($this->result_array as $line_name=>$row_array) { //feed data to table
				
					$problem=$this->$problem_info[$line_name]['current_down'];
					$txt_no="txt_no";
					$txt_actual="txt_actual";
					$b_line_al="b_line_al";
					if($problem)$txt_no="txt_no_down";
					if($problem)$txt_actual="txt_actual_down";
					if($problem)$b_line_al="b_line_al_down";				
					
					if($row_array[diff]<0) {
						$textAHcolor="#ff0000";
					}else {
						$textAHcolor="#00ff00";
					}
					
					if($textAHcolor=='#00ff00'){
						$fell= "<img src='/sample/getoutput/gif/smile1.png' border=0  width='30' height='30' title='".$title[$pattern]."' alt='' />";
					}else{
						$fell= "<img src='/sample/getoutput/gif/bad_smile.png' border=0  width='30' height='30' title='".$title[$pattern]."' alt='' />";
					}	
					
					if(empty($problem))echo "<tr onMouseOver=\"this.bgColor = '#EEDD82'\"   onMouseOut =\"this.bgColor = '#EFEFEF'\"   bgcolor=\"#EFEFEF\">";
					if($problem)echo "<tr bgcolor=\"#EEDD82\">";
					
					$act_var="";
					foreach  ($row_array as $field_name=>$field_data) {
						$act_var=$act_var."&$field_name=$field_data";
					}
					
					
					
					foreach  ($row_array as $field_name=>$field_data) 
					{
						if(in_array($field_name, $myfield))
						{
							//print $line_name;
							//echo '<td align=right>'.$field_data;
							
							if($field_name=="business")
							{
								echo "<td align='center' id='h_sec_b'>".$field_data;
							}
							elseif($field_name=="chassis" || $field_name=="line")
							{
								echo "<td align='center' id='sec_b_ap'>".$field_data;
							}
							elseif($field_name=="diff")
							{
								echo "<td align='center' id='$txt_no'><font color='$textAHcolor'>".$field_data."</font>";
							}
							elseif($field_name=="feel")
							{
							echo "<td align='center' id='$txt_no'>".$fell;
							}
							else 
							{
								echo "<td align='center' id='$txt_no'>".$field_data;
							}
						}
					}
					echo'</tr>';
				}
				
			   echo "</table>";
			}
			
			if($sound=='ON')echo "<bgsound src='../wav/currentSound.wav' loop='1'></bgsound>";
			
	}// end func show_data


function show_data()
	{
			$Num_Rows=count($this->result_array);
			if($this->result_array){
				foreach($this->result_array as $key=>$row){
					@$this->col_name=array_keys($row);
					break;				
				}
			}			
			
			//print_r($this->prod_real_time );
		foreach($this->prod_real_time as $key_line=>$row){
			$business=$row['business'];
			$chassis=$row['chassis'];
			$line=$row['line'];
			$result_array[]=$line;		
			$result_array_business[$business][$chassis][]=$line;
			$result_array_group[$line]=array($business,$chassis);		
		}			
			
			
		$business_temp="";
		$count_end=0;
		if($result_array_business){
			foreach($result_array_business as $business_name=>$v_array1){
				foreach($v_array1 as $chassis_name=>$v_array2){
					$rowspan_chassis[$business_name][$chassis_name]=round(count($v_array2)/2)*2;//set chassis rowspan value
				}
			}
		}
		
		$rowspan="";
		if($rowspan_chassis){
			FOREACH($rowspan_chassis AS $business_name=>$chassis_array){
				$rowspan_of_business="";
				FOREACH($chassis_array AS $chassis_name=>$amount_line){
					$rowspan_of_business[]=round($amount_line/2);
					$rowspan[$business_name]=array_sum($rowspan_of_business); //set business rowspan value
				}
			}
		}			
			
			
			//$myfield = array('shift_date','business','chassis','line','shift','target','actual','diff','mc_down','freq');
			//$myfield = array('business','chassis','line','target','actual','diff','feel','mc_down','freq','current');
			//$myfield = array('business','chassis','line','shift','target','actual','diff','feel','mc_down','freq','current_down');
			$myfield = array('business','chassis','line','target','actual','diff','mc_down','freq','feel');
			$needfield = array('target','actual','diff','mc_down','freq','feel');
			
			if($this->col_name)
			foreach  ($this->col_name as $field_name=>$field_data) {	
				if(in_array($field_data, $myfield))$row[]=$field_data;
				
			}
			
			$this->col_name='';
			$this->col_name =$myfield;
			
//			echo "<span align='left' id='search_condition'><b>Search Condition :</b><font color=blue>  ".$this->where." </font><br>(Total result <font color=blue> $Num_Rows </font>record)</span>";	

	echo "<div align='center'><H3>PRODUCTION PERFORMANCE MONITORING</H3></div>";
	echo "<fieldset>";
	echo "<table border=0>";
	echo "<tr id='bg_h'>
	<td  id='h_sec' align='left'>
	<a href=\"?business=&chassis=&line=\"  onClick=\"\">BUSINESS</a>
	<td  id='h_sec'>CHASSIS
	
	<td  width='6.5%' align='center' id='h_sec'>LINE
	<td  width='7.5%' align='center' id='h2_p1'>TARGET
	<td  width='7.5%' align='center' id='h2_a1'>ACTUAL
	<td  width='7.5%' align='center' id='h2_d1'>DIFF
	<td  width='7.5%' align='center'>DOWN
	<td  width='5%' align='center'>FREQ.
	<td  width='5%' align='center'>FEEL";	
	
	echo "
	<td  width='6.5%' align='center' id='h_sec'>LINE
	<td  width='7.5%' align='center' id='h2_p1'>TARGET
	<td  width='7.5%' align='center' id='h2_a1'>ACTUAL
	<td  width='7.5%' align='center' id='h2_d1'>DIFF
	<td  width='7.5%' align='center'>DOWN
	<td  width='5%' align='center'>FREQ.
	<td  width='5%' align='center'>FEEL";	



		$line_num=1;
		$business_temp="";
		$chassis_temp="";
		$chassis_change=0;
		$output_result=$this->result_array;
		foreach($output_result as $line_name=>$data_of_line_array){
		
		
			//$problem=$this->problem_info[$line_name]['problem_des_full'];
			$txt_no="txt_no";
			$txt_actual="txt_actual";
			$b_line_al="b_line_al";
			if($problem)$txt_no="txt_no_down";
			if($problem)$txt_actual="txt_actual_down";
			if($problem)$b_line_al="b_line_al_down";		
				
				
				$chassis_change=0;
				$business_name=$result_array_group[$line_name][0];
				$chassis_name=$result_array_group[$line_name][1];
				
				if(empty($business_temp))$business_temp=$business_name;
				if(empty($chassis_temp))$chassis_temp=$chassis_name;
				
				if($business_temp!=$business_name){
					if($line_num%2==0){
						echo "<td id='b_line_al' align='left'>--";
						echo "<td id='txt_no'  align='center'>--";
						echo "<td id='txt_no'  align='center'>--";
						echo "<td id='txt_no'  align='center'>--";
						echo "<td id='txt_no'  align='center'>--";
						echo "<td id='txt_no'  align='center'>--";
						echo "<td id='txt_no'  align='center'>--";
						//echo "<td  bgcolor='#ffffff'>--";				
					}	
					$line_num = 1;
					$business_temp=$business_name;
				}
				
				if($business_temp==$business_name){
					if($chassis_temp!=$chassis_name){
						if($line_num%2==0){
							echo "<td id='b_line_al' align='left'>--";
							echo "<td id='txt_no'  align='center'>--";
							echo "<td id='txt_no'  align='center'>--";
							echo "<td id='txt_no'  align='center'>--";
							echo "<td id='txt_no'  align='center'>--";
							echo "<td id='txt_no'  align='center'>--";
							echo "<td id='txt_no'  align='center'>--";
							//echo "<td bgcolor='#ffffff'>--";
						}
					
						$chassis_change=1;
						$chassis_temp=$chassis_name;
						if($line_num%2==0)$line_num++;
					}
				}
				
				//$problem='';
				//print_r($output_result);		
				//$problem=$output_result[$line_name][current_down];
				
				if($this->problem_info)
				$problem=$this->problem_info[$line_name]['problem_des_full'];
				$txt_no="txt_no";
				$txt_actual="txt_actual";
				$b_line_al="b_line_al";
				if($problem)$txt_no="txt_no_down";
				if($problem)$txt_actual="txt_actual_down";
				if($problem)$b_line_al="b_line_al_down";	
				
				$row_span_business=$rowspan[$result_array_group[$line_name][0]];
				$row_span_chassis=round($rowspan_chassis[$result_array_group[$line_name][0]][$result_array_group[$line_name][1]]/2);
				
				if($line_num%2 == 1 )echo "<tr>"; //when at right zone ($line_num=odd is echo on same row,$line_num=even is echo on new row)
				if($line_num==1){	
					echo "<td id='h_sec_b' rowspan='$row_span_business'>".
					"<a href=\"/monitor/index.php?business=$business_name&chassis=&line=\" onClick=\"\">".$result_array_group[$line_name][0]."</a>\n";//business		
					
					echo "<td id='sec_b_ap' rowspan='$row_span_chassis'>".
					"<a href=\"/monitor/index.php?business=$business_name&chassis=$chassis_name&line=\" onClick=\"\">".$result_array_group[$line_name][1]."</a>\n";//chassis		
					
					echo "<td id='$b_line_al' align='left'>".
					"<a href=\"/monitor/index.php?business=$business_name&chassis=$chassis_name&line=$line_name\" onClick=\"\">".$line_name."</a>\n";//line		
					
				}elseif($chassis_change==1){
					if($line_num%2==0){ //right hand print
						echo "<tr><td id='sec_b_ap' rowspan='$row_span_chassis'>".
						"<a href=\"/monitor/index.php?business=$business_name&chassis=$chassis_name&line=\" onClick=\"\">".$result_array_group[$line_name][1]."</a>\n";//chassis		
						
					}
					if($line_num%2==1){//left hand print
						echo "<td id='sec_b_ap' rowspan='$row_span_chassis'>".
						"<a href=\"/monitor/index.php?business=$business_name&chassis=$chassis_name&line=\" onClick=\"\">".$result_array_group[$line_name][1]."</a>\n";//chassis		
					}
					echo "<td id='$b_line_al' align='left'>".
					"<a href=\"/monitor/index.php?business=$business_name&chassis=$chassis_name&line=$line_name\" onClick=\"\">".$line_name."</a>\n";//line		
					
					$chassis_change=0;
					if($line_num%2==0)$line_num++;
					
				}elseif($right_chassis==1){
					echo "<td id='sec_b_ap' rowspan='$row_span_chassis'> ".$result_array_group[$line_name][1];//chassis
					echo "<td id='$b_line_al' align='left'>".
					"<a href=\"/monitor/index.php?business=$business_name&chassis=$chassis_name&line=$line_name\" onClick=\"\">".$line_name."</a>\n";//line		
					
					$right_chassis=0;
				}else{
					if($chassis_temp!=$chassis_name)echo "<td>".$result_array_group[$line_name][1];//chassis
					echo "<td id='$b_line_al' align='left'>".
					"<a href=\"/monitor/index.php?business=$business_name&chassis=$chassis_name&line=$line_name\" onClick=\"\">".$line_name."</a>\n";//line		
				}
				
				
				//print_r($problem);
				foreach($data_of_line_array as $key_index=>$data_of_line){
				$sound='';
						if(in_array($key_index, $needfield)){
							if($key_index=='diff'){
								
								$colors_diff = "#00FF00";
								if($data_of_line_array[diff]<0) $colors_diff = "#FF0000";
								
								if(!$problem)echo "<td id='$txt_no' align='center'><font color='$colors_diff'>$data_of_line</font>";
							}elseif($key_index=='target'){
								if(!$problem)echo "<td id='$txt_actual' align='center'><a href='../plan_input.php' target='_blank'>".$data_of_line."</a>";							
								if($problem){
									$data_of_line=$this->problem_info[$line_name]['occur_time'];
									
								$colors_diff = "#FF0000";
								//if($data_of_line<0) $colors_diff = "#FF0000";
									
									echo "<td id='$txt_no' colspan=6>$problem<font color='$colors_diff'>($data_of_line)</font>";	
									$sound='NO';
								}
								
							}elseif($key_index=='actual'){
								$actual='0';
								if($output_result[$line_name]['actual'])$actual=$output_result[$line_name]['actual'];
								//if(!$problem)echo "<td id='$txt_no' align='center'><A HREF=\"javascript:void(0)\" onclick=\"window.open('/mfe/production/output.php?search=$this->shift_date,$line_name,$current_shift','outputtoday','height=700, width=900,status,toolbar=yes,scrollbars=yes,resizable=yes,outerwidth=0, outerheight=0, left=50, right=0,top=0')\">".$data_of_line."</a>";
								if(!$problem)echo "<td id='$txt_no' align='center'><a href=\"/monitor/today_output/prod_history/output.php?search=$this->shift_date,$line_name,$current_shift\" onClick=\"\" target=\"_blank\">".$data_of_line."</a>";
							}elseif($key_index=='feel'){
									//$problem=$output_result[$line_name][information][problem_info];
									/*
									if($problem){
										foreach($problem as $key_is_line=>$value_is_problem_array){
											foreach($value_is_problem_array as $key=>$value_is_problem){
												if(($value_is_problem!='BREAK TIME') && empty($sound))$sound='ON';
											}
										}
									}
									
									*/
									
									
									if($problem){
										//foreach($problem as $key_is_line=>$value_is_problem_array){
											//foreach($value_is_problem_array as $key=>$value_is_problem){
												if(($problem !='BREAK TIME') && empty($sound))$sound='ON';
											//}
										//}
									}									
									
									if($sound=='ON'){
										echo "<bgsound src='./wav/currentSound.wav' loop='1'></bgsound>";
										
									}else{
										echo "<td id='$txt_no'  align='center'><a href=\"/monitor/downalert/lineproblem.php?send=search&search=$gbl_search&new=true&Page=$Page&Per_Page=$Per_Page&summarize=daily&shift=$shift&line=$line_name&shift_date=$today&glb_owner=$glb_owner&glb_orderby=&glb_sort_direction=$glb_sort_direction&glb_select_title=$glb_select_title\" onClick=\"\" target=\"_blank\"><font color=$limitColor>".$data_of_line."</font></a>";
									}
									
							}elseif(($key_index=='mc_down' || $key_index=='freq' ) ){
										$shift=$output_result[$line_name][shift];
										$shift_date=$output_result[$line_name][shift_date];
										
										if(empty($shift) || empty($shift_date)){
											$shift=$this->shift;
											$shift_date=$this->shift_date;
										}
										
										
										
										$colors_freq="#FFCC00";
										if($data_of_line_array[mc_down]>30 || $data_of_line_array[freq]>=10) $colors_freq="#FF0000";
										
										//echo "<td id='$txt_no' align='center'><a href=\"/monitor/downalert/lineproblem.php?send=search&search=$gbl_search&new=true&Page=$Page&Per_Page=$Per_Page&shift=$shift&line=$line_name&shift_date=$shift_date&glb_owner=$glb_owner&glb_orderby=&glb_sort_direction=$glb_sort_direction&glb_select_title=$glb_select_title\" onClick=\"\" target=\"_blank\"><font color=$limitColor>".$data_of_line."</font></a>";
										//echo "<td id='$txt_no' align='center'>tttt<a href=\"/monitor/downalert/lineproblem.php?send=search&search=$gbl_search&new=true&Page=$Page&Per_Page=$Per_Page&shift=$shift&line=$line_name&shift_date=$shift_date&glb_owner=$glb_owner&glb_orderby=&glb_sort_direction=$glb_sort_direction&glb_select_title=$glb_select_title\" onClick=\"\" target=\"_blank\"><font color=".$colors_freq.">".$data_of_line."</font></a>";
										
										if(!$problem){
											echo "<td id='$txt_no' align='center'><a href=\"/monitor/downalert/lineproblem.php?send=search&search=$gbl_search&new=true&Page=$Page&Per_Page=$Per_Page&shift=$shift&line=$line_name&shift_date=$shift_date&glb_owner=$glb_owner&glb_orderby=&glb_sort_direction=$glb_sort_direction&glb_select_title=$glb_select_title\" onClick=\"\" target=\"_blank\"><font color=".$colors_freq.">".$data_of_line."</font></a>";
										}else{
										}
										
										
							}else{
								echo "<td id='$txt_no' align='center'>$data_of_line";
							}
						}
				}	
				$line_num++;			
		}
			
			if($line_num%2==0){//add - to empty column at the end table
				echo "<td id='b_line_al' align='left'>--";
				echo "<td id='txt_no' align='center'>--";
				echo "<td id='txt_no' align='center'>--";
				echo "<td id='txt_no' align='center'>--";
				echo "<td id='txt_no' align='center'>--";
				echo "<td id='txt_no' align='center'>--";
				echo "<td id='txt_no' align='center'>--";
				//echo "<td  bgcolor='#ffffff'>--";
			}
		echo "</table>";
		echo '</fieldset>';
			
	}// end func show_data


function show_data_ford($col_name = array(null),$align = array(null), $bg_color=null, $font_color=null ,$link=array(null),$size=array(null))
{
	global $glb_sort_direction,$glb_orderby,$gbl_sql_title,$ME,$server_name,$user_dept,$total_down_time,

	$glb_select_title,$glb_sql_source,$glb_owner,$gbl_Emp_ID,$Page,$Per_Page,$Num_Rows,
	$gbl_search,$gbl_new,$gbl_date,$gbl_to_date,$gbl_link_var,$user_type,$dir,$nowDate,$root,$send,$ss_owner;
		if($result_array){

			$Num_Rows=count($this->result_array);
			if($this->result_array){
				foreach($this->result_array as $key=>$row){
					@$this->col_name=array_keys($row);
					break;				
				}
			}	
		}

//print_r($this->result_array);

		echo "<br>";

		echo "<b>Total found <font color='#993366'>". $Num_Row."</font> records.)</b>";
	//	if(!empty($this->result_array))echo "<a href=\"$ME?submit=search&search=".$this->gbl_search."&new=$new&csv_create=1\"  onClick=\"\"><img src='./gif/download.gif' border=0 alt='Download to excel line'></a>\n";		
		if($glb_sql_source[start_date]&&$glb_sql_source[stop_date])echo " [ from date: <font color=blue>".$glb_sql_source[start_date]." to ".$glb_sql_source[stop_date]."</font> ]</b>";
		
		echo "<table border=1 colspan=5 width=100%>";
		echo "<tr>";
		
		
		//start print header hear	
		$header_color="black";
		$mode=array("start"=>"on","end"=>"off");		
		echo "<td align=center id=h_sec><font color='white' size=2><b>Item</b></font>";		
		
		
		if($this->col_name){
			foreach ($this->col_name as $key=>$name) { //create columm header of table
				if((trim($glb_orderby)==trim($name)) && (trim($glb_sort_direction)=="ASC")){
					$glb_sort_direction="DESC";
				}else if(($glb_orderby==$name) && (trim($glb_sort_direction)=="DESC")){
					$glb_sort_direction="ASC";
				}
				if($name!='data_id' and $name!='occuring_date'and $name!='close_date'){
					echo "<td  id=h_sec><a href=\"$ME?submit=search&search=$gbl_search&new=$gbl_new&Page=$Page&Per_Page=$Per_Page&$gbl_link_var&glb_owner=$glb_owner&glb_orderby=$name&glb_sort_direction=$glb_sort_direction&glb_select_title=$glb_select_title\" onClick=\"\"><font color=white size=2><b>".ucwords(strtolower($name))."</b></font></a>";
					if($glb_sort_direction=="DESC")echo "<a href=\"$ME?submit=search&search=$gbl_search&new=$gbl_new&Page=$Page&Per_Page=$Per_Page&$gbl_link_var&glb_owner=$glb_owner&glb_orderby=$name&glb_sort_direction=$glb_sort_direction&glb_select_title=$glb_select_title\" onClick=\"\"><img src=\"\attendance\image\acs.png\" title=\"���§�ҡ������ҡ ASC\" alt=\"bbb\" border=\"0\" width=\"7\" height=\"7\" /></a>\n";
					if($glb_sort_direction=="ASC")echo "<a href=\"$ME?submit=search&search=$gbl_search&new=$gbl_new&Page=$Page&Per_Page=$Per_Page&$gbl_link_var&glb_owner=$glb_owner&glb_orderby=$name&glb_sort_direction=$glb_sort_direction&glb_select_title=$glb_select_title\" onClick=\"\"><img src=\"\attendance\image\desc.png\" title=\"���§�ҡ�ҡ仹��� DESC\" alt=\"bbb\" border=\"0\" width=\"7\" height=\"7\" /></a>\n";
				}
			}
		}
		/*
		if((($user_type=="admin")||($user_type=="admins")) && $mode[end]=='on'){
			$colspan=1;
			echo "<td colspan=$colspan><font color='white' size=2>MODE</font>";
		}
		*/
		echo "</tr>";
		echo "<tr>";
		
		//start print data detail
		if($this->result_array){
			foreach ($this->result_array as $key=>$row_array) { //feed data to table
				echo "<tr>";
				$i=0;
				//echo "<td><font size=2>".($key+1)."</font>";
				echo "<td  id=h_sec_b>".($key+1);
				$act_var="";
				foreach  ($row_array as $field_name=>$field_data) {
					$act_var=$act_var."&$field_name=$field_data";	
				}

				foreach  ($row_array as $field_name=>$field_data) {
					
							
							if($field_name=='data_id')$data_id=$field_data;
							if($field_name!='data_id' and $field_name!='occuring_date'and $field_name!='close_date'){
								if($field_name=='Ef_no'){
									$field_data_=substr($field_data,1,12);
									echo "<td id=h_sec_b><a href ='http://43.72.52.84/efcard/ef_link.php?serial=$field_data_' target='_blank'>$field_data</a>";
								}else{
									echo "<td id=h_sec_b>".$field_data."\n";									
								}
							}
					$i++;
				}
				
			}
			
		}else{
			if($send=='Delete_This_Record'){
				$variable="Delete Complete";
			}else{
				$variable="No data in system";
			}
				
			/*	
				echo " 
				<script type='text/javascript'> 
					alert('$variable'); 
					window.location = 'http://$root/breaktime.php?submit=new&search=&new=0&Per_Page=$Per_Page&Page=1'
					
				</script>";				
			*/
			
		}
		echo "</tr>";
		echo "</table>";
		echo "</div>";
}// end function show_data



    /** Internal method to get the current time.
      * @return The current time in seconds with microseconds (in float format).
     */
    function getMicroTime()
    {
      list($msec, $sec) = explode(' ', microtime());
      return floor($sec / 1000) + $msec;
    }

    function getExecTime()
    {
      return round(($this->getMicroTime() - $this->mtStart) * 1000) / 1000;
    }




	function CnndB(){

		//if($this->line{1}=='F'){
		//	//$this->db  = mssql_connect ( 'thsttamfg01', 'usReader', '' );// or die ( 'Can not connect to server' );//mssql server connection (picsy db)
		//	$this->db  = mssql_connect("THSTTSUBSYS03", "Picsy_monitor", "picsy12345*");// or die ( 'Can not connect to server' );//mssql server connection (picsy db)
		//	mssql_select_db ( 'datawarehouse', $this->db  );// or die ( 'Can not select database' );//connection database

			
			$this->db  = mssql_connect("43.72.52.24", "STD", "std-123");// or die ( 'Can not connect to server' );//mssql server connection (picsy db)
			//$this->db  = mssql_connect("43.72.59.205", "sttc", "sttc");// or die ( 'Can not connect to server' );//mssql server connection (picsy db)
			//mssql_select_db('MEA', $this->db);// or die ( 'Can not select database' );//connection database
			
			

		//}else{
			//$this->db = new mysqli($this->host, $this->user, $this->password, $this->dbname);	// MySql Server
		//}

	}

	

	// mssql_connect("43.72.52.25", "EMS", "Ems@SttMFD")


	function CnndBMySQL(){

		//if($this->line{1}=='F'){
		//	//$this->db  = mssql_connect ( 'thsttamfg01', 'usReader', '' );// or die ( 'Can not connect to server' );//mssql server connection (picsy db)
		//	$this->db  = mssql_connect("THSTTSUBSYS03", "Picsy_monitor", "picsy12345*");// or die ( 'Can not connect to server' );//mssql server connection (picsy db)
		//	mssql_select_db ( 'datawarehouse', $this->db  );// or die ( 'Can not select database' );//connection database


/*			$this->db  = mssql_connect("172.20.2.3", "sttc", "sttc");// or die ( 'Can not connect to server' );//mssql server connection (picsy db)
			mssql_select_db('sttc', $this->db);// or die ( 'Can not select database' );//connection database
*/

		//}else{
			$this->db = new mysqli($this->host, $this->user, $this->password, $this->dbname);	// MySql Server
		//}

	}

	function GetRow_num($sql){	
		$r = mssql_query ( $sql,$this->db );

		$this->Num_Rows = mssql_num_rows($r); //total_row 	
		print 'Total ===>'.$this->Num_Rows;

	}
	


	function GetdBMySql($sql){
		//print '<br>'.$sql;
		$result = $this->db->query($sql);
		$row='';
		while ($row= $result->fetch_array(MYSQLI_ASSOC)){//MYSQLI_NUM,MYSQLI_ASSOC

			foreach($row as $k=>$v){
				if($v=='' || $v=='0')$v='-';
				if(!empty($v))$temp[$k]=$v;
			}

			$this->result_array[]=$temp;
			if(empty($col)){
				@$this->col_name=array_keys($row);
				$col=1;
			}

		}	
	}

	function exec($sql){
		
		//print  '<P>'.$sql. '<br>';		
		//die;
	
			$r = mssql_query ( $sql,$this->db );

		}



	function GetdB($sql){
		
		//print  '<P>'.$sql. '<br>';		
		//die;

		$col=0;
		$this->col_name='';
		
	//	if($this->line{1}=='F'){
	
			$r = mssql_query ( $sql,$this->db );

			$row='';
			while ( $row = mssql_fetch_array ( $r,MSSQL_ASSOC) ){

				//print_r($row);
				$this->result_array[]=$row;
				if(empty($col)){
					$this->col_name=array_keys($row);
					$col=1;
				}				
			}	


/*
		}elseif($this->line{1}=='Z' ||$this->line{1}=='V'  ||$this->line{1}=='P' ){	
				//print  '<P>'.$sql. '<br>';		
				$stmt = oci_parse($this->conn_sttc, $sql);
				$objExecute = oci_execute($stmt, OCI_DEFAULT);
				if($objExecute)
				{
					$row='';
					while($row = oci_fetch_array($stmt, OCI_ASSOC)){
						$this->result_array[$row[LINE]][line_shift]=$row[LINE_SHIFT];
						$this->result_array[$row[LINE]][line]=$row[LINE];
						$this->result_array[$row[LINE]][actual]=$row[ACTUAL];
					}				
				}		
				
		}elseif($this->line{1}=='B' ||$this->line{1}=='E'){	
				//print  '<P>'.$sql. '<br>';		
				$stmt = oci_parse($this->conn_stta, $sql);
				$objExecute = oci_execute($stmt, OCI_DEFAULT);
				if($objExecute)
				{
					$row='';
					while($row = oci_fetch_array($stmt, OCI_ASSOC)){
						$this->result_array[$row[LINE]][line_shift]=$row[LINE_SHIFT];
						$this->result_array[$row[LINE]][line]=$row[LINE];
						$this->result_array[$row[LINE]][actual]=$row[ACTUAL];
					}				
				}						
						
		}else{
		*/
		
/*			print '<br>'.$sql;
			$result = $this->db->query($sql);
			$row='';
			while ($row= $result->fetch_array(MYSQLI_ASSOC)){//MYSQLI_NUM,MYSQLI_ASSOC
				foreach($row as $k=>$v){
					if($v=='' || $v=='0')$v='-';
					if(!empty($v))$temp[$k]=$v;
				}
				$this->result_array[]=$temp;
				if(empty($col)){
					@$this->col_name=array_keys($row);
					$col=1;
				}
			};*/
		//}
		

		
		if(empty($this->result_array)&&$this->delete_target_flag){
			echo " 
			<script type='text/javascript'> 
				alert('Not found data  [ OR please fill line name too]'); 
			</script> 
			";		
			//$this->db->closs();
			//exit;
		}		
		//print_r($this->col_name);
		//@$this->col_name=array_keys($this->result_array[0]);
	}
	

	
	function make_csv_line($values){
		foreach($values as $i =>$value){
			if((strpos($value, ',') != false ) ||
				(strpos($value, '"') != false ) ||
				(strpos($value, ' ') != false ) ||
				(strpos($value, '\t') != false ) ||
				(strpos($value, '\n') != false ) ||
				(strpos($value, '\r') != false )) {
					$values[$i] = '"' . str_replace('"', '""', $value) . '"';
			}
		}
		return implode(',', $values) . "\n";
	} 

	
	function GenCSV($tbname){
		
		//check folder CSV exist?
		
		if(!is_dir('csv')){
			mkdir('csv');
		}
		
		//config file for csv file
		$file_csv=trim($tbname).".csv";
		$StorePath="/csv/$file_csv";
		if (file_exists($StorePath)){
			unlink ($StorePath);//delete file command
		}
		
		$path = ".\\csv\\$file_csv";
		$fh = fopen($path, 'wb');
			
		if($this->result_array){
			foreach($this->result_array as $row){
				
				if(empty($csvHeader)){
					foreach(array_keys($row) as $k ){
						$csvHeader=$csvHeader.",".strtoupper($k);
					}
					$csvHeader=substr($csvHeader,1,strlen($csvHeader));
					$csvHeader=$csvHeader;
					if(empty($writetofile)){
						fwrite($fh, $csvHeader."\n");
						$writetofile=true;
					}
				}
				
				if($search){
					foreach($this->col_name as $key =>$data){
						$$data=="";
					}
				}
				
				
				$csvData="";
				foreach($row as $k=>$v){
						if(empty($v))$v='-';
						$csvData[]=trim($v);
				}
					
					
				//csv--------------------------
					$csv = $this->make_csv_line($csvData);
					fwrite($fh, $csv);
				//-----------------------------
				
				
			}
			$csv='';
			if($fh)fclose($fh);
		}
		echo "
		<script type='text/javascript'>
			window.open('./csv/$file_csv','_blank');
			
		</script>";
	}
		
		
	function show_sql_result() { 
		//print_r($this->col_name);
		if($this->result_array){
			foreach($this->result_array as $key=>$row){
				@$this->col_name=array_keys($row);
				break;				
			}
		}
		
		if($this->result_array){
			echo '<table border=1 width=100%>';
			
			echo '<tr>';
			foreach($this->col_name as $data){
				echo '<td bgcolor=orange>'.$data;
			}		
			
			foreach($this->result_array as $key=>$data_array){
				echo '<tr>';
				foreach($data_array as $key2=>$data){
					echo '<td>'.$data;
				}
			};
			echo '</table>';
		}
		
	} 	
	
	function run_sql($sql){
		//print $sql;
		 $this->db->query($sql);
	}	
	
	function show_sql_result2() {
		//print_r($this->col_name);
		if($this->result_array){
			foreach($this->result_array as $key=>$row){
				@$this->col_name=array_keys($row);
				break;				
			}
		}
		
		
		if($this->result_array){
			echo '<table border=1 width=100%>';
			$i=1;
			foreach($this->result_array as $key=>$data_array){
				echo '<tr><td>'.$i;
				foreach($data_array as $key2=>$data){
					echo "<td bgcolor=orange>".$key2;
				}
				echo '<tr><td>';
				foreach($data_array as $key2=>$data){
					echo '<td>'.$data;
				}
				$i++;
			};
			echo '</table>';
		}
		
	} 	
	
	
//eregular	
	function Line($search)
	{
		IF(eregi('^[fF]{1}[a-zA-Z]{1,2}$',$search)){
			
			$this->line=$search;
			return $search;
		}
	}

	function Shift($search)
	{
		//IF(eregi('^[a-bA-B]{1}$',$search)) {
		IF(eregi('^(day|night)$',$search)) {
			
			$this->shift=$search;	
			return $search;
		}
	}
	
	function DateType($search)//2010-2099,(01,02,03,04,05,06,07,08,09,10,11,12),(01,02,03,04,05,06,07,08,09,10,11,12,13,14,15...31)
	{
		IF(eregi('^([2]{1})+0+([1-9]{1})+([0-9]{1})+-+([0-1]{1})+([0-9]{1})+-+([0-3]{1})+([0-9]{1})$' ,$search)){
			
			$this->shift_date=$search;		
			
			return $search;
		}
	}
	
	function MODEL($search)
	{
		IF(eregi('^([NnCcRcHh]{1})([0-9]{3,3})[0-9a-zA-Z]?',$search)) return $search;
	}	
	
	function getHour($search)
	{
		//return eregi('^[0-9]{7}$',$str);
		IF(eregi('^[0-9]{2}$',$search)) {
			$this->hour=$search;	
			return $search;
		}
	}	

	function Serial($search)
	{
		IF(eregi('^[0-9]{7}$',$search)) {
			$this->serial=$search;	
			return $search;
		}
	}

	function Serial2($search)
	{
		IF(eregi('^[0-9]{15}$',$search)) {
			$this->serial=$search;	
			return $search;
		}
	}

	function Prod_code($search)
	{
		IF(eregi('^[0-9]{8}$',$search)) {
			$this->prono=$search;	
			return $search;
		}
	}

	function Line_name($search)
	{
		IF(eregi('^[fF]{1}[a-zA-Z0-9]{1,2}',$search)){
			
			$this->line=$search;
			return $search;
		}
	}

	function judgment($search)
	{
		IF(eregi('^(OK|ok|NG|ng)',$search)){
			
			$this->judgment=$search;
			return $search;
		}
	}



	function ef_card($search)
	{
		IF(eregi('^[Pp]{1}[0-9]{12}$',$search)){
			
			$this->ef_card=$search;
			return $search;
		}
	}

//delet field in array
	function del_array($delete_target){
		//$key='hour';
		foreach($delete_target as $key){
			unset($this->sql_array[$key]);
		}
	}




	
//sql generate

	function sql_gen(){
		
		//print '<p>'.$sql.'<br>';
		
		sort($this->result_separate);
		$repear_shift_date=0;
		$repear_line=0;
		
		foreach($this->result_separate as $search){
			
			
			if($this->Line_name($search)){
				//$this->sql_array['line']="'".$this->Line_name($search)."'";
				$this->sql_array['line'][]="'".$this->Line_name($search)."'";
			}
			
			if($this->Shift($search)){
				$this->sql_array['line_shift']="'".$this->Shift($search)."'";
			}
			
			if($this->getHour($search)){
				if($this->delete_target_flag==0)  $this->sql_array['hour']="'".$this->getHour($search)."'";
			}			
			
			if($this->MODEL($search)){
				$this->sql_array['Model']=" like  '%".$this->MODEL($search)."%'";
			} 

			if($this->judgment($search)){
				$this->sql_array['judgment']="'".$this->judgment($search)."'";
			} 			
			
			
			if($this->Serial($search)){
				$this->sql_array['serial'][]="  '".$this->Serial($search)."'";
			} 	
			
			if($this->Serial2($search)){
				$this->sql_array['Serialno'][]="  '".$this->Serial2($search)."'";
			} 			
			
			
			if($this->ef_card($search)){
				$this->sql_array['ef_no'][]="  '".$this->ef_card($search)."'";
			} 	  
			
			
			
			if($this->Prod_code($search)){
				$this->sql_array['Prod_code']="  '".$this->Prod_code($search)."'";
			} 			
			
			if($this->DateType($search)){
				//if(!$repear_shift_date)$this->sql_array["DATE_FORMAT(Date_en,'%Y-%m-%d')"]="='".$this->DateType($search)."'";
				if(!$repear_shift_date)$this->sql_array["CONVERT(VARCHAR(10), Date_en, 120)"]="='".$this->DateType($search)."'";
				if($repear_shift_date)$this->sql_array["CONVERT(VARCHAR(10), Date_en, 120)"]=" BETWEEN ".substr($this->sql_array["CONVERT(VARCHAR(10), Date_en, 120)"],1)." and '".$this->DateType($search)."'";
				$repear_shift_date=1;
			}
			
		}
		
		$sql='';
		if($this->sql_array){
			$repear_op="";
			$where='';
			foreach($this->sql_array as $field_name =>$search){
				//line loop
				if($field_name=='line'){
					$comma="";
					foreach($search as $line_name){
						$line_in.=$comma.$line_name;
						$comma=',';
					}
					$where_array['line']="line in($line_in)";
					
				}else
				if($field_name=='hour'){
					$where_array[hour]='hour='.$search;
				}else
				if($field_name=='ef_no'){
					sort($this->sql_array['ef_no']);
					if(count($this->sql_array['ef_no'])==1)$where_array[ef_card]='ef_no='.$search[0];		
					if(count($this->sql_array['ef_no'])==2)$where_array[ef_card]="ef_no between $search[0] and $search[1]";	

					if(count($this->sql_array['ef_no'])>2){

						$comma="";
						foreach($this->sql_array['ef_no'] as $search_ef){
							$search_ef_.=$comma.$search_ef;
							$comma=',';
						}
						
						
						$where_array[ef_no]="ef_no in($search_ef_)";		
					}

	
				}else
				
				if($field_name=='Serialno'){
					sort($this->sql_array['Serialno']);
					if(count($this->sql_array['Serialno'])==1)$where_array[Serialno]='Serialno='.$search[0];		
					if(count($this->sql_array['Serialno'])==2)$where_array[Serialno]="Serialno between $search[0] and $search[1]";		

					if(count($this->sql_array['Serialno'])>2){

						$comma="";
						foreach($this->sql_array['Serialno'] as $search_Serialno){
							$search_Serialno_.=$comma.$search_Serialno;
							$comma=',';
						}
						
						$where_array[Serialno]="Serialno in($search_Serialno_)";	

					}



				}else	


				if($field_name=='serial'){
					sort($this->sql_array['serial']);
					if(count($this->sql_array['serial'])==1)$where_array[serial]='serial='.$search[0];		
					if(count($this->sql_array['serial'])==2)$where_array[serial]="serial between $search[0] and $search[1]";		
					if(count($this->sql_array['serial'])>2){

						$comma="";
						foreach($this->sql_array['serial'] as $search_Serial){
							$search_Serial_.=$comma.$search_Serial;
							$comma=',';
						}
						
						$where_array[serial]="serial in($search_Serial_)";	

					}




				}else				
				
				if($field_name=='PROD_ID'){
					sort($this->sql_array['PROD_ID']);
					if(count($this->sql_array['PROD_ID'])==1)$where_array[PROD_ID]='PROD_ID='.$search[0];		
					if(count($this->sql_array['PROD_ID'])==2)$where_array[PROD_ID]="PROD_ID between $search[0] and $search[1]";		
						
				}else{		
				
					$op ='=';
					//if($field_name=="DATE_FORMAT(Date_en,'%Y-%m-%d')" or $field_name=='MODEL' or $field_name=='line' )$op='';
					if($field_name=="CONVERT(VARCHAR(10), Date_en, 120)" or $field_name=='Model' or $field_name=='line' )$op='';
					//if($field_name=='Model_name' or $field_name=='line' )$op='';
					$where_other .= $repear_op.$field_name.$op.$search;
					$repear_op = ' and ';
					
				}

			}
			$where_array[other]=$where_other;
			
			$op=' ';
			foreach($where_array as $section){
				if($section)$where .= $op.$section;
				$op=' and ';
			}
			
			$this->where = ' WHERE '.$where;
		//	die;
		}else{
			
			echo " 
			<script type='text/javascript'> 
				alert('Please Check Correct Data'); 
			</script> 
			";		
			exit;
		}
	}

}


?>