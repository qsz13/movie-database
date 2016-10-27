<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Movie Database</title>
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/index.css" rel="stylesheet">

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
                <li><a href="addMovieDirector.php">Add Director to Movie</a></li>
            </ul>

            <ul class="nav nav-sidebar">
                <li><label class="tree-toggle nav-header">Browse data</label></li>
                <li><a href="showActor.php">Show Actor</a></li>
                <li class="active"><a href="showMovie.php">Show Movie</a></li>
            </ul>
            <ul class="nav nav-sidebar">
                <li><label class="tree-toggle nav-header">Search data</label></li>
                <li><a href="search.php">Search</a></li>
            </ul>
        </div>
        <div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">

            <?php if(!isset($_GET['id'])) { ?>

                <h1 class="page-header">Show Movie</h1>
                <div class="row">
                    <div class="col-sm-10 col-sm-offset-1">
                        <form class="form-group" action="#" method="GET">
                            <div class="col-sm-8">
                                <input name="query" type="search" placeholder="Movie Title" class="form-control">
                            </div>
                            <div class="col-sm-2">
                                <input type="submit" class="btn btn-primary" value="Search">
                            </div>
                        </form>
                    </div>
                </div>


                <?php if (isset($_GET['query'])) { ?>
                    <h4 class="top20">Showing results for "<?php echo $_GET['query'] ?>":</h4>
                    <?php
                    $db = new mysqli('localhost', 'cs143', '', 'CS143');
                    if ($db->connect_errno > 0) {
                        die('Unable to connect to database [' . $db->connect_error . ']');
                    }
                    $query = trim($_GET['query']);
                    $query = implode(" ", preg_split('/\s+/', $query));
                    $statement = $db->prepare("SELECT id, title, year FROM Movie WHERE Movie.title LIKE ?");
                    $search_keyword = "%".$db->real_escape_string($query)."%";
                    $statement->bind_param("s", $search_keyword);
                    if ($statement->execute()) {
                        $result = $statement->store_result();
                        $row_num = $statement->num_rows;
                        ?>
                        <p class="top20">Get <?php echo $row_num ?> results.</p>
                        <?php
                        $statement->bind_result($mid, $title, $year);
                        if($row_num > 0){?>

                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Title</th>
                                        <th>Year</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    while ($statement->fetch()) {
                                        echo "<tr><td>".$mid."</td><td><a href='showMovie.php?id=".$mid."'>".$title ."</a></td><td>".$year.'</td></tr>';
                                    }
                                    ?>
                                </tbody>
                            </table>

                        <?php
                        }
                    } else {
                        echo "There is an error while querying: " . $statement->error;
                    }
                    $statement->free_result();
                }

            } else {
                $db = new mysqli('localhost', 'cs143', '', 'CS143');
                if ($db->connect_errno > 0) {
                    die('Unable to connect to database [' . $db->connect_error . ']');
                }
                $mid = intval($_GET['id']);
                if($mid<=0) {
                    echo "<div class='alert alert-danger' role='alert'><h4>You got an error!</h4>Movie id wrong.</div>";
                    $db->close();
                    return 0;
                }
                $statement = $db->prepare("SELECT * FROM Movie WHERE Movie.id = ?");
                $statement->bind_param("s", $mid);
                if($statement->execute()) {
                    $statement->bind_result($mid, $title, $year, $rating, $company);
                    $statement->fetch();
                    $statement->free_result();
                    $statement = $db->prepare("SELECT genre FROM MovieGenre WHERE mid = ?");
                    $statement->bind_param("s",$mid);
                    $statement->bind_result($genre);
                    $statement->execute();
                    while ($statement->fetch()) {
                        $genres[]=$genre;

                    }
                    $statement->free_result();
                    $statement = $db->prepare("SELECT AVG(rating),COUNT(*) FROM Review WHERE mid = ?");
                    $statement->bind_param("s", $mid);
                    $statement->bind_result($avg_rating, $review_count);
                    $statement->execute();
                    $statement->fetch();
                    $statement->free_result();

                    ?>
                    <h1 class="page-header"><?php echo $title?>  <small>(<?php echo $year?>)</small></h1>
                    <h4><span class="label label-danger"><?php echo $rating?></span> | <?php foreach($genres as $g){echo "<span class=\"label label-default\">$g</span> ";}?> </h4>
                    <p class="top20"><strong>Produce Company</strong>: <?php echo $company?> </p>
                    <p><strong>Average Rating</strong>:
                    <?php
                    for ($i = 0; $i < intval($avg_rating); $i++){
                        echo "<span class=\"glyphicon glyphicon-star\" style=\"color:#ffd700\" aria-hidden=\"true\"></span>";
                    }
                        ?>
                    (<?php echo number_format($avg_rating, 2)?>/5)</p>
                    <h4 class="page-header">Comment</h4>

                    <form class="form-horizontal" action="addComment.php" method="post" >
                        <input type="hidden" name="mid" value="<?php echo $mid ?>">
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




                    <?php
                    $statement = $db->prepare("SELECT * FROM Review WHERE Review.mid = ?");
                    $statement->bind_param("s", $mid);
                    $statement->execute();
                    if($statement->execute()) {
                        $statement->bind_result($name, $time, $mid, $rating, $comment);
                        $statement->store_result();
                        if($statement->num_rows>0){


                        ?>
                <div class="panel panel-default">
                <!-- Default panel contents -->
                <div class="panel-heading"><strong>All Comments</strong> <span class="badge"><?php echo $review_count?></span></div>

                <!-- List group -->
                <ul class="list-group">
                        <?php
                        while($statement->fetch()){
                        ?>

                            <li class="list-group-item">
                                <p><strong><?php echo $name?></strong>
                                <?php for ($i = 0; $i < $rating; $i++) {
                                    echo "<span class=\"glyphicon glyphicon-star\" style=\"color:#ffd700\" aria-hidden=\"true\"></span>";
                                }
                                ?> <?php echo $time ?></p>
                                <p><?php echo $comment?></p>

                            </li>


                            <?php

                        }

                        ?>

                    </ul>
                    </div>

                    <?php
                        }
                    } else {
                        echo "There is an error getting comments: " . $statement->error;

                    }

                    ?>





                    <?php
                }
                else{
                    echo "There is an error while querying: " . $statement->error;
                }
                $statement->free_result();
                $db->close();

            } ?>












        </>
    </div>
</div>
</div>

<!-- Bootstrap core JavaScript
================================================== -->
<!-- Placed at the end of the document so the pages load faster -->
<script src="js/jquery.min.js"></script>
<script src="js/bootstrap.min.js"></script>



</body>
</html>
