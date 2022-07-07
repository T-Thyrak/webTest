<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Information_Detail</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-0evHe/X+R7YkIZDRvuzKMRqM+OrBnVFBL6DOitfPri4tjfHxaWutUpFmBp4vmVor" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/js/bootstrap.bundle.min.js" integrity="sha384-pprn3073KE6tl6bjs2QrFaJGz5/SUsLqktiwsUTF55Jfv3qYSDhgCecCxMW52nD2" crossorigin="anonymous"></script>
</head>
<body>
<div class="container mt-5 pt-5" method="POST">       
    <div class="col-10 col-md-6 col-lg-4 m-auto">
        <div class="card border-5px shadow" >
            <div class="card-body">
            <h3 class="text-success ms-1"> Information </h3>
                <table class="table table-hover ">       
                <tbody>
                        <tr>
                        <th >Name:</th>
                        <td>
                        <?php
                        echo $_SESSION['username'];
                        ?>
                        </td>
                        <tr>
                        <th >Gender:</th>
                        <td>
                        <?php
                        echo $_SESSION['gender'];
                        ?>
                        </td>
                        <tr>
                        <th >Class:</th>
                        <td>
                        <?php
                        echo $_SESSION['class'];
                        ?>
                        </td>
                        <tr>
                        <th >Email:</th>
                        <td>
                        <?php
                        echo $_SESSION['email'];
                        ?>
                        </td>     
                        </tr>                       
                    </tbody>
                </table>
            
            </div>    
        </div>  
    </div>  
</div>                
</body>
</html>

