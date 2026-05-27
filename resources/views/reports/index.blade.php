<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                📊 Activity Reports
            </h2>
            <button onclick="window.print()"
                class="bg-gray-600 hover:bg-gray-700 text-white 
                       font-bold py-2 px-4 rounded">
                🖨️ Print Report
            </button>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            {{-- Filter Panel --}}
            <div class="bg-white shadow-sm sm:rounded-lg p-6 mb-6">
                <h4 class="font-bold text-gray-700 mb-4">
                    🔍 Filter Activities
                </h4>
                <form method="GET" action="{{ route('reports.index') }}">
                    <div class="grid grid-cols-1 md:grid-cols-4 gap-4">

                        {{-- Start Date --}}
                        <div>
                            <label class="block text-gray-600 
                                          text-sm font-semibold mb-1">
                                Start Date
                            </label>
                            <input type="date"
                                name="start_date"
                                value="{{ $startDate }}"
                                class="w-full border border-gray-300 
                                       rounded px-3 py-2 text-sm
                                       focus:outline-none 
                                       focus:border-blue-500">
                        </div>

                        {{-- End Date --}}
                        <div>
                            <label class="block text-gray-600 
                                          text-sm font-semibold mb-1">
                                End Date
                            </label>
                            <input type="date"
                                name="end_date"
                                value="{{ $endDate }}"
                                class="w-full border border-gray-300 
                                       rounded px-3 py-2 text-sm
                                       focus:outline-none 
                                       focus:border-blue-500">
                        </div>

                        {{-- Status Filter --}}
                        <div>
                            <label class="block text-gray-600 
                                          text-sm font-semibold mb-1">
                                Status
                            </label>
                            <select name="status"
                                class="w-full border border-gray-300 
                                       rounded px-3 py-2 text-sm
                                       focus:outline-none 
                                       focus:border-blue-500">
                                <option value="all"
                                    {{ $statusFilter == 'all' 
                                        ? 'selected' : '' }}>
                                    All Statuses
                                </option>
                                <option value="done"
                                    {{ $statusFilter == 'done' 
                                        ? 'selected' : '' }}>
                                    ✅ Done Only
                                </option>
                                <option value="pending"
                                    {{ $statusFilter == 'pending' 
                                        ? 'selected' : '' }}>
                                    ⏳ Pending Only
                                </option>
                            </select>
                        </div>

                        {{-- Submit Button --}}
                        <div class="flex items-end gap-2">
                            <button type="submit"
                                class="flex-1 bg-blue-600 hover:bg-blue-700 
                                       text-white font-bold py-2 px-4 
                                       rounded text-sm">
                                🔍 Filter
                            </button>
                            <a href="{{ route('reports.index') }}"
                               class="bg-gray-200 hover:bg-gray-300 
                                      text-gray-700 font-bold py-2 px-4 
                                      rounded text-sm">
                                Reset
                            </a>
                        </div>

                    </div>
                </form>
            </div>

            {{-- Active Filter Info --}}
            <div class="mb-4 text-sm text-gray-600">
                Showing results from
                <span class="font-semibold text-blue-600">
                    {{ \Carbon\Carbon::parse($startDate)
                        ->format('d M Y') }}
                </span>
                to
                <span class="font-semibold text-blue-600">
                    {{ \Carbon\Carbon::parse($endDate)
                        ->format('d M Y') }}
                </span>
                @if($statusFilter !== 'all')
                    — Status:
                    <span class="font-semibold">
                        {{ ucfirst($statusFilter) }}
                    </span>
                @endif
            </div>

            {{-- Summary Cards --}}
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">

                <div class="bg-white shadow-sm sm:rounded-lg p-6 
                            border-l-4 border-blue-500">
                    <div class="text-3xl font-bold text-blue-600">
                        {{ $totalCount }}
                    </div>
                    <div class="text-gray-600 font-semibold mt-1">
                        Total Activities
                    </div>
                </div>

                <div class="bg-white shadow-sm sm:rounded-lg p-6 
                            border-l-4 border-green-500">
                    <div class="text-3xl font-bold text-green-600">
                        {{ $doneCount }}
                    </div>
                    <div class="text-gray-600 font-semibold mt-1">
                        ✅ Done
                    </div>
                    @if($totalCount > 0)
                        <div class="text-sm text-gray-400 mt-1">
                            {{ round(($doneCount / $totalCount) * 100) }}%
                            completion rate
                        </div>
                    @endif
                </div>

                <div class="bg-white shadow-sm sm:rounded-lg p-6 
                            border-l-4 border-yellow-500">
                    <div class="text-3xl font-bold text-yellow-600">
                        {{ $pendingCount }}
                    </div>
                    <div class="text-gray-600 font-semibold mt-1">
                        ⏳ Pending
                    </div>
                </div>

            </div>

            @if($totalCount > 0)

                {{-- Activities Table --}}
                <div class="bg-white shadow-sm sm:rounded-lg p-6 mb-6">
                    <h4 class="font-bold text-gray-800 mb-4">
                        📋 Activity Results
                        <span class="text-sm font-normal text-gray-500">
                            ({{ $totalCount }} total)
                        </span>
                    </h4>

                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="border-b-2 border-gray-200 bg-gray-50">
                                <th class="py-3 px-4 text-gray-600 text-sm">
                                    Title
                                </th>
                                <th class="py-3 px-4 text-gray-600 text-sm">
                                    Date
                                </th>
                                <th class="py-3 px-4 text-gray-600 text-sm">
                                    Status
                                </th>
                                <th class="py-3 px-4 text-gray-600 text-sm">
                                    Created By
                                </th>
                                <th class="py-3 px-4 text-gray-600 text-sm">
                                    Updates
                                </th>
                                <th class="py-3 px-4 text-gray-600 text-sm">
                                    Action
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($activities as $activity)
                            <tr class="border-b border-gray-100 
                                       hover:bg-gray-50">
                                <td class="py-3 px-4 font-medium text-sm">
                                    {{ $activity->title }}
                                </td>
                                <td class="py-3 px-4 text-gray-600 text-sm">
                                    {{ $activity->activity_date
                                        ->format('d M Y') }}
                                </td>
                                <td class="py-3 px-4">
                                    @if($activity->status === 'done')
                                        <span class="bg-green-100 
                                            text-green-800 px-2 py-1 
                                            rounded text-xs font-semibold">
                                            ✅ Done
                                        </span>
                                    @else
                                        <span class="bg-yellow-100 
                                            text-yellow-800 px-2 py-1 
                                            rounded text-xs font-semibold">
                                            ⏳ Pending
                                        </span>
                                    @endif
                                </td>
                                <td class="py-3 px-4 text-gray-600 text-sm">
                                    {{ $activity->user->name }}
                                </td>
                                <td class="py-3 px-4 text-center">
                                    <span class="bg-blue-100 text-blue-800 
                                                 px-2 py-1 rounded text-xs">
                                        {{ $activity->logs->count() }}
                                    </span>
                                </td>
                                <td class="py-3 px-4">
                                    <a href="{{ route('activities.show',
                                            $activity->id) }}"
                                       class="text-blue-600 hover:underline 
                                              text-sm">
                                        View →
                                    </a>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>

                    {{-- Pagination --}}
                    <div class="mt-4">
                        {{ $activities->links() }}
                    </div>
                </div>

                {{-- Full Log History --}}
                <div class="bg-white shadow-sm sm:rounded-lg p-6">
                    <h4 class="font-bold text-gray-800 mb-4">
                        📜 Full Update History
                        <span class="text-sm font-normal text-gray-500">
                            ({{ $logs->count() }} total updates in range)
                        </span>
                    </h4>

                    @if($logs->count() > 0)
                        <div class="space-y-3">
                            @foreach($logs as $log)
                            <div class="flex items-start gap-4 p-4 
                                        rounded-lg border border-gray-100
                                        hover:bg-gray-50">

                                {{-- Status dot --}}
                                <div class="mt-1 w-3 h-3 rounded-full 
                                    flex-shrink-0
                                    {{ $log->new_status === 'done'
                                        ? 'bg-green-500'
                                        : 'bg-yellow-500' }}">
                                </div>

                                <div class="flex-1">
                                    <div class="flex justify-between 
                                                items-start flex-wrap gap-2">
                                        <div>
                                            <span class="font-semibold 
                                                         text-gray-800 text-sm">
                                                {{ $log->user->name }}
                                            </span>
                                            <span class="text-gray-500 
                                                         text-sm mx-1">
                                                updated
                                            </span>
                                            <span class="font-medium 
                                                         text-blue-600 text-sm">
                                                "{{ $log->activity->title }}"
                                            </span>
                                        </div>
                                        <div class="text-right">
                                            <span class="text-xs text-gray-400
                                                    bg-gray-100 px-2 py-1 
                                                    rounded block">
                                                📅 {{ $log->created_at
                                                    ->format('d M Y') }}
                                                🕐 {{ $log->created_at
                                                    ->format('H:i:s') }}
                                            </span>
                                        </div>
                                    </div>

                                    {{-- Status change --}}
                                    <div class="mt-1 text-sm">
                                        @if($log->old_status === null)
                                            <span class="text-gray-500">
                                                Created with status:
                                            </span>
                                            <span class="font-semibold 
                                                         text-blue-600">
                                                {{ ucfirst($log->new_status) }}
                                            </span>
                                        @else
                                            <span class="text-gray-500">
                                                Status:
                                            </span>
                                            <span class="font-semibold 
                                                         text-red-500">
                                                {{ ucfirst($log->old_status) }}
                                            </span>
                                            →
                                            <span class="font-semibold 
                                                         text-green-600">
                                                {{ ucfirst($log->new_status) }}
                                            </span>
                                        @endif
                                    </div>

                                    {{-- Remark --}}
                                    @if($log->remark)
                                        <div class="mt-1 text-sm 
                                                    text-gray-500 italic">
                                            💬 "{{ $log->remark }}"
                                        </div>
                                    @endif
                                </div>
                            </div>
                            @endforeach
                        </div>

                    @else
                        <p class="text-gray-500 text-center py-6">
                            No update logs found in this date range.
                        </p>
                    @endif
                </div>

            @else
                {{-- No results --}}
                <div class="bg-white shadow-sm sm:rounded-lg p-12 
                            text-center">
                    <div class="text-6xl mb-4">🔍</div>
                    <p class="text-xl text-gray-500">
                        No activities found for the selected filters.
                    </p>
                    <p class="text-gray-400 mt-2">
                        Try a wider date range or different status filter.
                    </p>
                </div>
            @endif

        </div>
    </div>
</x-app-layout>