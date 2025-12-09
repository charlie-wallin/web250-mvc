<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Salamander Details</title>
</head>

<body>
    <h1><?php echo htmlspecialchars($salamander['name']); ?></h1>
    <p><strong>Description:</strong> <?php echo htmlspecialchars($salamander['description']); ?></p>
    <p><strong>Habitat:</strong> <?php echo htmlspecialchars($salamander['habitat']); ?></p>
    <p><strong>Diet:</strong> <?php echo htmlspecialchars($salamander['diet']); ?></p>
</body>

</html>