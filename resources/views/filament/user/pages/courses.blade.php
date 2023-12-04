<x-filament-panels::page @class([
    'fi-resource-list-records-page',
    'fi-resource-' . str_replace('/', '-', $this->getResource()::getSlug()),
])>
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4 p-4">
        @foreach ($courses as $course)
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow rounded-lg">
                <div class="p-4">
                    <h3 class="text-lg leading-6 font-medium text-gray-900 dark:text-white">
                        {{ $course->title }}
                    </h3>
                    <p class="mt-1 text-md text-gray-500 dark:text-gray-400">
                        {{ $course->course_code }}
                    </p>
                </div>
                <div class="bg-gray-50 dark:bg-gray-700 px-4 py-4 sm:px-6">
                    <div class="text-sm">
                        <a href="{{ route('filament.user.resources.courses.instruction-page', $course->id) }}"
                            class="font-medium text-green-600 hover:text-green-500 dark:hover:text-green-400">
                            Take {{ $course->course_code }} → Exam
                        </a>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
    <div class="flex flex-col gap-y-6">
        <x-filament-panels::resources.tabs />

        {{ \Filament\Support\Facades\FilamentView::renderHook('panels::resource.pages.list-records.table.before', scopes: $this->getRenderHookScopes()) }}
       
            {{ $this->table }}
     
        {{ \Filament\Support\Facades\FilamentView::renderHook('panels::resource.pages.list-records.table.after', scopes: $this->getRenderHookScopes()) }}
    </div>
</x-filament-panels::page>
