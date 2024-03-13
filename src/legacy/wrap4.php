<?php

ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL);

function debug($message) {
  echo "<div class=debug>$message</div>";
}

require 'vendor/autoload.php';

$ffmpeg = FFMpeg\FFMpeg::create();

$video = $ffmpeg->open('video.mpg');
$video
    ->filters()
    ->resize(new FFMpeg\Coordinate\Dimension(640, 480))
    ->synchronize();
debug("generate thumbnail");
$video
    ->frame(FFMpeg\Coordinate\TimeCode::fromSeconds(10))
    ->save('frame.jpg');
echo "<img src=frame.jpg>";
// debug("converting to mp4");
// $video->save(new FFMpeg\Format\Video\X264(), 'export-x264.mp4');
// debug("converting to wmv");
// $video->save(new FFMpeg\Format\Video\WMV(), 'export-wmv.wmv');
// debug("converting to webm");
// $video->save(new FFMpeg\Format\Video\WebM(), 'export-webm.webm');
?>
<video controls>
  <source src='export-x264.mp4' type=video/mp4>
  <source src='export-wmv.wmv' type=video/wmv>
  <source src='export-webm.webm' type=video/webm>
</video>
