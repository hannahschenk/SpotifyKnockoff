<!--
Hannah Schenk
Web and Internet Programming
Displays song information from a database
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


//gets the information the specified album and assigns them to a variable
$sql="SELECT artist_id, name FROM albums WHERE id='$id'";
$result=mysqli_query($conn,$sql);
$row=mysqli_fetch_assoc($result);
$album=$row["name"];
$artist_id=$row["artist_id"];

$combined=array();
$songs=array();
$ids=array();

//grabs song info from the database and adds them to arrays
$sql="SELECT id, name FROM songs WHERE album_id='$id'";
$results=mysqli_query($conn,$sql);
while($row=mysqli_fetch_assoc($results)){
  array_push($songs,$row["name"]);
  array_push($ids,$row["id"]);
}

//grabs the artist name for the specified album
$sql="SELECT name FROM artists WHERE id='$artist_id'";
$result=mysqli_query($conn,$sql);
$row=mysqli_fetch_assoc($result);
$artist=$row["name"];

$combined=array_combine( $ids, $songs);

mysqli_close($conn);
 ?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN"
    "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
  <head>
    <title><?=$album?></title>
    <link href="music.css" type="text/css" rel="stylesheet"/>
    <link href="https://fonts.googleapis.com/css?family=Lilita+One|Montserrat" rel="stylesheet"/>
    <script src="scripts.js" type="text/javascript"></script>
  </head>
  <body>
    <h1><?=$artist?>- <?=$album?></h1>
    <table>
      <tr>
    <?php
      //loops through the combined array to grab song names and places them in a table
      foreach($combined as $song){
        ?>
        <td><?=$song ?></td>

        <?php
      }
       ?>
      </tr>
     <tr>
   <?php
    //loops through song ids and adds audio files associated with the ids to a table
     foreach($ids as $song_id){
       ?>
       <td><audio controls><source src="music/<?=$song_id?>.mp3" type="audio/mp3">
         Your browser does not support the audio element.</audio></td>
       <?php
     }
      ?>
    </tr>
    <?php
    //loops through the combined array to grab song ids and then create checkboxes with a value of the ids
      foreach($combined as $key => $value){
        ?>
        <td>Select this song<input type="checkbox" id="<?=$key?>"
           value="<?=$value?>" class="songs"></input></td>
        <?php
      }
       ?>
     </tr>
    <tr>
      <td><button type="button" onclick="addToPlaylist()">Add Selected Songs to Playlist</button></td>
    </tr>
    <tr>
      <td><button type="button" onclick="finishPlaylist()">Finish Playlist</button></td>
    </tr>
   </table>
   <a href="javascript:history.back()">< Go back to albums</a>
  </body>
  </html>
