<!DOCTYPE HTML>  
<html>
<head>
    <title>Add NEW Movie</title>
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
 // query "SELECT * FROM MaxMovieID;
 
  $query = "SELECT * FROM MaxMovieID";
 
  if($db->connect_errno > 0){
      die('Unable to connect to database [' . $db->connect_error . ']');
  }

    //return query result 
    $rs = $db->query($query);
    

// define variables and set to empty values
$title = $company = $year = $rating ="";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $title = test_input($_POST["title"]);
  $company = test_input($_POST["company"]);
  $year = test_input($_POST["year"]);
  $rating = test_input($_POST["rating"]);

}
 $row = $rs->fetch_assoc();
    $id = $row['id'];
    $nid = $id +1;
    
    $query1 = "INSERT INTO Movie VALUES($nid,$title,$year,$rating,$company)";
    $db->query($query1);
    
    
    $query2 = "UPDATE MaxMovieID SET id = $nid";
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
  Title: <input type="text" name="title">
  <br><br>
  Company: <input type="text" name="company">
  <br><br>
  Year (yyyy-mm-dd):
    <br> 
    <input type="text" name="year">
  <br><br>
  Rating: <input type="text" name="rating">
  <button type="submit" class="btn btn-primary">Submit</button>
 
</form>

<?php
echo "<h2>The Information You Added:</h2>";
echo $title;
echo "<br>";
echo $company;
echo "<br>";
echo $year;
echo "<br>";
echo $rating;
echo "<br>";
?>

</body>
</html>

