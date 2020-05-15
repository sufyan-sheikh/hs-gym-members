<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/semantic-ui/2.4.1/semantic.css">
<script type="text/javascript" src="https://code.jquery.com/jquery-3.4.1.js"></script>
<script type="text/javascript" src="https://semantic-ui.com/javascript/library/tablesort.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/semantic-ui/2.4.1/components/dropdown.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/semantic-ui/2.4.1/components/transition.js"></script>
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/dt/jszip-2.5.0/dt-1.10.20/b-1.6.1/b-colvis-1.6.1/b-flash-1.6.1/b-html5-1.6.1/b-print-1.6.1/cr-1.5.2/sp-1.0.1/datatables.min.css"/>
 
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/pdfmake.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/vfs_fonts.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/v/dt/jszip-2.5.0/dt-1.10.20/b-1.6.1/b-colvis-1.6.1/b-flash-1.6.1/b-html5-1.6.1/b-print-1.6.1/cr-1.5.2/sp-1.0.1/datatables.min.js"></script>

<?php
if(is_admin()) {
    echo '<div style="padding-top: 20px; padding-right: 20px">';
}
$table_name = 'gym_member';
global $wpdb;
if (isset($_FILES["import"])) {
    if (pathinfo($_FILES["import"]["name"],PATHINFO_EXTENSION)==="csv") {
        $targetPath = dirname(__FILE__)."/" .rand(11,99). $_FILES["import"]["name"];
        move_uploaded_file($_FILES["import"]["tmp_name"], $targetPath);
        $handle = fopen($targetPath, "r");
        $imported = 0; $failed = 0;
        while(($filesop = fgetcsv($handle, 1000, ",")) !== false) {
            if (!$col) {
                for ($i=0; $i < count($filesop); $i++) { 
                    $col[$i] = $filesop[$i];
                }
            } else {
                for ($i=0; $i < count($filesop); $i++) { 
                    $data[$col[$i]] = sanitize_text_field($filesop[$i]);
                }
                $wpdb->insert($table_name,$data);
                if ($wpdb->insert_id) {
                    $imported++;
                } else {
                    $failed++;
                }
            }
        }
        echo $imported." rows imported. ".$failed." rows failed.";
        fclose($handle);
        unlink($targetPath);
    } else {
        $message = "Invalid File Type. Upload Excel File.";
        echo $message;
    }
}
if($_POST["action"]){
    $data["gym_member"] = $_POST["gym_member"];
    $data["gender"] = $_POST["gender"];
    $data["phone"] = $_POST["phone"];
    $data["email"] = $_POST["email"];
    $data["start_date"] = $_POST["start_date"];
    $data["end_date"] = $_POST["end_date"];
    $data["fees"] = $_POST["fees"];
    $data["slot"] = $_POST["slot"];
    $data["trainee"] = $_POST["trainee"];
    $data["status"] = $_POST["status"];
    if($_POST["action"]=='Add'){
        $wpdb->insert($table_name,$data);
    } else if($_POST["action"]=='Add New' || $_POST["action"]=='Edit'){
    $columns = rawurlencode('"gym_member","gender","phone","email","start_date","end_date","fees","slot","trainee","status"');
    ?>
    <h2>Import from CSV (excel)</h2>
    <form method="POST" enctype="multipart/form-data">
        <input type="file" name="import">
        <input type="submit" name="import_csv" value="Import (csv)" class="ui grey button">
        <a href="data:text/plain;charset=UTF-8,<?php echo $columns; ?>" download="filename.csv">Download Sample CSV</a>
    </form>
    <hr>
    <form method="POST" enctype="multipart/form-data">
        <h2 id="small_frm">Add New Here</h2>
        <input type="hidden" name="id">
        <table class="ui blue striped table collapsing">
        <tr>
            <td>Gym Member</td>
            <td><input type="text" name="gym_member">
            </td>
        </tr>
        <tr>
        <td>Gender</td>
        <td><select class="ui search dropdown" name="gender">
                <option value="">Select</option>
                <option value="Male">Male</option>
                <option value="Female">Female</option>
                <option value="Others">Others</option>
            </select>
            <script type="text/javascript">
                $(".ui.dropdown").dropdown();
            </script>
        </td>
        </tr>
        <tr>
            <td>Phone</td>
            <td><input type="text" name="phone">
            </td>
        </tr>
        <tr>
            <td>Email</td>
            <td><input type="text" name="email">
            </td>
        </tr>
        <tr>
            <td>Start Date</td>
            <td><input type="date" name="start_date">
            </td>
        </tr>
        <tr>
            <td>End Date</td>
            <td><input type="date" name="end_date">
            </td>
        </tr>
        <tr>
            <td>Fees</td>
            <td><input type="text" name="fees">
            </td>
        </tr>
        <tr>
        <td>Slot</td>
        <td><select class="ui search dropdown" name="slot">
                <option value="">Select</option>
                <option value="Morning">Morning</option>
                <option value="Evening">Evening</option>
            </select>
            <script type="text/javascript">
                $(".ui.dropdown").dropdown();
            </script>
        </td>
        </tr>
        <tr>
            <td>Trainee</td>
            <td><input type="text" name="trainee">
            </td>
        </tr>
        <tr>
        <td>Status</td>
        <td><select class="ui search dropdown" name="status">
                <option value="">Select</option>
                <option value="Active">Active</option>
                <option value="Inactive">Inactive</option>
            </select>
            <script type="text/javascript">
                $(".ui.dropdown").dropdown();
            </script>
        </td>
        </tr>
            <tr row-id="">
                <td></td>
                <td><input type="submit" name="action" value="Add" class="ui blue mini button"></td>
            </tr>
        </table>
        </form>
        <style type="text/css">
            .ui.dropdown{
                width: 100% !important;
            }
        </style>
        <?php
    }
    if($_POST["action"]=='Edit'){
        $id = $_POST["id"];
        $row = $wpdb->get_row("SELECT * FROM $table_name WHERE id = $id",ARRAY_A);
        $data = $row;
        ?>
        <script type="text/javascript">
            $('input[name=action]').val('Save');
            $('input[name=id]').val('<?php echo $_POST["id"]; ?>');
            $('#small_frm').html('Edit Here');
        </script>
    <script type="text/javascript">
        $('input[name=gym_member]').val('<?php echo $data["gym_member"]; ?>');
        $('select[name=gender]').val('<?php echo $data["gender"]; ?>');
        x = $('select[name=gender]').children('option[value=<?php echo $data["gender"]; ?>]').text();
        $("select[name=user]").parent().children(".text").html(x);
        y = $('select[name=gender]').parent().children(".text");
        y.html(x);
        y.css("color","black");
        $('input[name=phone]').val('<?php echo $data["phone"]; ?>');
        $('input[name=email]').val('<?php echo $data["email"]; ?>');
        $('input[name=start_date]').val('<?php echo $data["start_date"]; ?>');
        $('input[name=end_date]').val('<?php echo $data["end_date"]; ?>');
        $('input[name=fees]').val('<?php echo $data["fees"]; ?>');
        $('select[name=slot]').val('<?php echo $data["slot"]; ?>');
        x = $('select[name=slot]').children('option[value=<?php echo $data["slot"]; ?>]').text();
        $("select[name=user]").parent().children(".text").html(x);
        y = $('select[name=slot]').parent().children(".text");
        y.html(x);
        y.css("color","black");
        $('input[name=trainee]').val('<?php echo $data["trainee"]; ?>');
        $('select[name=status]').val('<?php echo $data["status"]; ?>');
        x = $('select[name=status]').children('option[value=<?php echo $data["status"]; ?>]').text();
        $("select[name=user]").parent().children(".text").html(x);
        y = $('select[name=status]').parent().children(".text");
        y.html(x);
        y.css("color","black");
    </script>
        <?php
    }
    if($_POST["action"]=='Save'){
        $id = $_POST["id"];
        $wpdb->update($table_name,$data,array('id' => $id));
    }
    if($_POST["action"]=='Delete'){
        $id = $_POST["id"];
        $wpdb->delete($table_name,array('id' => $id));
    }
} 
if(($_POST["action"]!='Edit') && $_POST["action"]!='Add New') {
    ?>
    <form method="POST"><input type="submit" name="action" value="Add New" class="ui green mini button"></form><br>
    <div style="overflow-x:auto">
    <table id="myTable" class="ui unstackable celled table dataTable">
        <thead>
            <tr>
                <th>Gym Member</th>
                <th>Gender</th>
                <th>Phone</th>
                <th>Email</th>
                <th>Start Date</th>
                <th>End Date</th>
                <th>Fees</th>
                <th>Slot</th>
                <th>Trainee</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $rows = $wpdb->get_results("SELECT * FROM $table_name ORDER BY id DESC");
            foreach($rows as $row){
                echo '<tr>';
                echo '<td>'.$row->gym_member.'</td>';
                echo '<td>'.$row->gender.'</td>';
                echo '<td>'.$row->phone.'</td>';
                echo '<td>'.$row->email.'</td>';
                echo '<td>'.$row->start_date.'</td>';
                echo '<td>'.$row->end_date.'</td>';
                echo '<td>'.$row->fees.'</td>';
                echo '<td>'.$row->slot.'</td>';
                echo '<td>'.$row->trainee.'</td>';
                echo '<td>'.$row->status.'</td>';
                echo '</tr>';
            }
            ?>
        </tbody>
    </table>
    </div>
    <form method="post" id="action_form">
        <input type="hidden" name="id">
        <input type="hidden" name="action">
    </form>
    <script type="text/javascript">
        $(document).ready(function(){
            $("td:last-child").append('<i class="trash alternate red icon" onclick="delete_now(this)"></i> <i class="edit blue icon" onclick="edit_now(this)"></i>');
        });
        function edit_now(x){
            var id = $(x).parent().parent().attr("row-id");
            var frm = $("#action_form")
            frm.children("input[name=id]").val(id);
            frm.children("input[name=action]").val("Edit");
            frm.submit();
        }
        function delete_now(x){
            var id = $(x).parent().parent().attr("row-id");
            var frm = $("#action_form")
            frm.children("input[name=id]").val(id);
            frm.children("input[name=action]").val("Delete");
            if (confirm("Do you want to delete?")) {
            frm.submit();
            }
        }
    </script>
    <style type="text/css">
        .edit.icon, .trash.icon{
            float: right !important;
            font-size: 140%;
            cursor: pointer;
        }
    </style>
    <script type="text/javascript">
    $(document).ready(function() {
        $("#myTable").DataTable( {
            dom: "Blfrtip",
            buttons: [
                "csv", "excel", "pdf", "print"
            ]
        } );
    } );
    </script>
    <?php
}
if(is_admin()) {
    echo '</div>';
}