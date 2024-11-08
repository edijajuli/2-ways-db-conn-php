<?php
require 'database.php';
$id = $_GET['id'] ?? null;

if (!$id) {
    header('Location: index.php');
    exit;
}

$sql = 'SELECT * FROM posts WHERE id = :id';
$stmt = $pdo->prepare($sql);
$params = ['id' => $id];
$stmt->execute($params);
$post = $stmt->fetch();
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.tailwindcss.com"></script>
    <title><?= $post['title']; ?></title>
</head>

<body class="bg-gray-100">
    <header class="bg-blue-500 text-white p-4">
        <div class="container mx-auto">
            <h1 class="text-3xl font-semibold">My Blog</h1>
        </div>
    </header>
    <div class="container mx-auto p-4 mt-4">
        <div class="md my-4">
            <div class="rounded-lg shadow-md mb-4">
                <div class="p-4">
                    <h2 class="text-2xl font-semibold"><?= $post['title']; ?></h2>
                    <p class="text-gray-700"><?= $post['body']; ?></p>
                    <a href="index.php">Go Back</a>
                </div>
            </div>


            <!-- EDIT button -->
            <a href="edit.php?id=<?= $post['id'] ?>"
                class="bg-green-500 text-white px-4 py-2 rounded block w-full text-center hover:bg-green-600 focus:outline-none">Edit</a>
            <!-- DELETE button -->
            <form action="delete.php" method="post">
                <input type="hidden" name="delete" value="delete">
                <input type="hidden" name="id" value="<?= $post['id'] ?>">
                <button type="submit" name="submit"
                    class="bg-red-500 text-white px-4 py-2 mt-3 rounded hover:bg-red-600 focus:outline-none w-full">Delete</button>
            </form>
        </div>
    </div>

</body>

</html>