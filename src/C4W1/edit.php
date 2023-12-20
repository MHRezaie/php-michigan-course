<?php
require_once "pdo.php";
session_start();
if ( ! isset($_SESSION['name']) ) {
    die("Not logged in");
}
if ( ! isset($_GET['profile_id']) ) {
    $_SESSION['error'] = "Missing id";
    header('Location: index.php');
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

if ($_SERVER["REQUEST_METHOD"]=="POST") {
    if(strlen($_POST['first_name'])<1 ||
            strlen($_POST['last_name'])<1 ||
            strlen($_POST['email'])<1 ||
            strlen($_POST['headline'])<1 ||
            strlen($_POST['summary'])<1){
            $_SESSION['error']="All fields are required";
            header("Location: edit.php?profile_id={$_GET['profile_id']}");
            return;
        }
    else if(substr_count($_POST['email'],"@")!=1){
        $_SESSION['error'] = "Email address must contain @";
        header("Location: edit.php?profile_id={$_GET['profile_id']}");
        return;
    }
    $sql = "UPDATE Profile SET 
            first_name= :fn, 
            last_name= :ln,
            email= :em,
            headline= :he, 
            summary= :su
            WHERE id = :id";
    $stmt = $pdo->prepare($sql);
    $stmt->execute(array(
            ':fn' => $_POST['first_name'],
            ':ln' => $_POST['last_name'],
            ':em' => $_POST['email'],
            ':he' => $_POST['headline'],
            ':su' => $_POST['summary'],
            ':id' => $_GET['profile_id'])
    );
    $_SESSION['success'] = 'Profile updated';
    header( 'Location: index.php' ) ;
    return;
}

// Guardian: Make sure that auto_id is present




// Flash pattern


$fn = htmlentities($row['first_name']);
$ln = htmlentities($row['last_name']);
$em = htmlentities($row['email']);
$he = htmlentities($row['headline']);
$su = htmlentities($row['summary']);
$id = $row['id'];
?>
<DOCTYPE html>
<html>
<head>
<title>M.H Rezaie</title>
<?php require_once "bootstrap.php"; ?>
</head>
<body>
<div class="container">
<h2>Edit Profile</h2>
<br>
<?php if ( isset($_SESSION['error']) ) {
    echo '<p style="color:red">'.$_SESSION['error']."</p>\n";
    unset($_SESSION['error']);
}?>
<form method="post">
<p>First Name: 
    <input type="text" name="first_name"  size="60" value="<?php echo $fn;?>"></p>
    <p>Last Name: 
    <input type="text" name="last_name" size="60" value="<?php echo $ln;?>"></p>
    <p>Email: 
    <input type="text" name="email" size="30" value="<?php echo $em;?>"></p>
    <p>headline: <br>
    <input  type="text" name="headline" size="80" value="<?php echo $he;?>"></p>
    <p>summary: <br>
    <textarea name="summary" rows="8" cols="80"><?php echo $su;?></textarea></p>
    <input type="hidden" name="profile_id" value="<?= $id ?>">
<p>
<input type="submit" value="Save"/>
<a href="index.php">Cancel</a></p>
</form>
</div>
</body>
</html>