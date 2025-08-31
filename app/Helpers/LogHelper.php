<?php

namespace App\Helpers;

class LogHelper
{
    /**
     * Masquer les données sensibles dans un tableau
     */
    public static function maskSensitiveData($data, $sensitiveKeys = null)
    {
        if ($sensitiveKeys === null) {
            $sensitiveKeys = [
                'password',
                'password_confirmation',
                'token',
                'api_key',
                'secret',
                'email',
                'phone',
                'address',
                'real_path',
                'file_path',
                'path',
                'user_after_save',
                'all_data',
                'files',
                'data'
            ];
        }

        if (is_array($data)) {
            $masked = [];
            foreach ($data as $key => $value) {
                if (in_array(strtolower($key), array_map('strtolower', $sensitiveKeys))) {
                    $masked[$key] = '[MASQUÉ]';
                } elseif (is_array($value)) {
                    $masked[$key] = self::maskSensitiveData($value, $sensitiveKeys);
                } else {
                    $masked[$key] = $value;
                }
            }
            return $masked;
        }

        return $data;
    }

    /**
     * Logger des informations de manière sécurisée
     */
    public static function secureLog($level, $message, $context = [])
    {
        $maskedContext = self::maskSensitiveData($context);
        \Log::$level($message, $maskedContext);
    }

    /**
     * Logger des informations de debug de manière sécurisée
     */
    public static function debug($message, $context = [])
    {
        if (config('app.debug')) {
            self::secureLog('debug', $message, $context);
        }
    }

    /**
     * Logger des informations de manière sécurisée
     */
    public static function info($message, $context = [])
    {
        self::secureLog('info', $message, $context);
    }

    /**
     * Logger des erreurs de manière sécurisée
     */
    public static function error($message, $context = [])
    {
        self::secureLog('error', $message, $context);
    }

    /**
     * Logger des avertissements de manière sécurisée
     */
    public static function warning($message, $context = [])
    {
        self::secureLog('warning', $message, $context);
    }
}
