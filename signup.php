<?php  
 session_start();  
 $host = "localhost";  
 $username = "root";  
 $password = "";  
 $database = "diana";  
 $message = "";  
 try  
 {  
      $connect = new PDO("mysql:host=$host; dbname=$database", $username, $password);  
      $connect->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);  
      
 }  
 catch(PDOException $error)  
 {  
      $message = $error->getMessage();  
 }  
 $username = $email = $password = "";
$username_err = $email_err = $password_err = "";

if($_SERVER["REQUEST_METHOD"] == "POST"){
  // Validation
  $input_username = trim($_POST["username"]);
  if(empty($input_username)){
      $username_err = "Please enter a username.";
  } elseif(!filter_var($input_username, FILTER_VALIDATE_REGEXP, array("options"=>array("regexp"=>"/^[a-zA-Z\s]+$/")))){
      $username_err = "Please enter a valid username.";
  } else{
      $username = $input_username;
  }
  
  $input_email = trim($_POST["email"]);
  if(empty($input_email)){
      $email_err = "Please enter your email.";     
  } else{
      $email = $input_email;
  }
  
  $input_password = trim($_POST["password"]);
  if(empty($input_password)){
      $password_err = "Please enter a password.";     
  }  else{
      $password = $input_password;
  }
  if(empty($username_err) && empty($email_err) && empty($password_err)){
    // insert these values into table plan
    $sql = "INSERT INTO newusers (username, email, password) VALUES (:username, :email, :password)";

    if($stmt = $connect->prepare($sql)){
        // Bind variables to the prepared statement as parameters
        $stmt->bindParam(":username", $param_username);
        $stmt->bindParam(":email", $param_email);
        $stmt->bindParam(":password", $param_password);
        
      
        $param_username = $username;
        $param_email = $email;
        $param_password = $password;
        if($stmt->execute()){
          //successfully created
          header("location: welcome.php");
          exit();
      } else{
          echo "Oops! Something went wrong. Please try again later.";
      }
  }
   
  unset($stmt);
}
    }
  
 ?>  
 <!DOCTYPE html>  
 <html>  
      <head>  
           <title>Webslesson Tutorial | PHP Login Script using PDO</title>  
           <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.min.js"></script>  
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" />  
           <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>  
           <style>
            * {
    margin: 0;
    padding: 0;
    -webkit-box-sizing: border-box;
    box-sizing: border-box;
    -webkit-transition: 0.3s;
    -o-transition: 0.3s;
    transition: 0.3s;
  }
  
  body {
    background-color: #fff;
    font-family: Montserrat;
    overflow-x: hidden;
  }
  
  article,
  aside,
  details,
  figure,
  footer,
  header,
  main,
  menu,
  nav,
  section,
  summary {
    display: block;
  }
  
  h1,
  h2,
  h3,
  h4,
  h5,
  h6,
  p,
  a {
    -ms-word-wrap: break-word;
    word-wrap: break-word;
    text-decoration: none;
  }
  
  img {
    border: none;
  }
  
  *:focus {
    outline: none;
  }
  
  .clearfix::after {
    content: "";
    display: table;
    clear: both;
  }
  
  .bg-illustration {
    position: relative;
    height: 100vh;
    width: 2000px;
    background-color:#dc5373;
    background-size: cover;
    
  }
  .bg-illustration img {
    width: 248px;
    -webkit-user-select: none;
       -moz-user-select: none;
        -ms-user-select: none;
            user-select: none;
    height: auto;
    margin: 19px 0 0 25px;
  }
  
  @-webkit-keyframes bgslide {
    from {
      left: -100%;
      width: 0;
      opacity: 0;
    }
    to {
      left: 0;
      width: 1194px;
      opacity: 1;
    }
  }
  
  @keyframes bgslide {
    from {
      left: -100%;
      width: 0;
      opacity: 0;
    }
    to {
      left: 0;
      width: 1600px;
      opacity: 1;
    }
  }

  .button{
     background-color: #000000; 
  border: none;
  color: white;
  padding: 16px 32px;
  text-align: center;
  text-decoration: none;
  display: inline-block;
  font-size: 16px;
  margin: 4px 2px;
  transition-duration: 0.4s;
  cursor: pointer;
  border: 2px solid #000000;
}

.button:hover {
  background-color: #dc5373;
  color: #white;
  }
  .log{
    background-color: #000000; 
  border: none;
  color: white;
  padding: 16px 37px;
  text-align: center;
  text-decoration: none;
  display: inline-block;
  font-size: 16px;
  margin: 4px 2px;
  transition-duration: 0.4s;
  cursor: pointer;
  border: 2px solid #000000;
        }
  
  
 
           </style>
      </head>  
      <body>  
           <br />  
           <div class="parent clearfix">
    <div class="bg-illustration">
    <a href="index.php"><img src="https://i.ibb.co/Pcg0Pk1/logo.png" alt="logo"></a>

      
        
           <div class="container" style="width:500px" float="left">  
                <?php  
                if(isset($message))  
                {  
                     echo '<label class="text-danger">'.$message.'</label>';  
                }  
                ?>  
                <br><br>
                <h1 >Sign Up</h1 ><br />  
                <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">  
                     <label>Username</label>  
                     <input type="text" name="username" class="form-control <?php echo (!empty($username_err)) ? 'is-invalid' : ''; ?>" />  
                     <?php echo $username_err;?>
                     <br />
                     <label>Email</label>  
                     <input type="text" name="username" class="form-control <?php echo (!empty($email_err)) ? 'is-invalid' : ''; ?>" /> 
                     <?php echo $email_err;?> 
                     <br />  
                     <label>Password</label>  
                     <input type="password" name="password" class="form-control <?php echo (!empty($password_err)) ? 'is-invalid' : ''; ?>" />  
                     <?php echo $password_err;?>
                     <br />  
                     <input type="submit" name="signup" class="button" value="Sign Up" />
                     
                </form>  
                <a href="login.php"><h6 class="log">Log In</h6><a>

           </div>  
           <br />  
      </body>  
 </html>  
