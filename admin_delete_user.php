<?php
/* ===== SEZIONE 1: Inclusione File e Controllo Accesso ===== */
// admin_delete_user.php - Script per la cancellazione utenti da parte dell'admin
require_once 'includes/connection.php';
session_start();

// PROTEZIONE FONDAMENTALE
// Verifica che chi chiama lo script sia effettivamente un admin loggato
if (!isset($_SESSION['user_id']) || $_SESSION['ruolo'] !== 'admin') {
    // Rifiuta accesso con messaggio di errore
    die("ACCESSO NEGATO. Non hai i permessi.");
}

/* ===== SEZIONE 2: Verifica Parametro ID da Cancellare ===== */
// Controlla se è stato passato un ID via GET
if (isset($_GET['id'])) {
    $id_da_cancellare = $_GET['id'];

    // PROTEZIONE AGGIUNTIVA: Evita l'auto-eliminazione accidentale
    if ($id_da_cancellare == $_SESSION['user_id']) {
        die("Non puoi cancellare te stesso da qui.");
    }

    try {
        /* ===== SEZIONE 3: Cancellazione dal Database con CASCADE ===== */
        $stmt = $pdo->prepare("DELETE FROM utenti WHERE id = ?");
        $stmt->execute([$id_da_cancellare]);

        // REDIRECT: Torna alla dashboard con messaggio di successo nel $_GET
        header("Location: admin_dashboard.php?msg=Utente eliminato con successo.");
        exit;

    } catch (PDOException $e) {
        // Se il database genera un errore, mostralo
        die("Errore Database: " . $e->getMessage());
    }
} else {
    // Se non è stato passato un ID valido, reindirizza senza fare nulla
    header("Location: admin_dashboard.php");
    exit;
}
?>