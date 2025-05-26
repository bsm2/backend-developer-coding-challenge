<?php

namespace App\Livewire\Platforms;

use App\Http\Services\PlatformService;
use Livewire\Attributes\Layout;
use Livewire\Component;

class Settings extends Component
{
    #[Layout('layouts.app')]
    public $platforms;
    public function render()
    {
        $platformService = new PlatformService();
        $platforms = $platformService->platforms()->map(fn($q) => ['id' => $q->id, 'name' => $q->name, 'active' => $q->users->first()?->active == 1 ? 1 : 0]);
        $this->platforms = $platforms;
        return view('livewire.platforms.settings', ['platforms' => $platforms]);
    }

    public function togglePlatforms()
    {
        $platformService = new PlatformService();
        $platformService->toggle($this->platforms->toArray());
        session()->flash('success', 'Settings successfully updated.');
    }
}
