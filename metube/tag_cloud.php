<?php


$terms = array(); // create empty array
$maximum = 0; // $maximum is the highest counter for a search term
$a = "SELECT tags, count FROM tag_count ORDER BY count DESC LIMIT 30";
$query = mysql_query($a) or die(mysql_error());
 
while ($row = mysql_fetch_array($query))
{
    $tags = $row['tags'];
    $count = $row['count'];
 
    // update $maximum if this term is more popular than the previous terms
    if ($count > $maximum) $maximum = $count;
 
    $terms[] = array('tags' => $tags, 'count' => $count);
 
}
 
// shuffle terms unless you want to retain the order of highest to lowest
shuffle($terms);

?>
<div id="sidebar">
<div id="tagcloud">
<?php 
// start looping through the tags
foreach ($terms as $term):
 // determine the popularity of this term as a percentage
 $percent = floor(($term['count'] / $maximum) * 100);
 //echo $percent;
 //echo $maximum;
 
 // determine the class for this term based on the percentage
 if ($percent < 20): 
   $class = 'smallest'; 
 elseif ($percent >= 20 and $percent < 40):
   $class = 'small'; 
 elseif ($percent >= 40 and $percent < 60):
   $class = 'medium';
 elseif ($percent >= 60 and $percent < 80):
   $class = 'large';
 else:
 $class = 'largest';
 endif;
?>
<span class="<?php echo $class; ?>">
  <a href="search2.php?search_query=<?php echo $term['tags']; ?>"><?php echo $term['tags']; ?></a>
</span>
<?php endforeach; ?>
</div>
</div>