<?php

   session_start();
   if(!isset($_SESSION['userid']) || $_SESSION['role']!='Admin')
   {
    header('Refresh:0;URL=error.php');
   }
   else{

   		include("conn.php");
		if(isset($_POST['add_category']))
		{
			// echo "<pre>"; print_r($_POST); echo "</pre>"; 
			// echo "<pre>"; print_r($_FILES); echo "</pre>"; die();
		    $category         		 = isset($_POST['category'])?$_POST['category']:'';
		    $qry="INSERT INTO k_category_video(category)values('$category')";
		    $res=mysqli_query($connect,$qry) or die(mysqli_error($connect));
		    header("Location:addCategory.php");
		}
		if(isset($_POST['add_sub_category']))
		{

			// echo "<pre>"; print_r($_POST); echo "</pre>"; 
			// echo "<pre>"; print_r($_FILES); echo "</pre>"; die();
		  $subcategory         		 = isset($_POST['sub_category'])?$_POST['sub_category']:'';
		  $category_id         		 = isset($_POST['category_id'])?$_POST['category_id']:'';

		  $qry="INSERT INTO k_subcategory(sub_category,category_id)values('$subcategory','$category_id')";
		  $res=mysqli_query($connect,$qry) or die(mysqli_error($connect));
		  header("Location:addCategory.php");
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
                                Add Category
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
                            <div class="card-header">
                                <button type="button"  class="btn btn-primary mb-2" data-toggle="modal" data-target="#categorymodel">Add Category</button>

                                <button type="button"  class="btn btn-primary mb-2" data-toggle="modal" data-target="#subcategorymodel">Add Sub Category</button>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table id="example" class="display" style="width:100%">
                                        <thead>
                                            <tr>
                                               <th class="th-sm">S.No</th>
                                               <th class="th-sm">Category Name</th>
                                               <th class="th-sm">Sub Category Name</th>
                                               <th class="th-sm">Action</th>
                                            </tr>
                                        </thead>
                                        
                                        <tbody>
                                            <?php
                                               include("conn.php");
                                               $x = "0";
                                               $result_set="SELECT k_category.category,k_subcategory.sub_category FROM k_category,k_subcategory  WHERE k_subcategory.category_id = k_category.id;" ;
                                               $result = mysqli_query($connect, $result_set) or die(mysqli_error($connect));
                                               $select = array();
                                               while( $row = mysqli_fetch_assoc($result) ) {
                                                       $select[] = $row;
                                                       }
                                               foreach ($select as $key => $row) {
                                                ?>
                                                 <tr>
                                                   <th scope="row"><?php echo ++$x; ?></th>
                                                   <td><?php echo $row['category']; ?> </td>
                                                   <td><?php echo $row['sub_category']; ?> </td>
                                                   <td>
													<div class="d-flex">
														<a href="#" class="btn btn-primary shadow btn-xs sharp mr-1"><i class="fa fa-pencil"></i></a>
														<a href="#" class="btn btn-danger shadow btn-xs sharp"><i class="fa fa-trash"></i></a>
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
            <div class="modal fade" id="subcategorymodel">
                <div class="modal-dialog modal-dialog-centered" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">Add SubCategory</h5>
                            <button type="button" class="close" data-dismiss="modal"><span>&times;</span>
                            </button>
                        </div>
                        <form action ="#" method="POST" enctype="multipart/form-data">
                        	<input type="hidden" name="add_sub_category">
		                	<div class="modal-body card-body">
		                        <div class="basic-form">
	                                <div class="form-group row">
	                                    <label class="col-sm-3 col-form-label">Sub Category Name</label>
	                                    <div class="col-sm-9">
	                                    	<?php $result_set="SELECT * FROM k_category ORDER BY id DESC"; 

	                                    	   $result = mysqli_query($connect, $result_set) or die(mysqli_error($connect)); ?>
                                               <select class="form-control" name="category_id" id="sel1">

                                               <?php
	                                    	      foreach ($result as $key => $row) {
                                                ?>
                                               	  <option value="<?php echo $row['id']; ?>"><?php echo $row['category']; ?></option> 
                                                <?php } ?>
                                               </select>
	                                    </div>
	                                </div>
		                        </div>
		                        <div class="basic-form">
	                                <div class="form-group row">
	                                    <label class="col-sm-3 col-form-label">Sub Category</label>
	                                    <div class="col-sm-9">
	                                        <input type="text" name="sub_category" class="form-control" placeholder="Fill Sub Category Name">
	                                    </div>
	                                </div>
		                        </div>
		                    </div>
		                    <div class="modal-footer">
		                        <button type="button" class="btn btn-danger light" data-dismiss="modal">Close</button>
		                        <button type="submit" class="btn btn-primary">Save changes</button>
		                    </div>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Modal -->
            <div class="modal fade" id="categorymodel">
                <div class="modal-dialog modal-dialog-centered" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">Add Category</h5>
                            <button type="button" class="close" data-dismiss="modal"><span>&times;</span>
                            </button>
                        </div>
                        <form action ="" method="POST" enctype="multipart/form-data">
                        	<input type="hidden" name="add_category">
		                	<div class="modal-body card-body">
		                        <div class="basic-form">
	                                <div class="form-group row">
	                                    <label class="col-sm-3 col-form-label">Category</label>
	                                    <div class="col-sm-9">
	                                        <input type="text" name="category" class="form-control" placeholder="Fill Category Name">
	                                    </div>
	                                </div>
		                        </div>
		                    </div>
		                 
		                    <div class="modal-footer">
		                        <button type="button" class="btn btn-danger light" data-dismiss="modal">Close</button>
		                        <button type="submit" class="btn btn-primary">Save changes</button>
		                    </div>
                        </form>
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