
<?php
// This is to include the database connection file 
session_start();
$message = "";
require_once '../machine-test1/connection.php';
if (isset($_SESSION['student_session_id'])) {

    $s_session = $_SESSION['student_session_id'];
    $sql = $conn->prepare("Select * from students where session_id = ?");
    $sql->execute([$s_session]);
    if (!($sql->rowCount() > 0)) {
        header("location:/machine_test/machine-test1/login.php");
    }
} else {
    header("location:/machine_test/machine-test1/login.php");
}

// This is to upload the blog and file 
if(isset($_POST['post_now'])){
    $title = $_POST['title'];
    $description = $_POST['description'];
    $blogImage = $_FILES['image'];
    $filename = $_FILES['image']['name'];
    $file_tmp = $_FILES['image']['tmp_name'];
    // move_uploaded_file($file_tmp, "../machine-test1/blog_images/" . $filename);
    move_uploaded_file($file_tmp, "../machine-test1/blog_images/" . $filename);
   $s_id= $_SESSION['student_id'];


    $insert_blog = $conn->prepare("Insert INTO blogs (student_id, title, blog_image, description) values (?, ?, ?, ?)");
    $insert_blog->execute([$s_id, $title, $filename, $description]);
    if($insert_blog->rowCount()>0){
        $message = "success";
    }

}




?>
<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

    <title>Student Register</title>
    <style>
        @import "bourbon";

body {
	background: #eee !important;	
}

.wrapper {	
	margin-top: 80px;
  margin-bottom: 80px;
}

.form-blog {
  max-width: 380px;
  padding: 15px 35px 45px;
  margin: 0 auto;
  background-color: #fff;
  border: 1px solid rgba(0,0,0,0.1);  

  .form-blog-heading,
	.checkbox {
	  margin-bottom: 30px;
	}

	.checkbox {
	  font-weight: normal;
	}

	.form-control {
	  position: relative;
	  font-size: 16px;
	  height: auto;
	  padding: 10px;
		@include box-sizing(border-box);

		&:focus {
		  z-index: 2;
		}
	}

	input[type="text"] {
	  margin-bottom: -1px;
	  border-bottom-left-radius: 0;
	  border-bottom-right-radius: 0;
	}

	input[type="password"] {
	  margin-bottom: 20px;
	  border-top-left-radius: 0;
	  border-top-right-radius: 0;
	}
    .text_link{
        text-decoration: none;
        text-align: center;
    }
}


    </style>
</head>

<body>
    <div class="wrapper">

        <form accept="#" class="form-blog" method="post" enctype="multipart/form-data">


        <h2 class="form-blog-heading">Post Your Blog</h2>
            <div class="">
                <label class="form-label" for="title ">Blog Title<span class="txt-danger"></span></label>
                <input class="form-control" type="text" id="title" name="title" placeholder="Enter Title">
                <div class="valid-feedback">Looks good!</div>

            </div>

            <div class="">
                <label class="form-label" for="title ">CHoose Image<span class="txt-danger"></span></label>
                <input class="form-control" type="file" id="image" name="image">
                <div class="valid-feedback">Looks good!</div>

            </div>

            <div class="">
                <label class="form-label" for="description">Description<span class="txt-danger"></span></label>
                <input class="form-control" type="text" id="description" name="description" placeholder="Enter description">
            </div>

            <div class="mt-4">
                <input type="submit" name="post_now" class="btn btn-lg btn-primary btn-block" value="Post Now">
                <a href="view_post.php" class="text_link" >View&nbsp;Post</a>
            </div>
        </form>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous">
    </script>
    <script>
 let message ="<?php echo $message; ?>";
        if(message=="success"){
            Swal.fire({
  position: "top-middle",
  icon: "success",
  title: `Blog Posted Successfully`,
  showConfirmButton: false,
  timer: 2500
});

        }
    </script>
</body>

</html>
