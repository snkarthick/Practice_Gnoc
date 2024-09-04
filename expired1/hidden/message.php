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
    echo 'You have '.$newcount.' more times to access this link.';
	mysqli_query($db,"UPDATE links SET counting='$newcount' WHERE link='$linkdb' ");
	$ct=1;
			
}
else {
    echo "Valid link not provided or link has expired.";
	exit();
}
mysqli_query($db,"INSERT INTO links(`ipc`,`browc`,`refc`,`locc`,`ispc`,`cityc`,`statec`,`countryc`)
VALUES ('$ip','$browser','$referrer','$details->loc','$details->org','$details->city','$details->region','$details->country')  where link=('$link') ");
}//while loop ends

// delete link so it can't be used again
mysqli_query($db,"DELETE FROM links WHERE link='$link' AND counting < '1' ");

mysqli_query($db,"INSERT INTO links(`ipc`,`browc`,`refc`,`locc`,`ispc`,`cityc`,`statec`,`countryc`)
VALUES ('$ip','$browser','$referrer','$details->loc','$details->org','$details->city','$details->region','$details->country')  where link=('$link') ");
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>HIDDEN TORCH</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <script>
        document.documentElement.setAttribute('data-theme', 'orange')
    </script>
    <style>
        * {
            box-sizing: border-box;
            text-rendering: optimizeLegibility;
            -webkit-font-smoothing: antialiased;
            -moz-osx-font-smoothing: grayscale;
            font-kerning: auto;
        }
        
        html {
            line-height: 1.4;
            font-weight: 400;
            font-family: sans-serif;
            -webkit-text-size-adjust: 100%;
        }
        
        body {
            background: rgb(0, 0, 0);
            margin: 0;
            font-family: sans-serif
        }
        
        header {
            color: rgb(150, 0, 0);
            padding: 1em;
            background: rgb(0, 0, 0);
            text-align: center;
        }
        
        header h1 {
            margin: 0;
        }
        
        header nav {
            display: block;
            overflow: hidden;
        }
        
        header nav a {
            display: inline-block;
            padding: .75em;
            color: rgb(121, 0, 0);
            font-weight: 600;
            text-transform: lowercase;
            width: 33.33%;
            float: left;
        }
        
        a {
            outline: none;
            text-decoration: none;
        }
        
        footer {
            color: rgb(15, 0, 32);
            padding: 2em;
            text-align: center;
        }
        
        h1,
        h2,
        h3,
        h4,
        h5,
        h6 {
            margin: 0 0 .5em 0;
            letter-spacing: -.02em;
        }
        
        h2 {
            font-size: 20pt;
            font-weight: 400;
            color: rgb(122, 0, 0);
        }
        
        p {
            margin: 0;
        }
        
        p+p {
            margin-top: .75em;
        }
        
        div {
            padding: 1.5em;
            background: rgb(0, 0, 0);
        }
        
        div h3 {
            color: rgb(0, 0, 0);
        }
        
        div p {
            color: rgb(150, 0, 0);
        }
        
        main {
            background: rgb(121, 0, 0);
            padding-bottom: 1.5em;
        }
        
        main section,
        main aside {
            padding: 1.5em;
            padding-bottom: 0;
        }
        
        main article {
            padding: 1.5em;
            background: rgb(0, 0, 0);
            border-radius: 3px;
        }
        
        main article p {
            color: rgb(153, 0, 0);
            line-height: 1.5;
        }
        
        .capsule {
            margin-left: auto;
            margin-right: auto;
            border: 1px solid rgb(0, 0, 0);
        }
        
        .capsule+.capsule {
            border-top: none;
        }
        
        .capsule:first-of-type {
            border-top-left-radius: 5px;
            border-top-right-radius: 5px;
        }
        
        .capsule:last-of-type {
            border-bottom-left-radius: 5px;
            border-bottom-right-radius: 5px;
        }
        
        @media (min-width: 800px) {
            header,
            main {
                overflow: hidden;
            }
            main section,
            main aside {
                float: left;
                width: 40%;
            }
            main section {
                width: 60%;
                padding-right: 0;
            }
            header h1 {
                float: left;
            }
            header nav {
                float: right;
            }
        }
    </style>
    <link rel='stylesheet' href='https://fonts.googleapis.com/css?family=Fira+Sans:300,400,500,700,300italic,400italic,500italic,700italic'>
    <link rel='stylesheet' href='https://fonts.googleapis.com/css?family=Source+Sans+Pro:200,300,400,600,700,900,200italic,300italic,400italic,600italic,700italic,900italic'>
    <link rel='stylesheet' href='https://fonts.googleapis.com/css?family=Source+Code+Pro:300,400,500,600,700,900'>
    <link rel="stylesheet" href="./style.css">

</head>

<body>
    <!-- partial:index.partial.html -->
    <!-- Any website -->

    <header>
        <h1>HIDDEN MESSAGE</h1>
    </header>
    <main>
        <section>
            <article>
                <h2>SS PRIVACY</h2>
                <h2>PRIVACY IS HUMAN RIGHTS</h2>
                      <h2>-----------------------------------------------------------------------------------------------</h2>
                <h1><?php echo "THE SECRET MESSAGE IS =  ".$ssmsg; ?> </h1>
                 <h1>  <p class="output">TO DOWNLOAD THE SECRET FILE CLICK <a target="_self" href="<?php echo "http://ssprivacyftp.rf.gd/expired/download.php?link=".$link;?>">NEXT</a> OR <a href="http://ssprivacyftp.rf.gd">RETURN TO THE HOME PAGE</a>.</p></h1>
            </article>
        </section>
    </main>
    <audio src="hidden.mp3" autoplay="autoplay" loop="loop"></audio>
    <script src="./script.js"></script>
</body>
</html>
<?php
include_once('../footer.php');
?>