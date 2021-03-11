<!--
Hannah Schenk
Web and Internet Programming
Displays album information from a database
-->

<?php
//conencts to database
$id=$_REQUEST["id"];
$servername = "sql9.freemysqlhosting.net";
$database = "sql9314412";
$username = "sql9314412";
$password = "G6tVuQb9RT";

$conn = mysqli_connect($servername,$username,$password,$database);
if(!$conn) {
  die ("connection failed: ". mysqli_connect_error());
}

//echo "connected successfully";

//gets the information about each artist and assigns them to a variable
$sql="SELECT id, name, genre FROM artists WHERE id='$id'";
$result=mysqli_query($conn,$sql);
$row=mysqli_fetch_assoc($result);
$name=$row["name"];
$genre=$row["genre"];

$albums=array();
$years=array();
$imgs=array();

//grabs album info from the database and adds them to arrays
$sql="SELECT id, name, release_year FROM albums WHERE artist_id='$id'";
$results=mysqli_query($conn,$sql);
while($row=mysqli_fetch_assoc($results)){
  array_push($albums,$row["name"]);
  array_push($years,$row["release_year"]);
  array_push($imgs,$row["id"]);
}

mysqli_close($conn);
 ?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN"
    "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
  <head>
    <title><?=$name?></title>
    <link href="music.css" type="text/css" rel="stylesheet"/>
    <link href="https://fonts.googleapis.com/css?family=Lilita+One|Montserrat" rel="stylesheet"/>
  </head>
  <body>
    <h1><?=$name?></h1>
    <h2>Genre- <?=$genre?></h2>
    <table>
      <tr>
    <?php
      //loops through the album array to grab album names and places them in a table
      foreach($albums as $album){
        ?>
        <td><?=$album ?></td>
        <?php
      }
       ?>
     </tr>
     <tr>
   <?php
      //loops through the years array to grab release years and places them in a table
     foreach($years as $year){
       ?>
       <td>Release Year: <?=$year?></td>
       <?php
     }
      ?>
    </tr>
    <tr>
  <?php
    //loops through the imgs array and uses their values to place images in a table
    foreach($imgs as $img){
      ?>
      <td><a href="songs.php?id=<?=$img?>"><img class="album" src="images/<?=$img?>.jpg" alt = "album<?=$img?>" width="500" height="500"/></a></td>
      <?php
    }
     ?>
   </tr>
   </table>
   <a href="javascript:history.back()">< Go back to artists</a>
  </body>
  </html>
