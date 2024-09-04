<div class="noise"></div>
<div class="overlay"></div>
<?php include('../header.php');  

$ip = $_SERVER['REMOTE_ADDR'];
$details = json_decode(file_get_contents("https://ipinfo.io/{$ip}/json"));
$browser = $_SERVER['HTTP_USER_AGENT'];
$referrer = $_SERVER['HTTP_REFERER'];
 if ($referred == "") {
  $referrer = "This page was accessed directly";
  }
  

  echo "<h2><b>YOUR IP ADDRESS : </b>" . $ip . "<br/>";
echo "<b>YOUR BROWSER&OS INFO : </b>" . $browser . "<br/>";
echo "<b>ROUTE OF YOUR CONNECTION : </b>" . $referrer . "<br/>";
echo "<b>APPROX GEO LOCATION : </b>" . $details->loc  . "<br/>" ;
echo "<b>ISP PROVIDER : </b>" . $details->org  . "<br/>" ;
echo "<b>CITY : </b>" . $details->city  . "<br/>" ;

echo "<b>STATE : </b>" . $details->region  . "<br/>" ;

echo "<b>COUNTRY : </b>" . $details->country  . "<br/>" ;



// retrieve link
if (isset($_GET["link"]) && preg_match('/^[0-9A-F]{40}$/i', $_GET["link"])) {
    $link = $_GET["link"];
}else{
    echo "<h1>Valid link not provided.</h1>";
	exit();
}

//starting verification with the $ct variable
$ct=0;

$currenttime= $_SERVER["REQUEST_TIME"];
$currentdate = date('M d, Y h:i:s A', $currenttime);
echo 'Current Date '.$currentdate.'<br/>';
// verify link get necessary information we will need to preocess request
$result = $db->query("SELECT * FROM links WHERE link='$link' ") ;
while ($row = $result->fetch_assoc()) {
   $patterns=$row['pattern']; 
   $ssmsg=$row['ssmsg'];
$linkdb = $row['link'];
$filedownload = $row['file'];
$tstamp = $row['tstamp'];
$expire = $row['expire'];
$counting = $row['counting'];
$newcount=$counting-1;
//convert timestamp to readable date the show expiration date and time
$date = date('M d, Y h:i:s A', $expire);
echo 'To Expire on '.$date.'<br/>';

// Check to see if link has expired
if ($currenttime > $expire) {
    echo "We are so sorry the link has expired.";
	exit();
// delete link so it can't be used again

	exit();
}
// unused link counter in expiration
if ($linkdb==$link) {
    echo 'You have '.$newcount.' more times to access this link.';
			
}
else {
    echo "Valid link not provided or link has expired.";
	exit();
}

}

?>
<?php echo "<link rel='stylesheet' type='text/css' href='https://cdnjs.cloudflare.com/ajax/libs/normalize/5.0.0/normalize.min.css' />";?>
<?php echo "<link rel='stylesheet' type='text/css' href='./style.css' />";?>

<body onLoad-"initclock()">

<div class="container">
  <h1>SS <span class="errorcode">PRIVACYFTP</span></h1>
  <h2>PRIVACY IS HUMAN RIGHTS</h2>
<p class="output">do you want to open this secure encrypted message.</p>
<p class="output">this is an one time temperory link with extreme privacy.</p>
<p class="output">with time limitation so please be cautious while reading.</p>
<p class="output">this message may have whispher message or files.</p> 
<p class="output">which may be harmful sometimes potentially or psychologically.</p>
<p class="output">-[In this case this platform is not responsible  for it.]</p>
  <p class="output">To proceed further normal<a target="_self" href="http://ssprivacyftp.rf.gd/expired/<?php echo$patterns;?>/message.php?link=<?php echo$link;?>">next</a> or <a href="http://ssprivacyftp.rf.gd">return to the homepage</a>.</p>
<audio src="ssaud.mp3" autoplay="autoplay" loop="loop"></audio>
</div> 
</body>

<?php
include_once('../footer.php');
?>
<style>
<?php
include_once('./style.css');
?>
</style>
