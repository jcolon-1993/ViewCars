<!DOCTYPE html>
<html>
  <head>
    <title>Upload File</title>
  </head>
  <body>
    <form action="addimage.php" method="post"
    enctype="multipart/form-data">
      <label for="file">Filename</label>
      <input type="file" name="file" id="file"><br>
      <input type="submit" name="Submit" value="Submit">
    </form>

<?php
  // Used to connect to the database
  include 'db.php';
  // Assign variable to the value that was passed when form was submitted
  if (isset($vin))
  {
    $vin = trim($_POST['VIN']);
    echo $vin;

  // Test to see if a file was uploaded
  if (isset($_FILES["file"]["error"]))
  {
    echo "Error: ".$_FILES["file"]["error"]."<br>";
    if ($_FILES["file"]["error"] > 0)
    {
      // If error, let user know
      echo "Error: ".$_FILES["file"]["error"]."<br>";
    }


  // Otherwise, process the uploaded file.
  else
  {
    // Prints info about the file
    echo "Upload: ".$_FILES["file"]["name"]."<br>"."<\n>";
    echo "Type: ".$_FILES["file"]["type"]."<br>"."<\n>";
    echo "Size: ".$_FILES["file"]["name"/ 1024]."kb<br>"."<\n>";
    // Prints the vin
    echo "VIN: ".$vin."<br>";
    // Tells us the name that php used to store the uploaded file.
    echo "Stored temporarily as: ".$_FILES["file"]["tmp_name"]."<br><BR>"."<\n>";
    // returns the current directory
    $currentFolder = getcwd();
    // Outputs the current directory
    echo "This script is running in: ".$currentFolder."<br>"."\n";
    // Variable used to create the target path
    $target_path = getcwd()."/uploads/";
    // Outputs the target_path
    echo "The uploaded file will be stored in the folder: ".$target_path."<br>"."\n";
    // Appends the original file name of the uploaded file
    $target_path = $target_path.basename($_FILES['file']['name']);
    // The name of the file without the entire file path
    $imagename = "uploads/".basename($_FILES['file']['name']);
    // Outputs the values of the files
    echo "The full file name of the uploaded file is'".$target_path."'<br>"."\n";
    echo "The relative name of the file for us in the IMG tag is".
    $imagename."<br><br>"."<\n>";

    /*
     Moves the uploaded file from the location assigned by php into the target
    path that I calculated
    */
    if(move_uploaded_file($_FILES['file']['tmp_name'], $target_path))
    {
      // Print out result
      echo "The file".basename($_FILES['file']['name']). "has been uploaded<br>"."\n";

      // Create a database entery for this image
      if (mysqli_connect_errno())
      {
        printf("Connection failed: %s\n", mysqli_connect_erro());
        exit();
      }
      echo "Connected successfully to mySQL.<BR>";
      // Returns name of the uploaded file
      $file_name = $_FILES['file']['name'];
      // Builds the query to insert the record into the database
      $query = "INSERT INTO images (VIN, ImageFile) VALUES ('$vin', '$file_name')";
      // prints out query
      echo $query."<br>\n";
      // Creates a link to add another image for a car
      echo "<a href='AddImage.php?VIN=";
      echo $vin;
      echo "'>Add another image for this car</a></p>\n";
      // Try to insert the new car into the database
      // Executes query and prints out failure or success message
      if ($result = $mysqli->query($query))
      {
        echo "<p>You hvae successfully entered $target_path into the database</p>\n";
      }
      else
      {
        echo "Error entering $VIN into database:". mysqli_error(query)."<br>";
      }
      // Closes connection
      $mysqli->close();
      // Creates an image tag for the file we uploaded
      echo "<img src=$'imagename' width='150'><br>";
  }
  else
  {
    echo "There was an error uploading the file, please try again!";
  }
}
}
}

?>
</body>
</html>
