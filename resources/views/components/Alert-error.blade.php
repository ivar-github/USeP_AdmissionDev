<div  
    x-data="{ show: true }"
    x-show="show"
    x-transition
    x-init="setTimeout(() => show = false, 5000)"
    tabindex="-1"
    class="flex align-items-center justify-content-center overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
    <div class="relative p-4 w-full max-w-md max-h-full">
        <div class="relative bg-red-500 rounded-lg shadow dark:bg-red-500">
            <button type="button" class="absolute top-3 end-2.5 text-gray-800 bg-transparent  hover:text-gray-700  text-sm w-8 h-8 ms-auto rounded-full inline-flex justify-center items-center hover:bg-gray-500 dark:text-gray-200 dark:hover:text-white dark:hover:bg-gray-500 transition-transform duration-1500"  >
                <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                </svg>
                <span class="sr-only">Close modal</span>
            </button>
            <div class="p-4 md:p-5 text-center">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 -960 960 960" class="mx-auto mb-4 w-20 h-20 text-gray-800 w-15 h-15 dark:text-gray-400">
                    <path fill="currentColor" d="M480-360q17 0 28.5-11.5T520-400q0-17-11.5-28.5T480-440q-17 0-28.5 11.5T440-400q0 17 11.5 28.5T480-360Zm-40-160h80v-240h-80v240ZM80-80v-720q0-33 23.5-56.5T160-880h640q33 0 56.5 23.5T880-800v480q0 33-23.5 56.5T800-240H240L80-80Zm126-240h594v-480H160v525l46-45Zm-46 0v-480 480Z"/>
                </svg>
                <h3 class="mb-5 text-lg font-normal text-gray-800 dark:text-gray-400">{{$slot}}</h3>
            </div>
        </div>
    </div>
</div>
@push('scripts')

    <script>
        document.querySelectorAll('[data-modal-hide]').forEach(button => {
            button.addEventListener('click', () => {
                const modal = document.getElementById(button.getAttribute('data-modal-hide'));
                if (modal) {
                    modal.classList.add('hidden');
                }
            });
        });
    </script>

@endpush
