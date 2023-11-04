<?php
require_once "pdo.php";
session_start();
if(!isset($_SESSION['name'])){
  header("Location: index.php");
  return;
}

$stmt = $pdo->prepare("SELECT * FROM Profile where id = :xyz");
$stmt->execute(array(":xyz" => $_GET['profile_id']));
$row = $stmt->fetch(PDO::FETCH_ASSOC);
if ( $row === false ) {
    $_SESSION['error'] = 'Bad value for profile_id';
    header( 'Location: index.php' ) ;
    return;
}
if($row['user_id']!=$_SESSION['user_id']){
  $_SESSION['error'] = 'Access error';
  header( 'Location: index.php' ) ;
  return;
}

if ( isset($_POST['delete']) && isset($_GET['profile_id']) ) {
    $sql = "DELETE FROM Profile WHERE id = :id";
    $stmt = $pdo->prepare($sql);
    $stmt->execute(array(':id' => $_GET['profile_id']));
    $_SESSION['success'] = 'Profile deleted';
    header( 'Location: index.php' ) ;
    return;
}

// Guardian: Make sure that auto_id is present
if ( ! isset($_GET['profile_id']) ) {
  $_SESSION['error'] = "Missing profile_id";
  header('Location: index.php');
  return;
}?>


<DOCTYPE html>
<html>
<head>
<title>M.H Rezaie</title>
<?php require_once "bootstrap.php"; ?>
</head>
<body>
<div class="container">
<H2>Deleteing Profile</H2>
<p>
First Name: <?= htmlentities($row['first_name'])?>
<br>
Last Name: <?= htmlentities($row['last_name'])?>
<br>
</p>

<form method="post">
<input type="hidden" name="profile_id" value="<?= $row['id'] ?>">
<input type="submit" value="Delete" name="delete">
<a href="index.php">Cancel</a>
</form>
</div>
</body>
</html>