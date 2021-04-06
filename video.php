<?php require("libs/fetch_data.php");?>
<?php //code to get the item using its id
include("database/conn.php");//database config file
?>
<!DOCTYPE html>
<html lang="zxx">
<head>
	<title>Video Category<?php getwebname("titles");?></title>
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta charset="utf-8">
	<link id="browser_favicon" rel="shortcut icon" href="blogadmin/images/<?php geticon("titles"); ?>">
	<meta charset="utf-8" name="description" content="<?php getshortdescription("titles");?>">
	<meta name="keywords" content="<?php getkeywords("titles");?>" />
	<script>
		addEventListener("load", function () {
			setTimeout(hideURLbar, 0);
		}, false);

		function hideURLbar() {
			window.scrollTo(0, 1);
		}
	</script>
	<style type="text/css">
		body { -webkit-font-smoothing: antialiased; text-rendering: optimizeLegibility; font-family: 'Roboto', sans-serif; letter-spacing: 0px; font-size: 16px; color: #7d7f82; font-weight: 400; line-height: 32px; }
h1, h2, h3, h4, h5, h6 { color: #26282c; margin: 0px 0px 12px 0px; font-family: 'Glegoo', serif; font-weight: 700; line-height: 1; }
h1 { font-size: 36px; }
h2 { font-size: 26px; line-height: 38px; }
h3 { font-size: 22px; line-height: 32px; }
h4 { font-size: 20px; }
h5 { font-size: 16px; line-height: 27px; }
h6 { font-size: 12px; }
p { margin: 0 0 20px; line-height: 1.7; }
p:last-child { margin: 0px; }
ul, ol { font-family: 'Roboto', sans-serif; }
a { text-decoration: none; color: #7d7f82; -webkit-transition: all 0.3s; -moz-transition: all 0.3s; transition: all 0.3s; }
a:focus, a:hover { text-decoration: none; color: #fe5b10; }



.video-testimonial-block { position: relative; width: auto; height: 206px; overflow: hidden; margin-bottom: 30px; }
.video-testimonial-block .video-thumbnail { height: 100%; width: 100%; position: absolute; z-index: 1; background-size: cover; top: 0; left: 0; }
.video-testimonial-block .video { }
.video-testimonial-block .video iframe { position: absolute; top: 0; left: 0; width: 100%; height: 100%; border: 0px; }
.video-testimonial-block .video-play { position: absolute; z-index: 2; top: 50%; left: 50%; margin-left: -40px; margin-top: -18px; text-decoration: none; }
.video-testimonial-block .video-play::before { content: "\f144"; font: normal normal normal 14px/1; font-family: 'Font Awesome\ 5 Free'; font-weight: 900; font-size: inherit; text-rendering: auto; -webkit-font-smoothing: antialiased; -moz-osx-font-smoothing: grayscale; font-size: 50px; color: #b3b5bc; }
.video-testimonial-block .video-play:hover::before { color: #172651; }
.mb10{margin-bottom:10px;}
.section-title { margin-bottom: 40px; }
	</style>
	<link href="css/bootstrap.css" rel='stylesheet' type='text/css' />
	<link rel="stylesheet" href="css/single.css">
	<link href="css/style.css" rel='stylesheet' type='text/css' />
	<link href="css/fontawesome-all.css" rel="stylesheet">
	<link href="//fonts.googleapis.com/css?family=Poppins:100,100i,200,200i,300,300i,400,400i,500,500i,600,600i,700,700i,800"
	    rel="stylesheet">
</head>
<body>
	<!--Header-->
	<?php include("header.php");?>
	<!--//header-->
	<!--/banner-->
	<div class="banner-inner">
	</div>
	<ol class="breadcrumb">
		<li class="breadcrumb-item">
			<a href="index.php">Home</a>
		</li>
		<li class="breadcrumb-item active">Video</li>
	</ol>
	<!--//banner-->
	<!--/main-->
	<section class="main-content-w3layouts-agileits">
		<div class="container">
			<h3 class="tittle">Video Posts</h3>

			

			<?php 
			require("database/db_connect.php");
			$sql="SELECT * FROM video_categories";
			$result=mysqli_query($con,$sql);

			foreach ($result as $key => $value): ?>
				<hr>
				 <div  class="video-testimonial-content">
	                <h4 class="mb10"><?php echo $value['name']; ?></h4>
	                <hr>
	             </div> <br>
	             <div class="row">
	            
	            <?php
	            $video_cat_id = $value['id'];
	            $video_sql="SELECT * FROM videos WHERE cat_id='$video_cat_id'";
	            $video_result=mysqli_query($con,$video_sql);
		            foreach ($video_result as $allvideokey => $allvideo):?>
			            <div class="col-xl-4 col-lg-4 col-md-12 col-sm-12 col-12">
		                    <div class="video-testimonial-block">
	                        	<div class="video">
		                            <iframe src="<?php echo $allvideo['video_content']; ?>" 
		                             title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen>
		                            </iframe>
	                        	</div>
		                    </div>
		                    <div class="video-testimonial-content">
		                        <p class="mb10"><?php echo isset($allvideo['video_title'])?$allvideo['video_title']:''; ?></p>
		                        
		                    </div>
		                </div> 

		            <?php	# code...
		          	endforeach;?>
		          </div>

				 <?php endforeach ?>
				
			
        </div>
    </div>
   
				
	</section>
	<!--//main-->

	<!--footer-->
	<?php include("footer.php");?>
	
</body>

</html>