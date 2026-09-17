<?php
/* ===== SEZIONE 1: Inclusione File e Impostazione Risposta JSON ===== */
// api_save_score.php - API endpoint per salvare i punteggi dal game.js
require_once 'includes/connection.php';
session_start();

// HEADER: Specifica che la risposta è JSON
// Questo header viene inviato per dire al browser che il contenuto è JSON, non HTML
header('Content-Type: application/json');

/* ===== SEZIONE 2: Controllo Sessione Utente ===== */
// Verifica che l'utente sia loggato prima di salvare qualsiasi punteggio
// Se non loggato, restituisce errore JSON
if (!isset($_SESSION['user_id'])) {
    // Risposta JSON con errore (formato compatibile con fetch del game.js)
    echo json_encode(['success' => false, 'message' => 'Devi essere loggato per salvare il punteggio']);
    exit;
}

/* ===== SEZIONE 2bis: Controllo Se Utente è Bannato ===== */
// Verifica che l'utente non sia bannato prima di salvare il punteggio
// Recupero l'ID dalla sessione
$user_id = $_SESSION['user_id'];

try {
    // CORREZIONE QUI: Uso 'utenti' e 'bannato' come nel resto del progetto
    $sql_check_ban = "SELECT bannato FROM utenti WHERE id = ?";
    $stmt_check = $pdo->prepare($sql_check_ban);
    $stmt_check->execute([$user_id]);
    $user = $stmt_check->fetch(PDO::FETCH_ASSOC);
    
    // Se l'utente esiste ed è bannato (bannato == 1)
    if ($user && $user['bannato'] == 1) {
        
        // Distrugge la sessione per buttarlo fuori
        session_destroy(); 
        
        echo json_encode(['success' => false, 'message' => 'Il tuo account è stato bannato. Logout in corso...']);
        exit;
    }
} catch (PDOException $e) {
    echo json_encode(['success' => false, 'message' => 'Errore nel controllo utente: ' . $e->getMessage()]);
    exit;
}

/* ===== SEZIONE 3: Decodifica Dati JSON in Input ===== */
// Legge il raw input (corpo della richiesta POST) che contiene JSON
$input = file_get_contents("php://input");
// Converte la stringa JSON in array associativo PHP (true = associativo)
$data = json_decode($input, true);

/* ===== SEZIONE 4: Validazione e Salvataggio Punteggio ===== */
// Verifica che il campo 'score' sia presente nei dati ricevuti
if (isset($data['score'])) {
    // Cast a INT per proteggere da valori non numerici
    $punteggio = (int)$data['score'];
    // Recupera l'ID utente dalla sessione (loggato)
    $user_id = $_SESSION['user_id'];

    try {
        /* ===== SEZIONE 5: Inserimento nel Database ===== */
        // INSERT query: aggiunge un nuovo record alla tabella punteggi
        // Campi: id_utente (chi ha fatto il punteggio), punteggio (valore)
        // Il timestamp viene aggiunto automaticamente dal database (DEFAULT CURRENT_TIMESTAMP)
        $sql = "INSERT INTO punteggi (id_utente, punteggio) VALUES (?, ?)";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$user_id, $punteggio]);
        
        // RISPOSTA: Successo con messaggio
        echo json_encode(['success' => true, 'message' => 'Punteggio salvato!']);
    } catch (PDOException $e) {
        // GESTIONE ERRORE: Se il database fallisce, restituisce messaggio di errore
        echo json_encode(['success' => false, 'message' => 'Errore DB: ' . $e->getMessage()]);
    }
} else {
    // ERRORE: Se 'score' non è presente nei dati
    echo json_encode(['success' => false, 'message' => 'Nessun punteggio ricevuto']);
}
?>