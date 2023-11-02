<?php
require_once "pdo.php";
session_start();
if ( ! isset($_SESSION['name']) ) {
    die("ACCESS DENIED");
}

if ($_SERVER["REQUEST_METHOD"]=="POST") {
    if(strlen($_POST['make'])<1 ||
        strlen($_POST['model'])<1 ||
        strlen($_POST['year'])<1 ||
        strlen($_POST['mileage'])<1){
            $_SESSION['error']="All fields are required";
            header("Location: edit.php?auto_id=".$_POST['auto_id']);
            return;
    }
    else if(!is_numeric($_POST['year'])||!is_numeric($_POST['mileage'])){
        $_SESSION['error']="Year or Mileage must be an integer";
        header("Location: edit.php?auto_id=".$_POST['auto_id']);
        return;
    }
    $sql = "UPDATE autos SET 
            make = :make,
            model = :model,
            year = :year,
            mileage=:mileage 
            WHERE auto_id = :auto_id";
    $stmt = $pdo->prepare($sql);
    $stmt->execute(array(
        ':make' => $_POST['make'],
        ':model' => $_POST['model'],
        ':year' => $_POST['year'],
        ':mileage' => $_POST['mileage'],
        ':auto_id'=>$_POST['auto_id']
    ));
    $_SESSION['success'] = 'Record updated';
    header( 'Location: index.php' ) ;
    return;
}

// Guardian: Make sure that auto_id is present
if ( ! isset($_GET['auto_id']) ) {
  $_SESSION['error'] = "Missing auto_id";
  header('Location: index.php');
  return;
}

$stmt = $pdo->prepare("SELECT * FROM autos where auto_id = :xyz");
$stmt->execute(array(":xyz" => $_GET['auto_id']));
$row = $stmt->fetch(PDO::FETCH_ASSOC);
if ( $row === false ) {
    $_SESSION['error'] = 'Bad value for auto_id';
    header( 'Location: index.php' ) ;
    return;
}

// Flash pattern
if ( isset($_SESSION['error']) ) {
    echo '<p style="color:red">'.$_SESSION['error']."</p>\n";
    unset($_SESSION['error']);
}

$mk = htmlentities($row['make']);
$md = htmlentities($row['model']??"");
$ml = htmlentities($row['mileage']);
$yr = htmlentities($row['year']);
$id = $row['auto_id'];
?>
<p>Edit Automobile</p>
<form method="post">
<p>Make:
<input type="text" name="make" value="<?= $mk ?>"></p>
<p>Model:
<input type="text" name="model" value="<?= $md ?>"></p>
<p>Mileage:
<input type="text" name="mileage" value="<?= $ml ?>"></p>
<p>Year:
<input type="text" name="year" value="<?= $yr ?>"></p>
<input type="hidden" name="auto_id" value="<?= $id ?>">
<p><input type="submit" value="update"/>
<a href="index.php">Cancel</a></p>
</form>
