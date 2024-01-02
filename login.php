<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Login</title>
<link rel="stylesheet" href="index.css">
</head>
<body>
<form action="#" method="post">
<h2>LOGIN</h2>
<?php
if (isset($_GET['error'])){?>
<p class="error" ><?php echo $_GET['error'];?></p>
<?php }?>

<p>Email</p>
<input type="text" name="email"  placeholder="Email"><br>
<p>Password</p>
<input type="password" name="password" placeholder="Password" ><br>
<button type="submit" name="login" >Login</button>
</form>

<?php
include('connexionBase.php');
$conn=OpenBase();
if(isset($_POST['login']) ){
    $user=$_POST['email'];
    $pass=$_POST['password'];
    $sql="select * from etudiant where email='$user' and password='$pass' ";
    $res=mysqli_query($conn,$sql);
    $row=mysqli_num_rows($res);

    if($row== 1) {
    $_SESSION['user_name']=$user;
      header('location:adminEtu.php');
    }else{
        echo"Login failed";
    }

}?>





</body>
</html>






