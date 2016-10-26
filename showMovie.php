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
                    $db->close();
                }

            } else {
                $db = new mysqli('localhost', 'cs143', '', 'CS143');
                if ($db->connect_errno > 0) {
                    die('Unable to connect to database [' . $db->connect_error . ']');
                }
                $mid = $_GET['id'];
                $statement = $db->prepare("SELECT * FROM Movie WHERE Movie.id = ?");
                $statement->bind_param("s", $mid);
                if($statement->execute()) {
                    $statement->bind_result($mid, $title, $year, $rating, $company);
                    $statement->fetch();
                    ?>
                    <h1 class="page-header"><?php echo $title?>  <small>(<?php echo $year?>)</small></h1>
                    <p>Title: <?php echo $title?></p>
                    <p>Year: <?php echo $year?></p>
                    <p>Rating: <?php echo $rating?> </p>
                    <p>Produce Company: <?php echo $company?> </p>
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
