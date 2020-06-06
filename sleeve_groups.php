<?php
// include_once("login_session.php");
include_once('directory.php');
include_once("sleeve_empty.php");
// List sleeve groups


if(session_status() != PHP_SESSION_NONE && $_SESSION["loggedIn"] && isset($_POST['sleevegroup'])) {
	get_sleeves_from_group($_POST['sleevegroup'], $_POST['sleevenb'], $_POST['sleeveqty']);
}

function sleeve_groups() {

	$db = new PDO('sqlite:' . dir_path() . '/data/games_db.sqlite');
  $groups = $db->query("SELECT * FROM SleeveGroupName" );
  ?>
	<div class="row">
		<div class="table-cell"><input type="number" name="sleevenb" value="0" step="1" id="sleeve_nb"></div>
		<div class="table-cell"><input type="number" name="sleeveqty" value="0" step="1" id="sleeve_qty"></div>
		<div class="table-cell">
			<select name="sleevegroup" id="sleeve_group">
			<?php
			foreach($groups as $group) {
				?>
			  <option value="<?php echo $group['Id']; ?>"><?php echo $group['Name']; ?></option>
			<?php
			}
			?>		
			</select>
		</div>
		<div class="table-cell"><button type="submit" class="submit" id="add_sleeve_groups_btn">Add Sleeves</button></div>
	</div>
	<?php
}

function get_sleeves_from_group($group_id, $nb, $qty) {

	$db = new PDO('sqlite:' . dir_path() . '/data/games_db.sqlite');
  $group = $db->query("SELECT SleeveGroups.SleeveId, SleeveCompany.Name, Sleeve.SleeveName FROM SleeveGroups INNER JOIN Sleeve ON SleeveGroups.SleeveId = Sleeve.Id INNER JOIN SleeveCompany ON SleeveCompany.Id = Sleeve.CompanyID WHERE GroupId = " . $group_id);

	$rows = array();
	foreach($group as $sleeve) {
		?>

		<div class="row">
			<div class="table-cell"><input type="number" name="nb[]" value="<?php echo $nb; ?>" step="1"></div>
			<div class="table-cell"><input type="number" name="quantity[]" value="<?php echo $qty; ?>" step="1"></div>
			<div class="table-cell"><?php sleeve_list($sleeve['SleeveId']); ?></div>
			<div class="table-cell"><span class="remove" data-sleeve_id="NULL">-</span></div>
		</div>
		<?php
	}
	?>
	<div class="row">
		<div class="table-cell"><input type="number" name="nb[]" value="0" step="1"></div>
		<div class="table-cell"><input type="number" name="quantity[]" value="0" step="1"></div>
		<div class="table-cell"><?php sleeve_list(); ?></div>
		<div class="table-cell"><span class="add">+</span></div>
	</div>

	<?php
}