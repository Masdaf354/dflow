<?php

namespace App\Livewire;

use Livewire\Component;

class GitDocumentation extends Component
{
    public string $activeTab = 'gitflow';

    public function render()
    {
        return view('livewire.git-documentation');
    }
}
