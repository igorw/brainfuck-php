<?php

namespace igorw\brainfuck;

/** @api */
function execute($code)
{
    $vm = new Machine($code);
    return $vm->execute();
}

// in order to allow consuming single chars,
// make sure to run with:
//   system("stty -icanon");
//
// source: http://stackoverflow.com/a/3684565/289985
class Machine
{
    public $code;
    public $ip = 0;

    public $tape;
    public $p = 0;

    function __construct($code)
    {
        $this->code = str_split($code);
        $this->tape = array_fill(0, 30000, 0);
    }

    function execute()
    {
        while (isset($this->code[$this->ip])) {
            $op = $this->code[$this->ip++];

            switch ($op) {
                case '>':
                    $this->p++;
                    break;
                case '<':
                    $this->p--;
                    break;
                case '+':
                    $this->tape[$this->p]++;
                    break;
                case '-':
                    $this->tape[$this->p]--;
                    break;
                case '.':
                    echo chr($this->tape[$this->p]);
                    break;
                case ',':
                    $char = fread(STDIN, 1);
                    $this->tape[$this->p] = ($char === "\x04") ? 0 : ord($char);
                    break;
                case '[':
                    if (!$this->tape[$this->p])
                        while ($this->code[$this->ip++] !== ']')
                            ;
                    break;
                case ']':
                    while ($this->code[--$this->ip] !== '[')
                        ;
                    break;
            }
        }
    }
}
