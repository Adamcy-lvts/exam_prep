<div>
    <style>
        section {
            background-color: #171717 !important;
        }

        /* Dropdown background */
        .choices__list--dropdown,
        .choices__list[aria-expanded] {
            background-color: #171717 !important;
            /* Dark background */
        }

        /* Dropdown items */
        .choices__list--dropdown .choices__item,
        .choices__list[aria-expanded] .choices__item {
            color: #ffffff !important;
            /* Light text */
        }

        /* Highlighted items on hover or keyboard navigation */
        .choices__list--dropdown .choices__item--selectable.is-highlighted,
        .choices__list[aria-expanded] .choices__item--selectable.is-highlighted {
            background-color: #343434 !important;
            /* Slightly lighter background for highlighted item */
            color: #ffffff !important;
            /* Light text */
        }

        /* Selected item */
        .choices__list--dropdown .choices__item--selectable.is-selected,
        .choices__list[aria-expanded] .choices__item--selectable.is-selected {
            background-color: #262626 !important;
            /* Even lighter background for selected item */
            color: #ffffff !important;
            /* Light text */
        }

        /* Styles for selected items in a multiple choice list */
        .choices__list--multiple .choices__item {
            background-color: #16a34a !important;
            /* Dark background for selected item */
            color: #ffffff !important;
            /* Light text for selected item */
            border: none !important;
            /* Remove border if any */
        }
/* 
        .choices[data-type*='select-multiple'] .choices__button {

            color: red !important;
        } */
    </style>
    <div class="min-h-screen bg-black flex items-center justify-center">
        <div class="container w-full max-w-3xl px-6 py-12  bg-neutral-900 rounded-xl">
            <form class="bg-neutral-900" wire:submit.prevent="create">
                {{ $this->form }}
                <button
                    class="w-full my-6 bg-green-600 text-white py-2 px-4 rounded-lg text-sm font-semibold cursor-pointer focus:outline-none focus:ring-2 focus:ring-green-700 focus:ring-opacity-75 hover:bg-green-700 transition duration-300 ease-in-out"
                    type="submit">
                    Submit
                </button>
            </form>
        </div>
    </div>



    <x-filament-actions::modals />
</div>
