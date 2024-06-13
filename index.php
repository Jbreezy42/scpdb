<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>SCP Index</title>
        <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Bebas+Neue&display=swap" rel="stylesheet"> 

     <!--custom CSS-->
     <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    

     <!--BOOTSTRAP-->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script defer src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="Style/style.css">
    </head>
  <body class= "container">
      <?php include "connection.php";?>

    <nav class="nav navbar-expand-lg navbar-dark bg-dark">
        <div class="container-fluid">

            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item active">
                    <a href="create.php" class="nav-link">Add New Record</a>
                  </li>
                  <?php foreach($Result as $link): ?>
                    <li class="nav-item mx-3 active"><a href="index.php?link='<?php echo $link['Item']; ?>'" class="nav-link"><?php echo $link['Item']; ?></a></li>
                  <?php endforeach; ?>
                </ul>
            </div>
        </div>
    </nav>
      
      <!--HEADER-->
      <br><br>
      <div class="container-fluid bg-dark text-white text-center">
         <h1 class="mb-4" style="font-size: 6rem; font-weight: bold;">SCP FOUNDATION</h1>
      </div>
      
      
</div>
      <div class="rounded border shadow p-5">
          
          <?php 
            
            if(isset($_GET['link']))
            {
                // trim out the single quote from get value
                $Item = trim($_GET['link'], "'");
                
                // run sql command to retrieve record based on $Item
                // $record = $connection->query("select * from scpdatabase where Item='$Item'");
                
                // save each field in record as an array
                // $array = $record->fetch_assoc();
                
                // prepared statement
                $statement = $connection->prepare("select * from scpdatabase where Item = ?");
                if(!$statement)
                {
                    echo "<p>Error in preparing sql statement</p>";
                    exit;
                }
                // bind parameters takes 2 arguments the type of data and the var to bind to.
                $statement->bind_param("s", $Item);
                
                if($statement->execute())
                {
                    $get_result = $statement->get_result();
                    
                    // check if record has been retrieved
                    if($get_result->num_rows > 0)
                    {
                        $array = array_map('htmlspecialchars', $get_result->fetch_assoc());
                         
                        $update = "update.php?update=" . $array['ID'];
                        $delete = "index.php?delete=" .$array['ID'];
                         
                         echo "<h2 class='display-2'>{$array['Item']}</h2>
                               <h3 class='display-3'>{$array['Class']}</h3>";
                        
                        if(!empty($array['Image']))
                        {
                            echo "
                            <p class='text-center'><img src='{$array['Image']}' alt='{$array['Item']}' class='img-fluid'></p>
                            ";
                        }
                        
                        echo "<p>{$array['Containment']}</p>
                              <p>{$array['Description']}</p>
                              <p class='buttons'><a href='{$update}' class='btn btn-dark'>Update Record</a> &nbsp;
                              <a href='{$delete}' class='btn btn-danger'>Delete Record</a></p>";
                        
                    }
                    else
                    {
                        echo "<p>No record found for Item: {$array['Item']}</p>";
                    }
                }
                else
                {
                    echo "<p>Error executing statement.</p>";
                }
                
              
            }
            else
            {
                echo "<div class='container text-center'>
                        <div class='row'>
                            <img src='images/frontpage.png' class='img-fluid'>
                        </div>
                        <p>Welcome to the SCP database. Use the links above to view current records in the database or create a new entry.</p>
                        </div>";
            }
          
          // Delete functionality
            if(isset($_GET['delete']))
            {
               $deleteID = $_GET['delete'];
               $delete_query = $connection->prepare("delete from scpdatabase where ID = ?");
               $delete_query->bind_param("i", $deleteID);
               
               if($delete_query->execute())
               {
                   echo "<div class='alert alert-danger'>Recorded Deleted...</div>";
               }
               else
               {
                    echo "<div class='alert alert-danger'>Error: {$delete_query->error}</div>";
               }
            } // end of delete funtionality
            
          ?>
          
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
