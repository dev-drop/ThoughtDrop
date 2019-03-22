<?php
require "db.php";
date_default_timezone_set('America/Vancouver');

//**** ASSIGN EMPLOYEE ID TO SESSION AFTER LOGIN ****
if($_SESSION)
{
    $currentUser = $_SESSION['currentUser'];
}
else
{
    $currentUser = false;
}

//**** GET POSTS ****
function allPosts($pdo)
{

//**** RETRIEVE 100 NEWEST POSTS ****
$statement = $pdo->prepare('SELECT * FROM `posts` ORDER BY `timestamp` DESC LIMIT 100');
$statement->execute();
$result = $statement->fetchAll();

    if($result > 0) {
        return $result;
    }
}

//**** GET POSTS FROM R&D *****
function rdPosts($pdo)
{


$statement = $pdo->prepare('SELECT * FROM `posts` WHERE substring(`author_Id`, 1, 1) = "R" ORDER BY `timestamp` DESC LIMIT 100');
$statement->execute();
$result = $statement->fetchAll();

    if($result > 0) {
        return $result;
    }
}

//**** GET POSTS FROM MARKETING *****
function msPosts($pdo)
{


$statement = $pdo->prepare('SELECT * FROM `posts` WHERE substring(`author_ID`, 1, 1) = "M" ORDER BY `timestamp` DESC LIMIT 100');
$statement->execute();
$result = $statement->fetchAll();

    if($result > 0) {
        return $result;
    }
}

//**** GET POSTS FROM ADMIN *****
function adPosts($pdo)
{


$statement = $pdo->prepare('SELECT * FROM `posts` WHERE substring(`author_ID`, 1, 1) = "A" ORDER BY `timestamp` DESC LIMIT 100');
$statement->execute();
$result = $statement->fetchAll();

    if($result > 0) {
        return $result;
    }
}

//**** FETCH USER INFO ****
function userProf($pdo)
{
   //SEARCH FOR USER PROFILE
    $statement = $pdo->prepare('SELECT * FROM `employee` WHERE `employee_Id` = ?');
    $statement->execute([$_SESSION['currentUser']]);
    $result = $statement->fetch();

    return $result;
}

//**** COMMIT NEW POST ****
if(isset($_POST['postContent']))
{
    if(!$currentUser){
        echo "Please Sign In";
        return;
    }else{

        //ASSIGN VALUES
        $authorId = $currentUser;
        $date = new DateTime();
        $timeStamp = $date->format('Y-m-d H:i:s');
        $postBody = htmlspecialchars($_POST['postBody'],ENT_COMPAT | ENT_XHTML,'utf-8');
        $cusfree = wordFilter($postBody);
        if(!$cusfree==""){
            //POST TO DB
            $statement = $pdo->prepare('INSERT INTO `posts` (`author_Id`, `timestamp`, `body`) VALUES (?, ?, ?)');
            $statement->execute([$authorId, $timeStamp, $cusfree]);
        }else{
            $message = "The post body cannot be left empty";
            echo "<script type='text/javascript'>alert('$message');</script>";
            return;
        }
    }
}

//**** DELETE POST ****
if(isset($_POST['delete']))
{
    //DEFINE THE POST TO BE SEARCHED FOR AND DELETED
    $postId = $_POST['postId'];
    $statement = $pdo->prepare('DELETE FROM `posts` WHERE `Id` = ?');
    $statement->execute([$postId]);
    $message = "Your Post has been Deleted successfully.";
    echo "<script type='text/javascript'>alert('$message');</script>";
}

//**** EDIT POST ****
if(isset($_POST['edit']))
{
    $postId = $_POST['postId'];
    $authorId = $_POST['author_Id'];
    $newBody = htmlspecialchars($_POST['body'],ENT_COMPAT | ENT_XHTML,'utf-8');;
    $cusfree = wordFilter($newBody);

    if(!$cusfree ==""){

        if($_SESSION['userRole'] == 127 || $currentUser == $authorId){
            $statement = $pdo->prepare('UPDATE `posts` SET `body` = ? WHERE `Id` = ? AND `author_Id` = ?');
            $statement->execute([$cusfree, $postId, $authorId]);
        }else{

            return;
        }

    }else{
      $message = "The post body cannot be left empty";
      echo "<script type='text/javascript'>alert('$message');</script>";
    }
}

//**** ASSIGN POST COLOR *****
function postColor($author)
{
    $RD = "rd";
    $MS = "ms";
    $admin = "admin";

    $firstCharacter = $author[0];
    switch($firstCharacter){
        case "A": return $admin;
            break;
        case "R": return $RD;
            break;
        case "M": return $MS;
            break;
    }
}

//**** GET DISPLAY_NAME ****
function displayName($pdo, $author)
{
    $statement = $pdo->prepare('SELECT * FROM `employee` WHERE `employee_Id` = ?');
    $statement->execute([$author]);
    $result = $statement->fetch();
    if(!$result['display_name'] == null){
        return $result['display_name'];
    }else{
        return $result['employee_Id'];
    }
}

//**** USERPROFILE IMAGES
function assignImage($pdo, $id){

    $statement = $pdo->prepare('SELECT * FROM `employee` WHERE `employee_Id` = ?');
    $statement->execute([$id]);
    $result = $statement->fetch();
    $image = $result['thumbnail'];
    if(!$image){
    $image = "images/defaultAvatar.png";
    }
    return $image;
}

//**** UPDATE USER DISPLAYNAME  ****

if(isset($_POST['editProfile']))
{
    $userId = $_POST['userId'];
    $userName = $_POST['userName'];
    $newName = htmlspecialchars($_POST['userName'],ENT_COMPAT | ENT_XHTML,'utf-8');;
    $cusfreeName = wordFilter($newName);

    if($cusfreeName){

        if($currentUser == $userId){
            $statement = $pdo->prepare('UPDATE `employee` SET `display_name` = ? WHERE `employee_Id` = ?');
            $statement->execute([$cusfreeName, $userId]);
        }else{
            $message = "Your ID doesn't match the updated Updated users Id";
            echo "<script type='text/javascript'>alert('$message');</script>";
            return;
        }

    }else{
      $message = "The post body cannot be left empty";
      echo "<script type='text/javascript'>alert('$message');</script>";
    }
}

//**** CHECK USER FOR POST MATCHES. ENABLE EDITING PERMISSIONS ****
function validate_permissions($currentUser, $Author)
{
        if($currentUser == $Author){
            //ENABLE PERMISSION TO EDIT / DELETE POST
            return true;
        }else{
            return false;
        }
    }


    function wordFilter($text)
    {
        $filter_terms = array('\bass(es|holes?)?\b', '\bshit(e|ted|ting|ty|head)\b', 'anal','anus','arse','assface','asslick','asswipe',
    		'ballsack','bastard','biatch','bitch','blowjob','bollock','bollok','boob','bugger','bum','butt','butthole','buttcam','buttplug','buttwipe','buttfucking','buttfuck','barely legal','bdsm','bbw','bimbo','bukkake',
    		'clit','clitoris','cock','cockhead','cocksucker','coon','crap','cunt','cum','cumshot','cumming',
    		'damn','dick','dickhead','dildo','dyke','deepthroat','defloration','doggystyle','dp',
    		'ejaculation',
    		'fag','fatass','fck','fellate','fellatio','felching','fuck','fucker','fuckface','fudgepacker','fucked','fisting','fingering','foreplay','foursome',
    		'gayboy','gaygirl','goddamn','gagged','gloryhole','golden shower','gilf',
    		'homo','handjob','hymen','huge toy','hooter',
    		'jackoff','jap','jizz',
    		'knob','knobend','knobjockey','knocker',
    		'labia','lactating','ladyboy',
    		'masterbate','masturbate','mofo','muff','milf','muff dive','muff diving',
    		'nigga','nigger','nipple',
    		'orgy',
    		'paki','penis','piss','pisstake','poop','porn','prick','pube','pussy','pornstar','porn star','porno','pornographic','pissing',
    		'rectum','retard',
    		'schlong','scrotum','sex','shit','shithead','shyte','slut','spunk','shitting','sperm','strap on','stripper','speculum','sybian',
    		'tit','tits','tosser','turd','twat','threesome','topless','titty',
    		'vagina',
    		'whore','wank','wanker','whoar'
      );
        $filtered_text = $text;
        foreach($filter_terms as $word)
        {
            $match_count = preg_match_all('/' . $word . '/i', $text, $matches);
            for($i = 0; $i < $match_count; $i++)
                {
                    $bwstr = trim($matches[0][$i]);
                    $filtered_text = preg_replace('/\b' . $bwstr . '\b/', str_repeat("*", strlen($bwstr)), $filtered_text);
                }
        }
        return $filtered_text;
    }

?>
