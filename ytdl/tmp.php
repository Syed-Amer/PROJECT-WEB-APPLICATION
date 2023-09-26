<?php
    session_start();
    $username = $_SESSION['uname'];

        // Get the user input (video link) from the form
        $videoLink = $_POST['video_link'];
        if(isset($_POST['video_format'])) {
            $video_format = $_POST['video_format'];
        }
        else {
            echo "not selected ";
        }
        $video_format = $_POST['$video_format'];
        echo "$videoLink";
        echo "$video_format";
        echo "asd<br>";


        // get video title
        $title = exec("yt-dlp --print \"%(title)s\" -I 1 \"$videoLink\"");
        $encodedFileName = rawurlencode("$title"); // Encode the file name
        $filePath = "/projectWeb/downloads" . $encodedFileName; // Construct the file path

        // Validate the input (you can add more thorough validation)
        if (filter_var($videoLink, FILTER_VALIDATE_URL)) {

            // if user choose mp3
            if ($video_format == "mp3") {
                exec("yt-dlp -f bestaudio --extract-audio --audio-format mp3 -o \"../srv/http/projectWeb/$title\" -I 1 --add-metadata --embed-thumbnail \"$videoLink\" 2>&1", $output, $returnCode);
                $ilePath = "ad";
            } elseif ($video_format == "mp4") {
                exec("yt-dlp -f \"bestvideo[height<=1080][ext=mp4]+bestaudio[ext=m4a]/best[height<=1080][ext=mp4]/best[height<=1080]\" --add-metadata --embed-thumbnail -o \"downloads/$title\" -I 1 \"$videoLink\" 2>&1", $output, $returnCode);
                echo "$title";
                echo '<a href="' . "$filePath.mp4" . '" download="' . $title . '">Download File</a>';
            }

            if ($returnCode == 0) {
                echo "Video downloaded successfully";
                echo "$title";
                echo '<a href="' . "$filePath/$title.mp3" . '" download="' . $title . '">Download File</a>';
            } else {
                echo "Error download<br>";
                echo "$title<br>";
                foreach ($output as $line) {
                    echo $line . "<br>";
                }
            }
        } else {
            print("$video_format");
            echo "<br>Invalid video link. Please enter a valid URL.<br>";
            echo "$username";
        }
