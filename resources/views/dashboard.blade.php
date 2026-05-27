<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            🏠 Dashboard
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            {{-- Welcome Card --}}
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6 text-gray-900">
                    <h3 class="text-2xl font-bold mb-2">
                        👋 Welcome, {{ Auth::user()->name }}!
                    </h3>
                    <p class="text-gray-600">
                        You are logged in as:
                        <span class="font-semibold text-blue-600">
                            {{ Auth::user()->email }}
                        </span>
                        —
                        <span class="inline-block bg-green-100 text-green-800 
                                     px-2 py-1 rounded text-sm font-semibold">
                            {{ ucfirst(Auth::user()->role) }}
                        </span>
                    </p>
                </div>
            </div>

            {{-- Quick Stats Cards --}}
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">

                <div class="bg-white rounded-lg shadow-sm p-5 
                            border-t-4 border-blue-500">
                    <div class="text-3xl font-bold text-blue-600">
                        {{ $todayActivities }}
                    </div>
                    <div class="text-gray-500 text-sm mt-1">
                        Today's Activities
                    </div>
                </div>

                <div class="bg-white rounded-lg shadow-sm p-5 
                            border-t-4 border-green-500">
                    <div class="text-3xl font-bold text-green-600">
                        {{ $todayDone }}
                    </div>
                    <div class="text-gray-500 text-sm mt-1">
                        ✅ Done Today
                    </div>
                </div>

                <div class="bg-white rounded-lg shadow-sm p-5 
                            border-t-4 border-yellow-500">
                    <div class="text-3xl font-bold text-yellow-600">
                        {{ $todayPending }}
                    </div>
                    <div class="text-gray-500 text-sm mt-1">
                        ⏳ Pending Today
                    </div>
                </div>

                <div class="bg-white rounded-lg shadow-sm p-5 
                            border-t-4 border-purple-500">
                    <div class="text-3xl font-bold text-purple-600">
                        {{ $totalActivities }}
                    </div>
                    <div class="text-gray-500 text-sm mt-1">
                        📦 All Time Total
                    </div>
                </div>

            </div>



            {{-- Bottom Two Columns --}}
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                {{-- Recent Activities --}}
                <div class="bg-white rounded-lg shadow-sm p-6">
                    <div class="flex justify-between items-center mb-4">
                        <h4 class="font-bold text-gray-800">
                            🕐 Recent Activities
                        </h4>
                        <a href="{{ route('activities.index') }}"
                           class="text-blue-600 hover:underline text-sm">
                            View all →
                        </a>
                    </div>

                    @if($recentActivities->count() > 0)
                        <div class="space-y-3">
                            @foreach($recentActivities as $activity)
                            <div class="flex justify-between items-center 
                                        py-2 border-b border-gray-100 
                                        last:border-0">
                                <div>
                                    <a href="{{ route('activities.show',
                                            $activity->id) }}"
                                       class="text-sm font-medium 
                                              text-gray-800 
                                              hover:text-blue-600">
                                        {{ \Illuminate\Support\Str::limit(
                                            $activity->title, 40) }}
                                    </a>
                                    <div class="text-xs text-gray-400 mt-0.5">
                                        {{ $activity->user->name }} •
                                        {{ $activity->activity_date
                                            ->format('d M Y') }}
                                    </div>
                                </div>
                                @if($activity->status === 'done')
                                    <span class="bg-green-100 text-green-700 
                                                 text-xs px-2 py-1 rounded-full
                                                 font-semibold shrink-0">
                                        ✅ Done
                                    </span>
                                @else
                                    <span class="bg-yellow-100 text-yellow-700
                                                 text-xs px-2 py-1 rounded-full
                                                 font-semibold shrink-0">
                                        ⏳ Pending
                                    </span>
                                @endif
                            </div>
                            @endforeach
                        </div>
                    @else
                        <div class="text-center py-8 text-gray-400">
                            <div class="text-3xl mb-2">📭</div>
                            <p class="text-sm">No activities yet.</p>
                            <a href="{{ route('activities.create') }}"
                               class="text-blue-600 hover:underline 
                                      text-sm mt-1 block">
                                Create your first one →
                            </a>
                        </div>
                    @endif
                </div>

                {{-- Recent Updates (Audit Trail) --}}
                <div class="bg-white rounded-lg shadow-sm p-6">
                    <div class="flex justify-between items-center mb-4">
                        <h4 class="font-bold text-gray-800">
                            📜 Recent Updates
                        </h4>
                        <a href="{{ route('reports.index') }}"
                           class="text-blue-600 hover:underline text-sm">
                            Full report →
                        </a>
                    </div>

                    @if($recentLogs->count() > 0)
                        <div class="space-y-3">
                            @foreach($recentLogs as $log)
                            <div class="flex gap-3 py-2 border-b 
                                        border-gray-100 last:border-0">
                                <div class="mt-1.5 w-2.5 h-2.5 rounded-full 
                                    flex-shrink-0
                                    {{ $log->new_status === 'done'
                                        ? 'bg-green-500'
                                        : 'bg-yellow-500' }}">
                                </div>
                                <div class="flex-1 min-w-0">
                                    <p class="text-sm text-gray-800">
                                        <span class="font-semibold">
                                            {{ $log->user->name }}
                                        </span>
                                        <span class="text-gray-500">
                                            updated
                                        </span>
                                    </p>
                                    <p class="text-xs text-blue-600 truncate">
                                        "{{ $log->activity->title }}"
                                    </p>
                                    <p class="text-xs text-gray-400 mt-0.5">
                                        🕐 {{ $log->created_at
                                            ->diffForHumans() }}
                                    </p>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    @else
                        <div class="text-center py-8 text-gray-400">
                            <div class="text-3xl mb-2">📝</div>
                            <p class="text-sm">No updates yet.</p>
                        </div>
                    @endif
                </div>

            </div>

        </div>
    </div>
</x-app-layout>