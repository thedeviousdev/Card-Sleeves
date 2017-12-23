<?php
$file = 'data/game-list.sqlite';

if (!file_exists($file)) {
	try {
	  $db = new PDO('sqlite:data/game-list.sqlite');
	  $db->exec("CREATE TABLE Game (Id INTEGER PRIMARY KEY, Name TEXT, Edition TEXT, CardNumber TEXT, Width INTEGER, Height INTEGER)");    
		if (($handle = fopen("data/Sleeves.csv", "r")) !== FALSE) {
		    while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
	        $num = count($data);

	        $name = $data[0];
	        $edition = NULL;
	        $card_number = $data[1];
	        $width = $data[2];
	        $height = $data[3];

			    $db->exec("INSERT INTO Game (Name, Edition, CardNumber, Width, Height) VALUES ('" . $name . "', '" . $edition . "', '" . $card_number . "', '" . $width . "', '" . $height . "');");

		    }
		    fclose($handle);
		}

	  $db = NULL;
	}
	catch(PDOException $e)
	{
	  print 'Exception : '.$e->getMessage();
	}
}
else {
	  $db = new PDO('sqlite:data/game-list.sqlite');

	  print "<table border=1>";
	  print "<tr><td>Id</td><td>Name</td><td>Edition</td><td>CardNumber</td><td>Width</td><td>Height</td></tr>";
	  $result = $db->query('SELECT * FROM Game');

	  foreach($result as $row) {
	    print "<tr><td>".$row['Id']."</td>";
	    print "<td>".$row['Name']."</td>";
	    print "<td>".$row['Edition']."</td>";
	    print "<td>".$row['CardNumber']."</td>";
	    print "<td>".$row['Width']."</td>";
	    print "<td>".$row['Height']."</td></tr>";
	  }
	  print "</table>";
}

?>