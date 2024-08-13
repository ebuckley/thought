<nav class="overflow-y-auto py-5 px-3 h-full bg-white border-r border-gray-200 dark:bg-gray-800 dark:border-gray-700">
    @if (Laravel\Jetstream\Jetstream::hasTeamFeatures())
        <div class="">
            <x-dropdown>
                <x-slot name="trigger">
                                    <span class="w-full flex rounded-md">
                                        <button type="button" class="flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 bg-white hover:text-gray-700 focus:outline-none focus:bg-gray-50 active:bg-gray-50 transition ease-in-out duration-150">
                                            <span class="font-bold text-xl">{{ Auth::user()->currentTeam->name }}</span>

                                            <svg class="ms-2 -me-0.5 h-4 w-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 15L12 18.75 15.75 15m-7.5-6L12 5.25 15.75 9" />
                                            </svg>
                                        </button>
                                    </span>
                </x-slot>

                <x-slot name="content">
                    <div class="w-60">
                        <!-- Team Management -->
                        <div class="block px-4 py-2 text-xs text-gray-400">
                            {{ __('Manage Team') }}
                        </div>

                        <!-- Team Settings -->
                        <x-dropdown-link href="{{ route('teams.show', Auth::user()->currentTeam->id) }}">
                            {{ __('Team Settings') }}
                        </x-dropdown-link>

                        @can('create', Laravel\Jetstream\Jetstream::newTeamModel())
                            <x-dropdown-link href="{{ route('teams.create') }}">
                                {{ __('Create New Team') }}
                            </x-dropdown-link>
                        @endcan

                        <!-- Team Switcher -->
                        @if (Auth::user()->allTeams()->count() > 1)
                            <div class="border-t border-gray-200"></div>

                            <div class="block px-4 py-2 text-xs text-gray-400">
                                {{ __('Switch Teams') }}
                            </div>

                            @foreach (Auth::user()->allTeams() as $team)
                                <x-switchable-team :team="$team" />
                            @endforeach
                        @endif
                    </div>
                </x-slot>
            </x-dropdown>
        </div>
    @endif
    <ul class="space-y-2">
        <li>
            <x-nav-link href="{{ route('dashboard') }}" :active="request()->routeIs('dashboard')">
                {{ __('Dashboard') }}
            </x-nav-link>
        </li>
        <li>
            <x-nav-link href="{{ route('notes.search') }}" :active="request()->routeIs('notes.search')">
                {{ __('Search') }}
            </x-nav-link>
        </li>
        <li>
            <x-nav-link href="{{route('files')}}" :active="request()->routeIs('files')">{{__('Files')}}</x-nav-link>
        </li>
    </ul>
    <div class="mt-5 pt-3 space-y-2 border-t border-gray-200">
        <span class="px-2 pt-4 font-semibold text-gray-500">ASSETS</span>
        @foreach(Auth::user()->currentTeam->assetTypes as $assetType)
            <x-nav-link href="{{route('structure.asset', $assetType)}}">
                {{Str::plural($assetType->name)}}
            </x-nav-link>
        @endforeach
        <x-nav-link href="{{route('structure.create')}}"> Add Asset </x-nav-link>
    </div>
</nav>
