<html class="gr__oak_cs_ucla_edu"><head><title>CS143 Project 1B Demo</title>
<style>table, th, td {border: 1px solid black;}</style></head>
<p>
Due to security concerns, this demo does not follow the spec exactly.
It is just to give you a rough idea of how your code should work.</p>

<p>Please do not run a complex query here. You may kill the server. </p>
Type an SQL query in the following box: <p>
Example: <tt>SELECT * FROM Actor WHERE id=10;</tt><br>
</p><p>
</p>
<form action="#" method="GET">
<textarea name="query" cols="60" rows="8"></textarea><br>
<input type="submit" value="Submit">
</form>

<?php

if(!empty($_GET['query'])) {

  $db = new mysqli('localhost', 'cs143', '', 'CS143');

  //$query = $db->real_escape_string($_GET['query']);
  $query = ""
  if($db->connect_errno > 0){
      die('Unable to connect to database [' . $db->connect_error . ']');
  }


  // $query = "SELECT * FROM Actor";
  //return query result in a table
  $rs = $db->query($query);
  print 'Total results: ' . $rs->num_rows."<br />";
  $cols = $rs->fetch_fields();

  echo "<table>";

  if(count($cols) > 0){
    echo "<tr>";
    foreach($cols as $col) {
      echo "<th>".$col->name."</th>";
    }
    echo "</tr>";
  }
  




  if ($rs->num_rows > 0){
    
    while($row = $rs->fetch_assoc()) {
      echo "<tr>";

      foreach($row as $value)
      {
        if($value == "") $value = "NULL";
        echo "<td>".$value.'</td>';
      }  
      echo "</tr>";
      
    }
  }



  echo "</table>";

  $rs->free();
  $db->close();
exit(1);  


  }

?>


<p>
</p>


</body>
</html>
