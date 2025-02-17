<?php 


if (!function_exists('stringToFloatVal')) {
    function stringToFloatVal(string $val): string
    {

        $massage_val = str_replace(",", ".", $val);
        $massage_val = preg_replace('/\.(?=.*\.)/', '', $massage_val);

        $floated_value = floatval($val);

        if (str_contains($val, '-')) {
            $floated_value = -1 * abs((float) $floated_value);
        }

        return (float) $floated_value;
    }
}

