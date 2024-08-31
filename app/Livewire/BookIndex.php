<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Book;

class BookIndex extends Component
{   
    public $liveModal = false;
    public $title;
    public $newImage;
    public $price;
    public $description;

    public function render()
    {
        return view('livewire.book-index');
    }
}
