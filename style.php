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
	opacity: 0.95;
	border-left: 1px solid #66AAFF;
	border-top: 1px solid #66AAFF;
	/* IE10 */ 
	background-image: -ms-radial-gradient(center top, ellipse farthest-side, #41A1C4 0%, #07101F 100%);

	/* Mozilla Firefox */ 
	background-image: -moz-radial-gradient(center top, ellipse farthest-side, #41A1C4 0%, #07101F 100%);

	/* Opera */ 
	background-image: -o-radial-gradient(center top, ellipse farthest-side, #41A1C4 0%, #07101F 100%);

	/* Webkit (Safari/Chrome 10) */ 
	background-image: -webkit-gradient(radial, center top, 0, center top, 488, color-stop(0, #41A1C4), color-stop(1, #07101F));

	/* Webkit (Chrome 11+) */ 
	background-image: -webkit-radial-gradient(center top, ellipse farthest-side, #41A1C4 0%, #07101F 100%);

	/* Proposed W3C Markup */ 
	background-image: radial-gradient(center top, ellipse farthest-side, #41A1C4 0%, #07101F 100%);
}

html {
	padding: 0 0 0 40px;
	margin: 0;
	text-align: center;
	background: #000000 url(http://zed0.co.uk/Misc/Wallpapers/Misconstrue_-_Image_1.jpg) no-repeat center;\n");
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

a:link, a:visited {
	color: #66AAFF;
}

#nav {
	margin: 15px 0 0 0;
	padding: 0;
	text-align: center;
}

#nav li {
	display: inline;
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
