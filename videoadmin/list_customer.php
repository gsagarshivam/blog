<?php
session_start();
require_once("inc/dbcn.php");
require_once("inc/iFunctions.php");
require_once("inc/req_authentication.php");
require_once("inc/formvalidator.php");
  

if((isset($_POST['cstatus'])))
{
$id=iClean($conn,$_POST['cstatus']);
$rs_del2=mysqli_fetch_array(mysqli_query($conn,"SELECT status FROM `customer_detail` WHERE auto_id='".$id."'"))or die(mysqli_error($conn));
if($rs_del2['status']==0)
{
$val=1; 
}
if($rs_del2['status']==1)
{
$val=0;  
}    
$sql2="update `customer_detail` set
status='".$val."'
where auto_id='".$id."'"; 
mysqli_query($conn,$sql2)or die(mysqli_error($conn));
}
///////////////////////////////////////////////////////
$datefrom=isset($_GET['datefrom'])?$_GET['datefrom']:'';
$dateto=isset($_GET['dateto'])?$_GET['dateto']:'';
$search_text=isset($_GET['search_text'])?$_GET['search_text']:'';
$new_user=isset($_GET['status'])?iClean($conn,$_GET['status']):'';
$per_page=isset($_GET['per_page_selected'])?$_GET['per_page_selected']:'20';
$get = $_GET;
foreach($get as $key=>$value) { //assuming you cleaned & validated the $_POST into $post
if($value!='')
  switch($key)
  {
    case 'status':
    $wheres[]="$key = '{$value}'";
    break;
    case 'search_text':
    $serachText = iClean($conn,$value);
    $wheres[]="(client_id LIKE '%{$serachText}%' OR m_name LIKE '{$serachText}%' OR m_mobile LIKE '{$serachText}%')";
    break;
    case 'datefrom':
    $key = 'join_date';
    $wheres[]="$key >= '".date('Y-m-d', strtotime($value))."'";
    break;
    case 'dateto':
    $key = 'join_date';
    $wheres[]="$key <= '".date('Y-m-d', strtotime($value))."'";
    break;
  }
}
if(empty($wheres)){$q = "";}
else{
$q=' WHERE ' . implode(' AND ', $wheres);
}

###############  Start Paging Code ##########################
require_once("inc/class.pagination.php");
$page = 1; //default page
$full_sql = "SELECT * FROM customer_detail $q ORDER BY auto_id DESC";
$num = mysqli_num_rows(mysqli_query($conn,$full_sql));    
$display_links = 11; //number of links to be displayed - odd number
//echo $full_sql;
if(isset($_REQUEST['page']))
$page = iClean($conn,$_REQUEST['page']);
//create object, pass the values
$cat_link = $_SERVER['SCRIPT_NAME']."?".$_SERVER['QUERY_STRING'];
//echo $cat_link;
$pageObj = new pagination($full_sql,$per_page,$page,$cat_link,$conn);
//sql after getting split in to pages
$sql = $pageObj->get_query();
$rsd = mysqli_query($conn,$sql);
//starting serial number
$sl_start = $pageObj->offset;
//get the links and store it in a variable
$page_links = $pageObj->get_links($display_links);
###############  End Paging Code ############################

?>
<!DOCTYPE html>
<html lang="en">
<head>
<title>List Customer : <?php echo COMPANY?></title>
<?php include("inc/common_head.php");?>
</head>
<body>
<div class="header-bg">
<?php include("inc/header.php");?>

</div>
 </div>
 <div class="wrapper">
 <div class="container-fluid">
 <div class="row">
 <div class="col-12">
 <div class="card">
 <div class="card-body">
 <h4 class="mt-0 header-title">List Customer</h4>
    <form name="frm1" method="GET" style="display: ;">
    <table>
    <tr>
    <!--<td><?php echo $package?></td>-->
    
    <td>
    <input type="text" name="search_text" value="<?php echo $search_text;?>"  placeholder="COde,Name,Mobile" class="form-control" style="width: 190px;"/>
    </td>
    <td>
    <select name="status" class="form-control" style="width: 90px;">
    <option value="">Status</option>
    <option value="0" <?php if($new_user=="0"){echo "selected";}?>>Inactive</option>
    <option value="1" <?php if($new_user=="1"){echo "selected";}?>>Active</option>
    </select>
    </td>
    <td>
    <select name="per_page_selected" onchange="this.form.submit()" class="form-control" style="width: 90px;">
    <option value="20"  <?php if($per_page==20){echo "selected";}else{echo "";}?>>20</option>
    <option value="100"  <?php if($per_page==100){echo "selected";}else{echo "";}?>>100</option>
    <option value="500"  <?php if($per_page==500){echo "selected";}else{echo "";}?>>500</option>
    <option value="1000"  <?php if($per_page==1000){echo "selected";}else{echo "";}?>>1000</option>
    <option value="10000"  <?php if($per_page==10000){echo "selected";}else{echo "";}?>>All</option>
    </select>
    </td>
    <td>
    <input type="date" name="datefrom" class="form-control"  id="paid_on" value="" style="width: 150px;" />    
    </td>
    <td>
    <input type="date" name="dateto" class="form-control"  id="paid_on1" value="" style="width: 150px;" /> 
    </td>
    <td>
    <input type="submit" name="validate" value="SEARCH" class="btn btn-primary"/>
    </td>
    </tr>
    </table>
    <br />
    Total Customer : <?php echo $num;?>
    </form>
    <!-- <button class="btn btn-success"  >Export</button><br /> -->
    <form method="POST" class="form-horizontal">   
    <div class="form-group row">
    <div class="col-sm-12">
        <div class="table-responsive">
    	<table class="table table-striped table-bordered" style="text-transform: uppercase;" id="table2excel">
            <thead>
            <tr>
            <th width="20">Sr.No</th>
            <th>Print</th>
            <th>Customer ID</th>
            <th>Customer Name</th>
            <th>Agent ID</th>
            <th>Email</th>
            <th>Mobile</th>
            <th>Address</th>
            <th>City</th>
            <th>State</th>
            <th>Pincode</th>
            <th style="width: 200px;">Block/Unblock</th>
            </tr>
            </thead>
            <tbody>
            <?php
            $i=1;
    		while($profile=mysqli_fetch_array($rsd))
    		{
            $client_id=$profile['client_id'];
            if($profile['status']==1)
            {
                $class = "btn btn-success btn-sm";
                $icon = "<i class=\"mdi mdi-account-check h5\"></i>";
                $background = "";
            } 
            else
            {
                $class = "btn btn-warning btn-sm";
                $icon = "<i class=\"mdi mdi-account-off h5\"></i>";
                $background="color: red;";
            }
            ?>
            <tr style="<?php echo $background?>">
            <td><?php echo $i;?>&nbsp;&nbsp;</td>
            <td>
            <a href="../clog/card_print.php?client=<?php echo $profile['client_id']?>" target="_blank"><i class="dripicons-print"></i></a>
            
            </td> 
            <td><?php echo $profile['client_id']?></td>
            <td><?php echo $profile['m_name']?></td>
            <td><?php echo $profile['client_intro_id']?></td>
    		<td><?php echo $profile['m_email']?></td>
            <td><?php echo $profile['m_mobile'];?></td>
            <td><?php echo $profile['m_address'];?></td>
            <td><?php echo $profile['m_city'];?></td>
            <td><?php echo $profile['m_state'];?></td>
            <td><?php echo $profile['m_pin'];?></td>  
    		<td>
            <button type="submit" name="cstatus" value="<?php echo $profile['auto_id']?>" class="<?php echo $class?>" onclick="return confirm('Are you sure you want to change status?')"><?php echo $icon?></button> 
            <a class="btn btn-info btn-sm" href="update_customer.php?client_id=<?php echo $profile['client_id'];?>"><i class="mdi mdi-pencil h5"></i></a>
            <!-- <a class="btn btn-danger btn-sm" href="add_wallet.php?aid=<?php //echo $rs1['id'];?>"><i class="mdi mdi-air-conditioner h5"></i></a>  -->

            </td>
            </tr>
    		<?php 
			$i++;
			 
            }
            ?>
            
           </tbody>
            </table>
            </div>
    </div>
    </div>
    <div class="form-group row">
    <div class="col-sm-12 pull-right">
        <?php echo $page_links; ?>     
    </div>
     </div>
    </form>

</div>
</div>
</div><!-- end col -->
</div><!-- end row -->
</div><!-- end container -->
</div>
<?php include("inc/footer.php");?>
<?php include("inc/footerjs.php");?>
</body>
</html>