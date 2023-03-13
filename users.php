<!DOCTYPE html>
<html>

<head>
    <title>Users</title>
</head>

<body>
    <h2>Registered Users</h2>
    <table border="1">
        <tr>
            <th>Name</th>
            <th>Email</th>
            <th>Profile Picture</th>
        </tr>
        <?php
		// Read user data from CSV file and display in table
		$file = fopen('users.csv', 'r');
		while (($data = fgetcsv($file)) !== false) {
		    echo "<tr>";
		    foreach ($data as $value) {
		        echo "<td>" . $value . "</td>";
		    }
		    echo "</tr>";
		}
		fclose($file);
		?>
    </table>
</body>

</html>