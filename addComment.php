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
                <li class="active"><a href="addComment.php">Add Comment</a></li>
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
            <h1 class="page-header">Add Comment</h1>
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
                    <label for="name" class="col-sm-2 control-label">Your Name</label>
                    <div class="col-sm-10">
                        <input type="text" name="name" class="form-control" id="name" style="width: 60%">
                    </div>
                </div>

                <div class="form-group required">
                    <label for="rating" class="col-sm-2 control-label">Rating</label>
                    <div class="col-sm-10">
                        <select name="rating" id="rating" class="form-control"  style="width: 60%">
                            <option>5</option>
                            <option>4</option>
                            <option>3</option>
                            <option>2</option>
                            <option>1</option>
                        </select>
                    </div>
                </div>

                <div class="form-group required">
                    <label for="comment" class="col-sm-2 control-label">Comment</label>
                    <div class="col-sm-10">
                        <textarea name="comment" id="comment" class="form-control" rows="3" style="width: 60%" placeholder="Less than 500 characters."></textarea>
                    </div>
                </div>


                <div class="form-group required">
                    <div class="col-sm-offset-2 col-sm-10">
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </div>
                </div>



            </form>


            <?php }

            else {




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
