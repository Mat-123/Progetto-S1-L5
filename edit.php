<?php

include __DIR__ . '/includes/db.php';

$errors = [];
$success = false;

if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET['id'])) {
    $id = $_GET['id'];
    $stmt = $pdo->prepare("SELECT * FROM libri WHERE id = ?");
    $stmt->execute([$id]);
    $user = $stmt->fetch();
} elseif ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = $_POST['id'];
    $titolo = htmlspecialchars($_POST['titolo']);
    $autore = htmlspecialchars($_POST['autore']);
    $anno = filter_input(INPUT_POST, 'anno_pubblicazione', FILTER_VALIDATE_INT);
    $genere = htmlspecialchars($_POST['genere']);

    if (empty($titolo) || empty($autore) || empty($genere)) {
        $errors[] = "Tutti i campi sono obbligatori.";
    } else {
        if (strlen((string)$anno) > 4) {
            $errors[] = "L'anno di pubblicazione non puo' avere piu' di 4 cifre.";
        }
    }

    if (empty($errors)) {
        $stmt = $pdo->prepare("UPDATE libri SET titolo = ?, autore = ?, anno_pubblicazione = ?, genere = ? WHERE id = ?");
        $stmt->execute([$titolo, $autore, $anno, $genere, $id]);
        echo "<script>alert('Data successfully updated!');</script>";
        $success = true;
        echo "<script>window.location = 'index.php';</script>";
        exit;
    }
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
    <div class="d-flex justify-content-between">
        <a href="index.php" class="btn btn-secondary mt-3">ANNULLA</a>
        <button type="submit" class="btn btn-warning mt-3">EDIT</button>
    </div>
</form>

<?php

include __DIR__ . '/includes/end.php';
