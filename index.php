<?php

include __DIR__ . '/includes/db.php';

$search = $_GET['search'] ?? '';

$stmt = $pdo->prepare("SELECT * FROM libri WHERE titolo LIKE ? OR autore LIKE ? OR genere LIKE ?");
$stmt->execute([
    "%$search%",
    "%$search%",
    "%$search%"
]);

if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    $stmt_delete = $pdo->prepare("DELETE FROM libri WHERE id = ?");
    $stmt_delete->execute([$id]);
    header("Location: index.php");
};

include __DIR__ . '/includes/html.php';

include __DIR__ . '/includes/navbar.php'; ?>


<div class="row">

    <?php
    foreach ($stmt as $row) {
        echo '<div class="card col-lg-4 col-md-6 col-xs-12 mt-2">';
        echo '<div class="card-body">';
        echo "<h5 class='card-title'>$row[titolo]</h5>";
        echo "<h6 class='card-subtitle mb-2 text-body-secondary'>$row[autore]</h6>";
        echo "<p class='card-text'>Anno di pubblicazione: $row[anno_pubblicazione] - Genere: $row[genere]</p>";
        echo "<div class='d-flex justify-content-between'>";
        echo "<a href='edit.php?id=" . $row["id"] . "' class='btn btn-primary'>Edit</a>";
        echo "<a href='?delete=" . $row["id"] . "' class='btn btn-danger' onclick='return confirm(\"Are you sure you want to delete user with ID: " . $row["id"] . "?\")'>Delete</a>";
        echo '</div>';
        echo '</div>';
        echo '</div>';
    }

    ?>
</div>

<?php

include __DIR__ . '/includes/end.php';
