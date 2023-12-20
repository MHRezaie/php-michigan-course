<?php
session_start();
require_once "pdo.php";

if ( ! isset($_SESSION['name']) ) {
    die("Not logged in");
}

// If the user requested logout go back to index.php
if(isset($_POST['cancel'])){
    header("Location: index.php");
    return;
}

if ( $_SERVER["REQUEST_METHOD"] == "POST"
    ){
        if(strlen($_POST['first_name'])<1 ||
            strlen($_POST['last_name'])<1 ||
            strlen($_POST['email'])<1 ||
            strlen($_POST['headline'])<1 ||
            strlen($_POST['summary'])<1){
            $_SESSION['error']="All fields are required";
            header("Location: add.php");
            return;
        }
        else{
            $stmt = $pdo->prepare('INSERT INTO Profile
            (user_id, first_name, last_name, email, headline, summary)
            VALUES ( :uid, :fn, :ln, :em, :he, :su)');
          
          $stmt->execute(array(
            ':uid' => $_SESSION['user_id'],
            ':fn' => $_POST['first_name'],
            ':ln' => $_POST['last_name'],
            ':em' => $_POST['email'],
            ':he' => $_POST['headline'],
            ':su' => $_POST['summary'])
          );
          $_SESSION['success'] = "Profile added";
            header("Location: index.php");
            return;
        }
     }
    
?>


<DOCTYPE html>
<html>
<head>
<title>M.H Rezaie</title>
<?php require_once "bootstrap.php"; ?>
</head>
<body>
<div class="container">
<form method="POST">
    <p>First Name:
    <input type="text" name="first_name"></p>
    <p>Last Name:
    <input type="text" name="last_name"></p>
    <p>Email:
    <input type="text" name="email"></p>
    <p>headline:
    <input  type="text" name="headline"></p>
    <p>summary:
    <textarea name="summary"></textarea></p>
    <input type="submit" value="Add">
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
