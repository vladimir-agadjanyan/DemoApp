<?php

namespace App\Livewire;

use App\Support\DemoPosts;
use Illuminate\Support\Collection;
use Livewire\Attributes\Computed;
use Livewire\Component;

class DemoCatalog extends Component
{
    private const PER_PAGE = 6;

    public string $search = '';
    public string $topic = 'all';
    public int $page = 1;

    public function updatedSearch(): void
    {
        $this->resetPagination();
    }

    public function updatedTopic(): void
    {
        $this->resetPagination();
    }

    public function loadMore(): void
    {
        $this->nextPage();
    }

    public function resetFilters(): void
    {
        $this->search = '';
        $this->topic = 'all';
        $this->resetPagination();
    }

    public function goToPage(int $page): void
    {
        $this->page = min(max($page, 1), $this->totalPages());
    }

    public function nextPage(): void
    {
        if (! $this->hasMorePages()) {
            return;
        }

        $this->page = $this->currentPage() + 1;
    }

    public function previousPage(): void
    {
        if (! $this->hasPreviousPage()) {
            return;
        }

        $this->page = $this->currentPage() - 1;
    }

    public function selectPost(int $postId): void
    {
        $this->dispatch('post-selected', id: $postId);
    }

    #[Computed]
    public function topics(): Collection
    {
        return collect([
            ['value' => 'all', 'label' => 'Все'],
            ['value' => 'перевозки', 'label' => 'Перевозки'],
            ['value' => 'склад', 'label' => 'Склад'],
            ['value' => 'контроль', 'label' => 'Контроль'],
        ]);
    }

    #[Computed]
    public function totalCount(): int
    {
        return DemoPosts::all()->count();
    }

    #[Computed]
    public function filteredPosts(): Collection
    {
        return DemoPosts::all()
            ->when($this->topic !== 'all', fn (Collection $posts) => $posts->where('topic', $this->topic))
            ->filter(function (array $post) {
                if ($this->search === '') {
                    return true;
                }

                $needle = mb_strtolower($this->search);
                $haystack = mb_strtolower($post['title'].' '.$post['excerpt'].' '.$post['body']);

                return str_contains($haystack, $needle);
            })
            ->values();
    }

    #[Computed]
    public function filteredCount(): int
    {
        return $this->filteredPosts()->count();
    }

    #[Computed]
    public function totalPages(): int
    {
        return max((int) ceil($this->filteredCount() / self::PER_PAGE), 1);
    }

    #[Computed]
    public function currentPage(): int
    {
        return min(max($this->page, 1), $this->totalPages());
    }

    #[Computed]
    public function pagePosts(): Collection
    {
        return $this->filteredPosts()
            ->slice(($this->currentPage() - 1) * self::PER_PAGE, self::PER_PAGE)
            ->values();
    }

    #[Computed]
    public function hasMorePages(): bool
    {
        return $this->currentPage() < $this->totalPages();
    }

    #[Computed]
    public function hasPreviousPage(): bool
    {
        return $this->currentPage() > 1;
    }

    #[Computed]
    public function remainingPages(): int
    {
        return max($this->totalPages() - $this->currentPage(), 0);
    }

    #[Computed]
    public function pageNumbers(): Collection
    {
        return collect(range(1, $this->totalPages()));
    }

    #[Computed]
    public function showingFrom(): int
    {
        if ($this->filteredCount() === 0) {
            return 0;
        }

        return (($this->currentPage() - 1) * self::PER_PAGE) + 1;
    }

    #[Computed]
    public function showingTo(): int
    {
        return min($this->currentPage() * self::PER_PAGE, $this->filteredCount());
    }

    #[Computed]
    public function hiddenCount(): int
    {
        return max($this->filteredCount() - $this->showingTo(), 0);
    }

    public function render()
    {
        return view('livewire.demo-catalog', [
            'topics' => $this->topics(),
            'totalCount' => $this->totalCount(),
            'filteredCount' => $this->filteredCount(),
            'currentPage' => $this->currentPage(),
            'pagePosts' => $this->pagePosts(),
            'pageNumbers' => $this->pageNumbers(),
            'totalPages' => $this->totalPages(),
            'showingFrom' => $this->showingFrom(),
            'showingTo' => $this->showingTo(),
            'hasMorePages' => $this->hasMorePages(),
            'hasPreviousPage' => $this->hasPreviousPage(),
            'remainingPages' => $this->remainingPages(),
            'hiddenCount' => $this->hiddenCount(),
        ]);
    }

    private function resetPagination(): void
    {
        $this->page = 1;
    }
}
