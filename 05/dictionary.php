<!DOCTYPE html>
<html>
<head>
    <title>Dictionary</title>
    <meta charset="utf-8" />
    <link href="dictionary.css" type="text/css" rel="stylesheet" />
</head>
<body>
<?php
if (isset($_GET["number_of_words"]))
    $number_of_words = $_GET["number_of_words"];
else
    $number_of_words = 3;

if (isset($_GET["character"]))
    $startCharacter = $_GET["character"];
else
    $startCharacter = "C";

if (isset($_GET["orderby"]))
    $orderby = $_GET["orderby"];
else
    $orderby = 0;

if (isset($_GET["new_word"]))
    $newWord = $_GET["new_word"];
else
    $newWord = "";

if (isset($_GET["meaning"]))
    $meaning = $_GET["meaning"];
else
    $meaning = "";

?>
<div id="header">
    <h1>My Dictionary</h1>
<!-- Ex. 1: File of Dictionary -->
    <?php
    $filename = "dictionary.tsv";
    $lines = file($filename);

    $words = count($lines);
    $size_file = filesize($filename);
    ?>
    <p>
        My dictionary has <?= $words ?> total words
        and
        size of <?= $size_file ?> bytes.
    </p>
</div>
<div class="article">
    <div class="section">
        <h2>Today's words</h2>
<!-- Ex. 2: Today’s Words & Ex 6: Query Parameters -->
        <?php
            function getWordsByNumber($listOfWords, $numberOfWords){
                $resultArray = array();
                $check = array();

                for ($i = 0; $i < count($listOfWords); ++$i) {
                    $check[] = 0;
                }

                for ($i = 0; $i < $numberOfWords; ++$i) {
                    $var = rand(0, count($listOfWords) - 1);
                    while($check[$var] == 1) {
                        $var = rand(0, count($listOfWords) - 1);
                    }
                    $check[$var] = 1;
                    $resultArray[] = $listOfWords[$var];
                }
                return $resultArray;
            }
        ?>
        <ol>
            <?php
            //$number_of_words = 3;
            $todaysWords = getWordsByNumber($lines, $number_of_words);
            foreach ($todaysWords as $key => $value) {
                $tmp = explode("\t", $value);
            ?>
            <li><?= $tmp[0]." - ".$tmp[1] ?></li>
            <?php
            }
            ?>
        </ol>
    </div>
    <div class="section">
        <h2>Searching Words</h2>
<!-- Ex. 3: Searching Words & Ex 6: Query Parameters -->
        <?php
            function getWordsByCharacter($listOfWords, $startCharacter){
                $resultArray = array();

                foreach ($listOfWords as $key => $value) {
                    if ($value[0] == $startCharacter)
                        $resultArray[] = $value;
                }

                return $resultArray;
            }
        ?>
        <?php
        //$startCharacter = "B";
        $searchedWords = getWordsByCharacter($lines, $startCharacter);
        ?>
        <p>
            Words that started by <strong>'<?= $startCharacter ?>'</strong> are followings :
        </p>
        <ol>
            <?php
            foreach ($searchedWords as $key => $value) {
            ?>
            <li><?= $value ?></li>
            <?php
            }
            ?>
        </ol>
    </div>
    <div class="section">
        <h2>List of Words</h2>
<!-- Ex. 4: List of Words & Ex 6: Query Parameters -->
        <?php
            function getWordsByOrder($listOfWords, $orderby){
                $resultArray = $listOfWords;
                if ($orderby == 0)
                    asort($resultArray);
                else if ($orderby == 1)
                    arsort($resultArray);
                return $resultArray;
            }
        ?>
        <?php
        //$orderby = 0;
        $ordered_list = getWordsByOrder($lines, $orderby);
        ?>
        <p>
            All of words ordered by <strong>alphabetical <?php if ($orderby == 1) echo("reverse"); ?> order</strong> are followings :
        </p>
        <ol>
            <?php
            foreach ($ordered_list as $idx => $val) {
                $tmp = explode("\t", $val);
                $key = $tmp[0];
                $value = $tmp[1];
                if (strlen($key) > 6)
                    $class = ' class="long"';
                else
                    $class = '';

            ?>
            <li <?= $class ?>><?= $key." - ".$value ?></li>
            <?php
            }
            ?>
        </ol>
    </div>
    <div class="section">
        <h2>Adding Words</h2>
<!-- Ex. 5: Adding Words & Ex 6: Query Parameters -->
        <?php
        //$newWord = "grape";
        //$meaning = "A grape is a fruiting berry of the deciduous woody vines of the botanical genus Vitis.";

        if (strlen($newWord) != 0 && strlen($meaning) != 0) 
            file_put_contents($filename, "\n".$newWord."\t".$meaning, FILE_APPEND);

        $new_lines = file($filename);

        $list = array();

        foreach ($new_lines as $idx => $line) {
            $tmp = explode("\t", $line);
            $list[$tmp[0]] = $tmp[1];
        }

        if (!isset($list[$newWord]) || strcmp($list[$newWord], $meaning)) {
        ?>
        <p>Input word or meaning of the word doesn't exist.</p>
        <?php
        }
        else {
        ?>
        <p>Adding a word is success!</p>
        <?php
        }
        ?>
    </div>
</div>
<div id="footer">
    <a href="http://validator.w3.org/check/referer">
        <img src="http://selab.hanyang.ac.kr/courses/cse326/2015/problems/images/w3c-html.png" alt="Valid HTML5" />
    </a>
    <a href="http://jigsaw.w3.org/css-validator/check/referer">
        <img src="http://selab.hanyang.ac.kr/courses/cse326/2015/problems/images/w3c-css.png" alt="Valid CSS" />
    </a>
</div>
</body>
</html>