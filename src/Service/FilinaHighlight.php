<?php
namespace App\Service;

use App\Interfaces\HighlightInterface;
use Highlight\Highlighter;

class FilinaHighlight implements HighlightInterface
{
    private $hl;

    public function __construct()
    {
        $this->hl = new Highlighter();
    }

    function hl(string $content): string
    {
        $highlighted = $this->hl->highlightAuto($content, ['php', 'ruby', 'python', 'cs', 'css', 'javascript', 'actionscript']);
        $output = sprintf('<pre data-lang="%s" class="hljs">%s</pre>', $highlighted->language, $highlighted->value);
        return $output;
    }
}
