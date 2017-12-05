<?php

use BN\BN;
use kornrunner\Solidity;

class SolidityTest extends PHPUnit\Framework\TestCase
{
    private const contractAddress = '0x2a0c0dbecc7e4d658f48e01e3fa353f44050c208';
    private const tokenBuy = '0x0000000000000000000000000000000000000000';
    private const amountBuy = '100000000';
    private const tokenSell = '0x1111111111111111111111111111111111111111';
    private const amountSell = '10000';
    private const address = '0x034767f3c519f361c5ecf46ebfc08981c629d381';
    private const nonce = 5;
    private const expires = '10000';

    /**
     * @dataProvider sha3
     */
    public function testSha3($data, $expect) {
        $this->assertEquals(Solidity::sha3($data), $expect);
    }

    public static function sha3 (): array {
        return [
            [self::contractAddress, '0x9f13f88230a70de90ed5fa41ba35a5fb78bc55d11cc9406f17d314fb67047ac7'],
            [self::tokenBuy, '0x5380c7b7ae81a58eb98d9c78de4a1fd7fd9535fc953ed2be602daaa41767312a'],
            [self::amountBuy, '0xfb05e4134e5b30db022b94b822e7d19b1e5cd1c244468eada63789fd3514454a'],
            [self::tokenSell, '0xe2c07404b8c1df4c46226425cac68c28d27a766bbddce62309f36724839b22c0'],
            [self::amountSell, '0x1d460b64f7b8ba0be629afe9b4ae65333b379985d7ea823ff4c0b8c3b5102153'],
            [self::expires, '0x1d460b64f7b8ba0be629afe9b4ae65333b379985d7ea823ff4c0b8c3b5102153'],
            [self::nonce, '0x036b6384b5eca791c62761152d0c79bb0604c104a5fb6f4eb0703f3154bb3db0'],
            [self::address, '0x5c72003ad77a34d6c7061c57eb81dd46bc248e43cfd5bd64fb43f10c2edb805b'],
            ['0x0a', '0x0ef9d8f8804d174666011a394cab7901679a8944d24249fd148a6a36071151f8'],
            [1, '0xb10e2d527612073b26eecdfd717e6a320cf44b4afac2b0732d9fcbe2b7fa0cf6'],
            [-1, '0xa9c584056064687e149968cbab758a3376d22aedc6a55823d1b3ecbee81b8fb9'],
            ['a', '0x3ac225168df54212a25c1c01fd35bebfea408fdac2e31ddd6f80a4bbf9a5f1cb'],
        ];
    }

    /**
     * @dataProvider sha3Variadic
     */
    public function testSha3Variadic($args, $expect) {
        $this->assertEquals(call_user_func_array('\kornrunner\Solidity::sha3', $args), $expect);
    }

    public static function sha3Variadic (): array {
        return [
            [[self::contractAddress, self::tokenBuy, self::amountBuy, self::tokenSell, self::amountSell, self::expires, self::nonce, self::address], '0xf20f20d357419f696f69e6ff05bc6566b1e6d38814ce4f489d35711e2fd2c481'],
            [['0x0a', 1], '0xf88b7969914a53d588c819dfc61967e9f4955a6acc93ab0e225ee6d463a592cf'],
        ];
    }
}