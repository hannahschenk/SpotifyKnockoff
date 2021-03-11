var x = 0;

function addToPlaylist() {
  if (typeof(Storage) !== "undefined") {
    var songs=document.getElementsByClassName("songs");
    var noSongsSelected = true;
    var checkedSongs=[];

    for (i=0; i<songs.length; i++){
      if (songs[i].checked) {
        checkedSongs[i] = songs[i];
        noSongsSelected=false;
      }
    }

    if (noSongsSelected) {
      alert("Please select a song to add to your playlist.");
    }
    else {
		for(var i=0; i<songs.length; i++){
			if(songs[i].type=='checkbox' && songs[i].checked) {
        var item = sessionStorage.getItem(songs[i].id);
        if(item == null) {
        sessionStorage.setItem(songs[i].id, songs[i].value);
        var test = sessionStorage.getItem(songs[i].id);
      }
      else {
        alert("A song you checked is already in your playlist.")
        checkedSongs.splice(i, 1);
      }
    }
	}
  alert("You added " + checkedSongs.length + " song[s] to your playlist! There are now " + sessionStorage.length + " song[s] in your playlist.");
 }
}
 else {
  document.getElementById("result").innerHTML = "Sorry, your browser does not support Web Storage...";
}

}

function finishPlaylist() {
  var noSongsSelected = true;
  if(confirm("Are you ready to finish your playlist? If not, press cancel and continue exploring new songs."))
   {window.location = 'http://mscs-php.uwstout.edu/2019FA/cs/248/001/schenkh0504/assignment9/playlist.html'

  }
}

function displayPlaylist() {
  let table = document.querySelector('#table');
  var header = table.insertRow();
  var blank1 = header.insertCell();
  var headerCell = header.insertCell();
  var blank2 = header.insertCell();
  var textnode = document.createTextNode("Playlist");
  headerCell.className = "headerCell";
  headerCell.appendChild(textnode);
  for(var i=0; i<sessionStorage.length; i++){
    let row = table.insertRow();
    let cell1 = row.insertCell();
    let cell2 = row.insertCell();
    let cell3 = row.insertCell();
    cell1.className = "left";
    cell2.className = "left";
    cell3.className = "left";
    var key = sessionStorage.key(i);
    var value = sessionStorage.getItem(key);
    let text = document.createTextNode(value);
    text.className = "left";
    var button = document.createElement('input');
    var sound = document.createElement('audio');
    sound.id = 'audio-player';
    sound.controls = 'controls';
    sound.src = 'music/'+key+'.mp3';
    sound.type = 'audio/mpeg';
    sound.className = "mid";
    button.setAttribute('type', 'button');
    button.setAttribute('value', 'Remove Song from Playlist');
    button.setAttribute('id', key);
    button.setAttribute('onclick', 'removeFromPlaylist('+key+')');
    button.className = "right";

    cell1.appendChild(text);
    cell2.appendChild(sound);
    cell3.appendChild(button);
  }

}

function removeRow(song) {
     var empTab = document.getElementById('table');
     empTab.deleteRow(song.parentNode.parentNode.rowIndex);
 }

 function removeFromPlaylist(song) {
   var button = document.getElementById(song);
   removeRow(button);
   sessionStorage.removeItem(song);
 }
