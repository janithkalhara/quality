<?php 
defined("HEXEC") or die("Restrited Access.");
?>
<?php 
global $mainframe;
$mainframe->setTitle("Help ");

if(isset($_GET['app'])){
	$app=$_GET['app'];
	
	if($app="pdf"){
		
		showDoc();
	}
}else{



?>

<b><h4>Data insertion process</h4></b>


<p>When you are logged in to the system using relevent user name and password, 
system would be displaying the main menu at the top. Select the 'Data Insertion' t
ab and it would drop down a pop up menu. Select 'Stock data insertion' from the pop up menu.</p>


<p>Once Stock data insertion is selected, system displays the workbook which consists four worksheets.</p>


<p>Firstly you need to fill the data feilds given in the header of the form with date, project, 
VehicleNo etc. When enetering the center, system automatically dispalys the relevent center names 
for the selected project as suggessions. You would not be able to enter any of new center names 
for a project other than those are given in the sugessions.</p>


<p>The grade which the stock  beleongs to can be given at the small tab appearing at the right corner.
 Further the subcategories of the grades can be selected by clilcking on the four buttons appearing front of the grade tab.</p>


<p.
>Adding details of the sample fruits is same as filling the data in to the hardcopy of the stock data insertion form. 
But when the details related to  chosen samples are entered system auotmatically showes the sum and the percentages.
</p>

<p>Then user need to fill the data feilds respectively with number of crates, noted weight and  true weight.</p>


<p>Once all the data feilds are filled system displays the sum and the percentages of defected grade, defects and payble quantity.</p>

<?php 
}

function showDoc(){

//print "<object type='application/pdf' data='files/sys_doc_hayleys.pdf' ' width='90%' height='90%' < /object >";

	print "<div id='wrapper-pdf' style='height:800px'>";
	print "<a href='files/sys_doc_hayleys.pdf' style='color:#3B5998;font-size:14px; font-weight:bold;'>Download a copy</a>";
	print "<EMBED src='files/sys_doc_hayleys.pdf' width='100%' height='100%'></EMBED>";
	print "</div>";
}


?>
 