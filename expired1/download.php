<?php include('header.php');  
//require_once 'export.php';	
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


echo $ssmsg;
          echo '<p>This file has been downloaded securily.</p>';?>
<div class="container">
<div class="jumbotron"><p class="text-xl-center">

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
$ssmsg=$row['ssmsg'];
$currenttime= $_SERVER["REQUEST_TIME"];
$currentdate = date('M d, Y h:i:s A', $currenttime);
echo  $ssmsg.'CURRENT TIME AND DATE ACCORDING TO YOUR IP: '.$currentdate.'<br/>';
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
    echo 'You have '.$newcount.' more times to access this link.'.$ssmsg;
	mysqli_query($db,"UPDATE links SET counting='$newcount' WHERE link='$linkdb' ");
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

	<body background="logo1.jpg">
<IMG SRC="ONGC.jpg" ALT="some text" WIDTH=1050 HEIGHT=306>

<br>
<font size="5" color="800517"><b>&nbsp;LINK EXPIRED SETHA PAIYALE</b></font>

<?php
 if($ct==1)
{  echo "file download successfull and encrypted".$ssmsg;  
echo "hi".nl2br($fetch['ssmsg']);

$path = ''; 
$path = "files/$filedownload"; 
echo $path;
$mime_type=mime_content_type($path); 
header('Content-Description: File Transfer');
header('Content-Type: application/octet-stream');
header('Content-Disposition: attachment; filename="'.$path.'"');
header('Content-Transfer-Encoding: binary');
header('Expires: 0');
header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
header('Pragma: public');
header('Content-Length: ' . filesize($path)); //Absolute URL
ob_clean();
flush();
readfile($path); //Absolute URL
}
else{
	 
          echo nl2br($fetch['ssmsg']).'<p>This file has already been dowloaded the maximum number of times.</p>';
}//download if condition ends

?>

</p>
</div>
<?php
include_once('footer.php');
?>