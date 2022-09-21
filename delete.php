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
// 
if(isset($_POST["id"]) && !empty($_POST["id"])){  
    // query we wrote to delete a specific row
    $sql = "DELETE FROM plan WHERE id = :id";
    
    if($stmt = $connect->prepare($sql)){
        $stmt->bindParam(":id", $param_id);
        $param_id = trim($_POST["id"]);
        
        // execute the prepared statement
        if($stmt->execute()){
            // successfully deleted
            header("location: login_success.php");
            exit();
        } else{
            echo "Oops! Something went wrong. Please try again later.";
        }
    }
     
    unset($stmt);
    
    // Close connection
    unset($connect);
} 
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Delete</title>
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
                    <h2 class="mt-5 mb-3">Delete </h2>
                    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                        <div class="alert alert-danger">
                            <input type="hidden" name="id" value="<?php echo trim($_GET["id"]); ?>"/>
                            <p>Are you sure you want to delete this part of plan?</p>
                            <p>
                                <input type="submit" value="Yes" class="btn btn-danger">
                                <a href="login_success.php" class="btn btn-secondary ml-2">No</a>
                            </p>
                        </div>
                    </form>
                </div>
            </div>        
        </div>
    </div>
</body>
</html>
