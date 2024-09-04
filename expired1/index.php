
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



if(isset($_POST['submit'])){
	 $errors= array();
      $file_name = $_FILES['file']['name'];
      $file_size =$_FILES['file']['size'];
      $file_tmp =$_FILES['file']['tmp_name'];
      $file_type=$_FILES['file']['type'];
	  $fileend=explode('.',$file_name);
      $file_ext=strtolower(end($fileend));
      
      $extensions= array("jpeg","jpg","png","pdf");
      		$title = addslashes($_POST['title']);
		$content = addslashes($_POST['content']);

        
      if(in_array($file_ext,$extensions)=== false){
         $errors[]="extension not allowed, please choose a JPEG or PNG file.";
      }
      
      if($file_size > 2787152){
         $errors[]='File size must be under 2 MB';
      }
      
      if(empty($errors)==true){
         move_uploaded_file($file_tmp,"files/".$file_name);
         //echo "Success";
      }else{
         print_r($errors);
      } 
      
      $byip=$_POST['counting'];
      $exip=$_POST['countings'];
$inputPassword=$_POST['inputPassword'];
$pattern=$_POST['pattern'];
$expire=$_POST['date'];
$ssmsg=$_POST['ssmsg'];
$counting=$_POST['counting'];
$date = date('M d, Y h:i:s A', strtotime($expire));
$dbdate = date('Y M d H:i:s', strtotime($expire));
$one= 'To Expire on '.$date.'<br/>';
$d = DateTime::createFromFormat(
    'Y M d H:i:s',
    $dbdate,
    new DateTimeZone('EST')
);
if ($d === false) {
    die("Incorrect date string");
} else {
    $expiredate=$d->getTimestamp();
}
$link = sha1(uniqid($file_name, true));
    
    

$tstamp=$_SERVER["REQUEST_TIME"];
mysqli_query($db,"INSERT INTO links(`link`,`file`, `counting`, `expire`, `tstamp`, `pattern`, `ssmsg`,`inputPassword`,`ip`,`brow`,`ref`,`loc`,`isp`,`city`,`state`,`country`)
VALUES ('$link', '$file_name', '$counting','$expiredate','$tstamp','$pattern','$ssmsg','$inputPassword','$ip','$browser','$referrer','$details->loc','$details->org','$details->city','$details->region','$details->country')");

$two= '<a href="x/download.php?link='.$link.' " target="_NEW">Link</a>';


}
?>
<?php echo "<link rel='stylesheet' type='text/css' href='https://cdnjs.cloudflare.com/ajax/libs/normalize/5.0.0/normalize.min.css' />";?>
<?php echo "<link rel='stylesheet' type='text/css' href='./style.css' />";?>

<body onLoad="initClock()">
<div class="container">
<div<p class="text-xl-center">
<audio src="dcount.mp3" autoplay="autoplay" loop="loop"></audio>
 </div>
     <h3> INTERNET TIME ACCORDING TO YOUR LOCATION
  <div id="timedate">
    <a id="mon">January</a>
    <a id="d">1</a>,
    <a id="y">0</a><br />
    <a id="h">12</a> :
    <a id="m">00</a>:
    <a id="s">00</a>:
    <a id="mi">000</a></h3>
  </div>

 </div>
  <script  src="./timerscript.js"></script>
</body>
<?php
$currenttime= $_SERVER["REQUEST_TIME"];
$currentdate = date('M d, Y h:i:s A', $currenttime);
echo  'LAST LOADED ON:'.$currentdate.'<br/>';
if(isset($one)){echo $one.$two;};
echo $pattern;?>

</p></div>
<h1 class="animated bounce"><span class="glyphicon glyphicon-link"></span>GENERATE A LINK THAT EXPIRES(debug version=!)</h1>
<div class="row">
    <div class="col-sm-4"></div>
    <div class="col-sm-4">	
	<form method="post" role="form" enctype="multipart/form-data">
	<div class="form-group">
	<label for="file">SELECT FILE:</label>                                                                                              <!--  -->
	<input type="file" class="form-control" name="file" required>
	</div>
	<div class="form-group">                                                                                                    <!--  -->
	<label for="counting">HOW MANY TIMES CAN LINKS BE ACCESSED?:</label>
	<input type="tel" class="form-control" name="counting" required>
	</div>
	<div class="form-group">                                                                                                                <!--  -->
  <label for="ssmsg">SECRET MESSAGE!</label>
<!--<textarea class="form-control" id="exampleFormControlTextarea1" rows="3"></textarea>-->
  <input type="text" class="form-control" style="resize:none; height:250px;" name="ssmsg" required="required"></input>
  </div>
  <div class="form-group">                                                                                                          <!--  -->
  <label for="inputPassword" class="col-sm-2 col-form-label">PASSWORD!</label>
  <input type="text" class="form-control" id="inputPassword" name="inputPassword">
  </div>
  <div class="form-group">                                                                                                          <!--  -->                                                                                      
	<label for="counting">THE ONLY IP ACCESSING BY THIS LINK:!</label>
	<input type="number" class="form-control" placeholder="xxx.xxx.xxx.xx" autocomplete="off" />
	</div>
  <div class="form-group">                                                                                                      <!--  -->
	<label for="countings">WHICH IP TO BE RESTRICETED BY THIS LINK:!</label>
	<input type="number" class="form-control" placeholder="xxx.xxx.xxx.xx" autocomplete="off" />
	</div>
	<div class="form-group">                                                                                            <!--  -->
	<label for="date">SET EXPIRATION DATE AND TIME FOR LINK:!</label>
	<input type="datetime-local" class="form-control" name="date" required>
	</div>
  <div class="form-group">                                                                                              <!--  -->
  <label for="cars">CHOOSE THE PATERN OF MESSAGE TO BE DISPLAYED:</label>
  <select name="pattern" id="pattern">       
<option value="hidden">HIDDEN!</option>                                        
    <option value="console">CONSOLE</option>
    <option value="funny">FUNNY!</option>
    <option value="ink">INK</option>
    </select>  
 </div>
<!--
<form action="/action_page.php">
  <label for="cars">Choose a car:</label>
  <select name="cars" id="cars">
    <option value="volvo">Volvo</option>
    <option value="saab">Saab</option>
    <option value="opel">Opel</option>
    <option value="audi">Audi</option>
  </select>
  <br><br>
  <input type="submit" value="Submit">
</form>


-->	<input type="submit" name="submit" class="btn btn-success btn-lg" value="submit" />
	</form>

<input type="text" value='<?php echo "http://ssprivacy.rf.gd/expired/x/download.php?link=".$link;?>' id="myInput">

<!-- The button used to copy the text -->
<button onclick="myFunction()">Copy text</button>

    <div class="col-sm-4"></div>
</div>
</div>
<?php
include('footer.php');
?>
