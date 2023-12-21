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
<h1>M.H Rezaie's Resume Registry</h1>
<?php
    $isLogged=false;
    if(!isset($_SESSION['name'])){
        echo "<p><a href='login.php'>Please log in</a></p>";
    }
    else{
        $isLogged=true;
        if(isset($_SESSION['error'])){
            echo "<p style='color:red'>{$_SESSION["error"]}</p>";
            unset($_SESSION['error']);
        }
        if(isset($_SESSION['success'])){
            echo "<p style='color:green'>{$_SESSION["success"]}</p>";
            unset($_SESSION['success']);
        }
        echo "<p><a href='logout.php'>Logout</a></p>";
}
$stmt = $pdo->query("SELECT * FROM Profile");
    if($stmt->rowCount()==0){
        echo "<b>No rows found !</b>";
    }
    else{
    echo('<table border="1" >'."\n");
    $tbl="<tr>
    <th style='padding:5px;'>Name</th>
    <th style='padding:5px;'>Headline</th>";
    
    $tbl.=$isLogged?"<th style='padding:5px;'>Action</th></tr>" : "</tr>";

    while ( $row = $stmt->fetch(PDO::FETCH_ASSOC) ) {
        echo "<tr><td style='padding:5px;'>";
        echo("<a href='/view.php?profile_id=".$row['id']."'>".
            htmlentities($row['first_name'])." ".htmlentities($row['last_name'])."</a>"
        );
        echo("</td><td style='padding:5px;'>");
        echo(htmlentities($row['headline']));
        if($isLogged){
            echo("</td><td style='padding:5px;'>");
            echo('<a href="/edit.php?profile_id='.$row['id'].'">Edit</a> / ');
            echo('<a href="/delete.php?profile_id='.$row['id'].'">Delete</a>');
        }
        echo("</td></tr>\n");
    }
    echo "</table>";
    }
if($isLogged){
    echo'
    <br/><br/>
    <a href="add.php">Add New Entry</a>
    <br/>';
}
?>
</div>
</body>
</html>
