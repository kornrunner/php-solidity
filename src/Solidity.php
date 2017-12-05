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
        } else {
            $tmp = mb_detect_encoding($input, 'UTF-8', true) ? utf8_encode($input) : $input;
            $out = '';
            for($i = 0; $i < strlen($tmp); $i++) {
                $code = ord($tmp[$i]);
                if ($code === 0) {
                    break;
                }

                $hex = dechex($code);
                $out .= strlen($hex) < 2 ? '0' . $hex : $hex;
            }
            $input = $out;
        }

        return $input;
    }

    public static function sha3(...$args): string {
        $hex_data = array_map(__CLASS__ . '::hex', $args);

        return '0x' . Keccak::hash(hex2bin(implode('', $hex_data)), 256);
    }
}
