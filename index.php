<?php
   ob_start();
   session_start();
?>
<!DOCTYPE html>
<html>
<title>The Assassin Game</title>
<head>
     <style>
	 * {margin: 0; padding: 0;}
	 body {background-color: #211F20; font-family: "Lucida Console", Monaco, monospace;}
	 #container {margin: 0 auto; opacity: 0.8; text-align: center; width: 80%; margin-top: 100px;}
	 #leftshark {margin-left: 0; width: 100%; background-color: #B79FA6; color: #FFFFFF; 
	     border-radius: 5px; padding-top: 20px; opacity: 0.5; padding-bottom: 20px;}
		 #leftshark:hover {opacity: 1;}
	 #rightshark {margin-right: 0; width: 64%; background-color: #8F787E; color: #FFFFFF; border-radius: 5px;
	     padding-top: 20px; opacity: 0.5; float: right;}
		 #rightshark:hover {opacity: 1;}
	 #lowershark {margin-left: 0; width: 100%; background-color: #8F787E; color: #FFFFFF; 
	     border-radius: 5px; padding-top: 20px; opacity: 0.5; margin-top: 20px;}
		 #lowershark:hover {opacity: 1;}
     .locked {display: none;}
	 
	 a {text-decoration: none; color: #FFFFFF; font-weight: bold; line-height: 125%;}
	     a:hover {font-size: 125%; line-height: 100%;}
	 h1 {font-size: 30px; line-height: 150%;}
	 hr {width: 50%; border-style: none none dotted none; border-width: 6px; margin-left: 25%;}
     </style>
</head>
<body>
     <div id="container">
	 <div style = "float: left; margin-left: 0; width: 33%;">
	     <div id="leftshark">
		     <h1>Welcome to Left Shark</h1>
			 <hr />
<?php
$name = $pass = $err = "";
$file = $user = $userCheck = $passCheck = $passPos = "";
$status = 0; $output = "";
if (!empty($_POST["submit1"])) {
	 if (empty($_POST["name"])) {
	 $err = "Username or password are incorrect.";
	 } else {
	 $name = test_input($_POST["name"]);
	 }
	 
	 if (empty($_POST["pass"])) {
	 $err = "Username or password are incorrect.";
	 } else {
	 $pass = test_input($_POST["pass"]);
	 }
	 
	 $file = file_get_contents("login.txt");
	 $user = strlen($name);
	 $userCheck = strpos($file, $name);
	 $passCheck = $userCheck + $user + 1;
	 $passPos = strpos($file, $pass);
	     if ($userCheck == "") {
	     $err = "Username or password are incorrect.";
	     }
	     if ($passCheck == $passPos) {
         $err = "Logged in.";
		 $_SESSION['username'] = $name;
	     } 
}
if (!empty($_SESSION['username'])) {
     $status = 1;
}
function test_input($data) {
$data = trim($data);
$data = stripslashes($data);
$data = htmlspecialchars($data);
return $data;
}
?>
	 <span id="menu" <?php if ($status == 1) {
		 echo "style='display: none;'";} ?>>
	     <br />
	 <form name="form1" method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
	 Username: <input type="text" name="name" value="<?php echo $name;?>">
	 <br /><br />
	 Password: <input type="text" name="pass" value="<?php echo $pass;?>">
	 <br /><?php echo $err; ?><br />
	 <input type="submit" name="submit1" value="Login">
	 </form>
	 <br />
     </span>

     <span class = "locked" <?php if ($status == 1) {
		 echo "style='display: inline;'";} ?>>
	 <br />
	 <h3>You are logged in as <?php echo $_SESSION['username']; ?>.</h3>
	 <br /> <br />
	 <a href = "logout.php">Log Out?</a>
	 <br /><br />
	 </span>
		 </div><!--leftshark-->
		 	 <div id = "lowershark" <?php if ($status == 0) {echo 'style = "padding-top: 0;"';}?>>
			 <div class = "locked" <?php if ($status == 1) {
			 echo "style='display: inline;'";} ?>>
		 <?php
		     $posts = file_get_contents('posts.txt');
			 $postFile = $newPost = "";
		     if (!empty($_POST['submit3'])) {
			     $postFile = fopen('posts.txt', 'w');
				 $newPost = $_POST['platypus'];
				 fwrite($postFile, $newPost);
				 fclose($postFile);
				 $posts = file_get_contents('posts.txt');
			 }
		 ?>
		 <h1>I am a chat box.</h1>
		 <br />
			 <?php echo $posts; ?>
		 <br /><br />
		 <form name = "chatform" method = "post" action = "<?php echo htmlspecialchars($_SERVER['PHP_SELF']);?>">
		 <input type = "text" name = "platypus" value = "" />
		 <input type = "submit" name = "submit3" value = "Post!" />
		 </form>
		 <br />
		 <br />
		 </div>
		 </div><!--lowershark-->
	 </div><!--left and lowershark--> 

		 <div id="rightshark">
		     <?php
			 if ($status == 0) {
			 echo "
			 <h1>Access Denied</h1>
			 <h6>Log in to proceed.</h6>
			 <br /><br />
			 ";
			 }
			 if ($status == 1) {
			 $target = "Steve";
			 }
			 ?>
			 
			 <div class = "locked" <?php if ($status == 1) {
			 echo "style='display: inline;'";} ?>>
			 
			 <?php
			 $targetCode = "27";
			 $output = $targetErr = "";
	     if (!empty($_POST["submit2"])) {
			 if (test_input($_POST["code"]) == $targetCode) {
			 $output = "Yay";
			 } else {
			 $targetErr = "Code incorrect.";
			 }
		 }
			 ?>
			 <h1>Welcome</h1>
			 <h3>You are:</h3>
			 <?php echo $_SESSION['username']; ?>
			 <br /><br />
			 <h3>Your target is:</h3>
			 <?php echo $target; ?>
			 <br /><br />
			 <form name="form2" method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
			 <p>Enter code:</p>
			 <input type="text" name="code" value="">
			 <input type="submit" name="submit2" value="Next Target">
			 </form>
			 <br /><br />
			 <?php echo $output; echo $targetErr; ?>
			 </div>
			 
		 </div><!--rightshark-->
		 

	 </div><!--container-->
	
     <script>
	     function menu() {
		     if () {}
		 }
     </script>

</body>
</html>
