<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Create Record</title>
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
            
            if(isset($_POST['submit']))
            {
               $imagePath = empty($_POST['Image']) ? 'images/classified.png' : $_POST['Image'];
               
               // write a prepare statement to insert data
                $insert = $connection->prepare("insert into scpdatabase(Item, Class, Containment, Description, Image) values(?,?,?,?,?)");
                 
                 
                //Bind parameters 
                $insert->bind_param("sssss", $_POST['Item'], $_POST['Class'], $_POST['Containment'], $_POST['Description'], $imagePath);
                
                //execute SQL command
                if($insert->execute())
                {
                    echo "<div class='alert alert-success mb-3'>Record added successfully</div>";
                }
                else
                {
                    echo "<div class='alert alert-danger'>Error adding record...</div>";
                    //{$insert->error}
                }
            
            }
            
            
      ?>
      
      
    <h1>Create a new record</h1>
    <p> <a href = "index.php" class="btn btn-dark">Back to index page</a></p>
    
    <form method="post" action="create.php" class="form-group">
        <label>Enter SCP Item Number:</label>
        <br>
        <input type="text" name="Item" placeholder="Item No..." class="form-control" required>
        <br><br>
        
        <label>Enter Class:</label>
        <br>
        <input type="text" name="Class" placeholder="Class..." class="form-control" required>
        <br><br>
        
        <label>Enter Containment Protocol:</label>
        <br>
        <textarea name="Containment" class="form-control" required> Containment Protocol...</textarea>
        <br><br>
        
        <label>Enter Description:</label>
        <br>
        <textarea name="Description" class="form-control" required> Description...</textarea>
        <br><br>
        
        <label>Enter Image:</label>
        <br>
        <input type="text" name="Image" placeholder="images/name_of_image.png" class="form-control">
        <br><br>
        
        <input type="submit" name="submit" class="btn btn-primary">
        
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
