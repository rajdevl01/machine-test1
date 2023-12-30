
<?php
// This is to start the session
session_start();
// This is to include the database connection file 
require_once '../machine-test1/connection.php';
$new_password='';
$email='';
$message ='';

if (isset($_POST['register'])) {
// echo  $_POST['email'], $_POST['roll_no'], $_POST['student_name'];
    if (isset($_POST['email']) and isset($_POST['roll_no'])) {
        $new_password = rand(10000000, 99999999);
        $s_name = $_POST['student_name'];
        $roll_no = $_POST['roll_no'];
        $email = $_POST['email'];
        $sql = $conn->prepare("Select * from students where email = ?");
        $sql->execute([$_POST['email']]);
        if ($sql->rowCount() > 0) {
            $message = "This is email is already registerd";
        } else {
            $sql2 = $conn->prepare("INSERT INTO Students (name, email, roll_number, password) values (?, ?, ?, ?)");
            $sql2->execute([$s_name, $email, $roll_no, $new_password]);
            if ($sql2->rowCount() > 0) {
                $lastInsertedId = $conn->lastInsertId();
                
            }
        }
    }
}
?>
<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="../machine-test1/style.css">
    <title>Student Register</title>
</head>

<body>
    <!-- <div class="container-fluid">

        <form accept="#" method="post">
            <div class="col-xl-4 col-sm-6">
                <label class="form-label" for="studentname">Student Name<span class="txt-danger"></span></label>
                <input class="form-control" type="text" id="student_name" name="student_name" placeholder="Enter Student Name" required="">

            </div>
            <div class="col-xl-4 col-sm-6">
                <label class="form-label" for="student email">Email <span class="txt-danger"></span></label>
                <input class="form-control" type="email" id="email" name="email" placeholder="Enter email" required="">
<?php echo $message; ?>
            </div>

            <div class="col-xl-4 col-sm-6">
                <label class="form-label" for="Student ">Roll Number <span class="txt-danger"></span></label>
                <input class="form-control" type="text" id="roll_no" name="roll_no" placeholder="Enter Roll number">
                <div class="valid-feedback">Looks good!</div>

            </div>

            <div class="col-xl-2 col-sm-4 mt-4">
                <input type="submit" name="register" class="btn bg-primary" value="Register">
                <a href="login.php">Login Now</a>
            </div>
        </form>
    </div> -->


    <div class="wrapper">
                <center>
                <div class="card" style="margin-top: 200px;">
                    <div class="circle"></div>
                    <div class="circle"></div>
                 
                    <div class="card-inner login">
                        <form accept="#" method="post">
                            <div class="input-box">
                                <input type="text" name="student_name" id="student_name" placeholder="Student Name">
                                <i class="fa fa-envelope"></i>
                            </div>
                            <div class="input-box">
                                <input type="email" name="email" id="email" placeholder="Student Email">
                                <i class="fa fa-envelope"></i>
                                <?php echo $message; ?>
                            </div>
                            
                            <div class="input-box">
                                <input type="text" name="roll_no" id="roll_no" placeholder="Roll Number">
                                <i class="fa fa-envelope"></i>
                            </div>
                            <div class="links">
                               
                                <a href="login.php">Already have an account</a>
                            </div>
                            <button type="submit" name="register">Register</button>
                
                        </form>
                </div>
                   
                </div>
            </center>
            
            </div>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    <script>
        let new_password ="<?php echo $new_password; ?>";
        let new_email ="<?php echo $email; ?>";
        if(new_password!==""){
            Swal.fire({
  position: "top-middle",
  icon: "success",
  title: `Registration Complete with email ${new_email} and  password is ${new_password}`,
  showConfirmButton: false,
  timer: 3500
});

        }
    </script>
</body>

</html>
