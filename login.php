<?php  
//start session and connect to database
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
      if(isset($_POST["login"]))//condition that has to be done if we want to log in into our account
      {  
           if(empty($_POST["username"]) || empty($_POST["password"]))  
           {  
                $message = '<label>All fields are required</label>';  
           }  
           else  
           {  
                $query = "SELECT * FROM userat WHERE username = :username AND password = :password";  
                $statement = $connect->prepare($query);  
                $statement->execute(  
                     array(  
                          'username'     =>     $_POST["username"],  
                          'password'     =>     $_POST["password"]  
                     )  
                );  
                $count = $statement->rowCount();  
                if($count > 0)  
                {  
                     $_SESSION["username"] = $_POST["username"];  
                     header("location:login_success.php");  //if we log in successfuly this is the file that we will be sent to
                }  
                else  
                {  
                     $message = '<label>Wrong Data</label>';//otherwise there's an error 
                }  
           }  
      }  
 }  
 catch(PDOException $error)  
 {  
      $message = $error->getMessage();  
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
  padding: 16px 25px;
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
                <h1 >Log In</h1 ><br />  
                <form method="post">  
                     <label>Username</label>  
                     <input type="text" name="username" class="form-control" />  
                     <br />  
                     <label>Password</label>  
                     <input type="password" name="password" class="form-control" />  
                     <br />  
                     <input type="submit" name="login" class="button" value="Login" />
                     
                </form>  
                <a href="signup.php"><h6 class="log">Sign Up</h6><a>

           </div>  
           <br />  
      </body>  
 </html>  
