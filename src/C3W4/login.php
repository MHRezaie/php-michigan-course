<?php
require_once "pdo.php";
session_start();
// p' OR '1' = '1


if ( isset($_POST['cancel'] ) ) {
    // Redirect the browser to game.php
    header("Location: index.php");
    return;
}

if ( isset($_POST['who']) && isset($_POST['pass'])  ) {
    if ( strlen($_POST['who']) < 1 || strlen($_POST['pass']) < 1 ) {
        $_SESSION['error'] = "Username or Password could not be empty.";
        header("Location: login.php");
        return;
    } 
    else if(substr_count($_POST['who'],"@")!=1){
        $_SESSION['error'] = "Email must have an at-sign (@)";
        header("Location: login.php");
        return;
    }
    else {

        // $sql = "SELECT name FROM users 
        //     WHERE who = :em AND pass = :pw";

        // $stmt = $pdo->prepare($sql);
        // $stmt->execute(array(
        //     ':em' => $_POST['who'], 
        //     ':pw' => $_POST['pass']));
        // $row = $stmt->fetch(PDO::FETCH_ASSOC);
        $row=$_POST['pass']=="php123";
    if ( $row === FALSE ) {
        error_log("Login fail ".$_POST['who']." ".hash('md5','XyZzy12*_'.$_POST['pass']));
        $_SESSION['error'] = "Incorrect pass";
        header("Location: login.php");
        return;
    } else { 
        error_log("Login success ".$_POST['who']);
        $_SESSION['name'] = $_POST['who'];
        header("Location: view.php");
        return;
    }
}
}
?>
<!DOCTYPE html>
<html>
<head>
<?php require_once "bootstrap.php"; ?>
<title>M.H Rezaie</title>
</head>
<body>
<div class="container">
<h1>Please Log In</h1>
<?php
// Note triple not equals and think how badly double
// not equals would work here...
if ( isset($_SESSION['error']) ) {
    // Look closely at the use of single and double quotes
    echo('<p style="color: red;">'.htmlentities($_SESSION['error'])."</p>\n");
    unset($_SESSION["error"]);
}
?>
<form method="POST">
<label for="nam">User Name</label>
<input type="text" name="who" id="nam"><br/>
<label for="id_1723">pass</label>
<input type="text" name="pass" id="id_1723"><br/>
<input type="submit" value="Log In">
<input type="submit" name="cancel" value="Cancel">
</form>
<p>
For a pass hint, view source and find a pass hint
in the HTML comments.
<!-- Hint: The pass is the four character sound a cat
makes (all lower case) followed by 123. -->
</p>
</div>
</body>
