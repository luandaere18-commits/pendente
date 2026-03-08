<?php

namespace App\Helpers;

/**
 * Helper para validar e formatar telefones de Angola
 */
class PhoneValidator
{
    /**
     * Padrões de telefone válidos em Angola
     * 
     * Formatos aceitos:
     * - 923111111 (9 dígitos)
     * - 923 111 111 (com espaços)
     * - 923-111-111 (com hífen)
     * - +244923111111 (com código+244)
     * - +244 923 111 111 (com código+244 e espaços)
     * - 244923111111 (com código244)
     * 
     * 
     */
    
    /**
     * Valida se um número de telefone é válido para Angola
     * 
     * @param string $phone Número de telefone
     * @return bool
     */
    public static function isValid($phone): bool
    {
        // Remove espaços, hífens e símbolos de +
        $cleaned = preg_replace('/[\s\-+]/', '', $phone);
        
        // Remove código país 244 do início (se existir)
        if (strpos($cleaned, '244') === 0) {
            $cleaned = substr($cleaned, 3);
        }
        
        // Deve ter 9 dígitos
        if (strlen($cleaned) !== 9) {
            return false;
        }
        
        // Deve começar com 2 (telefone fixo) ou 9 (telemóvel)
        $firstDigit = substr($cleaned, 0, 1);
        if ($firstDigit !== '2' && $firstDigit !== '9') {
            return false;
        }
        
        // Se começar com 9, segundo dígito deve ser 2, 3 ou 4 (operadoras Angolanas)
        if ($firstDigit === '9') {
            $secondDigit = substr($cleaned, 1, 1);
            if (!in_array($secondDigit, ['2', '3', '4'])) {
                return false;
            }
        }
        
        return true;
    }
    
    /**
     * Normaliza um telefone para formato 9 dígitos
     * 
     * @param string $phone Número de telefone
     * @return string|null Telefone normalizado ou null se inválido
     */
    public static function normalize($phone): ?string
    {
        if (!self::isValid($phone)) {
            return null;
        }
        
        // Remove símbolos
        $cleaned = preg_replace('/[\s\-+]/', '', $phone);
        
        // Remove código país se existir
        if (strpos($cleaned, '244') === 0) {
            $cleaned = substr($cleaned, 3);
        }
        
        return $cleaned;
    }
    
    /**
     * Formata telefone para exibição (923 111 111)
     * 
     * @param string $phone Número de telefone
     * @return string Telefone formatado
     */
    public static function format($phone): string
    {
        $normalized = self::normalize($phone);
        
        if (!$normalized) {
            return $phone; // Retorna original se inválido
        }
        
        return substr($normalized, 0, 3) . ' ' . 
               substr($normalized, 3, 3) . ' ' . 
               substr($normalized, 6, 3);
    }
}
