<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Movie Database</title>
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/index.css" rel="stylesheet">
    <link href="css/bootstrap-select.min.css" rel="stylesheet">


</head>

<body>

<nav class="navbar navbar-inverse navbar-fixed-top">
    <div class="container-fluid">
        <div class="navbar-header">
            <a class="navbar-brand" href="index.php">Movie Database</a>
        </div>
    </div>
</nav>

<div class="container-fluid">
    <div class="row">
        <div class="col-sm-3 col-md-2 sidebar">
            <ul class="nav nav-sidebar">
                <li><a href="index.php">Overview</a></li>
            </ul>
            <ul class="nav nav-sidebar">
                <li><label class="tree-toggle nav-header">Input data</label></li>
                <li><a href="addActorDirector.php">Add Actor/Director</a></li>
                <li class="active"><a href="addMovie.php">Add Movie</a></li>
                <li><a href="addComment.php">Add Comment</a></li>
                <li><a href="addMovieActor.php">Add Actor to Movie</a></li>
                <li><a href="addMovieDirector.php">Add Director to Movie</a></li>
            </ul>

            <ul class="nav nav-sidebar">
                <li><label class="tree-toggle nav-header">Browse data</label></li>
                <li><a href="showActor.php">Show Actor</a></li>
                <li><a href="showMovie.php">Show Movie</a></li>
            </ul>
            <ul class="nav nav-sidebar">
                <li><label class="tree-toggle nav-header">Search data</label></li>
                <li><a href="search.php">Search</a></li>
            </ul>
        </div>
        <div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">
            <h1 class="page-header">Add Movie</h1>
            <?php if(empty($_POST)){ ?>
            <form class="form-horizontal" action="#" method="post" >


                <div class="form-group required">
                    <label for="title" class="col-sm-2 control-label">Title</label>
                    <div class="col-sm-10">
                        <input type="text" name="title" class="form-control" id="title" placeholder="Title">
                    </div>
                </div>
                <div class="form-group required">
                    <label for="company" class="col-sm-2 control-label">Company</label>
                    <div class="col-sm-10">
                        <input type="text" name="company" class="form-control" id="company" placeholder="Company Name">
                    </div>
                </div>


                <div class="form-group required">
                    <label for="year" class="col-sm-2 control-label">Year</label>
                    <div class="col-sm-10">
                        <input type="text" name="year" class="form-control" id="year" placeholder="1990">
                    </div>
                </div>

                <div class="form-group required">
                    <label for="rating" class="col-sm-2 control-label">MPAA Rating</label>
                    <div class="col-sm-10">
                        <select name="rating" id="rating" class="form-control">
                            <option>G</option>
                            <option>PG</option>
                            <option>PG-13</option>
                            <option>NC-17</option>
                            <option>R</option>
                        </select>
                    </div>
                </div>

                <div class="form-group required">
                    <label for="genre" class="col-sm-2 control-label">Genre</label>
                    <div class="col-sm-10">
                        <select name="genre[]" id="genre" class="selectpicker" multiple>
                            <option>Action</option>
                            <option>Adult</option>
                            <option>Adventure</option>
                            <option>Animation</option>
                            <option>Comedy</option>
                            <option>Crime</option>
                            <option>Documentary</option>
                            <option>Drama</option>
                            <option>Family</option>
                            <option>Fantasy</option>
                            <option>Horror</option>
                            <option>Musical</option>
                            <option>Mystery</option>
                            <option>Romance</option>
                            <option>Sci-Fi</option>
                            <option>Short</option>
                            <option>Thriller</option>
                            <option>War</option>
                            <option>Western</option>
                        </select>
                    </div>
                </div>




                <div class="form-group">
                    <div class="col-sm-offset-2 col-sm-10">
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </div>
                </div>
            </form>
            <?php }
            else {

                $db = new mysqli('localhost', 'cs143', '', 'CS143');
                if ($db->connect_errno > 0) {
                    die('Unable to connect to database [' . $db->connect_error . ']');
                }
                $title = $db->real_escape_string(trim($_POST["title"]));
                $company = $db->real_escape_string(trim($_POST["company"]));
                $year = intval($_POST["year"]);
                $rating = $_POST["rating"];
                $genres = $_POST["genre"];

                if($title=="") {
                    echo "<div class='alert alert-danger' role='alert'><h4>You got an error!</h4><strong>Title</strong> is required.</div><a href='addMovie.php'><button class='btn btn-danger'>Try again</button></a>";
                    $db->close();
                    return 0;
                } else if($company=="") {
                    echo "<div class='alert alert-danger' role='alert'><h4>You got an error!</h4><strong>Company</strong> is required.</div><a href='addMovie.php'><button class='btn btn-danger'>Try again</button></a>";
                    $db->close();
                    return 0;
                } else if($year <1800 || $year > 2100) {
                    echo "<div class='alert alert-danger' role='alert'><h4>You got an error!</h4><strong>Year</strong> is incorrect.</div><a href='addMovie.php'><button class='btn btn-danger'>Try again</button></a>";
                    $db->close();
                    return 0;
                } else if($rating ==""){
                    echo "<div class='alert alert-danger' role='alert'><h4>You got an error!</h4><strong>Rating</strong> is incorrect.</div><a href='addMovie.php'><button class='btn btn-danger'>Try again</button></a>";
                    $db->close();
                    return 0;
                }

                $rs = $db->query("SELECT id FROM MaxMovieID");
                $maxID = intval($rs->fetch_assoc()['id'])+1;
                $rs->free();
                $db->autocommit(FALSE);
                $success = true;
                $errormsg = "";
                $stmt = $db->prepare("INSERT INTO Movie (id, title, year, rating, company) VALUES (?, ?, ?, ?, ?)");
                $stmt->bind_param("issss", $maxID, $title, $year, $rating, $company);
                $success = $stmt->execute();
                if(!$success) $errormsg = $stmt->error;
                $stmt->free_result();

                $stmt = $db->prepare("UPDATE MaxMovieID SET id = id +1");
                $success = $stmt->execute();
                if(!$success) $errormsg = $stmt->error;
                $stmt->free_result();


                $stmt = $db->prepare("INSERT INTO MovieGenre (mid, genre) VALUES (?, ?)");
                $stmt->bind_param("is", $maxID, $movie_genre);
                foreach($genres as $g) {
                    $movie_genre = $g;
                    $success = $stmt->execute();
                    if(!$success) $errormsg = $stmt->error;
                }
                if(!$db->commit() || !$success){
                    echo "<div class='alert alert-danger' role='alert'><h4>You got an error!</h4>There is an error while inserting: " .$errormsg."</div>";
                    $db->rollback();
                } else {
                    ?>

                    <div class="alert alert-success" role="alert">
                        <p><strong>Well done!</strong> The Movie has been successfully added: </p>
                        <ul>
                            <li>ID: <?php echo $maxID?></li>
                            <li>Title: <?php echo $title?></li>
                            <li>Year: <?php echo $year?></li>
                            <li>Rating: <?php echo $rating?></li>
                            <li>Company: <?php echo $company ?></li>
                            <li>Genre: <?php
                                foreach ($genres as $g) {
                                    echo $g.", ";
                                }
                            ?></li>
                        </ul>

                    </div>
                <?php }
                $stmt->free_result();
                $db->close();
            }


?>


        </div>
    </div>
</div>
</div>

<!-- Bootstrap core JavaScript
================================================== -->
<!-- Placed at the end of the document so the pages load faster -->
<script src="js/jquery.min.js"></script>
<script src="js/bootstrap.min.js"></script>
<script src="js/bootstrap-select.min.js"></script>



</body>
</html>
