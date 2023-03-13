<?php
// Read user data from CSV file
$file = fopen('./uploads/users.csv', 'r');
$data = array();
while (($row = fgetcsv($file)) !== false) {
	$data[] = $row;
}
fclose($file);
?>

<!DOCTYPE html>
<html>

<head>
    <title>User List</title>
</head>

<body>
    <table>
        <tr>
            <th>Name</th>
            <th>Email</th>
            <th>Profile Picture</th>
        </tr>
        <?php foreach($data as $row): ?>
        <tr>
            <td><?= $row[0] ?></td>
            <td><?= $row[1] ?></td>
            <td><img src="<?= $row[2] ?>" width="100px"></td>
        </tr>
        <?php endforeach; ?>
    </table>
</body>

</html>