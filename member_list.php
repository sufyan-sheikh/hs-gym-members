<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/semantic-ui/2.4.1/components/form.min.css">
<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/semantic-ui/2.4.1/components/table.min.css">
<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/semantic-ui/2.4.1/components/button.min.css">


<?php
global $wpdb;
if(isset($_POST["delete"])){
	$id = $_POST["id"];
	$wpdb->delete( 'hs_gym', array( 'id' => $id ) );
}
if(isset($_POST["edit"])){
	$id = $_POST["id"];
	$row = $wpdb->get_row("SELECT * FROM hs_gym WHERE id = $id",ARRAY_A);
	echo '
	<h1>Edit Member</h1>
	<form action="" method="POST">
	<input type="hidden" name="id" value="'.$_POST["id"].'">
	<table class="">
		<tr>
			<td>Name:</td>
			<td><input type="text" name="user_name" value="'.$row["user_name"].'" autofocus></td>
		</tr>
		<tr>
			<td>Gender:</td>
			<td>
				<select name="gender" id="gender">
					<option value="Male">Male</option>
					<option value="Female">Female</option>
					<option value="Other">Other</option>
				</select>
			</td>
		</tr>
		<tr>
			<td>Phone:</td>
			<td><input type="text" name="phone" value="'.$row["phone"].'" maxlength="10"></td>
		</tr>
		<tr>
			<td>Email:</td>
			<td><input type="email" name="email" value="'.$row["email"].'"></td>
		</tr>
		<tr>
			<td>Start date</td>
			<td><input type="date" name="start_date" value="'.$row["start_date"].'"></td>
		</tr>
		<tr>
			<td>End date</td>
			<td><input type="date" name="end_date" value="'.$row["end_date"].'"></td>
		</tr>
		<tr>
			<td>Time slot</td>
			<td>
				<select name="slot" id="slot">
					<option value="Morning">Morning</option>
					<option value="Evening">Evening</option>
				</select>
			</td>
		</tr>
		<tr>
			<td>Trainee</td>
			<td><input name="trainee" value="'.$row["trainee"].'"></td>
		</tr>
		<tr>
			<td>Fees</td>
			<td><input name="fees" value="'.$row["fees"].'"></td>
		</tr>
		<tr>
			<td>Trainee</td>
			<td>
				<select name="status" id="status">
					<option value="Active">Active</option>
					<option value="Expired">Expired</option>
				</select>
			</td>
		</tr>
		<tr>
			<td></td>
			<td><input type="submit" name="save" value="Save"
						class="ui blue mini button"></td>
		</tr>
	</table>
</form>
<script type="text/javascript">
	document.getElementById("slot").value = "'.$row["slot"].'";
	document.getElementById("gender").value = "'.$row["gender"].'";
	document.getElementById("status").value = "'.$row["status"].'";
</script>';
}
if(isset($_POST["save"])){
	$wpdb->update('hs_gym',
		array( 
			'user_name'   => $_POST["user_name"],
			'phone'       => $_POST["phone"],
			'gender'	  => $_POST["gender"],
			'email'   	  => $_POST["email"],
			'start_date'  => $_POST["start_date"],
			'end_date'    => $_POST["end_date"],
			'slot'   	  => $_POST["slot"],
			'status'   	  => $_POST["status"],
			'trainee'     => $_POST["trainee"],
			'fees'   	  => $_POST["fees"]
		),array('id' => $_POST["id"]));
}
$rows = $wpdb->get_results("SELECT * FROM hs_gym");

?>
<h1>List of members:</h1>
	<table class="ui striped table">
		<thead>
		<tr>
			<th> User Name  </th>
			<th> Gender     </th>
			<th> Phone      </th>
			<th> Email      </th>
			<th> Start date </th>
			<th> End date   </th>
			<th> Fees       </th>
			<th> Status     </th>
			<th> Trainee    </th>
			<th> Slot       </th>
			<th> Edit		</th>
			<th> Delete		</th>
		</thead>
	   </tr>
<?php
if(count($rows) == 0){
	echo '<tr>
		<td colspan="10"><h3>No members found. <a href="/wp-admin/admin.php?page=hs_gym_member_add">Add New Member</a>.</h3></td>
	</tr>';
}
foreach ( $rows as $row ){
 echo '
		<tr>
			<td>    '.$row->user_name.'     </td>
			<td>    '.$row->gender.'        </td>
			<td>    '.$row->phone.'		    </td>
			<td>    '.$row->email.'	    	</td>
			<td>    '.$row->start_date.'    </td>
			<td>    '.$row->end_date.'      </td>
			<td>    '.$row->fees.'		    </td>
			<td>    '.$row->status.'	    </td>
			<td>    '.$row->trainee.'	    </td>
			<td>    '.$row->slot.'	        </td>
			<td>
				<form method="POST">
					<input type="hidden" name="id" value="'.$row->id.'">
					<input type="submit" name="edit" value="Edit" class="ui blue mini button">
				</form>
			</td>
			<td>
				<form method="POST">
				<input type="hidden" name="id" value="'.$row->id.'">
				<input type="submit" name="delete" value="Delete" class="ui red mini button">
				</form>
			</td>
		</tr>';
}
?>
</table>