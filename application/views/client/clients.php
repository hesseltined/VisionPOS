     	<table  border="1" style="header">
		<tr font weight="bold">
 	        	<TD colspan="2">Name</TD>
 	        	<TD colspan="4">Address</TD>
 	        	<TD>Type</TD>
 	        	<TD>Last Recall</TD>
 	        	<TD>Last Exam</TD>
 	        	<TD colspan="3">Phone Numbers</TD>
 	        	<TD>Email</TD>
 	        </TR>
 	        <?php foreach($query as $row):?>
     		<tr>
     		         <td><?=$row->FirstName?></TD>
     		         <td><?=$row->LastName?></TD>
     		         <td><?=$row->Address?></TD>
     		         <td><?=$row->Address2?></TD>
     		         <td><?=$row->City?>, <?=$row->State?>  <?=$row->Zip?></TD>
  		         <td><?=$row->Email?></TD>
  		         <td><?=$row->Type?></TD>
  		         <td><?=$row->LastRecall?></TD>
  		         <td><?=$row->LastExam?></TD>
  		         <td><? echo format_phone_number($row->Phone);?></TD>
  		         <td><?=$row->Phone2?></TD>
  		         <td><?=$row->Phone3?></TD>
  		         <td><?=$row->Email?></TD>
 		</TR>
         	<?php endforeach;?>  
         </table>