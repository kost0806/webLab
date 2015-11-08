<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <title>Simple Timeline</title>
        <link rel="stylesheet" href="timeline.css">
    </head>
    <body>
        <?php
        include("timeline.php");
        $timeline = new TimeLine();
        ?>
        <div>
            <a href="index.php"><h1>Simple Timeline</h1></a>
            <div class="search">
                <!-- Ex 3: Modify forms -->
                <form class="search-form" action="index.php">
                    <input type="submit" value="search">
                    <input type="text" placeholder="Search" name="query">
                    <select name="type">
                        <option value="author">Author</option>
                        <option value="content">Content</option>
                    </select>
                </form>
            </div>
            <div class="panel">
                <div class="panel-heading">
                    <!-- Ex 3: Modify forms -->
                    <form class="write-form" action="add.php">
                        <input type="text" placeholder="Author" name="author">
                        <div>
                            <input type="text" placeholder="Content" name="content">
                        </div>
                        <input type="submit" value="write">
                    </form>
                </div>
                <!-- Ex 3: Modify forms & Load tweets -->
                <?php
                if (isset($_GET["type"]) && isset($_GET["query"]))
                    if (strlen($_GET["type"]) != 0 && strlen($_GET["query"]) != 0) {
                        if (!strcmp($_GET["type"], "content") || !strcmp($_GET["type"], "author"))
                            $rows = $timeline->searchTweets($_GET["type"], $_GET["query"]);
                        else
                            $rows = $timeline->loadTweets();
                    }
                    else
                        $rows = $timeline->loadTweets();
                else
                    $rows = $timeline->loadTweets();
                foreach ($rows as $row) {
                    $tmp = explode(" ", $row["time"]);
                    $tmp[0] = explode("-", $tmp[0]);
                    $tmp[0] = $tmp[0][2]."-".$tmp[0][1]."-".$tmp[0][0];
                    $time = $tmp[1]." ".$tmp[0];
                ?>
                <div class="tweet">
                    <form class="delete-form" action="delete.php" method="POST">
                        <input type="submit" value="delete">
                        <input type="hidden" value="<?= $row['no']?>" name="no">
                    </form>
                    <div class="tweet-info">
                        <span><?= $row["author"]?></span>
                        <span><?= $time?></span>
                    </div>
                    <div class="tweet-content">
                        <?= $row["contents"]?>
                    </div>
                </div>
                <?php
                }
                ?>
            </div>
        </div>
    </body>
</html>
