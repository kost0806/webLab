<?php
    # Ex 4 : Write a tweet

    try {
        require_once("timeline.php");
        if (preg_match("/^[a-zA-Z]?([a-zA-Z][-\s]?[a-zA-Z]?){0,9}([a-zA-Z]|[^-]){1}$/", $_POST["author"])) { #validate author & content
            $timeline = new TimeLine();
            $tweets = array(
                "author" => $_POST["author"],
                "content" => htmlspecialchars($_POST["content"])
                );
            $timeline->add($tweets);
            header("Location:index.php");
        } else {
            header("Location:error.php");
        }
        
    } catch(Exception $e) {
        header("Location:error.php"); 
    }
?>
