<x-card title="Login" shadow class="mx-auto w-[450px]">

    @if($errors->hasAny(['invalidCredentials', 'rateLimiter']))
        <x-alert icon="o-home" class="alert-warning mb-4">
            @error('invalidCredentials')
            <span>{{ $message  }}</span>
            @enderror

            @error('rateLimiter')
            <span>{{ $message  }}</span>
            @enderror
        </x-alert>
    @endif

    <x-form wire:submit="tryToLogin">
        <x-input label="Email" wire:model="email"/>
        <x-input label="Password" wire:model="password" type="password"/>
        <x-slot:actions>
            <div class="w-full flex items-center justify-between">
                <a wire:navigate href="{{ route('auth.register') }}" class="link link-primary link-hover">
                    I Want to create an account
                </a>
                <div>
                    <x-button label="Login" class="btn-primary w-32" type="submit" spinner="submit"/>
                </div>
            </div>
        </x-slot:actions>
    </x-form>
</x-card>
