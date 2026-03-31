<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="">
<script>
    if(localStorage.getItem('theme')!=='light'){document.documentElement.classList.add('dark')}
</script>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', config('app.name', 'OasisX'))</title>

    {{-- Tailwind CSS --}}
    <script src="https://cdn.tailwindcss.com"></script>

    {{-- Alpine.js --}}
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.13.3/dist/cdn.min.js"></script>

    <script>
        tailwind.config = {
            darkMode: 'class',
            theme: {
                extend: {
                    colors: {
                        primary: '#171717',
                        secondary: '#64748b',
                        dark: '#000000',
                    },
                    fontFamily: {
                        sans: ['Inter', 'sans-serif'],
                    }
                }
            }
        }
    </script>

    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <style>
        body {
            font-family: 'Inter', sans-serif;
            -webkit-tap-highlight-color: transparent;
        }

        .glass {
            background: rgba(255, 255, 255, 0.9);
            backdrop-filter: blur(12px);
        }

        .dark .glass {
            background: rgba(0, 0, 0, 0.8);
            border-bottom-color: rgba(255, 255, 255, 0.1);
        }

        [x-cloak] {
            display: none !important;
        }

        .toast-enter {
            animation: toastIn .35s ease-out;
        }

        .toast-leave {
            animation: toastOut .25s ease-in forwards;
        }

        @keyframes toastIn {
            from {
                opacity: 0;
                transform: translateX(1rem);
            }

            to {
                opacity: 1;
                transform: translateX(0);
            }
        }

        @keyframes toastOut {
            to {
                opacity: 0;
                transform: translateX(1rem);
            }
        }
    </style>

    <script>
        document.addEventListener('alpine:init', () => {
            Alpine.data('customSelect', (config = {}) => ({
                open: false,
                search: '',
                options: [],
                selected: null,
                placeholder: config.placeholder || 'Select an option',
                searchable: config.searchable || false,
                init() {
                    const select = this.$refs.select;
                    this.options = Array.from(select.options).map(option => ({
                        value: option.value,
                        label: option.text,
                        disabled: option.disabled,
                        selected: option.selected
                    }));
                    const selectedOption = this.options.find(o => o.selected) || this.options[0];
                    if (selectedOption) {
                        this.selected = selectedOption.value;
                    }
                },
                get selectedLabel() {
                    const selectedOption = this.options.find(o => o.value === this.selected);
                    return selectedOption ? selectedOption.label : this.placeholder;
                },
                filteredOptions() {
                    if (!this.searchable || !this.search) {
                        return this.options;
                    }
                    const term = this.search.toLowerCase();
                    return this.options.filter(o => o.label.toLowerCase().includes(term));
                },
                selectOption(value) {
                    this.selected = value;
                    const select = this.$refs.select;
                    select.value = value;
                    select.dispatchEvent(new Event('change'));
                    this.open = false;
                }
            }));
        });
    </script>

    @stack('styles')
</head>

<body class="bg-gray-50 dark:bg-black text-gray-900 dark:text-white antialiased">

    {{-- Preloader --}}
    <div id="preloader"
        class="fixed inset-0 z-[100] bg-white dark:bg-black flex items-center justify-center transition-opacity duration-500">
        <div class="flex flex-col items-center">
            <div class="animate-spin rounded-full h-12 w-12 border-b-2 border-black dark:border-white mb-4"></div>
            <div class="text-sm font-medium text-gray-900 dark:text-white animate-pulse">Loading...</div>
        </div>
    </div>
    <script>
        window.addEventListener('load', function() {
            const preloader = document.getElementById('preloader');
            preloader.classList.add('opacity-0');
            setTimeout(() => { preloader.style.display = 'none'; }, 500);
        });
    </script>

    <div class="min-h-screen flex flex-col">

        {{-- Impersonation Banner --}}
        @if(session('admin_impersonating'))
        <div class="bg-yellow-500 text-black text-center py-2 px-4 text-sm font-medium z-[100] relative">
            You are currently viewing as <strong>{{ auth()->user()->name }}</strong>.
            <form action="{{ route('admin.users.stop-impersonating') }}" method="POST" class="inline">
                @csrf
                <button type="submit" class="underline font-bold hover:opacity-80 ml-2">Return to Admin</button>
            </form>
        </div>
        @endif

        {{-- Top Navigation --}}
        @include('user.partials.navbar')

        {{-- Mobile Bottom Nav --}}
        @include('user.partials.bottom-nav')

        {{-- Toastr Notifications --}}
        <div x-data="toastr()" x-cloak class="fixed top-4 right-4 z-[200] flex flex-col gap-3 w-80">
            <template x-for="toast in toasts" :key="toast.id">
                <div :class="toast.removing ? 'toast-leave' : 'toast-enter'"
                    class="flex items-start gap-3 px-4 py-3 rounded-xl shadow-lg border backdrop-blur-sm"
                    :style="toast.type === 'success'
                        ? (document.documentElement.classList.contains('dark') ? 'background:rgba(6,78,59,.85);border-color:#065f46;' : 'background:rgba(240,253,244,.95);border-color:#bbf7d0;')
                        : (document.documentElement.classList.contains('dark') ? 'background:rgba(127,29,29,.85);border-color:#991b1b;' : 'background:rgba(254,242,242,.95);border-color:#fecaca;')">
                    <template x-if="toast.type === 'success'">
                        <svg class="w-5 h-5 text-green-500 mt-0.5 shrink-0" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </template>
                    <template x-if="toast.type === 'error'">
                        <svg class="w-5 h-5 text-red-500 mt-0.5 shrink-0" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </template>
                    <p class="text-sm font-medium flex-1"
                        :class="toast.type === 'success' ? 'text-green-800 dark:text-green-200' : 'text-red-800 dark:text-red-200'"
                        x-text="toast.message"></p>
                    <button @click="remove(toast.id)" class="shrink-0 mt-0.5"
                        :class="toast.type === 'success' ? 'text-green-400 hover:text-green-600 dark:text-green-300 dark:hover:text-green-100' : 'text-red-400 hover:text-red-600 dark:text-red-300 dark:hover:text-red-100'">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </button>
                </div>
            </template>
        </div>
        <script>
            document.addEventListener('alpine:init', () => {
                Alpine.data('toastr', () => ({
                    toasts: [],
                    counter: 0,
                    init() {
                        @if(session('success'))
                            this.add('success', @json(session('success')));
                        @endif
                        @if(session('error'))
                            this.add('error', @json(session('error')));
                        @endif
                        @if($errors->any())
                            this.add('error', @json($errors->first()));
                        @endif
                    },
                    add(type, message) {
                        const id = ++this.counter;
                        this.toasts.push({ id, type, message, removing: false });
                        setTimeout(() => this.remove(id), 5000);
                    },
                    remove(id) {
                        const toast = this.toasts.find(t => t.id === id);
                        if (toast) {
                            toast.removing = true;
                            setTimeout(() => { this.toasts = this.toasts.filter(t => t.id !== id); }, 250);
                        }
                    }
                }));
            });
        </script>

        {{-- Content --}}
        <main class="flex-1">
            <div class="max-w-7xl mx-auto py-6 px-4 pb-24 md:pb-6 sm:px-6 lg:px-8">
                @yield('content')
            </div>
        </main>

    </div>

    @stack('scripts')
</body>

</html>