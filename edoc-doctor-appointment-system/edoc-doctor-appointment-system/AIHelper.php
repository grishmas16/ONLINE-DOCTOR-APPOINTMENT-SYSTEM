<?php
/**
 * AI and MongoDB Utility for eDoc Medical LLM System
 */
require_once(__DIR__ . '/env_loader.php');

class AIHelper {
    private $llm_api_url;
    private $llm_api_key;
    private $llm_model;
    private $mongodb_url;
    private $database_name;

    public function __construct() {
        $this->llm_api_url = getenv('LLM_API_URL') ?: 'http://localhost:9999/predict';
        $this->llm_api_key = getenv('LLM_API_KEY') ?: 'dev-key';
        $this->llm_model = getenv('LLM_MODEL') ?: 'dev-model';
        $this->mongodb_url = getenv('MONGODB_URL') ?: 'mongodb://localhost:27017';
        $this->database_name = getenv('DATABASE_NAME') ?: 'medical_llm_db';
    }

    /**
     * Get AI Insights from the LLM API
     */
    public function getAIInsight($prompt, $user_context = []) {
        $data = [
            'model' => $this->llm_model,
            'prompt' => $prompt,
            'context' => $user_context
        ];

        // cURL extension not available — fall through to offline fallback
        if (!function_exists('curl_init')) {
            $http_code = 0;
            $response   = false;
            $curl_error = 'cURL extension is not enabled on this server.';
        } else {
            $ch = curl_init($this->llm_api_url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
            curl_setopt($ch, CURLOPT_HTTPHEADER, [
                'Content-Type: application/json',
                'Authorization: Bearer ' . $this->llm_api_key
            ]);

            $response   = curl_exec($ch);
            $http_code  = curl_getinfo($ch, CURLINFO_HTTP_CODE);
            $curl_error = curl_error($ch);
            curl_close($ch);
        }

        if ($http_code === 200) {
            $result = json_decode($response, true);
            $ai_text = $result['prediction'] ?? 'No response from AI.';
            
            // Log to MongoDB if possible
            $this->logToMongoDB('ai_interactions', [
                'type' => 'user_query',
                'prompt' => $prompt,
                'response' => $ai_text,
                'timestamp' => date('Y-m-d H:i:s')
            ]);

            return $ai_text;
        }

        if ($http_code === 0) {
            // Fallback to local mock logic if backend is offline
            $prompt_lower = strtolower($prompt);
            if (strpos($prompt_lower, 'headache') !== false) {
                return "AI Assistant (Offline Mode): Headaches can be caused by stress or dehydration. Drink water and rest. If pain persists, see a doctor.";
            } elseif (strpos($prompt_lower, 'fever') !== false) {
                return "AI Assistant (Offline Mode): A fever indicates your body is fighting infection. Monitor your temperature and stay hydrated.";
            } elseif (strpos($prompt_lower, 'analyze') !== false) {
                return "AI Assistant (Offline Mode): Based on the clinical data provided, I recommend a follow-up consultation with a specialist for further evaluation.";
            } else {
                return "AI Assistant (Offline Mode): I've analyzed your query: '$prompt'. Please consult with our eDoc professionals for a detailed diagnosis.";
            }
        }

        return "AI Assistant is currently unavailable. (Error: $http_code - $curl_error)";
    }

    /**
     * Log interaction to MongoDB (Stub - requires MongoDB extension)
     */
    private function logToMongoDB($collection, $data) {
        if (!class_exists('MongoDB\Driver\Manager')) {
            // MongoDB extension not installed, skipping log
            return false;
        }

        try {
            $manager = new MongoDB\Driver\Manager($this->mongodb_url);
            $bulk = new MongoDB\Driver\BulkWrite;
            $bulk->insert($data);
            $manager->executeBulkWrite($this->database_name . '.' . $collection, $bulk);
            return true;
        } catch (Exception $e) {
            return false;
        }
    }
}
?>
