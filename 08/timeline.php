<?php
    class TimeLine {
        # Ex 2 : Fill out the methods
        private $db;
        function __construct()
        {
            # You can change mysql username or password
            $this->db = new PDO("mysql:host=localhost;dbname=kost", "kost", "kost");
            $this->db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        }
        public function add($tweet) // This function inserts a tweet
        {
            $author = $this->db->quote($tweet["author"]);
            $contents = $this->db->quote($tweet["content"]);
            $q = "INSERT INTO tweets (author, contents, time)values($author, $contents, now())";
            $result = $this->db->query($q);
        }
        public function delete($no) // This function deletes a tweet
        {
            $no = $this->db->quote($no);
            $q = "DELETE FROM tweets WHERE no=$no";
            $result = $this->db->query($q);
        }
        # Ex 6: hash tag
        # Find has tag from the contents, add <a> tag using preg_replace() or preg_replace_callback()
        public function loadTweets() // This function load all tweets
        {
            $q = "SELECT * FROM tweets ORDER BY time DESC";
            $result = $this->db->query($q);
            $num_row = $result->rowCount();
            $result = $result->fetchAll();
            for ($i = 0; $i < $num_row; ++$i) {
                $content = $result[$i]["contents"];
                $url = "index.php";
                $replace = "<a href=\"{$url}?type=content&query=%23$1\">#$1</a>";
                $content = preg_replace("/#([_]*[a-zA-Z0-9가-힣]+[\w가-힣]*)/", $replace, $content);
                $result[$i]["contents"] = $content;
            }
            return $result;
        }
        public function searchTweets($type, $query) // This function load tweets meeting conditions
        {
            $t = strtolower($type);
            $q = "";
            if (!strcmp($t, "author")) {
                $author = $this->db->quote("%$query%");
                $q = "SELECT * FROM tweets WHERE author like $author ORDER BY time DESC";
            }
            else {
                $query = htmlspecialchars($query);
                $contents = $this->db->quote("%$query%");
                $q = "SELECT * FROM tweets WHERE contents like $contents ORDER BY time DESC";
            }
            $result = $this->db->query($q);
            $num_row = $result->rowCount();
            $result = $result->fetchAll();
            for ($i = 0; $i < $num_row; ++$i) {
                $content = $result[$i]["contents"];
                $url = "index.php";
                $replace = "<a href=\"{$url}?type=content&query=%23$1\">#$1</a>";
                $content = preg_replace("/#([_]*[a-zA-Z0-9가-힣]+[\w가-힣]*)/", $replace, $content);
                $result[$i]["contents"] = $content;
            }
            return $result;
        }
    }
?>