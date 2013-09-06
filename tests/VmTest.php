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

    /** @test */
    function loop()
    {
        $code = '+>++>+++<<[.>]';
        $this->expectOutputString(0x010203);
        execute($code);
    }

    /** @test */
    function nestedLoop()
    {
        $code = '++[>+++++++[>+++++++<-]<-]>>';
        $this->expectOutputString(0x98);
        execute($code);
    }
}
