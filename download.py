import sys
import subprocess

# Check if the user provided a YouTube video URL as an argument
if len(sys.argv) != 2:
    print("Usage: python download.py <YouTube_URL>")
    sys.exit(1)

# Get the YouTube video URL from the command line argument
video_url = sys.argv[1]

# Define the download directory
download_directory = '/srv/http/projectWeb/downloads'  # Replace with the actual path to your downloads directory

# Construct the youtube-dl command to download the video
command = [
    "yt-dlp",
    "-o",
    download_directory + "/%(title)s.%(ext)s",
    video_url,
]

# Execute the youtube-dl command
try:
    subprocess.run(command, check=True)
    print("Video downloaded successfully.")
except subprocess.CalledProcessError as e:
    print(f"Error downloading video: {e}")

