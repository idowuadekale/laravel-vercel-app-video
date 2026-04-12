<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                <div class="max-w-xl">
                    <section>
                        <header>
                            <h6 class="p-6 text-gray-900 ">
                                @php
                                    $roleLabel = match (Auth::user()->role) {
                                        'super' => 'Super Admin',
                                        'admin' => 'Admin',
                                        'developer' => 'Developer',
                                        default => 'User',
                                    };
                                @endphp
                                Welcome back, {{ Auth::user()->name }}! ({{ $roleLabel }}) 🎉 <br>
                                <small>
                                    {{ __("You're logged in!") }}
                                    <a style="text-decoration: underline; color:green;"
                                        href="{{ route('welcome') }}">Click to access
                                        the homepage.</a>
                                </small>
                            </h6>
                            <h2 class="text-lg font-medium text-gray-900">
                                {{ __('Adminstration Maintenance') }}
                            </h2>

                            <p class="mt-1 text-sm text-gray-600">
                                {{ __('The Administration Maintenance panel lets authorized admins add, edit, or remove important data and system settings. Access should be limited to trusted users, as changes in this section can affect how the entire application functions.') }}
                            </p>
                        </header>

                        @php
                            $user = auth()->user();
                        @endphp

                        <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-3 gap-4 my-6">

                            {{-- Developer sees everything --}}
                            @if ($user->role === 'developer')
                                {{-- All links --}}

                                <a href="{{ route('landing.edit') }}"
                                    class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded text-center">
                                    {{ __('Manage HomePage') }}
                                </a>

                                <a href="#"
                                    class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded text-center">
                                    {{ __('Manage About Page') }}
                                </a>

                                <a href="{{ route('team.create') }}"
                                    class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded text-center w-auto">
                                    {{ __('Lasu C&S Leaders') }}
                                </a>

                                <a href="{{ route('executives.create') }}"
                                    class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded text-center w-auto">
                                    {{ __('Ojo Executives') }}
                                </a>

                                <a href="{{ route('secretaries.create') }}"
                                    class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded text-center">
                                    {{ __('Other Executives') }}
                                </a>

                                <a href="{{ route('programs.create') }}"
                                    class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded text-center">
                                    {{ __('Manage Program') }}
                                </a>

                                <a href="{{ route('galleries.create') }}"
                                    class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded text-center">
                                    {{ __('Manage Gallery') }}
                                </a>

                                <a href="{{ route('templates.index') }}"
                                    class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded text-center">
                                    {{ __('Manage Newsletter') }}
                                </a>

                                <a href="{{ route('social.edit') }}"
                                    class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded text-center">
                                    {{ __('Manage Socials') }}
                                </a>

                                <a href="{{ route('activities.create') }}"
                                    class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded text-center">
                                    {{ __('Manage Activities') }}
                                </a>

                                <a href="{{ route('faqs.create') }}"
                                    class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded text-center">
                                    {{ __('Manage Faqs') }}
                                </a>

                                <a href="{{ route('hero.create') }}"
                                    class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded text-center">
                                    {{ __('Manage Home Image') }}
                                </a>

                                <a href="{{ route('images.create') }}"
                                    class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded text-center">
                                    {{ __('Manage Group Images') }}
                                </a>

                                <a href="{{ route('announcements.create') }}"
                                    class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded text-center">
                                    {{ __('Manage Announcement') }}
                                </a>

                                <a href="{{ route('admin-year.index') }}"
                                    class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded text-center">
                                    {{ __('Manage Administration Year') }}
                                </a>

                                <a href="{{ route('leaders.create') }}"
                                    class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded text-center w-auto">
                                    {{ __('Past & Present Leaders') }}
                                </a>

                                <a href="{{ route('birthday.create') }}"
                                    class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded text-center w-auto">
                                    {{ __('Member Birthday') }}
                                </a>

                                {{-- Developer management --}}
                                <a href="{{ route('developer.dashboard') }}"
                                    class="bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded text-center">
                                    {{ __('Developer Dashboard') }}
                                </a>

                                <a href="{{ route('audit.index') }}"
                                    class="bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded text-center">
                                    {{ __('Audit Trail') }}
                                </a>
                            @endif

                            {{-- Admin sees only their management links --}}
                            @if ($user->role === 'admin')
                                {{-- <a href="{{ route('audit.index') }}"
                                    class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded text-center">
                                    {{ __('Audit Trail') }}
                                </a> --}}

                                <a href="{{ route('landing.edit') }}"
                                    class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded text-center">
                                    {{ __('Manage HomePage') }}
                                </a>

                                <a href="#"
                                    class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded text-center">
                                    {{ __('Manage About Page') }}
                                </a>

                                <a href="{{ route('team.create') }}"
                                    class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded text-center w-auto">
                                    {{ __('Lasu C&S Leaders') }}
                                </a>

                                <a href="{{ route('executives.create') }}"
                                    class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded text-center w-auto">
                                    {{ __('Ojo Executives') }}
                                </a>

                                <a href="{{ route('secretaries.create') }}"
                                    class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded text-center">
                                    {{ __('Other Executives') }}
                                </a>

                                <a href="{{ route('programs.create') }}"
                                    class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded text-center">
                                    {{ __('Manage Program') }}
                                </a>

                                <a href="{{ route('galleries.create') }}"
                                    class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded text-center">
                                    {{ __('Manage Gallery') }}
                                </a>

                                <a href="{{ route('templates.index') }}"
                                    class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded text-center">
                                    {{ __('Manage Newsletter') }}
                                </a>

                                <a href="{{ route('social.edit') }}"
                                    class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded text-center">
                                    {{ __('Manage Socials') }}
                                </a>

                                <a href="{{ route('activities.create') }}"
                                    class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded text-center">
                                    {{ __('Manage Activities') }}
                                </a>

                                <a href="{{ route('faqs.create') }}"
                                    class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded text-center">
                                    {{ __('Manage Faqs') }}
                                </a>

                                <a href="{{ route('hero.create') }}"
                                    class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded text-center">
                                    {{ __('Manage Home Image') }}
                                </a>

                                <a href="{{ route('images.create') }}"
                                    class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded text-center">
                                    {{ __('Manage Group Images') }}
                                </a>

                                <a href="{{ route('announcements.create') }}"
                                    class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded text-center">
                                    {{ __('Manage Announcement') }}
                                </a>

                                <a href="{{ route('admin-year.index') }}"
                                    class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded text-center">
                                    {{ __('Manage Administration Year') }}
                                </a>

                                <a href="{{ route('leaders.create') }}"
                                    class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded text-center w-auto">
                                    {{ __('Past & Present Leaders') }}
                                </a>

                                <a href="{{ route('birthday.create') }}"
                                    class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded text-center w-auto">
                                    {{ __('Member Birthday') }}
                                </a>
                            @endif

                            {{-- Super Admin sees only admin create/store/index --}}
                            @if ($user->role === 'super')
                                <a href="{{ route('audit.index') }}"
                                    class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded text-center">
                                    {{ __('Audit Trail') }}
                                </a>

                                <a href="{{ route('superadmin.index') }}"
                                    class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded text-center">
                                    {{ __('Manage Admin') }}
                                </a>
                            @endif

                        </div>

                    </section>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
