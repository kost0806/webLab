<?php
require_once("timeline.php");
try {
    $timeline = new TimeLine();
    $timeline->delete($_GET["no"]);
    #call delete function
    header("Location:index.php");
    
} catch(Exception $e) {
    header("Loaction:error.php"); 
}
?>
