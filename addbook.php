<?php
include __DIR__ . '/includes/db.php';


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $titolo = htmlspecialchars($_POST['titolo']);
    $autore = htmlspecialchars($_POST['autore']);
    $anno = filter_input(INPUT_POST, 'anno_pubblicazione', FILTER_SANITIZE_NUMBER_INT);
    $genere = htmlspecialchars($_POST['genere']);

    if (filter_var($anno, FILTER_VALIDATE_INT) === false || strlen((string)$anno) > 4) {
        echo "<script>alert('L\'anno non è un numero intero valido o ha più di 4 cifre');</script>";
    }

    $stmt = $pdo->prepare("INSERT INTO libri (titolo, autore, anno_pubblicazione, genere) VALUES (?, ?, ?, ?)");
    $stmt->execute([$titolo, $autore, $anno, $genere]);
    echo "<script>alert('Dati inviati con successo!'); window.location = 'index.php';</script>";
}

include __DIR__ . '/includes/html.php';

include __DIR__ . '/includes/navbar.php'; ?>

<form action="addbook.php" method="post" class="needs-validation" novalidate>
    <div class="form-group">
        <label for="titolo">Titolo:</label>
        <input type="text" id="titolo" name="titolo" class="form-control" value="<?php echo isset($_POST['titolo']) ? htmlspecialchars($_POST['titolo']) : ''; ?>" required>
        <div class="invalid-feedback">
            Per favore inserisci il titolo del libro.
        </div>
    </div>
    <div class="form-group">
        <label for="autore">Autore:</label>
        <input type="text" id="autore" name="autore" class="form-control" value="<?php echo isset($_POST['autore']) ? htmlspecialchars($_POST['autore']) : ''; ?>" required>
        <div class="invalid-feedback">
            Per favore inserisci l'autore del libro.
        </div>
    </div>
    <div class="form-group">
        <label for="anno_pubblicazione">Anno di pubblicazione:</label>
        <input type="text" id="anno_pubblicazione" name="anno_pubblicazione" class="form-control" value="<?php echo isset($_POST['anno_pubblicazione']) ? htmlspecialchars($_POST['anno_pubblicazione']) : ''; ?>" required>
        <div class="invalid-feedback">
            Per favore inserisci l'anno di pubblicazione.
        </div>
    </div>
    <div class="form-group">
        <label for="genere">Genere:</label>
        <input type="text" id="genere" name="genere" class="form-control" value="<?php echo isset($_POST['genere']) ? htmlspecialchars($_POST['genere']) : ''; ?>" required>
        <div class="invalid-feedback">
            Per favore inserisci il genere del romanzo.
        </div>
    </div>
    <button type="submit" class="btn btn-primary mt-3">Submit</button>
</form>


<?php

include __DIR__ . '/includes/end.php';
