<?php
require_once "pdo.php";
session_start();
// p' OR '1' = '1


if ( isset($_POST['cancel'] ) ) {
    // Redirect the browser to game.php
    header("Location: index.php");
    return;
}


if ( isset($_POST['email']) && isset($_POST['pass'])  ) {
    if ( strlen($_POST['email']) < 1 || strlen($_POST['pass']) < 1 ) {
        $_SESSION['error'] = "Username or Password could not be empty.";
        header("Location: login.php");
        return;
    } 
    else if(substr_count($_POST['email'],"@")!=1){
        $_SESSION['error'] = "Email address must contain @";
        header("Location: login.php");
        return;
    }
    else {
        $salt='XyZzy12*_';
        $check = hash('md5', $salt.$_POST['pass']);
        $stmt = $pdo->prepare('SELECT id, name FROM users
         WHERE email = :em AND password = :pw');
        $stmt->execute(array( ':em' => $_POST['email'], ':pw' => $check));
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        //$row=$_POST['pass']=="php123";
    if ( $row === false ) {
        error_log("Login fail ".$_POST['email']." ".hash('md5','XyZzy12*_'.$_POST['pass']));
        $_SESSION['error'] = "Incorrect pass";
        header("Location: login.php");
        return;
    } else { 
        error_log("Login success ".$_POST['email']);
        $_SESSION['name'] = $row['name'];
        $_SESSION['user_id'] = $row['id'];
        header("Location: index.php");
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
<input type="text" name="email" id="email"><br/>
<label for="id_1723">pass</label>
<input type="text" name="pass" id="id_1723"><br/>
<input type="submit" onclick="return doValidate();" value="Log In">
<input type="submit" name="cancel" value="Cancel">
</form>
<p>
For a pass hint, view source and find a pass hint
in the HTML comments.
<!-- Hint: The pass is the four character sound a cat
makes (all lower case) followed by 123. -->
</p>
</div>
<script>
        function doValidate() {
        console.log('Validating...');
        try {
            addr = document.getElementById('email').value;
            pw = document.getElementById('id_1723').value;
            console.log("Validating addr="+addr+" pw="+pw);
            if (addr == null || addr == "" || pw == null || pw == "") {
                alert("Both fields must be filled out");
                return false;
            }
            if ( addr.indexOf('@') == -1 ) {
                alert("Invalid email address");
                return false;
            }
            return true;
        } catch(e) {
            return false;
        }
        return false;
    }
</script>
</body>
