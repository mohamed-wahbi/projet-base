<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Interface Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <style>
        table {
            position: relative;
            top: 25px;
            width: 70%;
            display: inline-block;
            position: absolute;
            top: 31%;
            left: 31%;
            background: #d7d7d7;
            width: fit-content !important;
            font-family: cursive;
            color: #565252;
            border: 1px !important;

        }

        #h33 {
            text-align: center;
            color: blueviolet;
        }

        #div1 {
            position: relative;
            left: 40%;
            top: 20px;
        }

        #div2 {
            position: relative;
            top: 80px;
            border: 2px;
        }
    </style>
</head>

<body>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>

    <?php
    include_once('connexionBase.php');
    $userprofile=  $_SESSION['user_name'];
if($userprofile== true)
{

}
else
{
  header('location:login.php');
  exit;
}
    $Action = isset($_GET['action']) ? $_GET['action'] : '0';

    switch ($Action) {
        case 0:
            AfficherInterface();
            break;
        case 1:
            insertEtu();
            break;
        case 2:
            updateEtu();
            break;
        case 3:
            DeleteEtu();
            AfficherInterface('suppression ok');
            break;
        default:
            echo 'erreur dans la base';
    }

    function AfficherInterface()
    {
        include_once("connexionBase.php");
        echo "<div class='text-center mb-7'><h2> Lists of Students </h2></div>";
        echo " <form name='f' method='GET' action=''>
            <a type='button' class='btn btn-success m-3' href='adminEtu.php?action=1'>Add New</a> 
            <a type='button' class='btn btn-danger m-3' href='logout.php'>logout</a> ";
            

        $sql = "SELECT * FROM eleve ";
        $result = mysqli_query(OpenBase(), $sql);
        if ($result) {
            echo "
            <table class='table table-bordered'>
                <thead>
                    <tr>
                        <td > Cin </td>
                        <td> Nom </td>
                        <td> Prenom</td>
                        <td>E_mail </td>
                        <td colspan='2'>Action </td>
                    </tr>
                </thead>
                <tbody>";

            while ($row = mysqli_fetch_assoc($result)) {
                echo "
                    <tr>
                        <td > " . $row['cin'] . "</td>
                        <td>" . $row['nom'] . "</td>
                        <td> " . $row['prenom'] . "</td>
                        <td>" . $row['email'] . " </td>
                        <td><a class='btn btn-danger container ml-5' href='adminEtu.php?action=3&cin=" . $row['cin'] . "'>Delete</a> </td>
                        <td ><a type='button' class='btn btn-warning container ml-5' href='adminEtu.php?action=2&cin=" . $row['cin'] . "'>Update</a></td>
                    </tr>";
            }

            echo "
                </tbody>
            </table>";
        }
        mysqli_close(OpenBase());
    }

    function insertEtu()
{
    $conn = OpenBase(); // Assurez-vous que cette ligne est correcte
    
    if (!$conn) {
        die("Erreur de connexion : " . mysqli_connect_error());
    }

    if (isset($_POST['send'])) {
        $cin = $_POST["cin"];
        $nom = $_POST["nom"];
        $prenom = $_POST["prenom"];
        $email = $_POST["email"];

        $sql = "INSERT INTO eleve (cin, nom, prenom, email) VALUES ('$cin', '$nom', '$prenom', '$email')";

        if (mysqli_query($conn, $sql)) {
            header('location: adminEtu.php');
        } else {
            echo "Erreur : " . $sql . "<br>" . mysqli_error($conn);
        }
    } else {
        echo "
        <div id='div2'>
            <div class='text-center mb-4'><h3> Add New Student </h3></div>
            <div class='container d-flex justify-content-center'>
                <form name='f' method='POST' action='adminEtu.php?action=1' enctype='multipart/form-data' style ='width:50vw;min-width:350px'>   
                    Cin <input name='cin' class='form-control' type='text'><br>
                    Name <input name='nom' class='form-control' type='text'><br>
                    LastName  <input name='prenom' class='form-control' type='text'><br>
                    Email <input name='email' class='form-control' type='text'><br>
                    <input type='submit' name='send' value ='Add Student' class='btn btn-success'><br>
                </form>
            </div>
        </div>";
    }

    mysqli_close($conn);
}



    function updateEtu()
    {
        if (!isset($_GET['cin'])) {
            echo "Error: 'cin' parameter is not set.";
            return;
        }

        $conn = OpenBase();
        $cin = $_GET['cin'];

        $req = mysqli_query($conn, "SELECT * FROM eleve WHERE cin='$cin'");
        $row = mysqli_fetch_assoc($req);

        if (isset($_POST['submit'])) {
            $cin_post = $_POST["c"];
            $nom = $_POST["n"];
            $prenom = $_POST["p"];
            $email = $_POST["e"];

            if ($cin_post && $nom && $prenom && $email) {
                $sql = "UPDATE eleve 
                        SET cin='$cin_post', nom='$nom', prenom='$prenom', email='$email' 
                        WHERE cin='" . $row['cin'] . "'";
                $res = mysqli_query($conn, $sql);

                if ($res) {
                    header('location: adminEtu.php');
                } else {
                    echo "Error: " . $sql . "<br>" . mysqli_error($conn);
                }
            }
        } else {
            echo "<div class='text-center mb-4'><h3>Page Update Student </h3></div>";
            echo "<div class='container d-flex justify-content-center'>";
            echo "<form name='f' method='POST' action='adminEtu.php?action=2&cin=" . $row['cin'] . "' style ='width:50vw;min-width:350px' >";
            echo "Cin  <input class='form-control' name='c' type='text' value=" . $row['cin'] . ">";
            echo "<br>Name  <input class='form-control' name='n' type='text' value=" . $row['nom'] . " >";
            echo "<br>LastName  <input class='form-control' name='p' type='text' value=" . $row['prenom'] . ">";
            echo "<br>Email <input class='form-control' name='e' type='text' value=" . $row['email'] . ">";
            echo "<br> <input type='submit' name='submit' value ='Update' class='btn btn-success' >";
            echo "</form>";
            echo "</div>";
        }

        mysqli_close($conn);
    }

    function DeleteEtu()
    {
        $conn = OpenBase();
        $UserId = isset($_GET['cin']) ? $_GET['cin'] : '';
        $Sql = "DELETE FROM eleve WHERE cin='$UserId'";
        $Res = mysqli_query($conn, $Sql);
        mysqli_close($conn);
    }
    ?>
</body>

</html>