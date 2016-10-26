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
                <li class="active"><a href="addActorDirector.php">Add Actor/Director</a></li>
                <li><a href="addMovie.php">Add Movie</a></li>
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
            <h1 class="page-header">Add Actor/Director</h1>

<?php
function validateDate($date)
{
    if($date == "" || $date == NULL) return true;
    $d = DateTime::createFromFormat('Y-m-d', $date);
    return $d && $d->format('Y-m-d') === $date;
}
?>
            <?php if(empty($_POST)){ ?>
            <form class="form-horizontal" action="#" method="post" >

                <div class="form-group required">
                    <div class="col-sm-offset-2 col-sm-10">
                        <label class="radio-inline">
                            <input type="radio" name="role" id="actor" value="actor"> Actor
                        </label>
                        <label class="radio-inline">
                            <input type="radio" name="role" id="director" value="director"> Director
                        </label>
                    </div>
                </div>

                <div class="form-group required">
                    <label for="firstname" class="col-sm-2 control-label">First Name</label>
                    <div class="col-sm-10">
                        <input type="text" name="firstname" class="form-control" id="firstname" placeholder="First Name">
                    </div>
                </div>
                <div class="form-group required">
                    <label for="lastname" class="col-sm-2 control-label">Last Name</label>
                    <div class="col-sm-10">
                        <input type="text" name="lastname" class="form-control" id="lastname" placeholder="Last Name">
                    </div>
                </div>

                <div class="form-group">
                    <div class="col-sm-offset-2 col-sm-10">
                        <label class="radio-inline">
                            <input type="radio" name="sex" id="male" value="male"> Male
                        </label>
                        <label class="radio-inline">
                            <input type="radio" name="sex" id="female" value="male"> Female
                        </label>
                    </div>
                </div>

                <div class="form-group required">
                    <label for="dob" class="col-sm-2 control-label">Date of Birth</label>
                    <div class="col-sm-10">
                        <input type="text" name="dob" class="form-control" id="dob" placeholder="1990-01-01">
                    </div>
                </div>

                <div class="form-group">
                    <label for="dob" class="col-sm-2 control-label">Date of Death</label>
                    <div class="col-sm-10">
                        <input type="text" name="dod" class="form-control" id="dob" placeholder="1990-01-01">
                        <span id="helpBlock" class="help-block">This field can be left empty.</span>
                    </div>
                </div>

                <div class="form-group">
                    <div class="col-sm-offset-2 col-sm-10">
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </div>
                </div>
            </form>
            <?php }
            else  {
                $db = new mysqli('localhost', 'cs143', '', 'CS143');
                if ($db->connect_errno > 0) {
                    die('Unable to connect to database [' . $db->connect_error . ']');
                }
                $role = $_POST["role"];
                $firstname = $db->real_escape_string(trim($_POST["firstname"]));
                $lastname = $db->real_escape_string(trim($_POST["lastname"]));
                $sex = $_POST["sex"];
                $dob = trim($_POST["dob"]);
                $dod = trim($_POST["dod"]);
                if($dod == "") $dod = NULL;
                if($role=="") {
                    echo "<div class='alert alert-danger' role='alert'><h4>You got an error!</h4>Please select <strong>Actor</strong> or <strong>Director</strong>.</div><a href='addActorDirector.php'><button class='btn btn-danger'>Try again</button></a>";
                    $db->close();
                    return 0;
                }
                else if($firstname=="") {
                    echo "<div class='alert alert-danger' role='alert'><h4>You got an error!</h4><strong>First Name</strong> is required.</div><a href='addActorDirector.php'><button class='btn btn-danger'>Try again</button></a>";
                    $db->close();
                    return 0;
                }
                else if($lastname=="") {
                    echo "<div class='alert alert-danger' role='alert'><h4>You got an error!</h4><strong>Last Name</strong> is required.</div><a href='addActorDirector.php'><button class='btn btn-danger'>Try again</button></a>";
                    $db->close();
                    return 0;
                }
                else if($role=="actor" and $sex=="") {
                    echo "<div class='alert alert-danger' role='alert'><h4>You got an error!</h4>Please select <strong>Male</strong> or <strong>Female</strong>.</div><a href='addActorDirector.php'><button class='btn btn-danger'>Try again</button></a>";
                    $db->close();
                    return 0;
                }
                else if($dob=="") {
                    echo "<div class='alert alert-danger' role='alert'><h4>You got an error!</h4><strong>Date of Birth</strong> is required.</div><a href='addActorDirector.php'><button class='btn btn-danger'>Try again</button></a>";
                    $db->close();
                    return 0;
                }

                if(!validateDate($dod) || !validateDate($dob)){
                    echo "<div class='alert alert-danger' role='alert'><h4>You got an error!</h4><strong>Date</strong> format is incorrect.</div><a href='addActorDirector.php'><button class='btn btn-danger'>Try again</button></a>";
                    $db->close();
                    return 0;
                }



                $rs = $db->query("SELECT id FROM MaxPersonID");
                $maxID = intval($rs->fetch_assoc()['id'])+1;
                $rs->free();
                $db->autocommit(FALSE);
                $success = true;
                $errormsg = "";
                if($role == "actor") {
                    $stmt = $db->prepare("INSERT INTO Actor (id, last, first, sex, dob, dod) VALUES (?, ?, ?, ?, ?, ?)");
                    $stmt->bind_param("isssss", $maxID, $lastname, $firstname, $sex, $dob, $dod);
                    $success = $stmt->execute();
                    if(!$success) $errormsg = $stmt->error;
                    $stmt = $db->prepare("UPDATE MaxPersonID SET id = id +1");
                    $success = $stmt->execute();
                    if(!$success) $errormsg = $stmt->error;
                } else if($role == "director") {
                    $stmt = $db->prepare("INSERT INTO Director (id, last, first, dob, dod) VALUES (?, ?, ?, ?, ?)");
                    $stmt->bind_param("isssss", $maxID, $lastname, $firstname, $dob, $dod);
                    $success = $stmt->execute();
                    if(!$success) $errormsg = $stmt->error;
                    $stmt = $db->prepare("UPDATE MaxPersonID SET id = id +1");
                    $success = $stmt->execute();
                    if(!$success) $errormsg = $stmt->error;
                } else {
                    echo "<div class='alert alert-danger' role='alert'><h4>You got an error!</h4><strong>Actor or Director</strong> is required.</div><a href='addActorDirector.php'><button class='btn btn-danger'>Try again</button></a>";
                    $db->close();
                    return 0;
                }
                if(!$db->commit() || !$success){
                    echo "<div class='alert alert-danger' role='alert'><h4>You got an error!</h4>There is an error while inserting: " .$errormsg."</div>";
                    $db->rollback();
                } else {
                    ?>
                    <div class="alert alert-success" role="alert">
                        <p><strong>Well done!</strong> The <?php if($role == "actor"){echo "Actor";} else {echo "Director";}?> has been successfully added: </p>
                        <ul>
                            <li>Name: <?php echo $firstname." ".$lastname?></li>
                            <?php if($role == "actor") echo "<li>Sex:".$sex."</li>"; ?>
                            <li>Date of Birth: <?php echo $dob ?></li>
                            <?php if($dod != NULL) echo "<li>Date of Death:".$dod."</li>"; ?>

                        </ul>

                    </div>
                    <?php
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



</body>
</html>
