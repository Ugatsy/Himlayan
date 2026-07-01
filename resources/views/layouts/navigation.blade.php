<nav class="fixed top-0 left-0 right-0 z-50 bg-brand-blue">
    <div class="px-4 sm:px-6 lg:px-8">
        <div class="flex items-center justify-between h-16">
            <!-- Left: Logo + Mobile Hamburger -->
            <div class="flex items-center gap-2">
                <button @click="mobileNavOpen = !mobileNavOpen" class="lg:hidden inline-flex items-center justify-center p-2 rounded-lg text-white/80 hover:text-white hover:bg-white/10 focus:outline-none">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{'hidden': mobileNavOpen, 'inline-flex': !mobileNavOpen}" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                        <path :class="{'hidden': !mobileNavOpen, 'inline-flex': mobileNavOpen}" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
                <a href="{{ route('dashboard') }}" class="flex items-center gap-2 text-white shrink-0">
                    <img src="{{ asset('images/himlayan-logo.png') }}" alt="HIMLAYAN" class="block h-8 w-auto">
                    <span class="font-bold text-lg hidden sm:inline">HIMLAYAN</span>
                </a>
            </div>

            <!-- Center: Desktop Nav Links (wraps naturally, no scroll) -->
            <div class="hidden lg:flex items-center gap-1 flex-1 justify-center">
                <a class="inline-flex items-center px-3 py-1.5 rounded-lg text-sm font-medium whitespace-nowrap transition duration-150 ease-in-out {{ request()->routeIs('dashboard') ? 'text-white bg-white/15' : 'text-white/80 hover:text-white hover:bg-white/10' }}" href="{{ route('dashboard') }}">
                    Dashboard
                </a>
                <a class="inline-flex items-center px-3 py-1.5 rounded-lg text-sm font-medium whitespace-nowrap transition duration-150 ease-in-out {{ request()->routeIs('clients.*') ? 'text-white bg-white/15' : 'text-white/80 hover:text-white hover:bg-white/10' }}" href="{{ route('clients.index') }}">
                    Clients
                </a>
                <a class="inline-flex items-center px-3 py-1.5 rounded-lg text-sm font-medium whitespace-nowrap transition duration-150 ease-in-out {{ request()->routeIs('plots.*') || request()->routeIs('burials.*') || request()->routeIs('deceased.*') ? 'text-white bg-white/15' : 'text-white/80 hover:text-white hover:bg-white/10' }}" href="{{ route('plots.index') }}">
                    Lots &amp; Burials
                </a>
                <a class="inline-flex items-center px-3 py-1.5 rounded-lg text-sm font-medium whitespace-nowrap transition duration-150 ease-in-out {{ request()->routeIs('burial-permits.*') ? 'text-white bg-white/15' : 'text-white/80 hover:text-white hover:bg-white/10' }}" href="{{ route('burial-permits.index') }}">
                    Permits
                </a>
                <a class="inline-flex items-center px-3 py-1.5 rounded-lg text-sm font-medium whitespace-nowrap transition duration-150 ease-in-out {{ request()->routeIs('contracts.*') || request()->routeIs('payments.*') ? 'text-white bg-white/15' : 'text-white/80 hover:text-white hover:bg-white/10' }}" href="{{ route('contracts.index') }}">
                    Contracts &amp; Billing
                </a>
                <a class="inline-flex items-center px-3 py-1.5 rounded-lg text-sm font-medium whitespace-nowrap transition duration-150 ease-in-out {{ request()->routeIs('inquiries.*') ? 'text-white bg-white/15' : 'text-white/80 hover:text-white hover:bg-white/10' }}" href="{{ route('inquiries.index') }}">
                    Inquiries
                </a>
                <a class="inline-flex items-center px-3 py-1.5 rounded-lg text-sm font-medium whitespace-nowrap transition duration-150 ease-in-out {{ request()->routeIs('client-notifications.*') ? 'text-white bg-white/15' : 'text-white/80 hover:text-white hover:bg-white/10' }}" href="{{ route('client-notifications.index') }}">
                    Client Notifs
                </a>
                <a class="inline-flex items-center px-3 py-1.5 rounded-lg text-sm font-medium whitespace-nowrap transition duration-150 ease-in-out {{ request()->routeIs('activity-logs.*') ? 'text-white bg-white/15' : 'text-white/80 hover:text-white hover:bg-white/10' }}" href="{{ route('activity-logs.index') }}">
                    Activity Logs
                </a>

                <!-- Services Dropdown (Desktop) -->
                <div x-data="{ open: false, top: 0, left: 0 }" @click.outside="open = false" @close.stop="open = false">
                    <button x-ref="btn" @click="open = !open; if(open){const r=$refs.btn.getBoundingClientRect(); top=r.bottom + 8; left=r.left}" class="inline-flex items-center gap-1 px-3 py-1.5 rounded-lg text-sm font-medium text-white/80 hover:text-white hover:bg-white/10 transition duration-150 ease-in-out whitespace-nowrap">
                        Services
                        <svg class="h-4 w-4 fill-current transition-transform duration-200" :class="{ 'rotate-180': open }" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd"></path></svg>
                    </button>
                    <template x-teleport="body">
                        <div x-show="open" x-cloak x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 -translate-y-1" x-transition:enter-end="opacity-100 translate-y-0" x-transition:leave="transition ease-in duration-150" x-transition:leave-start="opacity-100 translate-y-0" x-transition:leave-end="opacity-0 -translate-y-1" :style="`position:fixed;top:${top}px;left:${left}px;`" class="w-56 rounded-lg bg-white shadow-lg ring-1 ring-black/5 py-1 z-[9999]" @click="open = false">
                            <a href="{{ route('pre-need-plans.index') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-brand-blue/10 hover:text-brand-blue">Pre-Need Plans</a>
                            <a href="{{ route('columbary-niches.index') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-brand-blue/10 hover:text-brand-blue">Columbary Niches</a>
                            <a href="{{ route('cemetery.admin') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-brand-blue/10 hover:text-brand-blue">Cemetery Map</a>
                            <a href="{{ route('paths.index') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-brand-blue/10 hover:text-brand-blue">Pathways</a>
                        </div>
                    </template>
                </div>
            </div>

            <!-- Right: Notifications Bell + User Dropdown -->
            <div class="flex items-center gap-1 shrink-0">
                <!-- Notifications icon button -->
                <a href="{{ route('notifications.index') }}" class="relative inline-flex items-center justify-center p-2 rounded-lg transition duration-150 ease-in-out {{ request()->routeIs('notifications.*') ? 'text-white bg-white/15' : 'text-white/80 hover:text-white hover:bg-white/10' }}" title="Notifications">
                    <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"></path>
                    </svg>
                    @if(($unreadNotifications ?? 0) > 0)
                        <span class="absolute top-1 right-1 block h-2 w-2 rounded-full bg-brand-yellow ring-2 ring-brand-blue"></span>
                    @endif
                </a>

                <!-- User Dropdown -->
                <div class="relative" x-data="{ open: false }" @click.outside="open = false" @close.stop="open = false">
                    <div @click="open = ! open">
                        <button class="inline-flex items-center gap-2 px-3 py-1.5 rounded-lg text-sm font-medium text-white/90 hover:text-white hover:bg-white/10 focus:outline-none transition ease-in-out duration-150">
                            <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                            <span class="hidden lg:inline">{{ Auth::user()->name }}</span>
                            <svg class="hidden lg:block fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                            </svg>
                        </button>
                    </div>

                    <div x-show="open" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100" x-transition:leave="transition ease-in duration-75" x-transition:leave-start="opacity-100 scale-100" x-transition:leave-end="opacity-0 scale-95" class="absolute z-[9999] mt-2 w-48 rounded-md shadow-lg ltr:origin-top-right rtl:origin-top-left end-0" style="display: none;" @click="open = false">
                        <div class="rounded-md ring-1 ring-black ring-opacity-5 py-1 bg-white">
                            <a class="block w-full px-4 py-2 text-start text-sm leading-5 text-gray-700 hover:bg-blue-50 hover:text-brand-blue focus:outline-none focus:bg-blue-50 transition duration-150 ease-in-out" href="{{ route('profile.edit') }}">Profile</a>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <a class="block w-full px-4 py-2 text-start text-sm leading-5 text-gray-700 hover:bg-blue-50 hover:text-brand-blue focus:outline-none focus:bg-blue-50 transition duration-150 ease-in-out" href="{{ route('logout') }}" onclick="event.preventDefault(); this.closest('form').submit();">Log Out</a>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Mobile Slide-Down Panel -->
    <div x-show="mobileNavOpen" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 -translate-y-2" x-transition:enter-end="opacity-100 translate-y-0" x-transition:leave="transition ease-in duration-150" x-transition:leave-start="opacity-100 translate-y-0" x-transition:leave-end="opacity-0 -translate-y-2" class="lg:hidden border-t border-white/10 bg-brand-blue" style="display: none;">
        <div class="px-4 py-3 space-y-1">
            <a class="block px-3 py-2 rounded-lg text-sm font-medium transition duration-150 ease-in-out {{ request()->routeIs('dashboard') ? 'text-white bg-white/15' : 'text-white/70 hover:text-white hover:bg-white/10' }}" href="{{ route('dashboard') }}">Dashboard</a>
            <a class="block px-3 py-2 rounded-lg text-sm font-medium transition duration-150 ease-in-out {{ request()->routeIs('clients.*') ? 'text-white bg-white/15' : 'text-white/70 hover:text-white hover:bg-white/10' }}" href="{{ route('clients.index') }}">Clients</a>
            <a class="block px-3 py-2 rounded-lg text-sm font-medium transition duration-150 ease-in-out {{ request()->routeIs('plots.*') || request()->routeIs('burials.*') || request()->routeIs('deceased.*') ? 'text-white bg-white/15' : 'text-white/70 hover:text-white hover:bg-white/10' }}" href="{{ route('plots.index') }}">Lots &amp; Burials</a>
            <a class="block px-3 py-2 rounded-lg text-sm font-medium transition duration-150 ease-in-out {{ request()->routeIs('burial-permits.*') ? 'text-white bg-white/15' : 'text-white/70 hover:text-white hover:bg-white/10' }}" href="{{ route('burial-permits.index') }}">Permits</a>
            <a class="block px-3 py-2 rounded-lg text-sm font-medium transition duration-150 ease-in-out {{ request()->routeIs('contracts.*') || request()->routeIs('payments.*') ? 'text-white bg-white/15' : 'text-white/70 hover:text-white hover:bg-white/10' }}" href="{{ route('contracts.index') }}">Contracts &amp; Billing</a>
            <a class="block px-3 py-2 rounded-lg text-sm font-medium transition duration-150 ease-in-out {{ request()->routeIs('inquiries.*') ? 'text-white bg-white/15' : 'text-white/70 hover:text-white hover:bg-white/10' }}" href="{{ route('inquiries.index') }}">Inquiries</a>
            <a class="block px-3 py-2 rounded-lg text-sm font-medium transition duration-150 ease-in-out {{ request()->routeIs('client-notifications.*') ? 'text-white bg-white/15' : 'text-white/70 hover:text-white hover:bg-white/10' }}" href="{{ route('client-notifications.index') }}">Client Notifs</a>
            <a class="block px-3 py-2 rounded-lg text-sm font-medium transition duration-150 ease-in-out {{ request()->routeIs('activity-logs.*') ? 'text-white bg-white/15' : 'text-white/70 hover:text-white hover:bg-white/10' }}" href="{{ route('activity-logs.index') }}">Activity Logs</a>

            <div class="pt-2 pb-1">
                <p class="px-3 text-xs font-semibold text-white/50 uppercase tracking-wider">Services</p>
            </div>
            <a class="block px-3 py-2 rounded-lg text-sm font-medium transition duration-150 ease-in-out {{ request()->routeIs('pre-need-plans.*') ? 'text-white bg-white/15' : 'text-white/70 hover:text-white hover:bg-white/10' }}" href="{{ route('pre-need-plans.index') }}">Pre-Need Plans</a>
            <a class="block px-3 py-2 rounded-lg text-sm font-medium transition duration-150 ease-in-out {{ request()->routeIs('columbary-niches.*') ? 'text-white bg-white/15' : 'text-white/70 hover:text-white hover:bg-white/10' }}" href="{{ route('columbary-niches.index') }}">Columbary Niches</a>
            <a class="block px-3 py-2 rounded-lg text-sm font-medium transition duration-150 ease-in-out {{ request()->routeIs('cemetery.*') ? 'text-white bg-white/15' : 'text-white/70 hover:text-white hover:bg-white/10' }}" href="{{ route('cemetery.admin') }}">Cemetery Map</a>
            <a class="block px-3 py-2 rounded-lg text-sm font-medium transition duration-150 ease-in-out {{ request()->routeIs('paths.*') ? 'text-white bg-white/15' : 'text-white/70 hover:text-white hover:bg-white/10' }}" href="{{ route('paths.index') }}">Pathways</a>

            <div class="pt-2 pb-1">
                <p class="px-3 text-xs font-semibold text-white/50 uppercase tracking-wider">Account</p>
            </div>
            <a class="block px-3 py-2 rounded-lg text-sm font-medium transition duration-150 ease-in-out {{ request()->routeIs('notifications.*') ? 'text-white bg-white/15' : 'text-white/70 hover:text-white hover:bg-white/10' }}" href="{{ route('notifications.index') }}">Notifications</a>
            <a class="block px-3 py-2 rounded-lg text-sm font-medium transition duration-150 ease-in-out" href="{{ route('profile.edit') }}">Profile</a>
        </div>
    </div>
</nav>