<?php
namespace App\Interfaces;

interface HighlightInterface
{
    function hl(string $content):string;
}