<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Movie Database</title>
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/index.css" rel="stylesheet">
    <link href="css/select2.min.css" rel="stylesheet">


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
                <li><a href="addMovie.php">Add Movie</a></li>
                <li><a href="addComment.php">Add Comment</a></li>
                <li><a href="addMovieActor.php">Add Actor to Movie</a></li>
                <li class="active"><a href="addMovieDirector.php">Add Director to Movie</a></li>
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
            <h1 class="page-header">Add Director to Movie</h1>

            <?php if(empty($_POST)){
                ?>
                <form class="form-horizontal" action="#" method="post" >

                    <div class="form-group required">
                        <label for="movie" class="col-sm-2 control-label">Title</label>
                        <div class="col-sm-10">
                            <select id=movie name="mid" class="movie-select" style="width: 60%">
                                    <?php
                                    $db = new mysqli('localhost', 'cs143', '', 'CS143');
                                    if ($db->connect_errno > 0) {
                                        die('Unable to connect to database [' . $db->connect_error . ']');
                                    }
                                    $rs = $db->query("SELECT * FROM Movie");
                                    $rs->fetch_assoc();
                                    while($row = $rs->fetch_assoc()) {
                                        $mid = $row['id'];
                                        $title = $row['title'];
                                        echo "<option value='".$mid."'>".$title."</option>";
                                    }
                                    $rs->free();
                                    ?>
                            </select>
                        </div>
                    </div>


                    <div class="form-group required">
                        <label for="director" class="col-sm-2 control-label">Director</label>
                        <div class="col-sm-10">
                            <select id="director" name="aid" class="director-select" style="width: 60%">
                                <?php
                                $rs = $db->query("SELECT * FROM Director");
                                $rs->fetch_assoc();
                                while($row = $rs->fetch_assoc()) {
                                    $did = $row['id'];
                                    $first = $row['first'];
                                    $last = $row['last'];
                                    echo "<option value='".$did."'>".$first." ".$last."</option>";
                                }
                                $rs->free();
                                $db->close();
                                ?>
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

                $mid = $_POST["mid"];
                $did = $_POST["did"];


                $stmt = $db->prepare("INSERT INTO MovieDirector (mid, did) VALUES (?, ?)");
                $stmt->bind_param("ii", $mid, $did);
                if($stmt->execute()) {
                    ?>
                    <div class="alert alert-success" role="alert">
                        <p><strong>Well done!</strong> The Movie Director has been successfully added. </p>
                    </div>
                    <?php
                } else {
                    echo "<div class='alert alert-danger' role='alert'><h4>You got an error!</h4>Somthing went wrong: $stmt->error.</div>";
                }
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
<script src="js/select2.full.min.js"></script>

<script type="text/javascript">
    $(document).ready(function() {
        $(".movie-select").select2();
        $(".director-select").select2();
    });
</script>

</body>
</html>
