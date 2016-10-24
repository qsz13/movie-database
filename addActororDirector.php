<!DOCTYPE HTML>  
<html>
<head>
    <title>Add NEW Actor or Director</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
</head>

<body>  

<?php

//db connection
if(!empty($_GET['query'])) {

  $db = new mysqli('localhost', 'cs143', '', 'CS143');
 // query "SELECT * FROM MaxPersonID;
 
  $query = "SELECT * FROM MaxPersonID";
 
  if($db->connect_errno > 0){
      die('Unable to connect to database [' . $db->connect_error . ']');
  }

    //return query result 
    $rs = $db->query($query);
    
// define variables and set to empty values
$identity = $firstname = $lastname= $sex = $dateofbirth = $dateofdeath = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $identity = test_input($_POST["identity"]);
  $firstname = test_input($_POST["firstname"]);
  $lastname = test_input($_POST["lastname"]);
  $sex = test_input($_POST["sex"]);
  $dateofbirth = test_input($_POST["dateofbirth"]);
  $dateofdeath = test_input($_POST["dateofdeath"]);

}
    //get the max person id and add 1
    $row = $rs->fetch_assoc();
    $id = $row['id'];
    $nid = $id +1;
    if($identity="Actor"){
        $query1 = "INSERT INTO Actor VALUES($nid,$lastname,$firstname,$sex,$dateofbirth,$dateofdeath)";
        $db->query($query1);
    } else {
         $query1 = "INSERT INTO Director VALUES($nid,$lastname,$firstname,$dateofbirth,$dateofdeath)";
        $db->query($query1);

    }
    $query2 = "UPDATE MaxPersonID SET id = $nid";
    $db->query($query2);

    $rs->free();
    $db->close();

function test_input($data) {
  $data = trim($data); //Strip unnecessary characters
  $data = stripslashes($data); //Remove backslashes
  $data = htmlspecialchars($data);
  return $data;
}

?>

<h2>Add NEW Actor or Director</h2>
<form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
  Identity:
  <input type="radio" name="identity" value="actor">Actor
  <input type="radio" name="identity" value="director">Director
  <br><br>
  First Name: <input type="text" name="firstname">
  <br>
  Last Name: <input type="text" name="lastname">
  <br><br>
  Sex:
  <input type="radio" name="sex" value="female">Female
  <input type="radio" name="sex" value="male">Male
  <br><br>

  Date of birth (yyyy-mm-dd):
    <br> 
    <input type="text" name="dateofbirth">
  <br><br>
  Date of death (Blank if still alive):
     <br>
     <input type="text" name="dateofdeath">
  <br><br>
    <button type="submit" class="btn btn-primary">Submit</button>
 
</form>

<?php
echo "<h2>The Information You Added:</h2>";
echo $identity;
echo "<br>";
echo $firstname;
echo "<br>";
echo $lastname;
echo "<br>";
echo $sex;
echo "<br>";
echo $dateofbirth;
echo "<br>";
echo $dateofdeath;
?>

</body>
</html>
