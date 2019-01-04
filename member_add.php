<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/semantic-ui/2.4.1/components/form.min.css">
<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/semantic-ui/2.4.1/components/table.min.css">
<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/semantic-ui/2.4.1/components/button.min.css">


<?php
global $wpdb;
if(isset($_POST["add"])){
$result = $wpdb->insert( 
	'hs_gym', 
	array( 
		'user_name'   => $_POST["user_name"],
		'phone'       => $_POST["phone"],
		'gender'	  => $_POST["gender"],
		'email'   	  => $_POST["email"],
		'start_date'  => $_POST["start_date"],
		'end_date'    => $_POST["end_date"],
		'slot'   	  => $_POST["slot"]
		)
		);
}
?>

<h1>Add New Member</h1>
<form action="" method="POST">
	<table class="ui striped table">
		<tr>
			<td>Name:</td>
			<td><input type="text" name="user_name" autofocus></td>
		</tr>
		<tr>
			<td>Gender:</td>
			<td>
				<select name="gender">
					<option value="Male">Male</option>
					<option value="Female">Female</option>
					<option value="Other">Other</option>
				</select>
			</td>
		</tr>
		<tr>
			<td>Phone:</td>
			<td><input type="text" name="phone" maxlength="10"></td>
		</tr>
		<tr>
			<td>Email:</td>
			<td><input type="email" name="email"></td>
		</tr>
		<tr>
			<td>Start date</td>
			<td><input type="date" name="start_date"></td>
		</tr>
		<tr>
			<td>End date</td>
			<td><input type="date" name="end_date"></td>
		</tr>
		<tr>
			<td>Time slot</td>
			<td>
				<select name="slot">
					<option value="Morning">Morning</option>
					<option value="Evening">Evening</option>
				</select>
			</td>
		</tr>
		<tr>
			<td></td>
			<td><input type="submit" name="add" value="Add"
						class="ui blue mini button"></td>
		</tr>

	</table>
</form>
<?php
if($result){
	echo '<h1 style="color:green;">"'.$_POST["user_name"].'" - member added successfully.<h1>';
}
?>