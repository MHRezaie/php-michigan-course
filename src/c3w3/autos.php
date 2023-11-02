<?php



require_once "pdo.php";

if ( ! isset($_GET['name']) || strlen($_GET['name']) < 1  ) {
    die('Name parameter missing');
}

// If the user requested logout go back to index.php
if ( isset($_POST['logout']) ) {
    header('Location: index.php');
    return;
}

$stmt = $pdo->query("SELECT * FROM autos");
$rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

$failure = false; 
$success=false;
if ( isset($_POST['make']) &&
    isset($_POST['year']) &&
    isset($_POST['mileage']) 
    ){

        if(strlen($_POST['make'])<1){
            $failure="Make is required";
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
            $success="Record inserted";
            
            }
        else{
            $failure="Mileage and year must be numeric";
        }
        $stmt = $pdo->query("SELECT * FROM autos");
        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
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
if ( $failure !== false ) {
    // Look closely at the use of single and double quotes
    echo('<p style="color: red;">'.htmlentities($failure)."</p>\n");
}
if ( $success !== false ) {
    // Look closely at the use of single and double quotes
    echo('<p style="color: green;">'.htmlentities($success)."</p>\n");
}
?>
<form method="post">
    <p>Make:
    <input type="text" name="make" size="60"></p>
    <p>Year:
    <input type="text" name="year"></p>
    <p>Mileage:
    <input  type="text" name="mileage"></p>
    <input type="submit" value="Add">
    <input type="submit" name="logout" value="Logout">
</form>
<h2 class="__web-inspector-hide-shortcut__">Automobiles</h2>
<?php
echo "<ul>";
foreach ( $rows as $row ) {
    echo "<li> {$row['year']} {$row['make']} / {$row['mileage']} </li>";
}
echo "</ul>";
?>

</div>
</body>
</html>
