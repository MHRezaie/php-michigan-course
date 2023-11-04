<?php

session_start();

require_once "pdo.php";

if ( ! isset($_SESSION['name']) ) {
    die('Not logged in');
  }

// If the user requested logout go back to index.php

$stmt = $pdo->query("SELECT * FROM autos");
$rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>


<!DOCTYPE html>
<html>
<head>
<title>M.H Rezaie</title>
<?php require_once "bootstrap.php"; ?>
</head>
<body>
<div class="container">
<?php
if ( isset($_GET['name']) ) {
    echo "<p>Tracking Autos for ";
    echo htmlentities($_REQUEST['name']);
    echo "</p>\n";
}
?>

<?php
// Note triple not equals and think how badly double
// not equals would work here...
if ( isset($_SESSION['success']) ) {
    echo('<p style="color: green;">'.htmlentities($_SESSION['success'])."</p>\n");
    unset($_SESSION['success']);
  }
?>

<h2 class="__web-inspector-hide-shortcut__ mb-5">Automobiles</h2>
<a href="/add.php">Add New</a>
<span>|</span>
<a href="/logout.php" >Logout</a>
<?php
echo "<ul >";
foreach ( $rows as $row ) {
    echo "<li> ".htmlentities($row['year'])." ". htmlentities($row['make'])." / ". htmlentities($row['mileage'])."</li>";
}
echo "</ul>";
?>

</div>
</body>
</html>
