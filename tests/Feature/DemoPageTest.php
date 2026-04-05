<?php

namespace Tests\Feature;

use Tests\TestCase;

class DemoPageTest extends TestCase
{
    public function test_demo_page_renders_successfully(): void
    {
        $response = $this->get('/');

        $response
            ->assertOk()
            ->assertSee('Каталог сценариев для команды продукта')
            ->assertSee('Внутренняя витрина')
            ->assertSee('реальной прокрутки страницы')
            ->assertDontSee('wire:intersect', false);
    }
}
