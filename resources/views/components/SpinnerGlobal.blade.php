{{-- <div x-data="{ loading: false }">
    <button @click="fetchData" class="px-4 py-2 bg-blue-500 text-white rounded">
        Fetch Data
    </button>

    <div x-show="loading" class="fixed inset-0 flex items-center justify-center bg-gray-900 bg-opacity-50">
        <div class="animate-spin rounded-full h-16 w-16 border-t-4 border-blue-500"></div>
    </div>

    <script>
        function fetchData() {
            let dataComponent = Alpine.store('data');
            dataComponent.loading = true;

            axios.get('/your-api-endpoint')
                .then(response => {
                    console.log(response.data);
                })
                .finally(() => {
                    dataComponent.loading = false;
                });
        }
    </script>
</div> --}}


{{-- <div id="loadingSpinner" class="fixed inset-0 flex items-center justify-center bg-gray-900 bg-opacity-50 hidden">
    <div class="animate-spin rounded-full h-16 w-16 border-t-4 border-blue-500"></div>
</div> --}}

<div id="SpinnerGlobal" class="fixed inset-0 flex items-center justify-center bg-gray-900 bg-opacity-50 hidden z-50">
    <div class="animate-spin rounded-full h-16 w-16 border-t-4 border-blue-500"></div>
</div>
