<?php
	header('Content-type: text/css');
?>
@font-face {
    font-family: "Starcraft";
    src: url("static/Starcraft_Normal.ttf");
}

@font-face {
    font-family: "Eurostile";
    src: url("static/EurostileExt-Reg.otf");
}

body {
	font-family: Eurostile, sans-serif;
	background-color: #000033;
	color: #FFFFFF;
	text-shadow: #BBBBFF 0px 0px 15px;
	width: 750px;
	text-align: left;
	margin-top: 30px;
	margin-left: auto;
	margin-right: auto;
	padding: 20px;
	opacity: 0.8;
	border-left: 1px solid #66AAFF;
	border-top: 1px solid #66AAFF;
/* IE10 */ 
background-image: url(./static/SC2Background.png), -ms-linear-gradient(top, #014B75 0%, #000000 100%);

/* Mozilla Firefox */ 
background-image: url(./static/SC2Background.png), -moz-linear-gradient(top, #014B75 0%, #000000 100%);

/* Opera */ 
background-image: url(./static/SC2Background.png), -o-linear-gradient(top, #014B75 0%, #000000 100%);

/* Webkit (Safari/Chrome 10) */ 
background-image: url(./static/SC2Background.png), -webkit-gradient(linear, left top, left bottom, color-stop(0, #014B75), color-stop(1, #000000));

/* Webkit (Chrome 11+) */ 
background-image: url(./static/SC2Background.png), -webkit-linear-gradient(top, #014B75 0%, #000000 100%);

/* Proposed W3C Markup */ 
background-image: url(./static/SC2Background.png), linear-gradient(top, #014B75 0%, #000000 100%);
	background-repeat: no-repeat;
}

html {
	padding: 0 0 0 40px;
	margin: 0;
	text-align: center;
	background: #000000 url(./static/sc2background.jpg) no-repeat center;
	background-position: top;
}

h1 {
	text-align: center;
	font-family: Starcraft, sans-serif;
	text-shadow: #DDDDFF 0px 0px 35px;
}

h1 a:link, h1 a:visited {
	color: #FFFFFF;
	text-decoration: none;
}

h1 a:hover {
	text-shadow: #FFFFFF 0px 0px 25px;
}

a:link, a:visited {
	text-decoration: none;
	color: #66AAFF;
}

a:hover {
	color: #88CCFF;
	text-shadow: #FFFFFF 0px 0px 10px;
}

#nav {
	margin: 15px 0 0 0;
	padding: 0;
	text-align: center;
}

#nav li {
	display: inline;
	padding: 0 20px;
}

label {
	display: block;
	padding: 10px;
}

fieldset {
	margin: 10px;
}

.teammembers {
	margin: 0;
	padding: 0;
}

.teammembers li {
	float: left;
	padding: 10px;
	list-style: none;
}

dt {
	font-weight: bold;
}

.error {
	color: red;
}

#footer {
	padding: 40px 0 0 0;
	text-align: center;
	font-size: small;
	display: block;
}
