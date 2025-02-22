<?php
include_once('esp-database.php');

session_start(); // initialize the session

$result = getAllOutputs();
$html_buttons = null;
if ($result) {
    while ($row = $result->fetch_assoc()) {

        if ($row['state'] == "0") {
            $button_checked = "checked";
        } else {
            $button_checked = "unchecked";
        }
        $html_buttons .= '<h3>' . $row["name"] . ' - Board ' . $row["board"] . ' - GPIO ' . $row["gpio"] .
            ' </h3><label class="switch"><input type="checkbox" onchange="updateOutput(this)" id="' . $row["id"] . '" ' .
            $button_checked . '><span class="slider"></span></label> <br><br><br><br><br><br>';
    }
}

$result2 = getAllBoards();
$html_boards = null;
if ($result2) {
    $html_boards .= '<h3>Boards</h3>';
    while ($row = $result2->fetch_assoc()) {
        $row_reading_time = $row["last_request"];
        // Uncomment to set timezone to - 1 hour (you can change 1 to any number)
        //$row_reading_time = date("Y-m-d H:i:s", strtotime("$row_reading_time - 1 hours"));

        // Uncomment to set timezone to + 4 hours (you can change 4 to any number)
        //$row_reading_time = date("Y-m-d H:i:s", strtotime("$row_reading_time + 7 hours"));
        $html_boards .= '<p><strong>Board ' . $row["board"] . '</strong> - Last Request Time: ' . $row_reading_time . '</p>';
    }
}
?>

<!DOCTYPE HTML>
<html>


<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">

    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" type="text/css" href="esp-style.css">
    <title>ESP Output Control</title>

    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="description" content="Responsive Admin Dashboard Template">
        <meta name="keywords" content="admin,dashboard">
        <meta name="author" content="stacks">
        <title>rUrban Control System</title>
        <link href="esp-style.css" rel="stylesheet">
    </head>
</head>

<body>
    <center>
        <h2>rUrban Control System</h2>
    </center>
    <center>
        ENABLE AUTOMATIC CONTROL
        <?php echo $html_buttons; ?>
        <!-- <?php echo $html_boards; ?> -->
        <center>
            <br><br>
            <script>
                function updateOutput(element) {
                    var xhr = new XMLHttpRequest();
                    if (element.checked) {
                        xhr.open("GET", "esp-outputs-action.php?action=output_update&id=" + element.id + "&state=0", true);
                    } else {
                        xhr.open("GET", "esp-outputs-action.php?action=output_update&id=" + element.id + "&state=1", true);
                    }
                    xhr.send();
                }
            </script>

</body>

</html>