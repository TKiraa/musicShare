function onWriteDesc(text) {
	document.getElementById("desc-char").innerHTML = "(caract&egrave;res : " + (256 - text.length) + ")";
}
function findMusicWeb(link){
	var link_upper = link.toUpperCase();
	var img_path = "red_cross.png";
	var type = "0";
	var good = false;
	switch (true) {
		case link_upper.includes("SOUNDCLOUD.COM"):
			img_path = "soundcloud.png";
			good = true;
			type = "soundcloud";
			break;
		case link_upper.includes("SPOTIFY.COM"):
			img_path = "spotify.png";
			type = "spotify";
			good = true;
			break;
		case link_upper.includes("DEEZER.COM"):
			img_path = "deezer.png";
			type = "deezer";
			good = true;
			break;
		case (link_upper.includes("YOUTUBE.COM") || link_upper.includes("YOUTU.BE")):
			img_path = "youtube.png";
			type = "youtube";
			good = true;
			break;
		case (link_upper.includes("DAILYMOTION.COM") || link_upper.includes("DAI.LY")):
			img_path = "dailymotion.png";
			type = "dailymotion";
			good = true;
			break;
	}
	if(good) {
		document.getElementById("post-link").style.boxShadow = "0px 1px 10px 3px green";
		document.getElementById("post-type").value = type;
	}else{
		document.getElementById("post-link").style.boxShadow = "0px 1px 10px 3px red";
		document.getElementById("post-type").value = "0";
	}
	document.getElementById("img-link").innerHTML = "<img src='image/" + img_path + "' width='32'>";
}



function clickPost(argument) {
	var href = window.location.href;
	var dir = href.substring(0, href.lastIndexOf('/')) + "/";
	document.location.href = dir + "post.php?" + argument;
}
