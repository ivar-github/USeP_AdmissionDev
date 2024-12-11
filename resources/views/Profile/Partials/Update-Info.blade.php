<section>
    <header>
        <h2 class="text-xl mt-2 font-medium text-gray-900 dark:text-gray-100">
            Profile Information
        </h2>
        <p class="mt-1 text-md mb-10 text-gray-600 dark:text-gray-400">
            Update your account's profile information and email address.
        </p>
        @if (session('status') === 'profile-updated')
            <p
                x-data="{ show: true }"
                x-show="show"
                x-transition
                x-init="setTimeout(() => show = false, 2000)"
                class="text-sm text-gray-600 dark:text-gray-400"
            >{{ __('Updated Successfully.') }}</p>
        @endif
    </header>

    {{-- <form id="send-verification" method="post" action="{{ route('verification.send') }}">
        @csrf
    </form> --}}

    <form method="post" action="{{ route('profile.update') }}" class="mt-6 space-y-6">
        @csrf
        @method('patch')

        <div>
            <x-Input-Label for="name">Full Name</x-Input-Label>
            <x-Validation-Error class="mt-2" :messages="$errors->get('name')" />
            <x-Input-Field id="name" name="name" type="text" class="mt-1 block w-full" :value="old('name', $user->name)" required  autocomplete="name"  />
        </div>

        <div>
            <x-input-label for="email" >Email Address</x-Input-Label>
            <x-Input-Field id="email" name="email" type="email" class="mt-1 block w-full" :value="old('email', $user->email)" required autocomplete="username"  />
            <x-Validation-Error class="mt-2" :messages="$errors->get('email')" />
        </div>

        <div class="flex items-center gap-4">
            <x-Input-Submit>Update</x-Input-Submit>
        </div>
    </form>
</section>
