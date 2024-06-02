<?php

namespace App\Livewire;

use Livewire\Component;

class LoadingScreen extends Component
{
    public $loading = true;

    public function mount()
    {
        // Simulate a delay (e.g., fetching data from database)
        sleep(3); // Sleep for 3 seconds
        $this->loading = false; // Hide loading screen after delay
    }
    public function render()
    {
        return view('livewire.loading-screen');
    }
}
