<?php
// include_once("login_session.php");
// Blank rows for form


if($_SESSION["loggedIn"] && isset($_POST['sleeve_list'])) {
	sleeve_list_dropdown();
}

function sleeve_list($selected_id = NULL) {

	$db = new PDO('sqlite:data/games_db.sqlite');
  $sleeves = $db->query("SELECT Sleeve.Id, Sleeve.CompanyID, Sleeve.SleeveName, SleeveCompany.Name
		FROM Sleeve
		INNER JOIN SleeveCompany ON Sleeve.CompanyID = SleeveCompany.Id" );

  ?>						
	<select name="sleeve[]">
	<?php
	foreach($sleeves as $sleeve) {
		?>
	  <option value="<?php echo $sleeve['Id']; ?>" <?php if($sleeve['Id'] === $selected_id) echo 'selected="selected"'; ?>><?php echo $sleeve['Name'] . ' - ' . $sleeve['SleeveName'] ?></option>
	<?php
	}
	?>		
	</select>
	<?php
}

function sleeve_list_dropdown() {
?>
	<div class="row">
		<div class="table-cell"><input type="number" name="nb[]" value="0" step="1"></div>
		<div class="table-cell"><input type="number" name="quantity[]" value="0" step="1"></div>
		<div class="table-cell"><?php sleeve_list(); ?></div>
		<div class="table-cell"><span class="add">+</span></div>
	</div>

<?php
}