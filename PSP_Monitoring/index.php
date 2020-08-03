<script src="jquery-3.5.1.min.js" type="text/javascript"></script>

<?php 
include 'time.php';
include 'template.php';

$datetime;
$refresh_interval;
foreach ($time_stamp as $value) {
   $datetime = $value['datetime'];
}
?>

<style>
  .nav{
    background-color: black;
    color: white;
  }
    a:link, a:visited {
    color: white;
    text-decoration: none;
    cursor: auto;
}
</style>

<script type="text/javascript">

var Refresh_Interval = 1000;
var refreshIntervalId;

todo_list()

function todo_list(){
    get_psp_data("am","#am-data");
    get_psp_data("mcl","#mcl-data");
};

function get_psp_data(data_name,id){
  var index = -1;
  $.get("pspData.php?pspData=" + data_name +"&ran="+Math.random() , function(data) {
    var result = $.parseJSON(data);
    var color
    if(data_name == 'am')
      color = 'blue'
    else if(data_name == 'mcl')
      color = 'green'
    data_fill_to_table = '<tbody>';
    data_fill_to_table +=  '<tr style="background-color: '+color+'; color: white">';
    data_fill_to_table += '<th colspan='+(result.product)+'>PRODUCTION</th>';
    data_fill_to_table += '<th colspan='+(result.part)+'>PART</th>';
    data_fill_to_table += '<th colspan='+(result.next-2)+'>NEXT</th>';
    data_fill_to_table += '</tr>';
    data_fill_to_table += '<tr style="background-color: '+color+'; color: white">';
  
    $.each(result.header,function(key, VALUE) {
      if(VALUE != 'Part_Min' && VALUE != 'Refresh_Sec')
        data_fill_to_table += '<th>'+VALUE+'</th>';
    })
    
    data_fill_to_table += '</tr>';    
    
    $.each(result,function(key, VALUE) {
          if(typeof(VALUE.Refresh_Sec)=='number'){
            Refresh_Interval = VALUE.Refresh_Sec;
          }
          
          if(key=="1" || key=="2" || key=="3"){

            var diff = VALUE.Lot_Qty - VALUE.Output_Qty;
            var alertcolor ="white";
            if (VALUE.Part_Remain < VALUE.Part_Min)
              var alertcolor ="red";

              data_fill_to_table += "<tr style = 'color:";
              data_fill_to_table += alertcolor +"'>";
              
              index++
              $.each(result.body[index],function(key, val) {
                if(val == null){      
                  val = "";
                }
                if(key != 'Part_Min' && key != 'Refresh_Sec')
                data_fill_to_table += '<th>'+val+'</th>';
              })

              data_fill_to_table += "</tr>";
          }
        });

        
       data_fill_to_table += '</tbody>';
       data_fill_to_table += '</table>';

       if(id=='#am-data'){
         $("#am-data tr").remove();
       }
       if(id=='#mcl-data'){
         $("#mcl-data tr").remove();
       }
        
    $(id).append(data_fill_to_table);
			clearInterval(refreshIntervalId);
    
    if(id == "#am-data"){
      $("#refresh-am").html("Refresh every "+Refresh_Interval+" sec.");  
      refreshIntervalId = setInterval('todo_list()',1000*Refresh_Interval);
      console.log("refresh-am => "+Refresh_Interval);  
    }
    else if(id == "#mcl-data"){
      $("#refresh-mcl").html("Refresh every "+Refresh_Interval+" sec.");
      refreshIntervalId = setInterval('todo_list()',1000*Refresh_Interval);  
      console.log("refresh-mcl => "+Refresh_Interval);  
    } 
  });
}

setInterval(function() {
    <?php 
      date_default_timezone_set("Asia/Bangkok");
      $db = $datetime;
      $timestamp = strtotime($db);          
    ?>
    $(".current-time").html("<?php echo date("d-m-Y H:i:", $timestamp); ?>" + new Date().getSeconds());
}, 1000);

if(Refresh_Interval==5){
  console.log(Refresh_Interval);
    clearInterval(refreshIntervalId);
		refreshIntervalId = setInterval('todo_list()',1000*Refresh_Interval);
}
</script>

<!DOCTYPE html>
<html lang="en">
   <head>
      <meta charset="utf-8">
      <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
      <meta http-equiv="x-ua-compatible" content="ie=edge">
      <meta name="description" content="Askbootstrap">
      <meta name="author" content="Askbootstrap">
      <title>PSP</title>
      <link rel="icon" type="image/png" href="img.png">


<div id="nav">
 <ul class="nav nav-tabs" id="myTab" role="tablist">
  <li class="nav-item">
    <a class="nav-link active" id="home-tab" data-toggle="tab" href="#am" role="tab" aria-controls="home" aria-selected="true">AM</a>
  </li>
  <li class="nav-item">
    <a class="nav-link" id="profile-tab" data-toggle="tab" href="#mcl" role="tab" aria-controls="profile" aria-selected="false">MCL</a>
  </li>
</ul> 
</div>

<body style="background-color: black;color:white">
  <div class="tab-content" id="nav-tabContent" style="background-color: black;color:white">
    <br>

  <div class="tab-pane fade show active" id="am" role="tabpanel" aria-labelledby="home-tab">
  
  <div class="row">
        <div class="col-md-7">
          <h1 style="float: left;">PART SUPPLY PLAN(PSP) VER. AM</h1>
        </div>
        <div class="col-md-3">
          <div id="refresh-am" style="margin-right:20px; padding-top:5px;font-size: 25px;"></div>
        </div>
        <div class="col-md-2">
          <div class="current-time" style="float: right; margin-right:20px; padding-top:5px;font-size: 25px;"></div>
        </div>
      </div>

    <div id="am-data-table"></div>
    <table id="am-data" class="table table-bordered" style="text-align: center;background-color: black; color: white"></table>
  </div>

  <div class="tab-pane fade" id="mcl" role="tabpanel" aria-labelledby="profile-tab">
  <div class="row">
        <div class="col-md-7">
          <h1 style="float: left;">PART SUPPLY PLAN(PSP) VER. MCL</h1>
        </div>
        <div class="col-md-3">
          <div id="refresh-mcl" style="margin-right:20px; padding-top:5px;font-size: 25px;"></div>
        </div>
        <div class="col-md-2">
          <div class="current-time" style="float: right; margin-right:20px; padding-top:5px;font-size: 25px;"></div>
        </div>
      </div>
  
  <div id="mcl-data-table"></div>
    <table id="mcl-data" class="table table-bordered" style="text-align: center;background-color: black; color: white"></table>
  </div>
</div>
</body>
</html>