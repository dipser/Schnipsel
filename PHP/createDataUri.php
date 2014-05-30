<?php

/**
 * Create data uri’s
 *
 * Data uri’s can be useful for embedding images into HTML/CSS/JS to save on HTTP requests, at the cost of maintainability. You can use online tools to create data uri’s, or you can use the simple PHP function below:
 */
function dataUri($file, $mime) {
  $contents = file_get_contents($file);
  $base64 = base64_encode($contents);
  return "data:$mime;base64,$base64";
}

?>
