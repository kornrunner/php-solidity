<?php
namespace kornrunner;

final class Solidity {

    private static function hex ($input): string {
        if (strpos($input, '0x') === 0) {
            $input = substr($input, 2);
        } elseif (is_numeric($input)) {
            $pad = '0';
            if ($input < 0) {
                $input = PHP_INT_SIZE === 8 ? decbin($input) & 0xFFFFFFFF : decbin($input) >> 1;
                $pad = 'F';
            }

            $input = str_pad(dechex($input), 64, $pad, STR_PAD_LEFT);
        }

        return $input;
    }

    public static function sha3(...$args): string {
        $hex_data = array_map(__CLASS__ . '::hex', $args);

        return '0x' . Keccak::hash(hex2bin(implode('', $hex_data)), 256);
    }
}
