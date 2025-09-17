<?php
// app/Http/Livewire/CkeditorEditor.php
namespace App\Http\Livewire;

use Livewire\Component;

class CkeditorEditor extends Component
{
    public $content = ''; // yahan define karna zaruri hai

    public function render()
    {
        return view('livewire.ckeditor-editor');
    }
}
