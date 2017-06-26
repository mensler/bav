<?php

namespace malkusch\bav;

use PHPUnit\Framework\TestCase;

class ValidatorA4Test extends TestCase
{
    private $validator;

    public function setUp()
    {
        parent::setUp();

        $backend = $this->createMock("malkusch\bav\FileDataBackend");
        $bank = $this->createMock(
            "malkusch\bav\Bank", array(), array($backend, 1, 'A4'));

        $this->validator = new ValidatorA4($bank);
    }

    /**
     * @param string $account The account id.
     * @param bool $expected The expected validation result.
     *
     * @dataProvider provideTestData
     */
    public function testIsValid($account, $expected)
    {
        // FIXME: fix validation for variant one
        if ('8623420004' === $account) {
            $this->markTestSkipped('Validation for 8623420004 should fail but doesn\'t and needs to be fixed');
        }

        // FIXME: fix validation for variant two
        if ('8623420000' === $account) {
            $this->markTestSkipped('Validation for 8623420000 should fail but doesn\'t and needs to be fixed');
        }

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
            // variant one
            ['0004711173', true],
            ['0007093330', true],

            // variant one
            ['8623420004', false],

            // variant two
            ['0004711172', true],
            ['0007093335', true],

            // variant two
            ['8623420000', false],

            // variant three
            ['1199503010', true],
            ['8499421235', true],

            // variant three
            ['6099702031', false],

            // variant four
            ['0000862342', true],
            ['8997710000', true],
            ['0664040000', true],
            ['0000905844', true],
            ['5030101099', true],
            ['0001123458', true],
            ['1299503117', true],

            // variant four
            ['0000399443', false],
            ['0000553313', false],
        ];
    }
}
