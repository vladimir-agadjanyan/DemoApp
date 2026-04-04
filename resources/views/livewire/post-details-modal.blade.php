<div>
    @if ($post)
        <flux:modal wire:model="open">
            <div class="space-y-5">
                <div class="space-y-3">
                    <div class="flex items-center gap-2 text-xs font-semibold uppercase tracking-[0.2em] text-zinc-400">
                        <span>{{ $post['topic'] }}</span>
                        <span class="text-zinc-300">/</span>
                        <span>{{ $post['status'] }}</span>
                    </div>

                    <div class="space-y-2">
                        <h2 class="text-2xl font-semibold tracking-tight text-zinc-950 dark:text-white">
                            {{ $post['title'] }}
                        </h2>
                        <p class="text-sm leading-6 text-zinc-500 dark:text-zinc-300">
                            {{ $post['excerpt'] }}
                        </p>
                    </div>
                </div>

                <div class="rounded-2xl border border-zinc-200/80 bg-zinc-50 px-4 py-4 text-sm leading-7 text-zinc-700 dark:border-zinc-700 dark:bg-zinc-900 dark:text-zinc-200">
                    {{ $post['body'] }}
                </div>

                <div class="flex items-center justify-between gap-3 border-t border-zinc-100 pt-4 dark:border-zinc-800">
                    <span class="text-xs font-semibold uppercase tracking-[0.18em] text-zinc-400">
                        Время чтения: {{ $post['minutes'] }} мин
                    </span>

                    <flux:button variant="primary" color="sky" wire:click="close">
                        Закрыть
                    </flux:button>
                </div>
            </div>
        </flux:modal>
    @endif
</div>
