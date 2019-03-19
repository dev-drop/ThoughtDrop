<?php
require 'Includes/db.php'; require 'Includes/login.php';
require 'Includes/posts.php'; require 'Includes/EnableGoogleAuth.php';
require 'Includes/likes.php'; require 'Includes/comments.php';
require 'Includes/upload.php';

if (! empty($_SESSION['currentUser']))
{
?>

<html lang="en">
<head>
  <!--Meta for Open Graph-->
    <meta property="og:title" content="ThoughtDrop | Drop Your Thoughts" />
    <meta property="og:type" content="website" />
    <meta property="og:description" content="An internal social media platform with your employees in mind." />
    <meta property="og:url" content="http://localhost:8888/Semester5/ThoughtDrop%20Commits/ThoughtDropV1.6/home.php" />
    <meta property="og:image" content="http://localhost:8888/Semester5/ThoughtDrop%20Commits/ThoughtDropV1.6/images/ThoughtDropLogo.png" />
    <meta property="og:image:width" content="300" />
    <meta property="og:image:height" content="300" />
    <meta property="og:image:alt" content="ThoughtDrop logo" />

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ThoughtDrop</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.5.0/css/all.css" integrity="sha384-B4dIYHKNBt8Bc12p+WXckhzcICo0wtJAoU8YZTY5qE0Id1GSseTk6S+L3BlXeVIU" crossorigin="anonymous">
    <link href="https://fonts.googleapis.com/css?family=Raleway|Roboto" rel="stylesheet">

    <script src="//code.jquery.com/jquery-1.11.1.min.js"></script>
    <script src="scripts/ajax.js"></script>
    <script type="text/javascript" src="scripts/app.js"></script>


    <link rel="stylesheet" href="styles/main.css">
    <link rel="stylesheet" href="styles/responsive.css">


</head>
<body id="bod" data-spy="scroll" data-target=".navbar-light" data-offset="300">
<!-- USER PROFILE -------------------------------------------------------------->

<?php
    //*** FETCH USER INFO------------------------------------------------------------ ***
    $userInfo = userProf($pdo);

    //*** SAVE VALUES FROM SUPERGLOBALS ***
    $employee_id = $userInfo['employee_Id'];
    $display_name = $userInfo['display_name'];
    $userThumb = $userInfo['thumbnail'];
    $secret = $userInfo['secret'];
?>


<!--- EDIT MODAL -------------------------------------------------------------->
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
                        <input type="hidden" id="authorId" name="author_Id" values="">
                        <input type="hidden" id="editId" name="postId" value="" />
                        <input type="text" id="editBody" name="body" value="" maxlength="300"/>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-info btn-lg" name="edit">Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

<!--- UPLOAD IMAGE MODAL -------------------------------------------------------------->
    <div class="modal fade" id="uploadModal" role="dialog">
        <div class="modal-dialog">
            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Upload Image</h4><button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                 
                <form action="" method="post" enctype="multipart/form-data">
                    Select image to upload:
                    <input type="file" name="fileToUpload" id="fileToUpload">
                    <input type="submit" value="Upload Image" name="submitImage">
                </form>
                
            </div>
        </div>
    </div>        



<!-- AUTH MODAL -------------------------------------------------------------->
  <div class="modal fade" id="myAuth" role="dialog">
    <div class="modal-dialog modal-sm">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Google Authenticator</h4>
        </div>
        <div class="modal-body">
         <?php $authInfo = goAuthInit($ga);?>
          <img src="<?php echo $authInfo[1]; ?>" alt="">
          <p><?php echo $authInfo[0]; ?></p>
          <form action="" method="POST">
            <input type="hidden" name="secret" value="<?php echo $authInfo[0]; ?>">
            <input type="password" name="code" maxlength="6">
            <button class="google-btn" type="submit" name="submitCode">Enable GoogleAuth</button>
        </form>
        </div>
        <div class="modal-footer">
          <button type="button" class="google-btn" data-dismiss="modal">Close</button>
        </div>
      </div>
    </div>
  </div>

<!-- DisAUTH MODAL -------------------------------------------------------------->
  <div class="modal fade" id="disAuth" role="dialog">
    <div class="modal-dialog modal-sm">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Disable Google Authenticator</h4>
        </div>
        <div class="modal-body">
         <?php $authInfo = goAuthInit($ga);?>
          <form action="" method="POST">
            <input type="hidden" name="secretDis" value="<?php echo $secret; ?>">
            <input type="password" name="code" maxlength="6">
            <button class="btn btn-danger" type="submit" name="submitDisCode">Disable GoogleAuth</button>
        </form>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        </div>
      </div>
    </div>
  </div>





  <!-- Search Profile Modal -------------------------------------------------------------->
    <div class="modal fade" id="searchProfile" role="dialog">
      <div class="modal-dialog modal-lg">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            <h4 class="modal-title">View User Profile</h4>
          </div>
          <div class="modal-body Pbody">
            <div class="profileBody">

            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
          </div>
        </div>
      </div>
    </div>



<!--Navigation bar-------------------------------------------------------------->
<nav id="navbar" class="navbar fixed-top navbar-expand-lg navbar-light bg-light">
    <a class="navbar-brand" id="nav-brand" href="#">Company<span style="color:Red">XYZ</span></a><br>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
        <ul class="nav-pills navbar-nav" id="navbar-navv">


                      <li class="nav-item">
                        <form action="" method="POST" id='searchform'> <!---->
                          <input type="text" name="searchInput" id="searchbar">
                              <button class="searchbtn" type="submit" name="searchUsers"> <!--id="SearchForm"-->
                                <img id="searchimg" src="images/search.png"/>
                              </button>
                        </form>
                      </li>



            <form action="" method="post">
                <li class="nav-item">
                    <button class="logout" type="submit" name="logout">Logout</button>
                </li>
            </form>
        </ul>
    </div>
</nav>
<section class="bgimage">
    <div class="container-fluid">
        <div class="row">
          <img src="images/cloudswhite.png" id="cld1" alt="">
           <img src="images/cloudswhite.png" id="cld3" alt="">
           <img src="images/cloudswhite.png" id="cld2" alt="">
            <div class="hero-text">
                <img src="images/TDLogo300.png"/>
            </div>
        </div>
    </div>
</section>

<!---  Feed    ----------------------------------------------------------------->
<div class="newsfeed container-fluid">
<div class="row">
  <div class="profile-container col-md-2">
    <div class="profile-body">
      <div class="profile-img">
        <img src="<?php echo $userThumb ?>" alt="ProfileImg">
        <div id="overlay"><button type="button" class="editModal" data-toggle="modal" data-target="#uploadModal" ><i class="fas fa-camera-retro"></i>
          
        </button>
        </div>
      </div>
        <h2 style="font-weight: bolder;"><?php echo $display_name ?></h2>
        <h3 style="font-weight: 100;"><?php echo $employee_id ?></h3><br>
        <h6><i class="fas fa-thumbs-up thumb"></i>Likes:</h6><br>
        <h6><i class="fas fa-comment writecomment"></i>Comments:</h6><br>
        <?php
            if(!$_SESSION['GoogleAuth'])
            {
        ?>
        <button type="button" class="google-btn show" data-toggle="modal" data-target="#myAuth">Enable GoogleAuth</button>
        <?php }else{ ?>
        <button type="button" class="google-btn hidden " data-toggle="modal" data-target="#disAuth">Disable GoogleAuth</button>
        <?php } ?>

    </div>
  </div>

  <div class="col-md-8">



  <!-- NEW POST FORM -------------------------------------------------------------->
   <form action="" method="post">
        <div class="form-group" id="postStatus">
          <textarea placeholder="Drop Your Thoughts" class="form-control statusTA" name="postBody" maxlength="300" onkeyup="auto_grow(this)" row="1"></textarea>
          <button type="submit" class="btn statusTAsubmit " name="postContent"><img src="images/cloud-computing.png"/></button>
        </div>
        <div id="the-count">
          <span id="current">0</span>
          <span id="maximum">/ 300</span>
        </div>
    </form>



    <!--TAB NAVIGATION ---------------------------------------------------------------------->
        <ul class="nav nav-tabs" id="myTab" role="tablist">
          <li class="nav-item tab">
            <a class="nav-link active" id="all-tab" data-toggle="" href="?filter=allPosts" role="" aria-controls="" aria-selected="" >All</a>
          </li>
          <li class="nav-item tab">
            <a class="nav-link" id="rd-tab" data-toggle="" href="?filter=rdPosts" role="" aria-controls="" aria-selected="false" >R&D</a>
          </li>
          <li class="nav-item tab">
            <a class="nav-link" id="ms-tab" data-toggle="" href="?filter=msPosts" role="" aria-controls="" aria-selected="false">M&S</a>
          </li>
          <li class="nav-item tab">
            <a class="nav-link" id="admin-tab" data-toggle="" href="?filter=adPosts" role="" aria-controls="" aria-selected="false">Admin</a>
          </li>
        </ul>
        <div class="tab-content" id="myTabContent">


          <!-- FILTERED TEMPLATES SECTION ----------------------------------------------->
          <?php
            $filter = "allPosts";
            if(isset($_GET['filter'])){
                $filter = $_GET['filter'];
            }
            switch($filter){
                case "allPosts": $rows = allPosts($pdo);
                break;
                case "rdPosts": $rows = rdPosts($pdo);
                break;
                case "msPosts": $rows = msPosts($pdo);
                break;
                case "adPosts": $rows = adPosts($pdo);
                break;
            }
            foreach ($rows as $row)
                {
          ?>
          <div class="tab-pane fade show active posts" id="all" role="tabpanel" aria-labelledby="all-tab">
            <div data-post-id="<?php echo $row['Id']; ?>" class="card post <?php echo postColor($row['author_Id']); ?>">
              <div class="card-body cardheader">
              <div id="cardheader row">
                <h5 class="card-title"><img src="<?php echo assignImage($pdo, $row['author_Id']); ?>"> <?php echo displayName($pdo, $row['author_Id']); ?></h5>
                <p id="timestamp"><?php echo $row['timestamp'] ?></p>
              </div>
            </div>

              <div class="card-body">
                <p class="card-text"><?php echo $row['body']; ?></p>
                <div>
                  <button class="icon likePost"><i class="fas fa-thumbs-up thumb likeCount"> <?php echo getLikes($pdo, $row['Id'] ); ?></i></button>
                  <button class="icon commentPost"><i class="fas fa-comment writecomment"> <?php echo getCommentCount($pdo, $row['Id'] ); ?></i></button>


              <?php

//-------------- VALIDATE USER FOR ADMIN PERMISSIONS -------------------
                $adminOptions = validate_permissions($_SESSION['currentUser'], $row['author_Id']);
                if($adminOptions || ($_SESSION['userRole'] == 127)){
                ?>
              <div class="adminOpt">

<!-------------- OPEN EDIT MODAL WINDOW -------------------------------->
                  <button type="button" class="editModal icon" data-toggle="modal" data-target="#myModal" data-id="<?php echo $row['Id'];?>" data-author="<?php echo $row['author_Id']; ?>" data-val="<?php echo $row['body']; ?>" ><i class="fas fa-edit"></i></button>

                  <!-- DELETE POST FORM -->
                  <form action="" class="deleteForm" method="post">
                        <input type="hidden" name="postId" value="<?php echo $row['Id']; ?>" />
                        <button class="icon"  type="submit" name="delete"><i class="fas fa-trash"></i></button>
                  </form>
              </div>
            
<!-- COMMENTS & COMMENT FORM ----------------------------->
              <?php } ?>
              </div>
        </div>
              <div class="card-comment ">
                 <div class="comments-body "></div>
                  <form action="" method="post">
                       <div class="form-group" id="postComment">
                        <input type="hidden" name="post_Id" value="<?php echo $row['Id']; ?>">
                         <textarea placeholder="Write a Comment" class="form-control commentTA" name="commentBody" maxlength="300" onkeyup="auto_grow(this)" row="1"></textarea>
                         <button type="submit" class="btn statusTAsubmit" name="commentSubmit"><img src="images/sendSM.png"/></button>
                       </div>
                   </form>
                </div>
            </div>
          </div>
          <?php
            }
          ?>
        </div>
</div>

  <div class="col-md-2">
  </div>
</div>
</div>
<div class="footer">
  <div class="container-fluid">
    <div class="row">
      <div class="dev-footer">
      <h2>ThoughtDrop Developed with Love by Cameron & Jessica</h2>
      </div>
    </div>
</div>
</div>
<script src="scripts/scripts.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
</body>
</html>
<?php
}else{
   header("Location: http://localhost:8888/ThoughtDrop-master5/");
}
