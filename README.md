# brainfuck-php

![brainfuck](doc/brainfuck.png)

brainfuck is a turing complete language with 8 instructions.

## Example

Hello World:

    >+++++++++[<++++++++>-]<.>+++++++[<++++>-]<+.+++++++..+++.>>>++++++++[<++++>-]
    <.>>>++++++++++[<+++++++++>-]<---.<<<<.+++.------.--------.>>+.

Cat:

    ,[.,]

## Usage

Just pass a filename to the interpreter:

    $ bin/brainfuck examples/hello.bf

You can also pass the --debug option to get a log of all instructions.

    $ bin/brainfuck --debug examples/hello.bf

## References

* [Brian Raiter's guide](http://www.muppetlabs.com/~breadbox/bf/)
* [brainfuck on Esolang](http://esolangs.org/wiki/Brainfuck)
