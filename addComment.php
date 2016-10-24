<!DOCTYPE HTML>  
<html>
<head>
    <title>Add NEW Comment</title>
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
 
 
  
  if($db->connect_errno > 0){
      die('Unable to connect to database [' . $db->connect_error . ']');
  }

   // define variables and set to empty values
$name = $movie = $comment = $rating ="";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = test_input($_POST["name"]);
    $movie = test_input($_POST["movie"]);
    $comment = test_input($_POST["comment"]);
    $rating = test_input($_POST["rating"]);
    

}
    $time = date(DATE_COOKIE);
    
    $query = "SELECT id FROM Movie WHERE title=$movie";
    $rs = $db->query($query);
    $query1 = "INSERT INTO Review VALUES($name,$time,$rs,$rating,$comment)";
    $db->query($query1);
    
    
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
  Your Name: <input type="text" name="name">
  <br><br>
  Movie Name: <input type="text" name="movie">
  <br><br>
   Rating: 
  <input type="radio" name="rating" value="1">1
  <input type="radio" name="rating" value="2">2
  <input type="radio" name="rating" value="3">3
  <input type="radio" name="rating" value="4">4
  <input type="radio" name="rating" value="5">5
  
  <br><br>
    Comment:
  <br>
  <textarea name="comment" rows="5" cols="40"></textarea>
  <br><br>
 <button type="submit" class="btn btn-primary">Submit</button>
 
</form>

<?php
echo "<h2>The Information You Added:</h2>";
echo $name;
echo "<br>";
echo $movie;
echo "<br>";
echo $time;
echo "<br>";
echo $rating;
echo "<br>";
echo $comment;
echo "<br>";
?>

</body>
</html>
