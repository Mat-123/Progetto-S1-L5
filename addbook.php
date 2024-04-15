<?php
include __DIR__ . '/includes/db.php';

$errors = [];
$success = false;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
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
        $stmt = $pdo->prepare("INSERT INTO libri (titolo, autore, anno_pubblicazione, genere) VALUES (?, ?, ?, ?)");
        $stmt->execute([$titolo, $autore, $anno, $genere]);

        $success = true;
    }
}

include __DIR__ . '/includes/html.php';

include __DIR__ . '/includes/navbar.php';
?>

<?php if ($success) : ?>
    <div class="alert alert-success" role="alert">
        Dati inviati con successo!
    </div>
<?php endif; ?>
<div class="row">
    <div class="col-md-6 col-sx-12 mx-auto">
        <form action="addbook.php" method="post" class="needs-validation" novalidate>
            <?php if (!empty($errors)) : ?>
                <div class="alert alert-danger" role="alert">
                    <?php foreach ($errors as $error) : ?>
                        <?php echo $error; ?><br>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
            <div class="form-group">
                <label for="titolo">Titolo:</label>
                <input type="text" id="titolo" name="titolo" class="form-control" value="<?php echo isset($_POST['titolo']) ? htmlspecialchars($_POST['titolo']) : ''; ?>" required>
            </div>
            <div class="form-group">
                <label for="autore">Autore:</label>
                <input type="text" id="autore" name="autore" class="form-control" value="<?php echo isset($_POST['autore']) ? htmlspecialchars($_POST['autore']) : ''; ?>" required>
            </div>
            <div class="form-group">
                <label for="anno_pubblicazione">Anno di pubblicazione:</label>
                <input type="text" id="anno_pubblicazione" name="anno_pubblicazione" class="form-control" value="<?php echo isset($_POST['anno_pubblicazione']) ? htmlspecialchars($_POST['anno_pubblicazione']) : ''; ?>" required>
            </div>
            <div class="form-group">
                <label for="genere">Genere:</label>
                <input type="text" id="genere" name="genere" class="form-control" value="<?php echo isset($_POST['genere']) ? htmlspecialchars($_POST['genere']) : ''; ?>" required>
            </div>
            <div class="d-flex justify-content-between">
                <a href="index.php" class="btn btn-secondary mt-3">Annulla</a>
                <button type="submit" class="btn btn-primary mt-3">Aggiungi</button>
            </div>
        </form>
    </div>
</div>
<?php
include __DIR__ . '/includes/end.php';
?>