<?php
namespace App\Interfaces;

interface ReflectionInterface
{
    function getMethodLines($class, string $method, int $offset = 0, int $length = 0);
}