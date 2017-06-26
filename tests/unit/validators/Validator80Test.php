<?php

namespace malkusch\bav;

use PHPUnit\Framework\TestCase;

class Validator80Test extends TestCase
{
    private $validator;

    public function setUp()
    {
        parent::setUp();

        $backend = $this->createMock("malkusch\bav\FileDataBackend");
        $bank = $this->createMock(
            "malkusch\bav\Bank", array(), array($backend, 1, '80'));

        $this->validator = new Validator80($bank);
    }

    /**
     * @param string $account The account id.
     * @param bool $expected The expected validation result.
     *
     * @dataProvider provideTestData
     */
    public function testIsValid($account, $expected)
    {
        $this->assertEquals($expected, $this->validator->isValid($account));
    }

    /**
     * Returns test cases for testIsValid().
     *
     * @return array Test cases.
     */
    public function provideTestData()
    {
        return [
            // method A
            ['340968', true],

            // method A
            ['340969', false],

            // method B
            ['340966', true],

            // method B
            ['340967', false],

            // exceptions - calculation as exceptions in validator 51
            ['0199100002', true],
            ['0099100010', true],
            ['2599100002', true],
            ['0199100004', true],
            ['2599100003', true],
            ['3199204090', true],

            // exceptions - calculation as exceptions in validator 51
            ['0099345678', false],
            ['0099345678', false],
            ['0099100110', false],
            ['0199100040', false],
        ];
    }
}
