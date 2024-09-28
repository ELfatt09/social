<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class LinkifyContent extends Component
{
    public $content;

    /**
     * Create a new component instance.
     */
    public function __construct($content)
    {
        $this->content = $this->makeLinks($content);
    }

    /**
     * Transform URLs into clickable links.
     */
    protected function makeLinks($text)
    {
        $urlPattern = '~(https?://[a-zA-Z0-9\/\-]+(?:\.[a-zA-Z0-9\/\-]+)*(?:\/[a-zA-Z0-9\/\-._]+)*(?:\?[a-zA-Z0-9\/\-&=]+)?(?:#[a-zA-Z0-9\/\-._]+)?)~';
        return preg_replace(
            $urlPattern,
            '<a href="$0" target="_blank" rel="noopener noreferrer" class="text-decoration-none text-primary">$0</a>',
            $text
        );
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.linkify-content');
    }
}

