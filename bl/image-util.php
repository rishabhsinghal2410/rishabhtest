<?

//createThumbnail("../images/1446376822_image.jpeg", "../images/thumbnail/tmbnail_2.jpg", 272, "image/jpeg");

/**
 * Create thumnail from an actual image. Provide hieght and it maintains the aspect ratio automatically.
 */
function createThumbnail($src, $dest, $desiredWidth, $format) {
    /* read the source image */
    $sourceImage = null;
    if($format == 'image/jpeg') {
        $sourceImage = imagecreatefromjpeg($src);
    } else if($format == 'image/png') {
        $sourceImage = imagecreatefrompng($src);
    }

    $width = imagesx($sourceImage);
    $height = imagesy($sourceImage);

    /* find the "desired height" of this thumbnail, relative to the desired width  */
    $desiredHeight = floor($height * ($desiredWidth / $width));

    /* create a new, "virtual" image */
    $virtualImage = imagecreatetruecolor($desiredWidth, $desiredHeight);

    imageAlphaBlending($virtualImage, false);
    imageSaveAlpha($virtualImage, true);

    /* copy source image at a resized size */
    imagecopyresampled($virtualImage, $sourceImage, 0, 0, 0, 0, $desiredWidth, $desiredHeight, $width, $height);

    /* create the physical thumbnail image to its destination */
    if($format == 'image/jpeg') {
        imagejpeg($virtualImage, $dest);
    } else if($format == 'image/png') {
        imagepng($virtualImage, $dest);
    }
}

?>
