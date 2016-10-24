<!DOCTYPE html>
<html lang="en">
<head>
    <title>Moviw Database Project</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
</head>

<body>
    <nav class="navbar navbar-default"> 
        <!-- Add Actor or Director -->
        <div style="text-align: center">

        <button type="button" class="btn btn-primary navbar-btn" onClick="location.href='addActororDirector.php'">Add Actor/Director </button>

        <!-- Add Movie -->
        <button type="button" class="btn btn-success navbar-btn" onClick="location.href='addMovie.php'"> Add Movie </button>

        <!--Add Comment  -->
        <button type="button" class="btn btn-info navbar-btn">Add Comment</button>

        <!-- Add Actor/Movie Relation -->
        <button type="button" class="btn btn-warning navbar-btn">Add Actor/Movie</button>

        <!-- Add Director/Movie Relation -->
        <button type="button" class="btn btn-danger navbar-btn">Add Director/Movie</button>
        </div>
    </nav>
    <div class="jumbotron">
     <h1 class="text-center"> Movie</h1>
    </div>

    <form action="search.php" method="get">
    <div class="row">
       <div class="col-md-8 col-md-offset-2">

        <div class="form-group">
         <label>Search for Actors/Actresses/Movies</label>
            <!-- Put Submit Button on the right of text-->
         
         <input type="text" class="form-control" placeholder="Tom Hanks" name="search">
         <button type="submit" class="btn btn-primary">Submit</button>
            
        </div>
       </div>
    </div>
    </form>

<?php

?>
</body>
</html>

