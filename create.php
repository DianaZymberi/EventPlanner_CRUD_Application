<?php
// start session and connect to database
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
 
// Define variables and initialize with empty values
$name = $about = $status = "";
$name_err = $about_err = $status_err = "";
 

if($_SERVER["REQUEST_METHOD"] == "POST"){
    // Validation
    $input_name = trim($_POST["name"]);
    if(empty($input_name)){
        $name_err = "Please enter a name.";
    } elseif(!filter_var($input_name, FILTER_VALIDATE_REGEXP, array("options"=>array("regexp"=>"/^[a-zA-Z\s]+$/")))){
        $name_err = "Please enter a valid name.";
    } else{
        $name = $input_name;
    }
    
    $input_about = trim($_POST["about"]);
    if(empty($input_about)){
        $about_err = "Please enter something.";     
    } else{
        $about = $input_about;
    }
    
    $input_status = trim($_POST["status"]);
    if(empty($input_status)){
        $status_err = "Please enter the status amount.";     
    } elseif(ctype_digit($input_status)){
        $status_err = "Please enter text";
    } else{
        $status = $input_status;
    }
    
    // Check input errors before inserting in database
    if(empty($name_err) && empty($about_err) && empty($status_err)){
        // insert these values into table plan
        $sql = "INSERT INTO plan (name, about, status) VALUES (:name, :about, :status)";
 
        if($stmt = $connect->prepare($sql)){
            // Bind variables to the prepared statement as parameters
            $stmt->bindParam(":name", $param_name);
            $stmt->bindParam(":about", $param_about);
            $stmt->bindParam(":status", $param_status);
            
          
            $param_name = $name;
            $param_about = $about;
            $param_status = $status;
            
            //execute the prepared statement
            if($stmt->execute()){
                //successfully created
                header("location: login_success.php");
                exit();
            } else{
                echo "Oops! Something went wrong. Please try again later.";
            }
        }
         
        unset($stmt);
    }
    
    // Close connection
    unset($pdo);
}
?>
 
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Create </title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
         body{
            background-color: #dc5373;
        }
        .wrapper{
            width: 600px;
            margin: 0 auto;
        }
        .log{
            background-color: black;
            color:white;
            padding: 10px 20px;
        }
    </style>
</head>
<body>
    <div class="wrapper">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <br><br><br>
                    <h2 class="mt-5">Add Another Plan</h2>
                    <p>Please fill this form and submit to add details about your planner.</p>
                    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                        <div class="form-group">
                            <label>Name</label>
                            <input type="text" name="name" class="form-control <?php echo (!empty($name_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $name; ?>">
                            <span class="invalid-feedback"><?php echo $name_err;?></span>
                        </div>
                        <div class="form-group">
                            <label>About</label>
                            <textarea name="about" class="form-control <?php echo (!empty($about_err)) ? 'is-invalid' : ''; ?>"></textarea>
                            <span class="invalid-feedback"><?php echo $about_err;?></span>
                        </div>
                        <div class="form-group">
                            <label>Satatus</label>
                            <input type="text" name="status" class="form-control <?php echo (!empty($status_err)) ? 'is-invalid' : ''; ?>" >
                            <span class="invalid-feedback"><?php echo $status_err;?></span>
                        </div>
                        <input type="submit"  class="log" value="Submit">
                        <a href="login_success.php" class="btn btn-secondary ml-2">Cancel</a>
                    </form>
                </div>
            </div>        
        </div>
    </div>
</body>
</html>