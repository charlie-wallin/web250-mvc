<?php
// src/Views/salamanders/index.php
//
// The View is responsible ONLY for displaying data as HTML.
// It receives the $salamanders variable from the controller.
// It should NOT talk directly to the database.
//
// We use htmlspecialchars() to prevent XSS (cross-site scripting) attacks,
// and nl2br() to keep line breaks in our text.
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Salamanders</title>
</head>

<body>
    <h1>Salamanders</h1>

    <table>
        <thead>
            <tr>
                <th>Name</th>
                <th>Habitat</th>
                <th>Description</th>
                <th>Show</th>
                <th>Edit</th>
                <th>Delete</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($salamanders as $s): ?>
                <tr>
                    <td><?= htmlspecialchars($s['name']) ?></td>
                    <td><?= nl2br(htmlspecialchars($s['habitat'])) ?></td>
                    <td><?= nl2br(htmlspecialchars($s['description'])) ?></td>
                    <td><a href="/salamanders/show?id=<?= urlencode((string)$s['id']) ?>">Show</a></td>
                    <td><a href="/salamanders/edit?id=<?= urlencode((string)$s['id']) ?>">Edit</a></td>
                    <td><a href="/salamanders/delete?id=<?= urlencode((string)$s['id']) ?>">Delete</a></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</body>

</html>
