<?php

namespace igorw\brainfuck;

use Psr\Log\LoggerInterface;
use Psr\Log\NullLogger;

/** @api */
function execute($code, LoggerInterface $logger = null)
{
    $vm = new Machine($code, $logger);
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

    public $logger;

    function __construct($code, LoggerInterface $logger = null)
    {
        $this->code = str_split($code);
        $this->tape = array_fill(0, 30000, 0);
        $this->logger = $logger ?: new NullLogger();
    }

    function execute()
    {
        $this->logger->info('init', ['p' => $this->p]);

        while (isset($this->code[$this->ip])) {
            $op = $this->code[$this->ip++];

            switch ($op) {
                case '>':
                    $this->p++;
                    $this->logger->info('right', ['p' => $this->p]);
                    break;
                case '<':
                    $this->p--;
                    $this->logger->info('left', ['p' => $this->p]);
                    break;
                case '+':
                    $this->tape[$this->p]++;
                    $this->logger->info('inc', ['p' => $this->p]);
                    break;
                case '-':
                    $this->tape[$this->p]--;
                    $this->logger->info('dec', ['p' => $this->p]);
                    break;
                case '.':
                    $char = chr($this->tape[$this->p]);
                    echo $char;
                    $this->logger->info('output', ['p' => $this->p, 'char' => $char]);
                    break;
                case ',':
                    $char = fread(STDIN, 1);
                    $this->tape[$this->p] = ($char === "\x04") ? 0 : ord($char);
                    $this->logger->info('input', ['p' => $this->p, 'char' => ($char === "\x04") ? 'EOF' : $char]);
                    break;
                case '[':
                    if (!$this->tape[$this->p]) {
                        $nesting = 1;
                        while ($nesting) {
                            $char = $this->code[$this->ip++];

                            if ($char === '[') $nesting++;
                            if ($char === ']') $nesting--;
                        }
                    }
                    $this->logger->info('while', ['p' => $this->p]);
                    break;
                case ']':
                    if ($this->tape[$this->p]) {
                        $this->ip--;
                        $nesting = 1;
                        while ($nesting) {
                            $char = $this->code[--$this->ip];

                            if ($char === ']') $nesting++;
                            if ($char === '[') $nesting--;
                        }
                    }
                    $this->logger->info('endwhile', ['p' => $this->p]);
                    break;
                default:
                    // noop
                    break;
            }
        }
    }
}
