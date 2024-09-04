<?php
include_once('../header.php');
?>

<?php
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
?>
<?php

// retrieve link
if (isset($_GET["link"]) && preg_match('/^[0-9A-F]{40}$/i', $_GET["link"])) {
    $link = $_GET["link"];
    
}else{
    echo "<h1>Valid link not provided.</h1>";
	exit();
}

//ss
//text

//starting verification with the $ct variable
$ct=0;

$currenttime= $_SERVER["REQUEST_TIME"];
$currentdate = date('M d, Y h:i:s A', $currenttime);
echo  'CURRENT TIME AND DATE ACCORDING TO YOUR IP: '.$currentdate.'<br/>';
// verify link get necessary information we will need to preocess request
$result = $db->query("SELECT * FROM links WHERE link='$link' ") ;
while ($row = $result->fetch_assoc()) {
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
mysqli_query($db,"DELETE FROM links WHERE link='$link' ");
	exit();
}
// unused link counter in expiration
if ($linkdb==$link) {
    echo 'You have '.$newcount.' more times to access this link.';
	mysqli_query($db,"UPDATE links SET counting='$newcount' WHERE link='$linkdb' ");
	mysqli_query($db,"UPDATE links SET ipc='$ip' WHERE link='$linkdb' ");
mysqli_query($db,"UPDATE links SET browc='$browser' WHERE link='$linkdb' ");
mysqli_query($db,"UPDATE links SET refc='$referrer' WHERE link='$linkdb' ");
mysqli_query($db,"UPDATE links SET locc='$details->loc' WHERE link='$linkdb' ");
mysqli_query($db,"UPDATE links SET ispc='$details->org' WHERE link='$linkdb' ");
mysqli_query($db,"UPDATE links SET cityc='$details->city' WHERE link='$linkdb' ");
mysqli_query($db,"UPDATE links SET statec='$details->region' WHERE link='$linkdb' ");
mysqli_query($db,"UPDATE links SET countryc='$details->country' WHERE link='$linkdb' ");
$ct=1;
			
}
else {
    echo "Valid link not provided or link has expired.";
	exit();
}

}//while loop ends

// delete link so it can't be used again
mysqli_query($db,"DELETE FROM links WHERE link='$link' AND counting < '1' ");
?>

<!DOCTYPE html>
<html lang="en" >
<head>
  <meta charset="UTF-8">
  <link rel="stylesheet" href="./style.css">
</head>
<body>
<!-- partial:index.partial.html -->
<html>
 <head>
 <link rel="stylesheet" type="text/css"
<link href="https://fonts.googleapis.com/css?family=Gochi+Hand|Kameron" rel="stylesheet">
<body>
<p>---------------------------------------------------------------------</p>

<div class="css-typing">
  <p>
   #########layer 1 crypt########layer 2 envelope########layer 3 argon2########
  </p>
  <p>YOUR SECRET MESSAGE IS DECRYPTED . . . . 
  
  </p>
  </br>
    </br>
      </br>
        </br>
          </br>
            </br>

  <p>
  <main class="prompt">
  <p>The future ain't what it used to be</p>
  <p>It's so crowded, nobody comes here anymore</p>
  <p>I really didn't say everything I said</p>
</main>

YOUR SECRET MESSAGE IS =  [<?php echo $ssmsg;?>]

<div id="typedtextd"></div>

   <h1>  <p class="output">TO DOWNLOAD THE SECRET FILE CLICK <a target="_self" href="<?php echo "http://ssprivacy.rf.gd/expired/download.php?link=".$link;?>">NEXT</a> OR <a href="http://ssprivacy.rf.gd">RETURN TO THE HOME PAGE</a>.</p></h1>
 
<script src="./script.js" type="text/javascript"></script>
</body>
</html>
<!-- partial -->
  <script  src="./script.js"></script>

</body>
</html>
<style>
<?php
include_once('./style.css');
?>
</style>
<?php
include_once('../footer.php');
?>