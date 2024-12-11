<div 
    x-data="{ show: true }"
    x-show="show"
    x-transition
    x-init="setTimeout(() => show = false, 5000)"
    tabindex="-1"
    class="flex align-items-center justify-content-center overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
    <div class="relative p-4 w-full max-w-md max-h-full">
        <div class="relative bg-green-300 rounded-lg shadow dark:bg-green-800">
            <button type="button" class="absolute top-3 end-2.5 text-gray-800 bg-transparent  hover:text-gray-700  text-sm w-8 h-8 ms-auto rounded-full inline-flex justify-center items-center hover:bg-gray-500 dark:text-gray-200 dark:hover:text-white dark:hover:bg-gray-500 transition-transform duration-1500"  >
                <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                </svg>
                <span class="sr-only">Close modal</span>
            </button>
            <div class="p-4 md:p-5 text-center">
                <svg xmlns="http://www.w3.org/2000/svg"  viewBox="0 -960 960 960" class="mx-auto mb-4 w-20 h-20 text-gray-600 w-15 h-15 dark:text-gray-200"  >
                    <path fill="currentColor" d="m424-296 282-282-56-56-226 226-114-114-56 56 170 170Zm56 216q-83 0-156-31.5T197-197q-54-54-85.5-127T80-480q0-83 31.5-156T197-763q54-54 127-85.5T480-880q83 0 156 31.5T763-763q54 54 85.5 127T880-480q0 83-31.5 156T763-197q-54 54-127 85.5T480-80Zm0-80q134 0 227-93t93-227q0-134-93-227t-227-93q-134 0-227 93t-93 227q0 134 93 227t227 93Zm0-320Z"/>
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