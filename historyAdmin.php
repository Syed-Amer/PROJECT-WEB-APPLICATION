<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>History</title>
    <link rel="stylesheet" href="css/header.css">
    <link rel="stylesheet" href="css/historyAdmin.css">
</head>

<body>
    <?php
    session_start();
    include_once 'header.php';
    include_once 'includes/functions.inc.php';
    include_once 'includes/db.inc.php';
    ?>
    <section>
        <div>
            <form action="" method="post">
                <label for="select">Select User</label>

                <!-- Checklist to select user id -->
                <select name="select" id="select">
                    <?php getAllUsersId($conn); ?>
                </select>
                <button type="submit" name="submit" class="submit">Submit</button>
            </form>
            <form action="includes/deleteDownloaded.inc.php" method="post">
                <table>
                    <?php
                    if ($_SERVER["REQUEST_METHOD"] == "POST") {
                        if (isset($_POST['select'])) {
                            $id = $_POST['select'];
                            $_SESSION['selectId'] = $id;
                            header("location: historyAdmin.php?id=$id");
                        }
                    }
                    handleFormSubmission($conn);
                    ?>
                </table>
                <button name="delete" class="delete">Delete</button>
            </form>
            <form action="includes/alterData.inc.php" method="post" class="updateForm">

                <?php
                if (isset($_GET['error'])) {
                    echo '<p class="error">' . $_GET['error'] . '</p>';
                }
                if (isset($_GET['update'])) {
                    echo '<p class="success">' . $_GET['update'] . '</p>';
                }
                ?>
                <table>
                    <tr>
                        <td>Video Id</td>
                        <td><input type="text" name="video_id"></td>
                    </tr>
                    <tr>
                        <td>New video title</td>
                        <td><input type="text" name="title"></td>
                    </tr>
                    <tr>
                        <td>New filepath</td>
                        <td><input type="text" name="filepath"></td>
                    </tr>
                </table>
                <button type="submit" name="update" class="update">Update</button><br><br>
            </form>
        </div>
    </section>

</body>

</html>