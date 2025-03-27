<section >
    <header>
        <h2 class="text-xl mt-2 font-medium text-gray-900 dark:text-gray-100">
            Update Password
        </h2>
        <p class="mt-1 text-md mb-10 text-gray-600 dark:text-gray-400">
            Ensure your account is using a long, random password to stay secure.
        </p>
        @if (session('status') === 'password-updated')
            <p
                x-data="{ show: true }"
                x-show="show"
                x-transition
                x-init="setTimeout(() => show = false, 10000)"
                class="text-sm text-gray-600 dark:text-gray-400"
            >{{ __('Updated Successfully.') }}</p>
        @endif
    </header>

    <form method="post" action="{{ route('password.update') }}" class="mt-6 space-y-6">
        @csrf
        @method('put')
        <div>
            <x-Input-Label for="update_password_current_password">Current Password</x-Input-Label>
            <x-Validation-Error class="mt-2" :messages="$errors->updatePassword->get('current_password')" />
            <x-Input-Field id="update_password_current_password" name="current_password" type="password" class="mt-1 block w-full" autocomplete="current-password" />
        </div>
        <div>
            <x-Input-Label for="update_password_password">New Password</x-Input-Label>
            <x-Validation-Error :messages="$errors->updatePassword->get('password')" class="mt-2" />
            <x-Input-Field id="update_password_password" name="password" type="password" class="mt-1 block w-full" autocomplete="new-password" />
        </div>

        <div>
            <x-Input-Label for="update_password_password_confirmation">Confirm Password</x-Input-Label>
            <x-Validation-Error :messages="$errors->updatePassword->get('password_confirmation')" class="mt-2" />
            <x-Input-Field id="update_password_password_confirmation" name="password_confirmation" type="password" class="mt-1 block w-full" autocomplete="new-password" />
        </div>

        <div class="flex items-center gap-4">
            <x-Input-Submit>Update</x-Input-Submit>
        </div>
    </form>
</section>
