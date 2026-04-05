@extends('layouts.app')

@section('content')
    <main class="mx-auto flex w-full max-w-7xl flex-col gap-10 px-4 py-8 sm:px-6 lg:px-8">
        <section class="relative overflow-hidden rounded-[2rem] border border-zinc-200/70 bg-white/88 p-8 shadow-[0_32px_80px_-48px_rgba(15,23,42,0.55)] backdrop-blur xl:p-12">
            <div class="absolute -left-16 top-0 h-48 w-48 rounded-full bg-sky-300/30 blur-3xl"></div>
            <div class="absolute right-0 top-8 h-56 w-56 rounded-full bg-emerald-300/20 blur-3xl"></div>

            <div class="relative grid gap-8 lg:grid-cols-[minmax(0,1.6fr)_minmax(20rem,0.9fr)]">
                <div class="space-y-5">
                    <p class="text-sm font-semibold uppercase tracking-[0.28em] text-zinc-500">Внутренняя витрина</p>
                    <h1 class="max-w-3xl text-4xl font-semibold tracking-tight text-zinc-950 sm:text-5xl">
                        Каталог сценариев для команды продукта
                    </h1>
                    <p class="max-w-2xl text-base leading-7 text-zinc-600 sm:text-lg">
                        Спокойный рабочий экран для просмотра заметок, быстрых фильтров и деталей по карточке.
                        Список обновляется без перезагрузки, а следующая порция подтягивается только после
                        <span class="font-semibold text-zinc-900">реальной прокрутки страницы</span>.
                    </p>
                </div>

                <div class="rounded-[1.75rem] border border-zinc-200/80 bg-zinc-950 px-6 py-6 text-zinc-50 shadow-lg">
                    <div class="space-y-4">
                        <p class="text-sm font-semibold uppercase tracking-[0.22em] text-zinc-400">Что на экране</p>
                        <ul class="space-y-3 text-sm leading-6 text-zinc-300">
                            <li>Лента карточек с единым оформлением и быстрыми действиями.</li>
                            <li>Поиск и фильтрация без лишних переходов между экранами.</li>
                            <li>Сводка сверху, которая сразу отражает текущее состояние списка.</li>
                            <li>Открытие деталей в отдельном окне по клику на карточку.</li>
                            <li>Мягкая догрузка следующей порции только после скролла пользователя.</li>
                        </ul>
                    </div>
                </div>
            </div>
        </section>

        <livewire:demo-catalog />
        <livewire:post-details-modal />
    </main>
@endsection
