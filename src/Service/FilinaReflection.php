<?php
namespace App\Service;

use App\Interfaces\ReflectionInterface;

class FilinaReflection implements ReflectionInterface
{
    public function getMethodLines($class, string $method, int $offset = 0, int $length = 0, $trim = false)
    {
        $func = new \ReflectionMethod($class, $method);
        $filename = $func->getFileName();
        $methodStart = $func->getStartLine();
        $methodEnd = $func->getEndLine();

        $source = file($filename);
        $lines = array_slice($source, $methodStart + $offset, $length);

        if ($trim) {
            $numSpaces = strspn($lines[0], ' ');
            $lines = array_map(function(string $line) use ($numSpaces) {
                return substr($line, $numSpaces);
            }, $lines);
        }

        $body = implode("", $lines);
        return $body;
    }
}