
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

?>
<!doctype html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
  <link rel="stylesheet" href="../machine-test1/view_blog.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
  <title>Blog Posted</title>
  <style>
    .btn-custom {
  background-color: #45a049; /* Set your desired background color */
  color: white; /* Text color */
  border: 2px solid #4CAF50; /* Border color */
  border-radius: 5px; /* Rounded corners */
  padding: 10px 20px; /* Adjust padding for button size */
  font-size: 16px; /* Adjust font size */
  margin: 20px;
  transition: background-color 0.3s, color 0.3s; /* Add smooth transition */
}

.btn-custom:hover {
  background-color: #45a049; /* Change background color on hover */
  color: white; /* Change text color on hover */
  border-color: #45a049; /* Change border color on hover */
}
  </style>
</head>

<body>

<div>
  <div class="mt-4">
    <a href="blog_post.php">
      <button class="btn-custom">POST New Blog</button>
    </a>
  </div>
</div>

  <section id="gallery">
    <div class="container">
      <div id="image-gallery">
        <div class="row">
          <?php
          $all_post = $conn->prepare("Select * from blogs as B inner join students as S on B.student_id = S.id where S.id = ?");
          $s_session = $_SESSION['student_id'];
          $all_post->execute([$s_session]);
          $posts = $all_post->fetchAll();
          foreach ($posts as $post) {
            $datetime = $post['created_at'];
            $date = date('Y-m-d', strtotime($datetime));
          ?>
            <div class="col-lg-3 col-md-6 col-sm-6 col-xs-12 image">
              <div class="img-wrapper position-relative">
                <a href="../machine-test1/blog_images/<?= $post['blog_image']; ?>">
                  <img src="../machine-test1/blog_images/<?= $post['blog_image']; ?>" class="img-fluid" alt="Blog Image">
                  <div class="img-overlay">
                    <i class="fa fa-plus-circle" aria-hidden="true"></i>
                  </div>
                </a>
                <div class="blog-info text-center">
                  <span class="posted-by">Posted by: <?= $post['name']; ?></span>
                  <span class="post-date">On: <?= $date; ?></span>
                </div>
              </div>
            </div>
          <?php

            echo "<br>";
          }
          ?>


        </div><!-- End row -->
      </div><!-- End image gallery -->
    </div><!-- End container -->
  </section>

  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous">

  </script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.7/js/bootstrap.min.js"></script>
  <script>
    // Gallery image hover
    $(".img-wrapper").hover(
      function() {
        $(this).find(".img-overlay").animate({
          opacity: 1
        }, 600);
      },
      function() {
        $(this).find(".img-overlay").animate({
          opacity: 0
        }, 600);
      }
    );

    // Lightbox
    var $overlay = $('<div id="overlay"></div>');
    var $image = $("<img>");
    var $prevButton = $('<div id="prevButton"><i class="fa fa-chevron-left"></i></div>');
    var $nextButton = $('<div id="nextButton"><i class="fa fa-chevron-right"></i></div>');
    var $exitButton = $('<div id="exitButton"><i class="fa fa-times"></i></div>');

    // Add overlay
    $overlay.append($image).prepend($prevButton).append($nextButton).append($exitButton);
    $("#gallery").append($overlay);

    // Hide overlay on default
    $overlay.hide();

    // When an image is clicked
    $(".img-overlay").click(function(event) {
      // Prevents default behavior
      event.preventDefault();
      // Adds href attribute to variable
      var imageLocation = $(this).prev().attr("href");
      // Add the image src to $image
      $image.attr("src", imageLocation);
      // Fade in the overlay
      $overlay.fadeIn("slow");
    });

    // When the overlay is clicked
    $overlay.click(function() {
      // Fade out the overlay
      $(this).fadeOut("slow");
    });

    // When next button is clicked
    $nextButton.click(function(event) {
      // Hide the current image
      $("#overlay img").hide();
      // Overlay image location
      var $currentImgSrc = $("#overlay img").attr("src");
      // Image with matching location of the overlay image
      var $currentImg = $('#image-gallery img[src="' + $currentImgSrc + '"]');
      // Finds the next image
      var $nextImg = $($currentImg.closest(".image").next().find("img"));
      // All of the images in the gallery
      var $images = $("#image-gallery img");
      // If there is a next image
      if ($nextImg.length > 0) {
        // Fade in the next image
        $("#overlay img").attr("src", $nextImg.attr("src")).fadeIn(800);
      } else {
        // Otherwise fade in the first image
        $("#overlay img").attr("src", $($images[0]).attr("src")).fadeIn(800);
      }
      // Prevents overlay from being hidden
      event.stopPropagation();
    });

    // When previous button is clicked
    $prevButton.click(function(event) {
      // Hide the current image
      $("#overlay img").hide();
      // Overlay image location
      var $currentImgSrc = $("#overlay img").attr("src");
      // Image with matching location of the overlay image
      var $currentImg = $('#image-gallery img[src="' + $currentImgSrc + '"]');
      // Finds the next image
      var $nextImg = $($currentImg.closest(".image").prev().find("img"));
      // Fade in the next image
      $("#overlay img").attr("src", $nextImg.attr("src")).fadeIn(800);
      // Prevents overlay from being hidden
      event.stopPropagation();
    });

    // When the exit button is clicked
    $exitButton.click(function() {
      // Fade out the overlay
      $("#overlay").fadeOut("slow");
    });
  </script>
</body>

</html>
