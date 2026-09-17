<?php
/* ===== SEZIONE 1: Inclusione File e Protezione Accesso ===== */
// delete_account.php - Script per l'auto-cancellazione dell'account utente
require_once 'includes/connection.php';
session_start();

// PROTEZIONE ASSOLUTA: Verifica che l'utente sia loggato
// Se non è loggato,viene reindirizzato alla pagina di login
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

// Recupera l'ID dell'utente corrente dalla sessione
$user_id = $_SESSION['user_id'];

/* ===== SEZIONE 1.5: Validazione Password ===== */
// Verifica che sia stato inviato il form POST con la password
if ($_SERVER['REQUEST_METHOD'] !== 'POST' || !isset($_POST['password_confirm'])) {
    header("Location: profilo.php");
    exit;
}

// Recupera la password inserita dall'utente
$password_confirm = $_POST['password_confirm'];

// Recupera i dati dell'utente dal database per verificare la password
require_once 'includes/select.php';
$user = getUserData($pdo, $user_id);

if (!$user || !password_verify($password_confirm, $user['password'])) {
    // La password non corrisponde - reindirizza con errore
    header("Location: profilo.php?error=password");
    exit;
}

/* ===== SEZIONE 2: Cancellazione dal Database con CASCADE ===== */
try {
    // Query DELETE con prepared statement (protezione SQL Injection)
    $sql = "DELETE FROM utenti WHERE id = ?";
    $stmt = $pdo->prepare($sql);
    // Esegui con il parametro user_id
    $stmt->execute([$user_id]);

    /* ===== SEZIONE 3: Pulizia della Sessione (Logout Forzato) ===== */
    // Una volta cancellato dal database, l'utente deve essere scollegato
    
    // Pulisce l'array della sessione
    $_SESSION = [];
    
    // Verifica se il PHP usa i cookie di sessione (configurazione standard)
    if (ini_get("session.use_cookies")) {
        // Recupera i parametri del cookie di sessione corrente
        $params = session_get_cookie_params();
        // Cancella il cookie impostando data di scadenza nel passato
        // Questo forza il browser a eliminare il cookie
        setcookie(session_name(), '', time() - 42000,
            $params["path"], $params["domain"],
            $params["secure"], $params["httponly"]
        );
    }
    // Distrugge la sessione server-side completamente
    session_destroy();

    /* ===== SEZIONE 4: Reindirizzamento a Pagina di Conferma ===== */
    // L'utente viene mandato alla pagina di registrazione con parametro status
    header("Location: register.php?status=deleted");
    exit;

} catch (PDOException $e) {
    // GESTIONE ERRORE: Se il database genera un'eccezione
    die("Errore durante la cancellazione: " . $e->getMessage());
}
?>