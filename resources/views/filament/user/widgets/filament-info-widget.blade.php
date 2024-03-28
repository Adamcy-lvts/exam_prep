<x-filament-widgets::widget class="fi-filament-info-widget">
    <x-filament::section class="bg-gray-100 rounded-lg">
        <div class="flex gap-4">
            <p class="text-xl font-semibold">Subscription Status:</p>
            @if ($user->subscriptions->count() > 0)
                @php
                    $latestSubscription = $user->subscriptions()->latest()->first();
                    $status = $latestSubscription->status;
                    $badgeStyle = $status === 'active' ? 'bg-green-500' : 'bg-red-500';
                @endphp
                <span class="text-lg inline-block px-2 py-1 rounded-full text-white {{ $badgeStyle }}">
                    {{ ucfirst($status) }}
                </span>
            @else
                <p class="text-lg">No subscriptions found.</p>
            @endif
        </div>
    </x-filament::section>
</x-filament-widgets::widget>
