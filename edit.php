<?php

include __DIR__ . '/includes/db.php';

if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET['id'])) {
    $id = $_GET['id'];
    $stmt = $pdo->prepare("SELECT * FROM libri WHERE id = ?");
    $stmt->execute([$id]);
    $user = $stmt->fetch();
} elseif ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = $_POST['id'];
    $titolo = $_POST['titolo'];
    $autore = $_POST['autore'];
    $anno = $_POST['anno_pubblicazione'];
    $genere = $_POST['genere'];
    $stmt = $pdo->prepare("UPDATE libri SET titolo = ?, autore = ?, anno_pubblicazione = ?, genere = ? WHERE id = ?");
    $stmt->execute([$titolo, $autore, $anno, $genere, $id]);
    header("Location: index.php");
    exit;
}


include __DIR__ . '/includes/html.php';

include __DIR__ . '/includes/navbar.php'; ?>

<form action="edit.php" method="post">
    <input type="hidden" name="id" value="<?php echo $user['id']; ?>">
    <div class="form-group">
        <label for="titolo">Titolo:</label>
        <input type="text" id="titolo" name="titolo" class="form-control" value="<?php echo $user['titolo']; ?>">
    </div>
    <div class="form-group">
        <label for="autore">Autore:</label>
        <input type="text" id="autore" name="autore" class="form-control" value="<?php echo $user['autore']; ?>">
    </div>
    <div class="form-group">
        <label for="anno_pubblicazione">Anno di pubblicazione:</label>
        <input type="text" id="anno_pubblicazione" name="anno_pubblicazione" class="form-control" value="<?php echo $user['anno_pubblicazione']; ?>">
    </div>
    <div class="form-group">
        <label for="genere">Genere:</label>
        <input type="text" id="genere" name="genere" class="form-control" value="<?php echo $user['genere']; ?>">
    </div>
    <button type="submit" class="btn btn-primary mt-3">EDIT</button>
</form>

<?php

include __DIR__ . '/includes/end.php';
