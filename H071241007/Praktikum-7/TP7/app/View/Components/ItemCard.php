<?php

namespace App\View\Components;

use Illuminate\View\Component;

class ItemCard extends Component
{
    public $title;
    public $imageUrl;
    public $description;

    /**
     * Buat instance komponen baru.
     *
     * @param string $title
     * @param string $imageUrl
     * @param string $description
     * @return void
     */
    public function __construct($title, $imageUrl, $description)
    {
        $this->title = $title;
        $this->imageUrl = $imageUrl;
        $this->description = $description;
    }

    /**
     * Dapatkan view / konten yang merepresentasikan komponen.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.item-card');
    }
}