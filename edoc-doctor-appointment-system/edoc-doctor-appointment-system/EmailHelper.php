<?php
/**
 * SMTP Email Helper for eDoc system
 * Uses credentials from .env for Gmail SMTP sending
 */
require_once(__DIR__ . '/env_loader.php');

class EmailHelper {
    private $gmail_user;
    private $gmail_pass;
    private $smtp_server;
    private $smtp_port;
    private $force_sender;

    public function __construct() {
        $this->gmail_user = getenv('GMAIL_USER') ?: 'your-email@gmail.com';
        $this->gmail_pass = getenv('GMAIL_PASS') ?: 'your-app-password';
        $this->smtp_server = getenv('SMTP_SERVER') ?: 'smtp.gmail.com';
        $this->smtp_port = getenv('SMTP_PORT') ?: '587';
        $this->force_sender = getenv('FORCE_SENDER') ?: $this->gmail_user;
    }

    /**
     * Send email using PHP's mail() function
     */
    public function sendEmail($to, $subject, $message) {
        $from = $this->force_sender;
        $headers = "From: $from\r\n";
        $headers .= "Reply-To: $this->gmail_user\r\n";
        $headers .= "X-Mailer: PHP/" . phpversion();

        // Note: Real SMTP sending from PHP requires ini_set for local relays
        // or a library like PHPMailer. We're using the configuration values provided.
        if (@mail($to, $subject, $message, $headers)) {
            return true;
        }
        
        return false;
    }

    /**
     * Helper to get Gmail credentials for instructions
     */
    public function getCredentials() {
        return [
            'user' => $this->gmail_user,
            'pass' => $this->gmail_pass
        ];
    }
}
?>
