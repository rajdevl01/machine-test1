<?php
// This is to include the database connection file 
session_start();
require_once '../machine-test1/connection.php';
// show message
$message = '';

if (isset($_POST['login'])) {
    if (isset($_POST['roll_no']) and isset($_POST['password'])) {
        $password = $_POST['password'];
        $roll_no = $_POST['roll_no'];
        $new_session = uniqid();
        $sql = $conn->prepare("Select * from students where roll_number = ? and password = ?");
        $sql->execute([$roll_no, $password]);
        $result = $sql->fetch();

        if ($result) {
            $student_id = $result['id'];
          
            $sql2 = $conn->prepare('Update students set session_id = ? where id = ?');
            $sql2->execute([$new_session, $student_id]);
            if($sql2->rowCount()>0){
                $_SESSION['student_session_id'] = $new_session;
                $_SESSION['student_id'] = $student_id;
            }
            header("location:/machine_test/machine-test1/blog_post.php");
        } else {
            $message = "<span class ='text-danger'>Invalid Credentials</span>";
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

    <title>Student Register</title>
    <link rel="stylesheet" href="../machine-test1/style.css">
</head>

<body>
 
    <div class="wrapper">
                <center>
                <div class="card" style="margin-top: 200px;">
                    <div class="circle"></div>
                    <div class="circle"></div>
                 
                    <div class="card-inner login">
                        <form action="#" method="post">
                            <div class="input-box">
                                <input type="text" name="roll_no" id="roll_no" placeholder="Roll Number">
                                <i class="fa fa-envelope"></i>
                            </div>
                
                            <div class="input-box">
                                <input type="password" name="password" id="password" placeholder="Password">
                                <i class="fa fa-lock"></i>
                            </div>
                
                            <button type="submit" name="login">LOGIN</button>
                            <h3> <?php echo $message; ?></h3>
                            <div class="links">
                               
                                <a href="register.php">You don't have an account</a>
                            </div>
                
                        </form>
                </div>
                   
                </div>
            </center>
            
            </div>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    <script>
        //         let new_password ="<?php echo $new_password; ?>";
        //         let new_email ="<?php echo $email; ?>";
        //         if(new_password!==""){
        //             Swal.fire({
        //   position: "top-middle",
        //   icon: "success",
        //   title: `Registration Complete with email ${new_email} and  password is ${new_password}`,
        //   showConfirmButton: false,
        //   timer: 3500
        // });
        // 
        // }
    </script>
</body>

</html>


