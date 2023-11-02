<?php


session_start();
require_once "pdo.php";

if ( ! isset($_SESSION['name']) ) {
    die('Not logged in');
}

// If the user requested logout go back to index.php
if(isset($_POST['Cancle'])){
    header("Location: view.php");
}

if ( isset($_POST['make']) &&
    isset($_POST['year']) &&
    isset($_POST['mileage']) 
    ){

        if(strlen($_POST['make'])<1){
            $_SESSION['error']="Make is required";
            header("Location: add.php");
            return;
        }
        else if(is_numeric($_POST['year']) && is_numeric($_POST['mileage'])){
            $stmt = $pdo->prepare(
                'INSERT INTO autos(make, year, mileage) VALUES ( :mk, :yr, :mi)'
            );
            $stmt->execute(array(
                ':mk' => $_POST['make'],
                ':yr' => $_POST['year'],
                ':mi' => $_POST['mileage'])
            );
            $_SESSION['success'] = "Record inserted";
            header("Location: view.php");
            return;
            
            }
        else{
            $_SESSION['error']="Mileage and year must be numeric";
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
<form method="post">
    <p>Make:
    <input type="text" name="make" size="60"></p>
    <p>Year:
    <input type="text" name="year"></p>
    <p>Mileage:
    <input  type="text" name="mileage"></p>
    <input type="submit" value="Add">
    <input type="submit" name="Cancle" value="Cancle">
</form>
<?php
// Note triple not equals and think how badly double
// not equals would work here...
if ( isset($_SESSION['error'])) {
    // Look closely at the use of single and double quotes
    echo('<p style="color: red;">'.htmlentities($_SESSION['error'])."</p>\n");
    unset($_SESSION["error"]);
}
?>

</div>
</body>
</html>
