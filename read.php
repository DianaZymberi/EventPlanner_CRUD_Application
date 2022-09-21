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
}  
catch(PDOException $error)  
{  
     $message = $error->getMessage();  
}  
if(isset($_GET["id"]) && !empty(trim($_GET["id"]))){
    //select all from table plan 
    $sql = "SELECT * FROM plan WHERE id = :id";
    
    if($stmt = $connect->prepare($sql)){
        $stmt->bindParam(":id", $param_id);
        
        $param_id = trim($_GET["id"]);
        
        // execute the prepared statement
        if($stmt->execute()){
            if($stmt->rowCount() == 1){
               
                $row = $stmt->fetch(PDO::FETCH_ASSOC);
                
                // return their values
                $name = $row["name"];
                $about = $row["about"];
                $status = $row["status"];
            } else{
            echo "Oops! Something went wrong. Please try again later.";
        }
    }
}
     
    // Close statement
    unset($stmt);
    
    // Close connection
    unset($connect);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>View</title>
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        body{
            background-color: #dc5373;
        }
        .wrapper{
            width: 300px;
            margin: 0 auto ;
        }
       
    </style>
</head>
<body>
    <div class="wrapper">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <br><br><br>
                    <h1 class="mt-5 mb-3">More Information</h1>
                    <div class="form-group">
                        <label class="label">Name</label>
                        <p><b><?php echo $row["name"]; ?></b></p>
                    </div>
                    <div class="form-group">
                        <label>About</label>
                        <p><b><?php echo $row["about"]; ?></b></p>
                    </div>
                    <div class="form-group">
                        <label>Status</label>
                        <p><b><?php echo $row["status"]; ?></b></p>
                    </div>
                    <p><a href="login_success.php" class="btn btn-primary">Back</a></p>
                </div>
            </div>        
        </div>
    </div>
</body>
</html>