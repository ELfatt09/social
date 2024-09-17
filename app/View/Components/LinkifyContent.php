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
     * Fungsi untuk mengubah URL menjadi link aktif.
     */
    public function makeLinks($text)
    {
        $url_pattern = '/(http:\/\/|https:\/\/)([a-z0-9\_\-]+\.[a-z0-9\_\-]+\.[a-z0-9\_\-]+(?:\/[^\s]*)?)/i';

        return preg_replace($url_pattern, '<a href="$1$2" target="_blank" class="text-decoration-none text-primary">$1$2</a>', $text);
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.linkify-content');
    }
}
