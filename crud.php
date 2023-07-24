<?php

    // use "crud.sql" first
    // modify database name, user and password

    try
    {
        $db = new PDO('mysql:host=localhost;dbname=testintervolga;charset=utf8', 'username', 'password');
    }
    catch (Exception $e)
    {
        die('Error: ' . $e->getMessage());
    }

    if (isset($_POST['comment']) && isset($_POST['user']))
    {
        $sqlQuery = 'INSERT INTO comments(comment, username, datetimecomment) VALUES (:comment, :username, :datetimecomment)';

        $insertRecipe = $db->prepare($sqlQuery);

        $datetime = new DateTime('now');
        $datetime_txt = $datetime->format('Y-m-d H:i:s');

        $insertRecipe->execute([
            'comment' => $_POST['comment'],
            'username' => $_POST['user'],
            'datetimecomment' => $datetime_txt,
        ]);
    }

    $recipesStatement = $db->prepare('SELECT * FROM comments');
    $recipesStatement->execute();
    $comments = $recipesStatement->fetchAll();

?>

<html>
    <head>
        <meta charset="UTF-8"/>
        <link rel="stylesheet" type="text/css" href="style.css" />
    </head>

    <body>

        <a href="index.php">Home</a>
        
        <h1>CRUD</h1>

        <p>If error connection to database, check php comment</p>

        <h4>Add comment:</h4>

        <form action="crud.php" method="post">

            <label for="user">Username:</label>
            <br>
            <input type="text" id="user" name="user">
            <br>
            <label for="comment">Comment:</label>
            <br>
            <textarea name="comment" id="comment" rows="5" cols="50" placeholder="Write your comment here..."></textarea>
            <br>
            <input type="submit">

        </form>

        <h4>Last comments:</h4>

        <?php

            foreach ($comments as $comment)
            {
                echo $comment["datetimecomment"]." from ".$comment["username"]."<br>";
                echo $comment["comment"]."<br><br>";
            }

        ?>

    </body>

</html>