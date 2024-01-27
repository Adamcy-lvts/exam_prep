<x-filament-panels::page class="fi-dashboard-page">
    @if (method_exists($this, 'filtersForm'))
        {{ $this->filtersForm }}
    @endif
    <div class="space-y-4">
        @if ($subjects->isNotEmpty())
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 xl:grid-cols-4 gap-4">
                @foreach ($subjects as $subject)
                    @livewire('registered-subjects-widget', ['subject' => $subject], key($subject->id))
                @endforeach
            </div>
        @elseif ($courses->isNotEmpty())
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 xl:grid-cols-4 gap-4">
                @foreach ($courses as $course)
                    @livewire('registered-courses-widget', ['course' => $course], key($course->id))
                @endforeach
            </div>
        @endif

    </div>
    <x-filament-widgets::widgets :columns="$this->getColumns()" :data="[...property_exists($this, 'filters') ? ['filters' => $this->filters] : [], ...$this->getWidgetData()]" :widgets="$this->getVisibleWidgets()" />
</x-filament-panels::page>
