<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="dark">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Oasisxmarket') }}</title>

    {{-- Tailwind CSS --}}
    <script src="https://cdn.tailwindcss.com/"></script>

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
            setTimeout(() => {
                preloader.style.display = 'none';
            }, 500);
        });
    </script>

    <div class="min-h-screen flex flex-col">
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