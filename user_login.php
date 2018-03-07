<?php
session_start();
?>
<?php
include 'conn.php';

?>
<html>
<body>
<?php
if(isset($_REQUEST['btn_login'])){
if (isset($_REQUEST['userName']) and isset($_REQUEST['userPassword'])) {
$user=$_REQUEST['userName'];
$pass=$_REQUEST['userPassword'];
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} 
$sql = "SELECT * from login where Email='".$user."' and Password='".$pass."'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    // output data of each row
    while($row = $result->fetch_assoc()) {
        $_SESSION["user_ID"]= $row['Email'];
		
    }

}
 $sql = "SELECT * from user_info where Email='".$user."'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    // output data of each row
    while($row = $result->fetch_assoc()) {
        $_SESSION["uID"]= $row['UserID'];
		
    }

}

if(isset($_SESSION["user_ID"])) {
header("Location:Umobile.php");
}
else {
//header("Location:login.html");
echo "invalid username and password";
}

} 
$conn->close();
}
else
{
$name=$_REQUEST['Full_Name']; 
$mail=$_REQUEST['Email']; 
$dob=$_REQUEST['regi_dob'];
//$gen=$_REQUEST['gender'];
$mob=$_REQUEST['regi_mobile'];
$regiPass=$_REQUEST['regi_pass'];
if(isset($_REQUEST['gender']))
{
	$gen=$_REQUEST['gender'];
}
//$loc="";
/*if(isset($_REQUEST['addrs']))
{
$loc=$_REQUEST['addrs'];
}

	*/
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} 
try{
//login insert
 $sql = "insert into login values('".$mail."', '".$regiPass."')";
   if ($conn->query($sql) === TRUE) {
	   $sql = "insert into user_info values('".$name."', '".$mail."', '".$dob."','".$gen."','".$mob."',NOW(),'','','')";
	
      
   
   if ($conn->query($sql) === TRUE) {
    echo "Your account created successfully<br>please login from below link<br>
	<a href='UserLogin.html'>Sign in Here</a>
	";
}
else {
    echo "<br>Error: <br>";
	 throw new Exception();
}
}
 else {
    echo "<br>Error : <br>";
	 throw new Exception();
}
}
catch(Exception $e)
{
	echo "User Already Present Of Similar Email<br>".$e;
	echo"<a href='UserLogin.html'>Register with another Email</a>";
}
$conn->close();
}
?>
</body>
</html>
