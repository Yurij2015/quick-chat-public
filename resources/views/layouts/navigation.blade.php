<nav x-data="{ open: false }" class="bg-white/80 dark:bg-gray-900/80 backdrop-blur-xl border-b border-gray-200/50 dark:border-gray-800/80 sticky top-0 z-50 transition-colors duration-300">
    @if (session()->has('impersonated_by'))
        <div class="bg-yellow-50 border-b border-yellow-200 dark:bg-yellow-900/50 dark:border-yellow-700/50 relative overflow-hidden">
            <div class="max-w-7xl mx-auto py-2 px-4 sm:px-6 lg:px-8 relative z-10">
                <div class="flex items-center justify-between flex-wrap">
                    <div class="w-0 flex-1 flex items-center">
                        <span class="flex p-1.5 rounded-lg bg-yellow-200 dark:bg-yellow-800">
                            <svg class="h-5 w-5 text-yellow-800 dark:text-yellow-200" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                            </svg>
                        </span>
                        <p class="ms-3 font-medium text-yellow-800 dark:text-yellow-200 text-sm">
                            <span class="hidden md:inline">Ви знаходитесь в режимі імперсонації як <strong class="font-bold">{{ Auth::user()->name }}</strong>.</span>
                            <span class="md:hidden">Режим імперсонації</span>
                        </p>
                    </div>
                    <div class="order-3 mt-2 flex-shrink-0 w-full sm:order-2 sm:mt-0 sm:w-auto">
                        <form method="POST" action="{{ route('impersonate.leave') }}">
                            @csrf
                            <button type="submit" class="w-full flex items-center justify-center px-4 py-1.5 border border-transparent rounded-md shadow-sm text-sm font-bold text-yellow-900 bg-yellow-300 hover:bg-yellow-400 dark:text-yellow-100 dark:bg-yellow-700 dark:hover:bg-yellow-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-yellow-500 transition-colors">
                                Вийти з режиму
                            </button>
                        </form>
                    </div>
                </div>
            </div>

            <div class="absolute inset-0 opacity-10 dark:opacity-20 pointer-events-none" style="background-image: radial-gradient(circle at 2px 2px, currentColor 1px, transparent 1px); background-size: 16px 16px; color: #eab308;"></div>
        </div>
    @endif

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex items-center">

                <div class="shrink-0 flex items-center">
                    <a href="{{ route('dashboard') }}" class="flex items-center gap-2 group">
                        <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-indigo-500 to-blue-600 flex items-center justify-center text-white shadow-lg shadow-indigo-200/50 dark:shadow-indigo-900/20 group-hover:scale-105 transition-transform">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z" /></svg>
                        </div>
                        <span class="text-xl font-bold bg-clip-text text-transparent bg-gradient-to-r from-gray-900 to-gray-600 dark:from-white dark:to-gray-300 tracking-tight hidden sm:block">ChatApp</span>
                    </a>
                </div>


                <div class="hidden space-x-8 sm:-my-px sm:ms-10 sm:flex">
                    <a href="{{ route('dashboard') }}" class="inline-flex items-center px-1 pt-1 border-b-2 text-sm font-medium leading-5 transition duration-150 ease-in-out {{ request()->routeIs('dashboard') ? 'border-indigo-500 text-gray-900 dark:text-white focus:outline-none focus:border-indigo-700' : 'border-transparent text-gray-500 dark:text-gray-400 hover:text-gray-700 dark:hover:text-gray-300 hover:border-gray-300 dark:hover:border-gray-600 focus:outline-none focus:text-gray-700 dark:focus:text-gray-300 focus:border-gray-300 dark:focus:border-gray-600' }}">
                        Головна
                    </a>
                </div>
            </div>


            <div class="hidden sm:flex sm:items-center sm:ms-6 space-x-3">
                

                <div class="relative" x-data="{ open: false, totalUnread: 0, senders: [] }" 
                     @unread-updated.window="totalUnread = $event.detail.count; senders = $event.detail.senders;">
                    <button @click="open = !open" @click.away="open = false" class="p-2 w-10 h-10 flex items-center justify-center text-gray-400 hover:text-indigo-600 dark:hover:text-indigo-400 transition-colors rounded-full hover:bg-gray-100 dark:hover:bg-gray-800 focus:outline-none relative">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" /></svg>
                        <span x-show="totalUnread > 0" style="display: none;" class="absolute top-2 right-2.5 w-2 h-2 bg-red-500 rounded-full border-2 border-white dark:border-gray-800"></span>
                    </button>
                    
                    <div x-show="open" style="display: none;" 
                         x-transition:enter="transition ease-out duration-200"
                         x-transition:enter-start="opacity-0 scale-95"
                         x-transition:enter-end="opacity-100 scale-100"
                         x-transition:leave="transition ease-in duration-75"
                         x-transition:leave-start="opacity-100 scale-100"
                         x-transition:leave-end="opacity-0 scale-95"
                         class="absolute right-0 mt-2 w-80 bg-white dark:bg-gray-800 rounded-xl shadow-xl border border-gray-100 dark:border-gray-700 py-1 z-50 overflow-hidden origin-top-right">
                        <div class="px-4 py-3 border-b border-gray-100 dark:border-gray-700 bg-gray-50 dark:bg-gray-800/50 flex justify-between items-center">
                            <h3 class="text-sm font-semibold text-gray-900 dark:text-white">Сповіщення</h3>
                            <span class="bg-indigo-100 text-indigo-800 text-xs font-medium px-2.5 py-0.5 rounded-full dark:bg-indigo-900 dark:text-indigo-300" x-show="totalUnread > 0" x-text="totalUnread + ' нових'"></span>
                        </div>
                        <div class="max-h-80 overflow-y-auto no-scrollbar">
                            <template x-if="senders.length === 0">
                                <div class="px-4 py-8 flex flex-col items-center justify-center text-center">
                                    <div class="w-12 h-12 bg-gray-50 dark:bg-gray-800 rounded-full flex items-center justify-center text-gray-400 dark:text-gray-500 mb-3">
                                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" /></svg>
                                    </div>
                                    <p class="text-[13px] font-medium text-gray-900 dark:text-white mb-1">Немає нових повідомлень</p>
                                    <p class="text-[12px] text-gray-500 dark:text-gray-400">Всі чати прочитані</p>
                                </div>
                            </template>
                            <template x-for="sender in senders" :key="sender.id">
                                <a href="#" @click.prevent="window.dispatchEvent(new CustomEvent('open-chat', {detail: {id: sender.id, name: sender.name}})); open = false;" class="block px-4 py-3 hover:bg-gray-50 dark:hover:bg-gray-700/50 transition-colors border-b border-gray-100 dark:border-gray-700/50 last:border-0 group">
                                    <div class="flex items-center space-x-3">
                                        <div class="relative shrink-0">
                                            <div class="w-10 h-10 rounded-full bg-gradient-to-br from-blue-500 to-indigo-600 flex items-center justify-center text-white text-sm font-bold shadow-sm" x-text="sender.name.charAt(0)"></div>
                                        </div>
                                        <div class="flex-1 min-w-0">
                                            <p class="text-[14px] font-semibold text-gray-900 dark:text-white truncate" x-text="sender.name"></p>
                                            <p class="text-[13px] text-gray-500 dark:text-gray-400 truncate mt-0.5 group-hover:text-gray-700 dark:group-hover:text-gray-300 transition-colors" x-text="sender.text"></p>
                                        </div>
                                        <div class="shrink-0 flex flex-col items-end space-y-1">
                                            <span class="text-[11px] font-medium text-indigo-500 dark:text-indigo-400" x-text="sender.time"></span>
                                            <span class="inline-flex items-center justify-center px-1.5 py-0.5 min-w-[1.25rem] h-5 text-[10px] font-bold text-white bg-indigo-500 rounded-full shadow-sm shadow-indigo-200 dark:shadow-none" x-show="sender.count > 1" x-text="sender.count"></span>
                                        </div>
                                    </div>
                                </a>
                            </template>
                        </div>
                        <div x-show="senders.length > 0" class="p-2 border-t border-gray-100 dark:border-gray-700 bg-gray-50 dark:bg-gray-800/50">
                            <button @click="open = false" class="w-full text-center block text-xs font-semibold text-indigo-600 dark:text-indigo-400 hover:text-indigo-700 dark:hover:text-indigo-300 py-1.5 transition-colors">
                                Закрити
                            </button>
                        </div>
                    </div>
                </div>


                <button type="button" 
                        onclick="document.documentElement.dispatchEvent(new CustomEvent('toggle-theme'))"
                        x-data="{ isDark: document.documentElement.classList.contains('dark') }"
                        @theme-changed.window="isDark = $event.detail.isDark"
                        class="p-2 w-10 h-10 flex items-center justify-center text-gray-400 hover:text-yellow-500 dark:hover:text-yellow-400 transition-colors rounded-full hover:bg-gray-100 dark:hover:bg-gray-800 focus:outline-none">

                    <svg x-show="!isDark" class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg" style="display: none;"><path d="M17.293 13.293A8 8 0 016.707 2.707a8.001 8.001 0 1010.586 10.586z"></path></svg>

                    <svg x-show="isDark" class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg" style="display: none;"><path d="M10 2a1 1 0 011 1v1a1 1 0 11-2 0V3a1 1 0 011-1zm4 8a4 4 0 11-8 0 4 4 0 018 0zm-.464 4.95l.707.707a1 1 0 001.414-1.414l-.707-.707a1 1 0 00-1.414 1.414zm2.12-10.607a1 1 0 010 1.414l-.707.707a1 1 0 01-1.414-1.414l.707-.707a1 1 0 011.414 0zM17 11a1 1 0 100-2h-1a1 1 0 100 2h1zm-7 4a1 1 0 011 1v1a1 1 0 11-2 0v-1a1 1 0 011-1zM5.05 6.464A1 1 0 106.465 5.05l-.708-.707a1 1 0 00-1.414 1.414l.707.707zm1.414 8.486l-.707.707a1 1 0 01-1.414-1.414l.707-.707a1 1 0 011.414 1.414zM4 11a1 1 0 100-2H3a1 1 0 000 2h1z" fill-rule="evenodd" clip-rule="evenodd"></path></svg>
                </button>

                <div class="h-6 w-px bg-gray-200 dark:bg-gray-700 mx-2"></div>

                <x-dropdown align="right" width="48">
                    <x-slot name="trigger">
                        <button class="inline-flex items-center px-2 py-1.5 border border-transparent text-sm leading-4 font-semibold rounded-full text-gray-600 dark:text-gray-300 bg-gray-50 dark:bg-gray-800 hover:bg-gray-100 dark:hover:bg-gray-700 focus:outline-none transition-all duration-200">
                            <div class="flex items-center space-x-2">
                                <div class="w-7 h-7 rounded-full bg-gradient-to-br from-indigo-500 to-purple-600 flex items-center justify-center text-white text-xs shadow-sm">
                                    {{ mb_substr(Auth::user()->name, 0, 1) }}
                                </div>
                                <span class="hidden md:block pr-1">{{ explode(' ', Auth::user()->name)[0] }}</span>
                            </div>

                            <div class="ms-1 mr-1">
                                <svg class="fill-current h-4 w-4 text-gray-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 10-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                </svg>
                            </div>
                        </button>
                    </x-slot>

                    <x-slot name="content">
                        <div class="px-4 py-3 text-sm text-gray-900 dark:text-white border-b border-gray-100 dark:border-gray-700">
                            <div class="font-medium truncate">{{ Auth::user()->email }}</div>
                            <div class="text-xs text-gray-500 truncate mt-0.5">{{ Auth::user()->roles->pluck('name')->first() ?: 'Користувач' }}</div>
                        </div>

                        <x-dropdown-link :href="route('profile.edit')" class="mt-1">
                            Налаштування профілю
                        </x-dropdown-link>


                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <x-dropdown-link :href="route('logout')"
                                    class="text-red-600 dark:text-red-400 hover:bg-red-50 dark:hover:bg-red-900/30 mb-1"
                                    onclick="event.preventDefault(); this.closest('form').submit();">
                                Вийти
                            </x-dropdown-link>
                        </form>
                    </x-slot>
                </x-dropdown>
            </div>


            <div class="-me-2 flex items-center sm:hidden">
                <button type="button" 
                        onclick="document.documentElement.dispatchEvent(new CustomEvent('toggle-theme'))"
                        class="mr-2 p-2 rounded-md text-gray-400 hover:text-gray-500 hover:bg-gray-100 dark:hover:bg-gray-800 focus:outline-none transition duration-150 ease-in-out">
                    <svg class="w-5 h-5 block dark:hidden" fill="currentColor" viewBox="0 0 20 20"><path d="M17.293 13.293A8 8 0 016.707 2.707a8.001 8.001 0 1010.586 10.586z"></path></svg>
                    <svg class="w-5 h-5 hidden dark:block" fill="currentColor" viewBox="0 0 20 20"><path d="M10 2a1 1 0 011 1v1a1 1 0 11-2 0V3a1 1 0 011-1zm4 8a4 4 0 11-8 0 4 4 0 018 0zm-.464 4.95l.707.707a1 1 0 001.414-1.414l-.707-.707a1 1 0 00-1.414 1.414zm2.12-10.607a1 1 0 010 1.414l-.707.707a1 1 0 01-1.414-1.414l.707-.707a1 1 0 011.414 0zM17 11a1 1 0 100-2h-1a1 1 0 100 2h1zm-7 4a1 1 0 011 1v1a1 1 0 11-2 0v-1a1 1 0 011-1zM5.05 6.464A1 1 0 106.465 5.05l-.708-.707a1 1 0 00-1.414 1.414l.707.707zm1.414 8.486l-.707.707a1 1 0 01-1.414-1.414l.707-.707a1 1 0 011.414 1.414zM4 11a1 1 0 100-2H3a1 1 0 000 2h1z" fill-rule="evenodd" clip-rule="evenodd"></path></svg>
                </button>

                <button @click="open = ! open" class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-gray-500 hover:bg-gray-100 dark:hover:bg-gray-800 focus:outline-none focus:bg-gray-100 dark:focus:bg-gray-800 focus:text-gray-500 transition duration-150 ease-in-out">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>


    <div x-show="open" 
         x-transition:enter="transition ease-out duration-200"
         x-transition:enter-start="opacity-0 -translate-y-4"
         x-transition:enter-end="opacity-100 translate-y-0"
         x-transition:leave="transition ease-in duration-150"
         x-transition:leave-start="opacity-100 translate-y-0"
         x-transition:leave-end="opacity-0 -translate-y-4"
         class="sm:hidden absolute w-full bg-white dark:bg-gray-800 border-b border-gray-200 dark:border-gray-700 shadow-lg">
        <div class="pt-2 pb-3 space-y-1">
            <x-responsive-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                Головна
            </x-responsive-nav-link>
        </div>


        <div class="pt-4 pb-2 border-t border-gray-200 dark:border-gray-700">
            <div class="px-4 flex items-center space-x-3">
                <div class="w-10 h-10 rounded-full bg-gradient-to-br from-indigo-500 to-purple-600 flex items-center justify-center text-white text-sm font-bold shadow-sm">
                    {{ mb_substr(Auth::user()->name, 0, 1) }}
                </div>
                <div>
                    <div class="font-medium text-base text-gray-800 dark:text-gray-200">{{ Auth::user()->name }}</div>
                    <div class="font-medium text-sm text-gray-500">{{ Auth::user()->email }}</div>
                </div>
            </div>

            <div class="mt-3 space-y-1">
                <x-responsive-nav-link :href="route('profile.edit')">
                    Налаштування профілю
                </x-responsive-nav-link>


                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <x-responsive-nav-link :href="route('logout')"
                            onclick="event.preventDefault(); this.closest('form').submit();"
                            class="text-red-600 dark:text-red-400">
                        Вийти
                    </x-responsive-nav-link>
                </form>
            </div>
        </div>
    </div>
</nav>
