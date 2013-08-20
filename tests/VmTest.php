<?php

namespace igorw\brainfuck;

class VmTest extends \PHPUnit_Framework_TestCase
{
    /** @test */
    function helloWorld()
    {
        $code = '';
        $code .= '>+++++++++[<++++++++>-]<.>+++++++[<++++>-]<+.+++++++..+++.>>>++++++++[<++++>-]';
        $code .= '<.>>>++++++++++[<+++++++++>-]<---.<<<<.+++.------.--------.>>+.';
        $this->expectOutputString('Hello World!');
        execute($code);
    }
}
