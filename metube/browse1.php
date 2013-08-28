
<br/><br/>

<?php
include_once "functions.php";
        if(isset($_GET['category']))
        {
            $cate= $_GET['category'];
             $query = "SELECT * from media  where visibility='1' AND category='".$cate."' ORDER BY RAND() LIMIT 10;";
            }
        else {
 $query="select * from media where visibility='1' ORDER BY RAND() LIMIT 10;";
        }

    
    $result = mysql_query( $query );
    if (!$result)
    {
       die ("Could not query the media table in the database: <br />". mysql_error());
    }
?>
    
    <div style="background:#339900;color:#FFFFFF; width:150px;">Uploaded Media</div>
    
    <table width="50%" cellpadding="0" cellspacing="0">
        <?php
            while ($result_row = mysql_fetch_row($result))
            { 
        ?>
        <tr valign="top">           
            <td>
                    <?php 
                        echo $result_row[0];
                    ?>
            </td>
            <td>
                <a href="media.php?id=<?php echo $result_row[0];?>" target="_blank"><?php echo $result_row[1];?></a> stored in <?php echo $result_row[3].$result_row[1];?>
            </td>
            <td>
                <a href="<?php echo $result_row[3].$result_row[1];?>" onclick="Download()">Download</a>
            </td>
        </tr>
        <?php
            }
        ?>
    </table>
    <h2>Categories</h2>
        <?php
    $catquery="select distinct category from media ORDER BY category ASC";
    $catresult = mysql_query($catquery) ; 
    if(!$catresult)
    {die('errrrrrrr'.mysql_error());
    }
    ?>
    <table>
<?php 
while($crow = mysql_fetch_array($catresult))
{
    $category=$crow['category'];
    ?>
    <tr>
    <td><a href="browse.php?category=<?php echo $category; ?>"><?php echo $category; ?></td></tr>
<?php } ?>
</table>
<br>
<br>

<a href='friend.php'  style="color:#FF9900;">Members Area</a>
</div> <!-- end #content -->


