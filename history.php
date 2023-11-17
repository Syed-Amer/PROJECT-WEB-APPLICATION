<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>History</title>
    <link rel="stylesheet" href="css/historyAdmin.css">
    <link rel="stylesheet" href="css/header.css">
</head>

<body>
    <?php
    session_start();
    $id = $_SESSION['user_id'];
    include_once 'header.php';
    include_once 'includes/functions.inc.php';
    include_once 'includes/db.inc.php';
    ?>
    <section class="table-section">
        <div>
            <form action="includes/deleteDownloaded.inc.php" method="post">
                <table class="table-history">
                    <tr>
                        <td align="center">Id</td>
                        <td align="center">Title</td>
                        <td align="center">Download Format</td>
                        <td align="center">Download</td>
                        <td align="center">Delete</td>
                    </tr>
                    <?php
                    fetchDownloaded($conn, $id);
                    ?>
                </table>
                <button type="submit" name="delete" class="delete">Delete</button>
            </form>
            </form>
            <form action="includes/alterData.inc.php" method="post">
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
                </table>
                <button type="submit" name="update" class="update">Update</button>
            </form>
        </div>
    </section>

</body>

</html>