<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Test</title>
</head>
<body>
    <form class="question" method="post" action="">
        <span style="font-weight: 700;">Question 1</span>
        <div>
        <div <div style='display: flex;'>
        <!-- Every time if the page will be reloaded
        (It will reload, if any button will be pressed)
        this code will parse data from mysql database.
        It will be done for every question seperatly.
        It is very stupid and weak method,
        but it's works fine for this task i guess -->
            <?php 
            $host = 'localhost';
            $username = 'root';
            $password = '';
            $database = 'testDB';

            $conn = new mysqli($host, $username, $password, $database);
            // Here use a filter by questionId = 1, to show answers for first question
            $sql = "SELECT id, questionId, answer FROM question WHERE questionId = 1";
            $result = $conn->query($sql);
            if ($result->num_rows > 0) {
                // output data of each row
                while($row = $result->fetch_assoc()) {
                  echo "<div id='" . $row["questionId"] . "'>";
                  echo "<div><span>". $row["answer"] . "</span></div>";
                  echo "<div><form method='post' action=''><input type='hidden' name='answer_id' value='".$row["questionId"]."'/><input type='submit' value='Remove' name='remove' id='". $row["id"] ."' onClick='remove(this.id)' /></form></div>";
                  echo "<div>";
                  }
                }
            $conn->close();
            ?>
            <!-- So after fetching the data, it creates a div with id = questionID.
            Inside this div I'm creating a span, where is the answer and remove button
            with specific answerId, which was taken from mysql database.
            As you can see, there is 2 different id. Id - automatic id from database (Needs for removing)
            questionId - number of question (needs for indicating answer for specific question number) -->
        </div>
        <!-- As you can see, here must be a different name for input. For example, here answer1, which means, that this input attempts for question number one -->
        <input type="text" placeholder="Enter Answer..." name="answer1" />
        <button id="submitBTN1" type="submit" name="postButton">Submit</button>
        </form>
    <div>
       <!-- I'm creating a different form for specific question. The only way I have imagined in 1:30 AM.
            Probably it is because I need somehow handle submit buttons for specific questions. Othrewise, I could't
            separate the questions I think. -->
<form class="question2" method="post" action="">
        <span style="font-weight: 700;">Question 2</span>
        <div>
        <div <div style='display: flex;'>
            <?php 
            $host = 'localhost';
            $username = 'root';
            $password = '';
            $database = 'testDB';

            $conn = new mysqli($host, $username, $password, $database);
            // Here use filter with questionId = 2, to store only answers for second question etc...
            $sql = "SELECT id, questionId, answer FROM question WHERE questionId = 2";
            $result = $conn->query($sql);
            if ($result->num_rows > 0) {
                // output data of each row
                while($row = $result->fetch_assoc()) {
                  echo "<div id='" . $row["questionId"] . "'>";
                  echo "<div><span>". $row["answer"] . "</span></div>";
                  echo "<div><form method='post' action=''><input type='hidden' name='answer_id' value='".$row["questionId"]."'/><input type='submit' value='Remove' name='remove' id='". $row["id"] ."' onClick='remove(this.id)' /></form></div>";
                  echo "<div>";
                  }
                }
            $conn->close();
            ?>
        </div>
        
    <div>
        <!-- Here is question number two (name = "answer2") -->
        <input type="text" placeholder="Enter Answer..." name="answer2"/>
        <button id="submitBTN2" type="submit" name="postButton">Submit</button>
</form>

<!-- Script that POST data into MYSQL DATABASE
    I have writed php code on the same page, so I don't need to set action parameter on html form.
    Because, if I would have an action = "script.php" parameter on form,
    the page would redirected to new page -->
<?php
// Use your username and password, and database name instead
$host = 'localhost';
$username = 'root';
$password = '';
$database = 'testDB';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Create a new mysqli instance
    $conn = new mysqli($host, $username, $password, $database);

    // Check for connection errors
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
//Question 1
    if (isset($_POST['answer1']) && !empty($_POST['answer1'])) {
        $answer1 = $_POST['answer1'];
        $id1 = 1;
        // Prepare and execute the SQL statement
        $sql1 = "INSERT INTO question (questionId, answer) VALUES ('$id1', '$answer1')";

        if ($conn->query($sql1) === TRUE) {
            // Success
        } else {
            // Error
        }
    }
//Question 2
// Change answer1 -> answer2
    if (isset($_POST['answer2']) && !empty($_POST['answer2'])) {
        $answer2 = $_POST['answer2'];
        $id2 = 2;
        // Prepare and execute the SQL statement
        $sql2 = "INSERT INTO question (questionId, answer) VALUES ('$id2', '$answer2')";

        if ($conn->query($sql2) === TRUE) {
            // Success
        } else {
            // Error
        }
    }
//Question 3...

    $conn->close();
    // Need this part for refresh the page.
    header("Refresh:0");
}
?>

<!-- I have avoided using jquery and ajax.
    This is javascript code, that will be called,
    when the remove button will be pressed.
    So this JS code will call remove.php script,
    which will remove data from mysql database. -->

<script>
    const remove = (id) => {
    const url = "remove.php";

    fetch(url, {
        method: "POST",
        body: new URLSearchParams({
            id: id
        })
    })
    .then(response => response.text())
    .then(data => {
        // Handle the response from the PHP script
        console.log(data);
        // Refresh the page or update the DOM as needed
        location.reload(); // Example: Reload the page after data is removed
    })
    .catch(error => {
        // Handle any errors
        console.error("Error:", error);
    });
}
</script>
</body>
</html>