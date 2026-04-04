<section class="space-y-8">
    <div class="grid gap-4 md:grid-cols-3">
        <x-demo.stat
            label="Всего карточек"
            :value="$totalCount"
            caption="Небольшая рабочая подборка для проверки поведения списка."
            tone="sky"
        />

        <x-demo.stat
            label="Найдено"
            :value="$filteredCount"
            caption="Счётчик сразу реагирует на поиск и выбранную тему."
            tone="emerald"
        />

        <x-demo.stat
            label="Страниц впереди"
            :value="$remainingPages"
            caption="Следующая страница доступна по кнопке или при прокрутке вниз."
            tone="amber"
        />
    </div>

    <div class="grid gap-6 xl:grid-cols-[minmax(0,1fr)_19rem]">
        <div class="space-y-6">
            <div class="rounded-[1.75rem] border border-zinc-200/75 bg-white/92 p-5 shadow-sm shadow-zinc-950/5 backdrop-blur sm:p-6">
                <div class="grid gap-4 lg:grid-cols-[minmax(0,1fr)_auto] lg:items-end">
                    <label class="space-y-2">
                        <span class="text-sm font-semibold text-zinc-800">Поиск по операциям</span>
                        <input
                            type="text"
                            wire:model.live.debounce.300ms="search"
                            placeholder="Например, рейс, склад, температура или SLA"
                            class="w-full rounded-xl border border-zinc-200 bg-zinc-50 px-4 py-3 text-sm text-zinc-900 outline-none ring-0 transition placeholder:text-zinc-400 focus:border-sky-500"
                        >
                    </label>

                    <flux:button variant="subtle" wire:click="resetFilters" icon="arrow-path">
                        Сбросить фильтры
                    </flux:button>
                </div>

                <div class="mt-5 flex flex-wrap gap-2">
                    @foreach ($topics as $item)
                        <flux:button
                            wire:key="topic-{{ $item['value'] }}"
                            wire:click="$set('topic', '{{ $item['value'] }}')"
                            :variant="$topic === $item['value'] ? 'primary' : 'outline'"
                            color="sky"
                            size="sm"
                        >
                            {{ $item['label'] }}
                        </flux:button>
                    @endforeach
                </div>
            </div>

            @if ($pagePosts->isEmpty())
                <div class="rounded-[1.75rem] border border-dashed border-zinc-300 bg-white/70 px-6 py-10 text-center text-zinc-600">
                    Ничего не нашлось. Попробуйте другой запрос или снимите фильтр.
                </div>
            @else
                <div class="grid gap-4 md:grid-cols-2">
                    @foreach ($pagePosts as $post)
                        <flux:card wire:key="post-{{ $post['id'] }}" class="h-full">
                            <div class="flex h-full flex-col gap-5">
                                <div class="space-y-3">
                                    <div class="flex items-center justify-between gap-3">
                                        <span class="rounded-full bg-zinc-100 px-3 py-1 text-[11px] font-semibold uppercase tracking-[0.22em] text-zinc-500">
                                            {{ $post['topic'] }}
                                        </span>
                                        <span class="text-xs font-medium text-zinc-400">
                                            {{ $post['minutes'] }} мин
                                        </span>
                                    </div>

                                    <div class="space-y-2">
                                        <h2 class="text-xl font-semibold tracking-tight text-zinc-950">
                                            {{ $post['title'] }}
                                        </h2>
                                        <p class="text-sm leading-6 text-zinc-600">
                                            {{ $post['excerpt'] }}
                                        </p>
                                    </div>
                                </div>

                                <div class="mt-auto flex items-center justify-between gap-3 border-t border-zinc-100 pt-4">
                                    <span class="text-xs font-semibold uppercase tracking-[0.18em] text-zinc-400">
                                        статус: {{ $post['status'] }}
                                    </span>

                                    <flux:button
                                        variant="primary"
                                        color="sky"
                                        size="sm"
                                        wire:click="selectPost({{ $post['id'] }})"
                                        icon:trailing="arrow-right"
                                    >
                                        Детали
                                    </flux:button>
                                </div>
                            </div>
                        </flux:card>
                    @endforeach
                </div>

                <div class="rounded-[1.5rem] border border-zinc-200/80 bg-white/80 px-5 py-4 shadow-sm shadow-zinc-950/5">
                    <div class="flex flex-col gap-4 lg:flex-row lg:items-center lg:justify-between">
                        <p class="text-sm text-zinc-600">
                            Показаны материалы
                            <span class="font-semibold text-zinc-900">{{ $showingFrom }}-{{ $showingTo }}</span>
                            из
                            <span class="font-semibold text-zinc-900">{{ $filteredCount }}</span>.
                            Страница {{ $currentPage }} из {{ $totalPages }}.
                        </p>

                        <div class="flex flex-wrap items-center gap-2">
                            <flux:button
                                variant="outline"
                                size="sm"
                                wire:click="previousPage"
                                :disabled="! $hasPreviousPage"
                            >
                                Назад
                            </flux:button>

                            @foreach ($pageNumbers as $pageNumber)
                                <flux:button
                                    wire:key="page-{{ $pageNumber }}"
                                    wire:click="goToPage({{ $pageNumber }})"
                                    :variant="$currentPage === $pageNumber ? 'primary' : 'outline'"
                                    color="sky"
                                    size="sm"
                                >
                                    {{ $pageNumber }}
                                </flux:button>
                            @endforeach

                            <flux:button
                                variant="outline"
                                size="sm"
                                wire:click="nextPage"
                                :disabled="! $hasMorePages"
                            >
                                Дальше
                            </flux:button>
                        </div>
                    </div>
                </div>
            @endif

            @if ($hasMorePages)
                <div
                    wire:intersect.margin.200px="nextPage"
                    class="rounded-[1.5rem] border border-dashed border-zinc-300/80 bg-white/65 px-6 py-5 text-center"
                >
                    <p class="text-sm font-medium text-zinc-600">
                        Можно перейти дальше кнопками выше или просто дойти до конца блока, чтобы открыть следующую страницу.
                    </p>
                </div>
            @else
                <div class="rounded-[1.5rem] border border-zinc-200/80 bg-white/70 px-6 py-5 text-center text-sm text-zinc-600">
                    Это последняя страница по текущему фильтру.
                </div>
            @endif
        </div>

        <aside class="rounded-[1.75rem] border border-zinc-200/75 bg-zinc-950 p-6 text-zinc-50 shadow-lg">
            <div class="space-y-5">
                <div class="space-y-2">
                    <p class="text-sm font-semibold uppercase tracking-[0.22em] text-zinc-400">Состояние</p>
                    <p class="text-sm leading-6 text-zinc-300">
                        Поиск, активная тема и текущая страница живут в одном компоненте и синхронно управляют экраном.
                    </p>
                </div>

                <div class="space-y-2">
                    <p class="text-sm font-semibold uppercase tracking-[0.22em] text-zinc-400">Сводка</p>
                    <p class="text-sm leading-6 text-zinc-300">
                        Верхние показатели и текущая выдача пересчитываются из состояния без ручного дублирования данных.
                    </p>
                </div>

                <div class="space-y-2">
                    <p class="text-sm font-semibold uppercase tracking-[0.22em] text-zinc-400">Детали</p>
                    <p class="text-sm leading-6 text-zinc-300">
                        Клик по карточке открывает отдельное окно с полным описанием, не перегружая основной список.
                    </p>
                </div>

                <div class="rounded-2xl border border-white/10 bg-white/5 p-4 text-sm text-zinc-300">
                    Верхняя сводка вынесена в отдельный Blade-компонент, чтобы экран было проще поддерживать и переиспользовать.
                </div>
            </div>
        </aside>
    </div>
</section>
