<?php

namespace Tests\Feature;

use App\Livewire\DemoCatalog;
use App\Livewire\PostDetailsModal;
use Tests\TestCase;

class LivewireDemoTest extends TestCase
{
    public function test_catalog_filters_posts_and_changes_pages(): void
    {
        $component = new DemoCatalog();

        $this->assertSame(1, $component->page);
        $this->assertSame(12, $component->filteredCount());
        $this->assertSame(2, $component->totalPages());
        $this->assertSame(1, $component->showingFrom());
        $this->assertSame(6, $component->showingTo());

        $component->nextPage();

        $this->assertSame(2, $component->page);
        $this->assertSame(7, $component->showingFrom());
        $this->assertSame(12, $component->showingTo());
        $this->assertFalse($component->hasMorePages());

        $component->search = 'рефрижератор';
        $component->updatedSearch();

        $this->assertSame(1, $component->page);
        $this->assertSame(1, $component->totalPages());
        $this->assertSame(1, $component->showingFrom());
        $this->assertSame(1, $component->showingTo());
        $this->assertSame(['Рефрижераторный рейс в Екатеринбург'], $component->filteredPosts()->pluck('title')->all());
    }

    public function test_catalog_can_filter_posts_by_topic(): void
    {
        $component = new DemoCatalog();
        $component->goToPage(2);
        $component->topic = 'контроль';
        $component->updatedTopic();

        $this->assertSame(1, $component->page);
        $this->assertSame(4, $component->filteredCount());
        $this->assertSame(1, $component->totalPages());
        $this->assertSame([
            'Контроль SLA по доставкам',
            'Оповещение о простое транспорта',
            'Мониторинг температурных рейсов',
            'Сводка по возвратам и отклонениям',
        ], $component->filteredPosts()->pluck('title')->all());
    }

    public function test_catalog_returns_to_the_first_page_when_all_topic_is_selected(): void
    {
        $component = new DemoCatalog();
        $component->goToPage(2);
        $component->setTopic('all');

        $this->assertSame(1, $component->page);
        $this->assertSame(1, $component->currentPage());
        $this->assertSame([
            'Маршрут Москва - Казань',
            'Рефрижераторный рейс в Екатеринбург',
            'Окно отгрузки на складе Восток',
            'Пересортировка паллет перед отправкой',
            'Контроль SLA по доставкам',
            'Оповещение о простое транспорта',
        ], $component->pagePosts()->pluck('title')->all());
    }

    public function test_modal_opens_when_show_is_called_and_can_be_closed(): void
    {
        $component = new PostDetailsModal();

        $component->show(3);

        $this->assertTrue($component->open);
        $this->assertSame('Окно отгрузки на складе Восток', $component->post['title']);

        $component->close();

        $this->assertFalse($component->open);
        $this->assertNull($component->post);
    }
}
