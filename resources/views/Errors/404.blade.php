<x-guest-layout>
    <section class="dark:bg-gray-900">
        <div class="px-4 mx-auto max-w-screen-lg lg:py-2 lg:px-12">
            <div class="mx-auto max-w-screen-sm text-center flex flex-col items-center">
                <a href="/" class="mx-auto text-center mb-3">
                    <img src="{{ asset('img_assets/AdmissionLogo.png') }}" class="w-auto max-h-80" alt="Logo">
                </a>
                <h1 class="mt-1 text-6xl tracking-tight font-extrabold sm:text-8xl text-red-800 dark:text-red-800">404</h1>
                <p class="mb-2 text-md tracking-tight font-bold text-gray-700 sm:text-2xl dark:text-slate-300">Not found!</p>
                <p class="mb-4 text-sm md:text-lg font-light text-gray-500 dark:text-gray-400">The page you're looking for couldn't be found. You can explore more on our home page. </p>
                <a href="{{ route('dashboard') }}" class="inline-flex text-white bg-red-800 hover:bg-red-900  dark:text-slate-300 focus:ring-4 focus:outline-none focus:ring-red-800 font-medium rounded-lg text-sm md:text-md px-2 py-2 md:px-5 md:py-2 text-center dark:focus:ring-red-900 my-4">Return to Homepage</a>
            </div>
        </div>
    </section>
</x-guest-layout>

