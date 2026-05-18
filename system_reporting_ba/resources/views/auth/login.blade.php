<x-guest-layout>
    <div class="mb-8 text-center">
        <h2 class="text-3xl font-extrabold text-gray-900 dark:text-white">
            Selamat Datang
        </h2>
        <p class="mt-2 text-sm text-gray-600 dark:text-gray-400">
            Silakan login ke akun <span class="font-bold text-indigo-600 italic">System Reporting BA</span> Anda
        </p>
    </div>

    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('login') }}" class="space-y-6">
        @csrf

        <!-- Email Address -->
        <div>
            <x-input-label for="email" :value="__('Alamat Email')"
                class="text-xs uppercase tracking-widest font-bold opacity-70" />
            <div class="mt-1 relative rounded-md shadow-sm">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-gray-400">
                    <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M16 12a4 4 0 10-8 0 4 4 0 008 0zm0 0v1.5a2.5 2.5 0 005 0V12a9 9 0 10-9 9m4.5-1.206a8.959 8.959 0 01-4.5 1.207">
                        </path>
                    </svg>
                </div>
                <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus
                    placeholder="nama@email.com"
                    class="block w-full pl-10 border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-xl transition duration-150 ease-in-out sm:text-sm shadow-sm" />
            </div>
            <x-input-error :messages="$errors->get('email')" class="mt-2 text-xs" />
        </div>

        <!-- Password -->
        <div>
            <div class="flex justify-between items-center">
                <x-input-label for="password" :value="__('Kata Sandi')"
                    class="text-xs uppercase tracking-widest font-bold opacity-70" />
                @if (Route::has('password.request'))
                    <a class="text-xs text-indigo-600 hover:text-indigo-500 font-medium transition duration-150 ease-in-out"
                        href="{{ route('password.request') }}">
                        {{ __('Lupa password?') }}
                    </a>
                @endif
            </div>
            <div class="mt-1 relative rounded-md shadow-sm">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-gray-400">
                    <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z">
                        </path>
                    </svg>
                </div>
                <input id="password" type="password" name="password" required placeholder="••••••••"
                    class="block w-full pl-10 pr-12 border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-xl transition duration-150 ease-in-out sm:text-sm shadow-sm" />
                <button type="button"
                    onclick="const p = document.getElementById('password'); const isPass = p.type === 'password'; p.type = isPass ? 'text' : 'password'; document.getElementById('eyeIcon').classList.toggle('hidden'); document.getElementById('eyeSlashIcon').classList.toggle('hidden');"
                    class="absolute inset-y-0 right-0 px-4 flex items-center justify-center text-gray-400 hover:text-indigo-600 focus:outline-none focus:text-indigo-600 transition-colors bg-transparent rounded-r-xl group">
                    <svg id="eyeIcon" class="h-5 w-5 transform group-active:scale-95 transition-transform" fill="none"
                        stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                    </svg>
                    <svg id="eyeSlashIcon" class="h-5 w-5 hidden transform group-active:scale-95 transition-transform"
                        fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.29 3.29m0 0a10.05 10.05 0 011.563-3.029m5.858-.908a3 3 0 014.243-4.243M9.878 9.878l4.242 4.242" />
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3l18 18" />
                    </svg>
                </button>
            </div>
            <x-input-error :messages="$errors->get('password')" class="mt-2 text-xs" />
        </div>

        <!-- Remember Me -->
        <div class="flex items-center">
            <input id="remember_me" type="checkbox" name="remember"
                class="w-4 h-4 text-indigo-600 border-gray-300 rounded focus:ring-indigo-500 transition duration-150 ease-in-out">
            <span class="ml-2 text-sm text-gray-600 dark:text-gray-400 font-medium">{{ __('Ingat saya') }}</span>
        </div>

        <div>
            <button type="submit"
                class="w-full flex justify-center py-3 px-4 border border-transparent rounded-xl shadow-sm text-sm font-bold text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transform active:scale-[0.98] transition duration-150 ease-in-out">
                {{ __('Masuk Ke Sistem') }}
            </button>
        </div>
    </form>

    {{-- PWA Install Button --}}
    <div id="install-button-container" class="hidden mt-6 pt-6 border-t border-gray-100 dark:border-gray-700">
        <p
            class="text-xs text-center text-gray-500 dark:text-gray-400 mb-3 uppercase tracking-widest font-bold opacity-70">
            Aplikasi Belum Terinstal?
        </p>
        <button id="install-button" type="button"
            class="w-full flex items-center justify-center py-3 px-4 border border-indigo-200 dark:border-indigo-800 rounded-xl shadow-sm text-sm font-bold text-indigo-600 dark:text-indigo-400 bg-white dark:bg-gray-800 hover:bg-indigo-50 dark:hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transform active:scale-[0.98] transition duration-150 ease-in-out group">
            <svg class="w-5 h-5 mr-2 -ml-1 group-hover:animate-bounce" fill="none" stroke="currentColor"
                viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path>
            </svg>
            {{ __('Install Aplikasi') }}
        </button>
    </div>

    @push('scripts')
        <script>
            let deferredPrompt;
            const installContainer = document.getElementById('install-button-container');
            const installButton = document.getElementById('install-button');

            window.addEventListener('beforeinstallprompt', (e) => {
                // Prevent Chrome 67 and earlier from automatically showing the prompt
                e.preventDefault();
                // Stash the event so it can be triggered later.
                deferredPrompt = e;
                // Update UI to notify the user they can add to home screen
                installContainer.classList.remove('hidden');

                installButton.addEventListener('click', (e) => {
                    // hide our install button
                    installContainer.classList.add('hidden');
                    // Show the prompt
                    deferredPrompt.prompt();
                    // Wait for the user to respond to the prompt
                    deferredPrompt.userChoice.then((choiceResult) => {
                        if (choiceResult.outcome === 'accepted') {
                            console.log('User accepted the A2HS prompt');
                        } else {
                            console.log('User dismissed the A2HS prompt');
                            // Show the button again if they dismissed? 
                            // Maybe better to keep it hidden until next reload to avoid annoyance
                        }
                        deferredPrompt = null;
                    });
                });
            });

            window.addEventListener('appinstalled', (evt) => {
                console.log('PWA was installed');
                installContainer.classList.add('hidden');
            });
        </script>
    @endpush
</x-guest-layout>