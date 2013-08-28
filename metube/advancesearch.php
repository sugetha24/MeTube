 <form class="search-form" action="advancesearch2.php" method="get" name="searchForm"> 
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Search</title>
<link rel="stylesheet" type="text/css" href="css/default.css" />
<link rel="stylesheet" type="text/css" href="style.css" media="screen" />
<?php session_start(); ?>


</head>

<body>
<div id="wrapper">



<?php include('header.php'); ?>
<?php include('nav.php'); ?>
<?php include('navindex.php'); ?>

<div id="content">


<tr>
            <td >
            	<div ><strong> Advanced Search </strong></div>
	         	<br />
                <table>
               	  <tbody>
                        	<tr>
                            	
                                <td > 
                                <input type="TEXT" name="search_query" onClick="this.value='';this.onclick=null;"  value="Enter your search item " size="40" maxlength="128" align="center"/>
                 				</td>
                            </tr>
                  
                  
        	<td id="td"><label>Category:</label>
            </td>
       
            <td id="td">
            <select name="category"> 
           					 <option value="Nature">Nature</option> 
<option value="Sports" >Sports </option> 
<option value="Music" >Music</option> 
<option value="Education" >Education</option>
 <option value="Animals" >Animals</option>
<option value="Arts" >Arts</option> 
<option value="Fashion" >Fashion</option> 
<option value="People" >People</option> 
<option value="News" >News</option>
<option value="Science and tech" >Science and Technology</option> 
<option value="Travel" >Travel</option> 
<option value="Fitness" >Fitness</option> 
<option value="Entertainment" >Entertainment</option>
<option value="Other" >Other</option>
			</select>
            </td>
        
        	<td id="td"><label>Media Type:</label>
            </td>
        
            <td id="td">
            <select name="type"> 
					<option value="0" selected>All</option> 
                    <option value="1">Audio</option> 
                    <option value="2">Picture</option> 
                    <option value="3">Video</option> 
			</select>
            </td>
        </tr> 
			<tr> 
			  <td>&nbsp;</td> 
			  <td>&nbsp;</td> 
			  </tr>
            <tr> 
				<td colspan="4" align="center"> 
	 <span class="masthead-button-wrapper"><a href="#"
onclick="document.searchForm.submit(); return false;">				
  <input type="submit" name="searchbutton" value="Search" />
  				</td> 
			</tr> 
			<tr> 
				<td>&nbsp;</td> 
				<td>&nbsp;</td> 
			</tr> 
            </tbody>
		</table> 
	    </td>
   
    </tr>
    </table>
 </form>
 

</div> <!-- end #content -->


<?php// include('sidebar.php'); ?>


<?php include('footer.php'); ?> 			

</div> <!-- End #wrapper -->
	
</body>
</html>


  
