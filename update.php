<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Update record</title>
    <link href="https://fonts.googleapis.com/css2?family=Bebas+Neue&display=swap" rel="stylesheet"> 

     <!--custom CSS-->
     <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
     
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="Style/style.css">
  </head>
  <body class="container">
  
        
  <!--HEADER-->
    <br><br>
    <div class="container-fluid bg-dark text-white text-center">
        <h1 class="mb-4" style="font-size: 6rem; font-weight: bold;">SCP FOUNDATION</h1>
    </div>
      
    <div class="rounded border shadow p-5">    
    
    <?php
        
        include "connection.php";
        
        // initialise $row as empty array
        $row = [];
        
        //directed from index page record [update] button
        if(isset($_GET['update']))
        {
            $id = $_GET['update'];
            // based on id select appropriate record from db
            $recordID = $connection->prepare("select * from scpdatabase where ID = ?");
            
            if(!$recordID)
            {
                echo "<div class='alert alert-danger p-3 m-2'>Error preparing recored for updating.</div>";
                exit;
            }
            
            $recordID->bind_param("i", $id);
            
            if($recordID->execute())
            {
                echo "<div class='alert alert-success p-3 m-2'>Record ready for updating.</div>";
                $temp = $recordID->get_result();
                $row = $temp->fetch_assoc();
            }
            else
            {
                echo "<div class='alert alert-danger p-3 m-2'>Error: {$recordID->error}</div>";
            }
        }
        
        
        if(isset($_POST['update']))
        {
            // Write a prepare statemnet to insert data
            $update = $connection->prepare("update scpdatabase set Item=?, Class=?, Description=?, Containment=?, Image=? where ID=?");
        
            $update->bind_param("sssssi",$_POST['Item'], $_POST['Class'], $_POST['Description'], $_POST['Containment'], $_POST['Image'], $_POST['ID']);
            
            if($update->execute())
        {
            echo "<div class='alert alert-success p-3 m-2'>Record updated successfully</div>";
        }
        else
        {
            echo "<div class='alert alert-danger p-3 m-2'>Error: {$update->error}</div>";
        }
        }
        
        
      ?>
      
      
    <h1>Update record</h1>
    
    <p><a href="index.php" class="btn btn-dark">Back to index page.</a></p>
    
    <form method="post" action="update.php" class="form-group">
        <input type="hidden" name="ID" value="<?php echo isset($row['ID']) ? $row['ID'] : '' ; ?>">
        <label>SCP Item No:</label>
        <br>
        <input type="text" name="Item" placeholdoer="Item Number..." class="form-control" value="<?php echo isset($row['Item']) ? $row['Item'] : '' ; ?>">
        <br><br>
        
        <label>Class:</label>
        <br>
        <input type="text" name="Class" placeholdoer="Class..." class="form-control"value="<?php echo isset($row['Class']) ? $row['Class'] : '' ; ?>">
        <br><br>
        
        <label>Containment Protocol:</label>
        <br>
        <textarea name="Containment" class="form-control" ><?php echo isset($row['Containment']) ? $row['Containment'] : '' ; ?></textarea>
        <br><br>
        
        <label>Description:</label>
        <br>
        <textarea name="Description" class="form-control" style = "height:200px" ><?php echo isset($row['Description']) ? $row['Description'] : '' ; ?></textarea>
        <br><br>
        
        <label>Image:</label>
        <br>
        <input type="text" name="Image" placeholdoer="images/name_of_image.png" class="form-control"value="<?php echo isset($row['Image']) ? $row['Image'] : '' ; ?>">
        <br><br>
        
        <input type="submit" name="update" class="btn btn-primary">
        
    </form>
    
    </div>
    
<!--FOOTER-->
<div class="container">
    <footer class="d-flex pt-3 my-2 border-top">
       <h2 class="text-right pt-1 text-white">SECURE. CONTAIN. PROTECT.</h2>
    </footer>
</div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
  </body>
</html>
