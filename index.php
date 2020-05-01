<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

session_start();
?>
<!DOCTYPE html>
<html>
<head>
<style>
.error {color: #FF0000}
</style>
<title>I ❤️ SunAddIce</title>
</head>
<body>

<?php
$comment = $name = "";
$comment_err = $name_err = "";
$too_frequently = false;
$allow_comment = true;
$time_now = time();

$dbname = "comments";
$dbuser = "user";
$dbpass = "pass";
$conn = new mysqli("localhost", $dbuser, $dbpass, $dbname);
if ($conn->connect_error) {
    die("Unable to connect to database!");
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if ($time_now - $_SESSION["last_post_time"] <= 10) {
        $too_frequently = true;
        $allow_comment = false;
    }

    if (empty($_POST["name"])) {
        $allow_comment = false;
        $name_err = "Share your name plz!";
    }
    if (empty($_POST["comment"])) {
        $allow_comment = false;
        $comment_err = "Give your comment plz!";
    }

    if ($allow_comment) {
        $name = strip_input($_POST["name"]);
        $comment = strip_input($_POST["comment"]);
        $_SESSION["last_post_time"] = $time_now;

        
        $sql = $conn->prepare("INSERT INTO comments (time, name, content) VALUES (?, ?, ?)");
        if ($sql == false) {
            die("Comment failed!");
        }
        $time_str = date('Y-m-d H:i:s', $time_now);
        $sql->bind_param("sss", $time_str, $name, $comment);
        $sql->execute();
        if ($sql->affected_rows == 0) {
            die("Comment failed!");
        }
        $sql->close();
        header("Location: #");
    }
}

function strip_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}
?>
<h2>I ❤️ SunAddIce</h2>

Support IceLolly & SunAddIce by leaving a comment!<br><br>

<form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
    
    Name:<br>
    <input type="text" size="20" name="name" value="<?php echo $name; ?>" autofocus>
    <span class="error"><?php echo $name_err; ?></span>
    <br><br>

    Comment:<br>
    <input type="text" size="30" name="comment" value="<?php echo $comment; ?>">
    <span class="error"><?php echo $comment_err; ?></span>
    <br><br>

    <?php
    if ($too_frequently) {
        echo '<span class="error">Hey! You submitted too frequently! Stop doing that!</span><br>';
    }
    ?>

    <input type="submit" name="submit" value="Send">
</form>

<h2>All Comments</h2>
<?php
$result = $conn->query("SELECT time, name, content FROM comments ORDER BY time DESC");
if ($result->num_rows > 0) {
    echo "<b>" . $result->num_rows . " comments</b><br><br>";
    while ($row = $result->fetch_array()) {
        echo $row["time"] . " '" . $row["name"] . "' comments: " . $row["content"] . "<br>";
    }
} else {
    echo "No comments yet :(";
}
$conn->close();
?>

</body>
</html>
