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
 if(isset($_SESSION["username"]))  
 {  
     
 }  
 else  
 {  
      header("location:pdo_login.php");  
 }
}  
 catch(PDOException $error)  
 {  
      $message = $error->getMessage();  
 }  
 
$name = $about = $status = "";
$name_err = $about_err = $status_err = "";
 
if(isset($_POST["id"]) && !empty($_POST["id"])){
    $id = $_POST["id"];
    
    $input_name = trim($_POST["name"]);
    if(empty($input_name)){
        $name_err = "Please enter a name.";
    } elseif(!filter_var($input_name, FILTER_VALIDATE_REGEXP, array("options"=>array("regexp"=>"/^[a-zA-Z\s]+$/")))){
        $name_err = "Please enter a valid name.";
    } else{
        $name = $input_name;
    }
    
    $input_about = trim($_POST["abou"]);
    if(empty($input_about)){
        $about_err = "Please enter an about.";     
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
    if(empty($name_err) && empty($about_err) && empty($status_err)){
       
        $sql = "UPDATE plan SET name=:name, about=:about, status=:status WHERE id=:id";
 
        if($stmt = $connect->prepare($sql)){
        
            $stmt->bindParam(":name", $param_name);
            $stmt->bindParam(":about", $param_about);
            $stmt->bindParam(":status", $param_status);
            $stmt->bindParam(":id", $param_id);
            
    
            $param_name = $name;
            $param_about = $about;
            $param_status = $status;
            $param_id = $id;
            
            
            if($stmt->execute()){
                header("location: login_success.php");
                exit();
            } else{
                echo "Oops! Something went wrong. Please try again later.";
            }
        }
         
                unset($stmt);
    }
    
    unset($connect);
} else{
   
    if(isset($_GET["id"]) && !empty(trim($_GET["id"]))){
        
        $id =  trim($_GET["id"]);
        
       
        $sql = "SELECT * FROM plan WHERE id = :id";
        if($stmt = $connect->prepare($sql)){
           
            $stmt->bindParam(":id", $param_id);
            
            $param_id = $id;
            
           
            if($stmt->execute()){
                if($stmt->rowCount() == 1){
                    
                    $row = $stmt->fetch(PDO::FETCH_ASSOC);
                
                    $name = $row["name"];
                    $about = $row["about"];
                    $status = $row["status"];
                } else{
                    
                    header("location: error.php");
                    exit();
                }
                
            } else{
                echo "Oops! Something went wrong. Please try again later.";
            }
        }
        
        unset($stmt);
        
        unset($connect);
    }  else{
        header("location: error.php");
        exit();
    }
}
?>
 
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Update</title>
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
                    <h2 class="mt-5">Update</h2>
                    <p>Please edit the input values and submit to update your planner</p>
                    <form action="<?php echo htmlspecialchars(basename($_SERVER['REQUEST_URI'])); ?>" method="post">
                        <div class="form-group">
                            <label>Name</label>
                            <input type="text" name="name" class="form-control <?php echo (!empty($name_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $name; ?>">
                            <span class="invalid-feedback"><?php echo $name_err;?></span>
                        </div>
                        <div class="form-group">
                            <label>about</label>
                            <textarea name="abou" class="form-control <?php echo (!empty($about_err)) ? 'is-invalid' : ''; ?>"><?php echo $about; ?></textarea>
                            <span class="invalid-feedback"><?php echo $abou_err;?></span>
                        </div>
                        <div class="form-group">
                            <label>status</label>
                            <input type="text" name="status" class="form-control <?php echo (!empty($status_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $status; ?>">
                            <span class="invalid-feedback"><?php echo $status_err;?></span>
                        </div>
                        <input type="hidden" name="id" value="<?php echo $id; ?>"/>
                        <input type="submit" class="log" value="Submit">
                        <a href="login_success.php" class="log">Cancel</a>
                    </form>
                </div>
            </div>        
        </div>
    </div>
</body>
</html>