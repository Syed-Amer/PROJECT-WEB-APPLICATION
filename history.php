<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>History</title>
    <link rel="stylesheet" href="css/history.css">
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
                        <th>Title</th>
                        <th>Download Format</th>
                        <th>Download</th>
                        <th>Delete</th>
                    </tr>
                    <?php
                    fetchDownloaded($conn, $id);
                    ?>
                </table>
                <button type="submit" name="delete">Delete</button>
            </form>
        </div>
    </section>

</body>

</html>