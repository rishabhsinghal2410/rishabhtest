<?

$contains = strpos("http://www.amazon.in/gp/product/B00VM9HX1C", "?");

if ($contains === false) {
  echo "Text missing"; 
} else {
  echo "Text Present at index - " . $contains; 
}

?>