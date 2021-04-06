<?php
   session_start();
   if(!isset($_SESSION['userid']) || $_SESSION['role']!='Admin')
   {
    header('Refresh:0;URL=error.php');
   }
   else{

   	
    require("libs/fetch_data.php");
    include("conn.php");
    if(isset($_POST['type']))
        {

          $id        = isset($_POST['del_id'])?$_POST['del_id']:'';
          $qry_update="DELETE FROM videos WHERE id='$id'";
          $res=mysqli_query($connect,$qry_update) or die(mysqli_error($connect));
          header("Location:listarticles.php");
        }


		
   ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>Add Category</title>
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
                                List Video Category
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
                <div class="page-titles">
  					   <ol class="breadcrumb">
  						    <li class="breadcrumb-item"><a href="javascript:void(0)">Articles</a></li>
  						    <li class="breadcrumb-item active"><a href="javascript:void(0)">Category List</a></li>
  					   </ol>
                </div>
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table id="example" class="display" style="width:100%">
                                        <thead>
                                            <tr>
                                               <th class="th-sm">S.No</th>
                                               <th class="th-sm">Video Category Name</th>
                                               <th class="th-sm">Video Title</th>
                                               <th class="th-sm">Video Content</th>
                                               <th class="th-sm">Status</th>
                                               <th class="th-sm">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                               include("conn.php");
                                               $x = "0";
                                               $result_set="SELECT * FROM videos ORDER BY id DESC" ;
                                               $result = mysqli_query($connect, $result_set) or die(mysqli_error($connect));
                                               $select = array();
                                               while( $row = mysqli_fetch_assoc($result) ) {
                                                       $select[] = $row;
                                                       }
                                               foreach ($select as $key => $row) {
                                                ?>
                                                 <tr>

                                                   <?php $category_id = $row['cat_id']; ?>
                                                   <?php $status      = $row['status']; ?>
                                                   <td scope="row"><?php echo ++$x; ?></td>
                                                   <td><?php getcategories($category_id) ?></td>
                                                   <td><?php echo $row['video_title']; ?> </td>
                                                   <td><?php echo $row['video_content']; ?> </td>

                                                   <?php if($status == 1){?>
                                                    <td>Active</td>
                                                   <?php }else{?>
                                                    <td>Deactive</td>
                                                   <?php }?>
                                                   <td>
                                                    <div class="d-flex">
                                                      <a href="<?php echo $base_url."videoadmin/editVideo.php?id=".$row['id'];?>" class="btn btn-primary shadow btn-xs sharp mr-1"><i class="fa fa-pencil"></i></a>
                                                    <form method="POST" action="">
                                                      <input type="hidden" name="type" value="DELETE">
                                                      <input type="hidden" name="del_id" value="<?php echo $row['id']; ?>">

                                                      <button type="submit" class="btn btn-danger shadow btn-xs sharp"><i class="fa fa-trash"></i></button>
                                                    </form>
                                                    </div>
                                                  </td> 
                                                </tr>
                                                <?php
                                               }
                                             ?>
                                        </tbody>
                                        
                                        
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
				        </div>
            </div>
        </div>

        <!-- Modal -->
            

          
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