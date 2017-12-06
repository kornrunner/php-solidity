<?php
namespace kornrunner;

use BN\BN;

final class Solidity {

    private static function hex ($input): string {
        if ($input instanceof BN) {
            $input = $input->toString();
        } elseif (is_bool($input)) {
            return str_pad(dechex((int) $input), 2, '0', STR_PAD_LEFT);
        }

        if (strpos($input, '0x') === 0) {
            $input = substr($input, 2);
        } elseif (is_numeric($input)) {
            $pad = '0';
            if ($input < 0) {
                $input = PHP_INT_SIZE === 8 ? sprintf('%u', $input & 0xFFFFFFFF) : sprintf('%u', $input);
                $pad = 'f';
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
        $hex_array = array_map(__CLASS__ . '::hex', $args);
        $hex_glued = strtolower(implode('', $hex_array));
        return '0x' . Keccak::hash(hex2bin($hex_glued), 256);
    }
}
