<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Configuração de Moeda
    |--------------------------------------------------------------------------
    |
    | Define a moeda padrão do sistema (Angola)
    |
    */

    'code' => env('CURRENCY_CODE', 'AOA'),
    
    'name' => env('CURRENCY_NAME', 'Kwanza Angolano'),
    
    'symbol' => env('CURRENCY_SYMBOL', 'Kz'),
    
    'decimal_separator' => env('CURRENCY_DECIMAL', ','),
    
    'thousands_separator' => env('CURRENCY_THOUSANDS', '.'),
    
    /**
     * Formata um valor numérico para moeda
     * @param float $value Valor a formatar
     * @param bool $symbol Incluir símbolo (padrão: true)
     * @return string Valor formatado
     * 
     * Exemplo: formatCurrency(10000) => "10.000,00 Kz"
     */
    'format' => function($value, $symbol = true) {
        $formatted = number_format($value, 2, config('currency.decimal_separator'), config('currency.thousands_separator'));
        return $symbol ? $formatted . ' ' . config('currency.symbol') : $formatted;
    }
];
