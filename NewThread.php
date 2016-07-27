<!DOCTYPE html>
<html>
<head>
	<title> Theseus & Minotaur Social Site - New Thread</title>
	<link rel="shortcut icon" href="bull.ico">
	<link rel="stylesheet" href="MinotaurStyle.css">
</head>
<body>
	<div id="content">
		<h1>Theseus and Minotaur</h1>
		<h3>Create a New Thread</h3>
		<div class="form">
			<form name="htmlform" method="POST" enctype="multipart/form-data" action="NewThreadResult.php">
			<input  type="hidden" name="Board" value="<?php echo $_POST['Board']?>" />
			<table width="450px">
			</tr>
			<tr>
			 <td valign="top">
			  <label for="Subject">Subject</label>
			 </td>
			 <td valign="top">
			  <input  type="text" name="Subject" maxlength="50" size="30">
			 </td>
			</tr>
			 
			<tr>
			 <td valign="top"">
			  <label for="Name">Name</label>
			 </td>
			 <td valign="top">
			  <input  type="text" name="Name" maxlength="50" size="30">
			 </td>
			</tr>

			<tr>
			 <td valign="top">
			  <label for="Image">Image* (Max Size: 10MB)</label>
			 </td>
			 <td valign="top">
			     <input type="file" name="Image" accept="image/*">
			 </td>
			</tr>
			<tr>
			 <td valign="top">
			  <label for="Message">Message*</label>
			 </td>
			 <td valign="top">
			  <textarea  name="Message" maxlength="1000" cols="25" rows="6"></textarea>
			 </td>
			 
			 
			</tr>
			<tr>
			 <td colspan="2" style="text-align:center">
			  <input type="submit" value="Submit"> 
			  *You must have both to be able to post
			 </td>
			</tr>
			</table>
			</form>
		</div> 
	</div> 
</body>
</html>
