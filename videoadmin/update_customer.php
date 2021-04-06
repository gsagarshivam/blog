<?php
session_start();
require_once("inc/dbcn.php");
require_once("inc/iFunctions.php");
require_once("inc/req_authentication.php");
require_once("inc/formvalidator.php");
require_once('inc/imclass.php');
$client=iClean($conn,$_GET['client_id']);
$member_id=mysqli_fetch_array(mysqli_query($conn,"select * from customer_detail where client_id='".$client."'"));

$join_date=isset($_POST['join_date'])?$_POST['join_date']:$acc_profile['join_date'];



$m_status=isset($_POST['m_status'])?$_POST['m_status']:$member_id['m_status'];

$client_intro_id=isset($_POST['client_intro_id'])?$_POST['client_intro_id']:$member_id['client_intro_id'];
$client_id=isset($_POST['client_id'])?$_POST['client_id']:$member_id['client_id'];
$person_name=isset($_POST['person_name'])?$_POST['person_name']:$member_id['m_name'];
$dob=isset($_POST['dob'])?$_POST['dob']:$member_id['m_dob'];
$address=isset($_POST['address'])?$_POST['address']:$member_id['m_address'];
$address2=isset($_POST['address2'])?$_POST['address2']:$member_id['address2'];
$city=isset($_POST['city'])?$_POST['city']:$member_id['m_city'];
$state1=isset($_POST['state'])?$_POST['state']:$member_id['m_state'];
$pin=isset($_POST['pin'])?$_POST['pin']:$member_id['m_pin'];

$email=isset($_POST['email'])?$_POST['email']:$member_id['m_email'];
$mobile=isset($_POST['mobile'])?$_POST['mobile']:$member_id['m_mobile'];
$pan_no=isset($_POST['pan_no'])?$_POST['pan_no']:$member_id['m_pan'];
$adhar_no=isset($_POST['adhar_no'])?$_POST['adhar_no']:$member_id['adhar_no'];
$f_name=isset($_POST['f_name'])?$_POST['f_name']:$member_id['m_father_name'];
$m_name=isset($_POST['m_name'])?$_POST['m_name']:$member_id['m_mother_name'];

$illness=isset($_POST['illness'])?$_POST['illness']:$member_id['illness'];
$description=isset($_POST['description'])?$_POST['description']:$member_id['description'];




//$product=mysqli_fetch_array(mysqli_query("SELECT * FROM `stu_product` WHERE pro_id='".$pro_name."'"));
if(isset($_POST['submit']))
{
	$validator = new FormValidator();
    
    $validator->addValidation("person_name","req","Please enter your name");
	$validator->addValidation("dob","req","Please enter date of birth");


      if($validator->ValidateForm())
    	{
        if(!empty($_FILES["myfile"]["name"]))
        {
        if(($_FILES["myfile"]["type"]=="image/jpeg")||($_FILES["myfile"]["type"]=="image/png")||($_FILES["myfile"]["type"]=="image/gif")||($_FILES["myfile"]["type"]=="image/pjpeg")||($_FILES["myfile"]["type"]=="image/x-png"))
        {
        $target="../upload/useruploads/";
        $filename=basename($_FILES["myfile"]["name"]);
        $target.=$filename;
        $tmp_file=$_FILES["myfile"]["tmp_name"];
        // move_uploaded_file($tmp_file,$target);
        $image = new SimpleImage();
        $image->load($tmp_file);
        $image->resizeToWidth(120);
        $filname=rand().$filename;
        $image->save($filname,'../upload/useruploads/');
        }
        }
        else{
        $filname=$member_id['photo'];
        }
	     $sql="UPDATE `customer_detail` SET 
           `client_intro_id`='".iClean($conn,$_POST['client_intro_id'])."',
           `m_name`='".iClean($conn,$_POST['person_name'])."',
           `m_dob`='".iClean($conn,$_POST['dob'])."',
           `m_address`='".iClean($conn,$_POST['address'])."',
           `address2`='".iClean($conn,$_POST['address2'])."',
           `m_city`='".iClean($conn,$_POST['city'])."',
           `m_state`='".iClean($conn,$_POST['state'])."',
           `m_pin`='".iClean($conn,$_POST['pin'])."',

           `m_status`='".iClean($conn,$_POST['m_status'])."',
           
           `adhar_no`='".iClean($conn,$_POST['adhar_no'])."',
           `m_pan`='".iClean($conn,$_POST['pan_no'])."',
           `m_mobile`='".iClean($conn,$_POST['mobile'])."',
           `m_email`='".iClean($conn,$_POST['email'])."',
           `m_father_name`='".iClean($conn,$_POST['f_name'])."',
           `m_mother_name`='".iClean($conn,$_POST['m_name'])."',
           
           `illness`='".iClean($conn,$_POST['illness'])."',
           `description`='".iClean($conn,$_POST['description'])."',
           
            photo='".$filname."'
           WHERE client_id ='".$client."'";
           mysqli_query($conn,$sql)or die(mysqli_error($conn));
            $msg = "Details Updated Sucessfully";

    }
    else
    {
        $validation_errors='';    
    
        $error_hash = $validator->GetErrors();
        foreach($error_hash as $inpname => $inp_err)
        {
           $validation_errors .= "<p>$inp_err</p>\n";
        }        
    }
}
$result_con1=mysqli_query($conn,"SELECT * FROM `states`");
$state="<select name=\"state\" style=\"width:250px;\" class=\"form-control\">";
$state.="<option value=\"$state1\">$state1</option>";
while($row_con1=mysqli_fetch_array($result_con1))
{
if($state1==$row_con1['state']){$selected='selected';}else{$selected="";}
$state.="\t<option value='".$row_con1['state']."' ".$selected.">".$row_con1['state']."</option>\n";	
$selected="";
}
$state.="</select>\n";
?>
<!DOCTYPE html>
<html lang="en">
<head>
<title>Update Customer: <?php echo COMPANY?></title>
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
 <h4 class="mt-0 header-title">Update Customer</h4>
<form name="frm1" method="POST" enctype="multipart/form-data">
   <?php if(isset($validation_errors)){echo "<div class=\"alert alert-danger bg-danger text-white mb-0\">".$validation_errors."</div>";}?>
   <?php if(isset($msg)){echo "<div class=\"alert alert-danger bg-success text-white mb-0\">".$msg."</div>";}?><br />
    <table class="table table-striped table-bordered">
    <tr class="alert alert-danger bg-info text-white mb-0">
        <th colspan="3">Member Details</th>
    </tr> 
    <tr>
        <td>Customer Code:</td>
        <td><input type="text" name="client_id"  value="<?php echo $client_id;?>" class="form-control" readonly="readonly"/></td>
        <td rowspan="4" ><?php if($member_id['photo']!=""){echo "<img src=\"../upload/useruploads/".$member_id['photo']."\" width=\"120px\"/>";}
        else{echo "<img src=\"../clog/upload/nophoto.jpg\" width=\"120px\"/>";}?><br /><input type="file" name="myfile"/></td>
    </tr>
    <tr>
        <td>Sponsor ID:</td>
        <td><input type="text" name="client_intro_id"  value="<?php echo $client_intro_id;?>" class="form-control"/></td>
        
    </tr>
    <tr>
        <td>Full Name:</td>
        <td><input type="text" name="person_name"  value="<?php echo $person_name;?>" class="form-control"/></td>
        
    </tr>       
    
    <tr>
        <td>DOB:</td>
        <td><input type="date" name="dob"  id="dob" class="form-control"size="30" value="<?php if($dob!=""){ echo date('Y-m-d',strtotime($dob));}?>" style="width: 190px;" /></td>
    </tr>
    
    <tr>
        <td>Address1:<span class="note"></span></td>
        <td colspan="2"><input type="text"  name="address"  value="<?php echo $address;?>" class="form-control"/></td>
    </tr>
    <tr>
        <td>Address2:<span class="note"></span></td>
        <td colspan="2"><input type="text"  name="address2"  value="<?php echo $address2;?>" class="form-control"/></td>
    </tr>
    <tr>
        <td>City:</td>
        <td colspan="2"><input type="text" name="city"  value="<?php echo $city;?>" class="form-control"/></td>
    </tr>
    <tr>
        <td>State:</td>
        <td colspan="2"><?php echo $state;?></td>
    </tr>
    
    <tr>
        <td>Pin Code:</td>
        <td colspan="2"><input type="text" name="pin"  value="<?php echo $pin;?>" class="form-control"/></td>
    </tr>
    
    <tr class="alert alert-danger bg-info text-white mb-0">
    <th colspan="3">Bank Details</th>
    </tr>
    <tr>
        <td>Mobile:</td>
        <td colspan="2"><input type="text" name="mobile"  value="<?php echo $mobile;?>" class="form-control"/></td>
    </tr> 
    <tr>
        <td>Email:</td>
        <td colspan="2"> <input type="text" name="email"  value="<?php echo $email;?>" class="form-control"/></td>
    </tr>
              
    
    <tr>
    <td>Pan No:</td>
    <td colspan="2"><input type="text" name="pan_no"  value="<?php echo $pan_no;?>" class="form-control"/></td>
    
    </tr>
    <tr>
    <td>Adhar No:</td>
    <td colspan="2"><input type="text" name="adhar_no"  value="<?php echo $adhar_no;?>" class="form-control"/></td>
    </tr>
    <tr>
    <td>Father's Name:</td>
    <td colspan="2"><input type="text" name="f_name"  value="<?php echo $f_name;?>" class="form-control"/></td>
    </tr>
    <tr>
    <td>Mother's Name:</td>
    <td colspan="2"><input type="text" name="m_name"  value="<?php echo $m_name;?>" class="form-control"/></td>
    </tr>
    <tr class="alert alert-danger bg-info text-white mb-0">
    <th colspan="3">Any Illness</th>
    </tr>
    <tr>
    <td>Any Illness:</td>
    <td colspan="2">
    <div class="form-group" style="margin-top: 10px;">
                                    <span class=""> 
                                        <input type="radio" <?php if($illness=='Yes'){echo "checked";}else{echo "";}?> class="with-gap" name="illness" id="chkNo" value="Yes" />
                                        <label for="chkNo">Yes</label>
                                    </span>
                                    <span class="">
                                        <input type="radio" <?php if($illness=='No'){echo "checked";}else{echo "";}?> class="with-gap" name="illness" id="chkYes" value="No" />
                                        <label for="chkYes">No</label>
                                    </span>
                                </div>
    </td>
    </tr>
    <tr>
    <td>Description:</td>
    <td colspan="2"><textarea class="form-control" placeholder="Describe" name="description"   ><?php echo $description;?></textarea></td>
    </tr>
    <tr>
    <td align="center" colspan="3"><input type="submit" class="btn btn-info" name="submit" value="Update Now" /></td>
    </tr> 
    </table>
    </form>
</div>
</div>
</div>
</div>
</div>
</div>
                          
<?php include("inc/footer.php");?>
<?php include("inc/footerjs.php");?>
</body>
</html>