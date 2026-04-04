<?php

namespace App\Livewire;

use App\Support\DemoPosts;
use Livewire\Attributes\On;
use Livewire\Component;

class PostDetailsModal extends Component
{
    public bool $open = false;
    public ?array $post = null;

    #[On('post-selected')]
    public function show(int $id): void
    {
        $post = DemoPosts::find($id);

        if (! $post) {
            return;
        }

        $this->post = $post;
        $this->open = true;
    }

    public function close(): void
    {
        $this->reset('open', 'post');
    }

    public function render()
    {
        return view('livewire.post-details-modal');
    }
}
