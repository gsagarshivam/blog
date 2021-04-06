<?php

   session_start();
   if(!isset($_SESSION['userid']) || $_SESSION['role']!='Admin')
   {
    header('Refresh:0;URL=error.php');
   }
   else{

        include("conn.php");
        if(isset($_POST['add_articles']))
        {

            $blog_id                        = isset($_POST['blog_id'])?$_POST['blog_id']:'';
            $video_title                    = isset($_POST['video_title'])?$_POST['video_title']:'';
            $video_content                  = isset($_POST['video_content'])?$_POST['video_content']:'';
            
            $qry="INSERT INTO blog_video(blog_id,video_title,video_content)values('$blog_id','$video_title','$video_content')";
            $res=mysqli_query($connect,$qry) or die(mysqli_error($connect));
            header("Location:listarticles.php");
    }
        
   
   ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <link href="vendor/summernote/summernote.css" rel="stylesheet">
    <!-- Custom Stylesheet -->
    <link href="vendor/bootstrap-select/dist/css/bootstrap-select.min.css" rel="stylesheet">
    <link href="vendor/bootstrap-material-datetimepicker/css/bootstrap-material-datetimepicker.css" rel="stylesheet">
    <link href="css/style.css" rel="stylesheet">
    <title>Add Blog Video</title>
    <?php
        include("inc/head.php");

        
        
    ?>

</head>
<body>
    <div id="main-wrapper">
        <?php
            include("inc/nav.php");
        ?>
        <div class="header">
            <div class="header-content">
                <nav class="navbar navbar-expand">
                    <div class="collapse navbar-collapse justify-content-between">
                        <div class="header-left">
                            <div class="dashboard_bar">
                                Add Blog Video
                            </div>
                        </div>
                        <?php
                            include("inc/header.php");
                        ?>
                    </div>
                </nav>
            </div>
        </div>
        <?php
            include("inc/sidebar.php");
        ?>
        <div class="content-body">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="card">
                            <div class="card-header">
                                <h4 class="card-title">Add Video</h4>
                            </div>
                            <div class="card-body">
                                <div class="form-validation">
                                    <form class="form-valide" action="" method="POST" enctype="multipart/form-data">
                                        <input type="hidden" name="add_articles">
                                        <div class="row">
                                            <div class="col-xl-12">
                                                <div class="form-group row">
                                                    <label class="col-lg-4 col-form-label" for="val-skill">Blog Video Category
                                                        <span class="text-danger">*</span>
                                                    </label>
                                                    <div class="col-lg-8">

                                                        <?php $result_set="SELECT * FROM blogs ORDER BY id DESC"; 

                                                        $result = mysqli_query($connect, $result_set) or die(mysqli_error($connect)); ?>
                                                        <select class="form-control" name="blog_id" id="sel1">
                                                       <?php
                                                          foreach ($result as $key => $row) {
                                                        ?>
                                                          <option value="<?php echo $row['id']; ?>"><?php echo $row['title']; ?></option> 
                                                        <?php } ?>
                                                       </select>
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <label class="col-lg-4 col-form-label" for="val-email">Blog Video Title <span
                                                            class="text-danger">*</span>
                                                    </label>
                                                    <div class="col-lg-8">
                                                        <input type="text" class="form-control" id="val-email" name="video_title" placeholder="Fill Video Title">
                                                    </div>
                                                </div>
                                                
                                                
                                                <div class="form-group row">
                                                    <label class="col-lg-4 col-form-label" for="val-suggestions">Blog Video Url <span
                                                            class="text-danger">*</span>
                                                    </label>
                                                    <div class="col-lg-8">
                                                        <textarea class="form-control" id="article_keywords" name="video_content" rows="5" placeholder="What would you like to see?"></textarea>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-xl-12">
                                                <div class="form-group row">
                                                    <div class="col-lg-8 ml-auto">
                                                        <button type="submit" class="btn btn-primary">Submit</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
         <?php
            include("inc/footer.php");
         ?>
    </div>
    <script src="vendor/global/global.min.js"></script>
    <script src="js/custom.min.js"></script>
    <script src="js/plugins-init/datatables.init.js"></script>
     <script src="https://code.jquery.com/jquery-3.5.1.js"></script>
     <script src="https://cdn.datatables.net/1.10.23/js/jquery.dataTables.min.js"></script>
     <script src="https://cdn.datatables.net/buttons/1.6.5/js/dataTables.buttons.min.js"></script>
     <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
     <script src="https://cdn.datatables.net/buttons/1.6.5/js/buttons.html5.min.js"></script>

    <script src="vendor/global/global.min.js"></script>
    <script src="vendor/bootstrap-select/dist/js/bootstrap-select.min.js"></script>
    <script src="js/custom.min.js"></script>
    <script src="js/deznav-init.js"></script>

    <!-- Summernote init -->
    <script src="js/plugins-init/summernote-init.js"></script>
     <script src="vendor/summernote/js/summernote.min.js"></script>
    <!-- Summernote init -->
   
    <script type="text/javascript">
        $(document).ready( function() {
            $('#example').DataTable( {
             //    dom: 'Bfrtip',
             //    buttons: [ {
             //        extend: 'excelHtml5',
             //        autoFilter: true,
             //        sheetName: 'Exported data',
             //        text: 'Export',
             //        className: 'btn btn-primary'

             //    }
                
                
             // ]
            } );
        } );
    </script>

</body>
</html>
<?php } ?>