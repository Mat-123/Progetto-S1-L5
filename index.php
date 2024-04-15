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
        echo '<div class="col-lg-4 col-md-6 col-xs-12 g-3">';
        echo '<div class="card mt-2 h-100">';
        echo '<div class="card-body d-flex flex-column justify-content-between">';
        echo '<div>';
        echo "<h5 class='card-title'>$row[titolo]</h5>";
        echo "<h6 class='card-subtitle mb-3 text-body-secondary'>$row[autore]</h6>";
        echo "<p class='card-text mb-1'>Anno di pubblicazione: $row[anno_pubblicazione]</p>";
        echo "<p class='card-text'>Genere: $row[genere]</p>";
        echo '</div>';
        echo "<div class='d-flex justify-content-between mt-3'>";
        echo "<a href='edit.php?id=" . $row["id"] . "' class='btn btn-primary'>Modifica</a>";
        echo "<a href='?delete=" . $row["id"] . "' class='btn btn-danger' onclick='return confirm(\"Are you sure you want to delete the book: " . $row["titolo"] . "?\")'>Elimina</a>";
        echo '</div>';
        echo '</div>';
        echo '</div>';
        echo '</div>';
    }

    ?>
</div>

<?php

include __DIR__ . '/includes/end.php';
