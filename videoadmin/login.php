<?php ob_start();

    ?>
<!DOCTYPE html>
<html lang="en" class="h-100">


<!-- Mirrored from fito.dexignzone.com/xhtml/page-login.html by HTTrack Website Copier/3.x [XR&CO'2014], Tue, 09 Feb 2021 07:33:51 GMT -->
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>Video Dashboard</title>
    <!-- Favicon icon -->
    <link rel="icon" type="image/png" sizes="16x16" href="images/favicon.png">
    <link href="css/style.css" rel="stylesheet">

    <script>
       function validate(){
         
            var user=document.getElementById('username').value;
            var pass=document.getElementById('password').value;
           
            if(user != '00001' || pass != 'KidneyCare@@1'){
                $(document).ready(function(){
                    $(".text").html("<b><span  class='alert alert-primary alert-dismissible fade show' style='margin-top:10px;'>Invalid Credentials!.</span>");
                });
                  
                return false;
            }
           return true;
        }
    </script>

</head>

<body class="h-100">
    <?php
        
        require 'conn.php';
        if(isset($_POST['submit'])){
            @session_start();
            $hash1 = (isset($_POST['username'])) ? trim($_POST['username'])  : '';
            $hash2 = (isset($_POST['password'])) ? $_POST['password'] : '';
            $hash_password=mysqli_real_escape_string($connect,$hash2);
            $hash_id=mysqli_real_escape_string($connect,$hash1);
            $pass=$_POST['password'];
            $query="SELECT * from user where user_name=".$hash_id." and passwd='".$hash_password."'";
            $run=mysqli_query($connect,$query) or mysqli_error($connect);


            if(mysqli_num_rows($run) > 0){
                $row=mysqli_fetch_assoc($run);
                $_SESSION['role']=$row['rights'];
                $_SESSION['userid']=$row['user_name'];
                header("Location: index.php");
            }
            else{
                ?>
                <script>
                    
                </script>
                <?php
            }
        }
        ?>
    <div class="authincation h-100">
        <div class="container h-100">
            <div class="row justify-content-center h-100 align-items-center">
                <div class="col-md-6">
                    <div class="authincation-content">
                        <div class="row no-gutters">
                            <div class="col-xl-12">
                                <div class="auth-form">
                                    <h4 class="text-center mb-4">Sign in your account</h4>
                                    <form method="POST" action="login.php" onsubmit="return validate();">
                                        <div class="form-group">
                                            <label class="mb-1"><strong>Email</strong></label>
                                            <input class="form-control" type="text" name="username" id="username" placeholder="Username" required="">
                                        </div>
                                        <div class="form-group">
                                            <label class="mb-1"><strong>Password</strong></label>
                                            <input class="form-control" type="password"  name="password" id="password" placeholder="Password" required="">
                                        </div>
                                        <!-- <div class="form-row d-flex justify-content-between mt-4 mb-2">
                                            <div class="form-group">
                                               <div class="custom-control custom-checkbox ml-1">
													<input type="checkbox" class="custom-control-input" id="basic_checkbox_1">
													<label class="custom-control-label" for="basic_checkbox_1">Remember my preference</label>
												</div>
                                            </div>
                                            <div class="form-group">
                                                <a href="page-forgot-password.html">Forgot Password?</a>
                                            </div>
                                        </div> -->
                                        <div style="margin-top: 33px; margin-bottom: 20px; width: 800px !important;" class="text"></div>
                                        <hr>
                                        <div class="text-center">
                                            <button id="btn1" type="submit" name="submit" class="btn btn-primary btn-block">Sign Me In</button>
                                            
                                        </div>
                                    </form>
                                    <!-- <div class="new-account mt-3">
                                        <p>Don't have an account? <a class="text-primary" href="page-register.html">Sign up</a></p>
                                    </div> -->
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <!--**********************************
        Scripts
    ***********************************-->
    <!-- Required vendors -->
    <script src="vendor/global/global.min.js"></script>
	<script src="vendor/bootstrap-select/dist/js/bootstrap-select.min.js"></script>
    <script src="js/custom.min.js"></script>
    <script src="js/deznav-init.js"></script>

</body>


<!-- Mirrored from fito.dexignzone.com/xhtml/page-login.html by HTTrack Website Copier/3.x [XR&CO'2014], Tue, 09 Feb 2021 07:33:51 GMT -->
</html>