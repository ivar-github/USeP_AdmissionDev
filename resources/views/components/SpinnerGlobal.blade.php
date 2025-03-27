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

<div id="SpinnerGlobal" class="fixed inset-0 flex items-center justify-center --bg-gray-900 bg-opacity-50 hidden z-50">
    <div class="animate-spin rounded-full h-16 w-16 border-t-4 border-red-500"></div>
</div>


{{-- <div id="SpinnerGlobal" class="fixed inset-0 flex items-center justify-center --bg-gray-900 bg-opacity-50 hidden z-50">  
        <div class="hourglass-container">
        <div class="hourglass">
            <div class="top-sand"></div>
            <div class="bottom-sand"></div>
        </div>
        </div>
    </div>
    
    <style>
        .hourglass-container {
        position: relative;
        width: 64px;
        height: 64px;
        }
    
        .hourglass {
        position: relative;
        width: 0;
        height: 0;
        border-left: 32px solid transparent;
        border-right: 32px solid transparent;
        border-top: 32px solid transparent;
        border-bottom: 32px solid transparent;
        }
    
        .hourglass::before,
        .hourglass::after {
        content: '';
        position: absolute;
        left: 0;
        right: 0;
        width: 100%;
        height: 100%;
        background-color: transparent;
        }
    
        .hourglass::before {
        top: 0;
        background: linear-gradient(to bottom, transparent 0%, transparent 50%, #f00 50%, #f00 100%);
        animation: sandfall 2s infinite ease-in-out;
        }
    
        .hourglass::after {
        bottom: 0;
        background: linear-gradient(to top, transparent 0%, transparent 50%, #f00 50%, #f00 100%);
        animation: sandfall 2s infinite ease-in-out reverse;
        }
    
        @keyframes sandfall {
        0% {
            transform: scaleY(0);
        }
        50% {
            transform: scaleY(1);
        }
        100% {
            transform: scaleY(0);
        }
        }
    </style>
</div> --}}