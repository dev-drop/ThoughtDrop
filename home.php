<?php
require 'Includes/db.php'; require 'Includes/login.php'; require 'Includes/posts.php';
if (! empty($_SESSION['currentUser']))
{
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ThoughtDrop</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.5.0/css/all.css" integrity="sha384-B4dIYHKNBt8Bc12p+WXckhzcICo0wtJAoU8YZTY5qE0Id1GSseTk6S+L3BlXeVIU" crossorigin="anonymous">
    <link href="https://fonts.googleapis.com/css?family=Raleway|Roboto" rel="stylesheet">
    <script src="//code.jquery.com/jquery-1.11.1.min.js"></script>

    <link rel="stylesheet" href="styles/main.css">


</head>
<body id="bod" data-spy="scroll" data-target=".navbar-light" data-offset="300">
<!-- EDIT MODAL -->
    <div class="modal fade" id="myModal" role="dialog">
        <div class="modal-dialog">
            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Edit Post</h4><button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <!-- EDIT FORM -->
                <form action="" method="post">
                    <div class="modal-body">
                        <input type="hidden" id="editId" name="postId" value="" />
                        <input type="text" id="editBody" name="body" value="" />
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-info btn-lg" name="edit">Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>


<!--Navigation bar-->
<nav id="navbar" class="navbar fixed-top navbar-expand-lg navbar-light bg-light">
    <a class="navbar-brand" id="nav-brand" href="#">Company<span style="color:Red">XYZ</span></a><br>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
        <ul class="nav-pills navbar-nav" id="navbar-navv">

            <li class="nav-item">
              <div class="input-group mb-3 searchform">
                <input id="searchbar" type="text" class="form-control" placeholder="Search" aria-label="Search" aria-describedby="button-addon2">
                <div class="input-group-append">
                    <button class="btn btn-outline-light btn-sm searchbtn" type="button" id="button-addon2"><img id="searchimg" src="images/search.png"/></button>
                </div>
              </div>

            </li>
            <form action="" method="post">
                <li class="nav-item">
                    <button type="submit" name="logout">Logout</button>
                </li>
            </form>
        </ul>
    </div>
</nav>
<section class="bgimage">
    <div class="container-fluid">
        <div class="row">
            <div class="hero-text">
                <h1>ThoughtDrop</h1>
            </div>
        </div>
    </div>
</section>
<!--  An employee ID starts with a letter designating the department, followed by five numbers. D for R&D; S for marketing, sales, & support; and A for administration.

My employee ID is A00142 for example.

  We still want to allow our employees to set their own display name, though. We think it would be good if the social platform would display the employee ID if no display name is set up, or else the display name with the employee ID behind it in brackets.

  Does that make sense? We have an internal list of all employee IDs including names that is accessible by all employees, so the information is not sensitive within our company. The codes are used for our phone system and email. -->


<!---  Feed    ----------------------------------------------------------------->
<!-- USER PROFILE -->
<?php
    //*** FETCH USER INFO ***
    $userInfo = userProf($pdo);

    //*** FETCH ALL POSTS ***
    //$posts = allPosts($pdo);

    //*** SAVE VALUES FROM SUPERGLOBALS ***
    $employee_id = $userInfo['employee_Id'];
    $display_name = $userInfo['display_name'];
    $userThumb = $userInfo['thumbnail'];
?>

<div class="newsfeed container-fluid">
<div class="row">
  <div class="profile-container col">
    <div class="profile-body">
      <div class="profile-img">
        <img src="images/LindainAdmin.jpg" alt="ProfileImg">
        <div id="overlay"><button type="button" class="btn btn-info btn-lg editModal" data-toggle="modal" data-target="/#myModal" ><i class="fas fa-camera-retro"></i>
          <!--data-id=<"<?php echo $row['Id']; ?>" data-val="<?php echo $row['body']; ?>" -->
        </button></div>
      </div>
        <h2><?php echo $display_name ?></h2>
        <h3><?php echo $employee_id ?></h3>

    </div>
  </div>

  <div class="col-8">
  <!-- NEW POST FORM -->
   <form action="" method="post">
        <div class="form-group">
          <textarea placeholder="Drop Your Thoughts" class="form-control statusTA" id="exampleFormControlTextarea3" name="postBody" maxlength="300" onkeyup="auto_grow(this)" row="1"></textarea>
          <button type="submit" class="btn btn-info btn-lg" name="postContent">Post</button>
          <div id="the-count">
            <span id="current">0</span>
            <span id="maximum">/ 300</span>
          </div>
        </div>
    </form>
    <!------------------>
        <ul class="nav nav-tabs" id="myTab" role="tablist">
          <li class="nav-item tab">
            <a class="nav-link active" id="all-tab" data-toggle="" href="" role="" aria-controls="" aria-selected="" onclick="tabFilter(1)">All</a>
          </li>
          <li class="nav-item tab">
            <a class="nav-link" id="rd-tab" data-toggle="" href="" role="" aria-controls="" aria-selected="" onclick="">R&D</a>
          </li>
          <li class="nav-item tab">
            <a class="nav-link" id="ms-tab" data-toggle="tab" href="#ms" role="tab" aria-controls="ms" aria-selected="false">M&S</a>
          </li>
          <li class="nav-item tab">
            <a class="nav-link" id="admin-tab" data-toggle="tab" href="#admin" role="tab" aria-controls="admin" aria-selected="false">Admin</a>
          </li>
        </ul>
        <div class="tab-content" id="myTabContent">
          <!--ALL TAB CONTENT----------------------------------------------->
          <?php
            $rows = allPosts($pdo);
            if($rows[1] == "all"){
            foreach ($rows[0] as $row)
                {
          ?>
          <div class="tab-pane fade show active" id="all" role="tabpanel" aria-labelledby="all-tab">
            <div class="card">
              <div class="card-body">
                <h5 class="card-title"><?php echo $row['timestamp']." "; echo $row['author_Id']; ?></h5>
                <p class="card-text"><?php echo $row['body']; ?></p>
              </div>
              <?php
                //VALIDATE USER FOR ADMIN PERMISSIONS
                $adminOptions = validate_permissions($_SESSION['currentUser'], $row['author_Id']);
                if($adminOptions){
                ?>
              <div class="adminOpt">
                  <!-- OPEN EDIT MODAL WINDOW -->
                 <button type="button" class="btn btn-info btn-lg editModal" data-toggle="modal" data-target="#myModal" data-id="<?php echo $row['Id']; ?>" data-val="<?php echo $row['body']; ?>" >Edit Post</button>
                  <!-- DELETE POST FORM -->
                  <form action="" class="deleteForm" method="post">
                        <input type="hidden" name="postId" value="<?php echo $row['Id']; ?>" />
                        <button class="btn btn-info btn-lg"  type="submit" name="delete">Delete</button>
                  </form>
              </div>
              <?php } ?>
            </div>
          </div>
          <?php
            }
            }
          ?>
          <!--RD TAB CONTENT----------------------------------------------->
          <?php
            //$rows = rdPosts($pdo);
            if($rows[1] == "RD"){
            foreach ($rows[0] as $row)
                {
          ?>
          <div class="tab-pane fade show active" id="RD" role="tabpanel" aria-labelledby="all-tab">
            <div class="card">
              <div class="card-body">
                <h5 class="card-title"><?php echo $row['timestamp']." "; echo $row['author_Id']; ?></h5>
                <p class="card-text"><?php echo $row['body']; ?></p>
              </div>
              <?php
                //VALIDATE USER FOR ADMIN PERMISSIONS
                $adminOptions = validate_permissions($_SESSION['currentUser'], $row['author_Id']);
                if($adminOptions){
                ?>
              <div class="adminOpt">
                  <!-- OPEN EDIT MODAL WINDOW -->
                 <button type="button" class="btn btn-info btn-lg editModal" data-toggle="modal" data-target="#myModal" data-id="<?php echo $row['Id']; ?>" data-val="<?php echo $row['body']; ?>" >Edit Post</button>
                  <!-- DELETE POST FORM -->
                  <form action="" class="deleteForm" method="post">
                        <input type="hidden" name="postId" value="<?php echo $row['Id']; ?>" />
                        <button class="btn btn-info btn-lg"  type="submit" name="delete">Delete</button>
                  </form>
              </div>
              <?php } ?>
            </div>
          </div>
          <?php
            }
            }
          ?>

          <!--ALL TAB CONTENT----------------------------------------------->
          <div class="tab-pane fade" id="ms" role="tabpanel" aria-labelledby="ms-tab">
            <div class="tab-pane fade show active" id="" role="tabpanel" aria-labelledby="all-tab">
              <div class="card ms">
                <div class="card-body">
                  <h5 class="card-title">Username</h5>
                  <h6 class="card-subtitle mb-2 text-muted">TESTING ONE</h6>
                  <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p>
                </div>
              </div>
            </div>
          </div>

          <!--ALL TAB CONTENT----------------------------------------------->
          <div class="tab-pane fade" id="admin" role="tabpanel" aria-labelledby="admin-tab">
            <div class="tab-pane fade show active" id="" role="tabpanel" aria-labelledby="all-tab">
              <div class="card admin">
                <div class="card-body">
                  <h5 class="card-title">Username</h5>
                  <h6 class="card-subtitle mb-2 text-muted">TESTING two</h6>
                  <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p>
                </div>
              </div>
            </div>
          </div>
        </div>
</div>

  <div class="col">
  </div>
</div>
</div>
<script>
    function tabFilter(filter){
    if(filter == 1){
        <?php $rows = allPosts($pdo); ?>
    }

}
    </script>

<script src="scripts/scripts.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
</body>
</html>
<?php
}else{
   header("Location: http://localhost:8888/Semester5/ThoughtDrop%20Commits/ThoughDrop%20V1.2/");
}
