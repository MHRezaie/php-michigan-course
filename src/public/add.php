<?php
session_start();
require_once "pdo.php";

if ( ! isset($_SESSION['name']) ) {
    die("ACCESS DENIED");
}

// If the user requested logout go back to index.php
if(isset($_POST['cancel'])){
    header("Location: index.php");
    return;
}

if ( $_SERVER["REQUEST_METHOD"] == "POST"
    ){
        if(strlen($_POST['make'])<1 ||
        strlen($_POST['model'])<1 ||
        strlen($_POST['year'])<1 ||
        strlen($_POST['mileage'])<1){
            $_SESSION['error']="All fields are required";
            header("Location: add.php");
            return;
        }
        else if(is_numeric($_POST['year']) && is_numeric($_POST['mileage'])){
            $stmt = $pdo->prepare(
                'INSERT INTO autos(make,model, year, mileage) VALUES ( :mk,:md, :yr, :mi)'
            );
            $stmt->execute(array(
                ':mk' => $_POST['make'],
                ':md' => $_POST['model'],
                ':yr' => $_POST['year'],
                ':mi' => $_POST['mileage'])
            );
            $_SESSION['success'] = "Record added";
            header("Location: index.php");
            return;
            
            }
        else{
            if(!is_numeric($_POST['year']))
                $_SESSION['error']="Year must be an integer";
            if(!is_numeric($_POST['mileage']))
                $_SESSION['error']="Mileage must be an integer";    
            header("Location: add.php");
            return;
        }
     }
    
?>


<!DOCTYPE html>
<html>
<head>
<title>M.H Rezaie</title>
<?php require_once "bootstrap.php"; ?>
</head>
<body>
<div class="container">
<form method="POST">
    <p>Make:
    <input type="text" name="make" size="60"></p>
    <p>Model:
    <input type="text" name="model"></p>
    <p>Year:
    <input type="text" name="year"></p>
    <p>Mileage:
    <input  type="text" name="mileage"></p>
    <input type="submit" value="add">
    <input type="submit" name="cancel" value="cancel">
</form>
<?php
// Note triple not equals and think how badly double
// not equals would work here...
if ( isset($_SESSION['error'])) {
    echo "<br>";
    // Look closely at the use of single and double quotes
    echo '<p style="color: red;">'.htmlentities($_SESSION['error'])."</p>\n" ;
    unset($_SESSION["error"]);
}
?>

</div>
</body>
</html>
