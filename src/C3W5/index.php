<?php
    require_once "pdo.php";
    session_start();
?>

<DOCTYPE html>
<html>
<head>
<title>M.H Rezaie</title>
<?php require_once "bootstrap.php"; ?>
</head>
<body>
<div class="container">
<h1>Welcome to Automobiles Database</h1>
<?php
    if(!isset($_SESSION['name'])){
        echo "<p><a href='login.php'>Please log in</a></p>";
    }
    else{
        if(isset($_SESSION['error'])){
            echo "<p style='color:red'>{$_SESSION["error"]}</p>";
            unset($_SESSION['error']);
        }
        if(isset($_SESSION['success'])){
            echo "<p style='color:green'>{$_SESSION["success"]}</p>";
            unset($_SESSION['success']);
        }
        $stmt = $pdo->query("SELECT * FROM autos");
    if($stmt->rowCount()==0){
        echo "<b>No rows found !</b>";
    }
    else{
    echo('<table border="1" >'."\n");
    echo "<tr>
        <th style='padding:5px;'>Make</th>
        <th style='padding:5px;'>Model</th>
        <th style='padding:5px;'>Mileage</th>
        <th style='padding:5px;'>Year</th>
        <th style='padding:5px;'>Action</th>
    </tr>
    ";

    while ( $row = $stmt->fetch(PDO::FETCH_ASSOC) ) {
        echo "<tr><td style='padding:5px;'>";
        echo(htmlentities($row['make']));
        echo("</td><td style='padding:5px;'>");
        echo(htmlentities($row['model']??"empty"));
        echo("</td><td style='padding:5px;'>");
        echo(htmlentities($row['mileage']));
        echo("</td><td style='padding:5px;'>");
        echo(htmlentities($row['year']));
        echo("</td><td style='padding:5px;'>");
        echo('<a href="edit.php?auto_id='.$row['auto_id'].'">Edit</a> / ');
        echo('<a href="delete.php?auto_id='.$row['auto_id'].'">Delete</a>');
        echo("</td></tr>\n");
    }
    echo "</table>";
    }
    echo'
        <br/><br/>
        <a href="add.php">Add New Entry</a>
        <br/>
        <a href="logout.php" style="color:red">Logout</a>';
    
}
?>
</div>
</body>
</html>
