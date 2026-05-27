<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                📅 Daily Activity View — Team Handover
            </h2>
            {{-- Print Button --}}
            <button onclick="window.print()"
                class="bg-gray-600 hover:bg-gray-700 text-white 
                       font-bold py-2 px-4 rounded">
                🖨️ Print / Export
            </button>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            {{-- Date Picker --}}
            <div class="bg-white shadow-sm sm:rounded-lg p-6 mb-6">
                <form method="GET" action="{{ route('daily.index') }}"
                      class="flex items-end gap-4">
                    <div>
                        <label class="block text-gray-700 
                                      font-semibold mb-2">
                            📅 Select Date
                        </label>
                        <input type="date"
                            name="date"
                            value="{{ $date }}"
                            class="border border-gray-300 rounded 
                                   px-3 py-2 focus:outline-none 
                                   focus:border-blue-500">
                    </div>
                    <button type="submit"
                        class="bg-blue-600 hover:bg-blue-700 text-white 
                               font-bold py-2 px-6 rounded">
                        🔍 View
                    </button>
                    <a href="{{ route('daily.index') }}"
                       class="bg-gray-200 hover:bg-gray-300 text-gray-700 
                              font-bold py-2 px-4 rounded">
                        Today
                    </a>
                </form>
            </div>

            {{-- Date Heading --}}
            <div class="mb-4">
                <h3 class="text-lg font-bold text-gray-700">
                    Showing activities for:
                    <span class="text-blue-600">
                        {{ \Carbon\Carbon::parse($date)->format('l, d F Y') }}
                    </span>
                </h3>
            </div>

            {{-- Summary Cards --}}
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">

                <div class="bg-white shadow-sm sm:rounded-lg p-6 
                            border-l-4 border-blue-500">
                    <div class="text-3xl font-bold text-blue-600">
                        {{ $totalActivities }}
                    </div>
                    <div class="text-gray-600 font-semibold mt-1">
                        Total Activities
                    </div>
                </div>

                <div class="bg-white shadow-sm sm:rounded-lg p-6 
                            border-l-4 border-green-500">
                    <div class="text-3xl font-bold text-green-600">
                        {{ $doneActivities }}
                    </div>
                    <div class="text-gray-600 font-semibold mt-1">
                        ✅ Done
                    </div>
                </div>

                <div class="bg-white shadow-sm sm:rounded-lg p-6 
                            border-l-4 border-yellow-500">
                    <div class="text-3xl font-bold text-yellow-600">
                        {{ $pendingActivities }}
                    </div>
                    <div class="text-gray-600 font-semibold mt-1">
                        ⏳ Pending
                    </div>
                </div>

            </div>

            @if($totalActivities > 0)

                {{-- Activities Table --}}
                <div class="bg-white shadow-sm sm:rounded-lg p-6 mb-6">
                    <h4 class="text-lg font-bold text-gray-800 mb-4">
                        📋 Activities for This Day
                    </h4>

                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="border-b-2 border-gray-200 
                                       bg-gray-50">
                                <th class="py-3 px-4 text-gray-600">
                                    Title
                                </th>
                                <th class="py-3 px-4 text-gray-600">
                                    Status
                                </th>
                                <th class="py-3 px-4 text-gray-600">
                                    Created By
                                </th>
                                <th class="py-3 px-4 text-gray-600">
                                    Created At
                                </th>
                                <th class="py-3 px-4 text-gray-600">
                                    Last Updated
                                </th>
                                <th class="py-3 px-4 text-gray-600">
                                    Updates
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($activities as $activity)
                            <tr class="border-b border-gray-100 
                                       hover:bg-gray-50">
                                <td class="py-3 px-4 font-medium">
                                    {{ $activity->title }}
                                    @if($activity->description)
                                        <p class="text-xs text-gray-400 
                                                   mt-1">
                                            {{ Str::limit(
                                                $activity->description, 
                                                60) }}
                                        </p>
                                    @endif
                                </td>
                                <td class="py-3 px-4">
                                    @if($activity->status === 'done')
                                        <span class="bg-green-100 
                                            text-green-800 px-2 py-1 
                                            rounded text-sm font-semibold">
                                            ✅ Done
                                        </span>
                                    @else
                                        <span class="bg-yellow-100 
                                            text-yellow-800 px-2 py-1 
                                            rounded text-sm font-semibold">
                                            ⏳ Pending
                                        </span>
                                    @endif
                                </td>
                                <td class="py-3 px-4 text-gray-600">
                                    {{ $activity->user->name }}
                                </td>
                                <td class="py-3 px-4 text-gray-500 text-sm">
                                    {{ $activity->created_at
                                        ->format('H:i:s') }}
                                </td>
                                <td class="py-3 px-4 text-gray-500 text-sm">
                                    {{ $activity->updated_at
                                        ->format('H:i:s') }}
                                </td>
                                <td class="py-3 px-4">
                                    <span class="bg-blue-100 text-blue-800 
                                                 px-2 py-1 rounded text-sm">
                                        {{ $activity->logs->count() }}
                                        log(s)
                                    </span>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                {{-- Full Audit Trail for the Day --}}
                <div class="bg-white shadow-sm sm:rounded-lg p-6">
                    <h4 class="text-lg font-bold text-gray-800 mb-4">
                        📜 Full Audit Trail for This Day
                        <span class="text-sm font-normal text-gray-500">
                            (All updates in chronological order)
                        </span>
                    </h4>

                    @if($allLogs->count() > 0)
                        <div class="space-y-3">
                            @foreach($allLogs as $log)
                            <div class="flex items-start gap-4 p-4 
                                        rounded-lg border border-gray-100
                                        hover:bg-gray-50">

                                {{-- Timeline dot --}}
                                <div class="mt-1 w-3 h-3 rounded-full 
                                    flex-shrink-0
                                    {{ $log->new_status === 'done' 
                                        ? 'bg-green-500' 
                                        : 'bg-yellow-500' }}">
                                </div>

                                <div class="flex-1">
                                    {{-- Who and what --}}
                                    <div class="flex justify-between 
                                                items-start">
                                        <div>
                                            <span class="font-semibold 
                                                         text-gray-800">
                                                {{ $log->user->name }}
                                            </span>
                                            <span class="text-gray-500 
                                                         text-sm ml-2">
                                                updated
                                            </span>
                                            <span class="font-medium 
                                                         text-blue-600 
                                                         text-sm ml-1">
                                                "{{ $log->activity->title }}"
                                            </span>
                                        </div>
                                        {{-- Exact timestamp --}}
                                        <span class="text-xs text-gray-400 
                                                     whitespace-nowrap ml-4
                                                     bg-gray-100 px-2 py-1 
                                                     rounded">
                                            🕐 {{ $log->created_at
                                                    ->format('H:i:s') }}
                                        </span>
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
                                                Status changed:
                                            </span>
                                            <span class="font-semibold 
                                                         text-red-500">
                                                {{ ucfirst($log->old_status) }}
                                            </span>
                                            <span class="text-gray-400 mx-1">
                                                →
                                            </span>
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
                            No updates recorded for this day.
                        </p>
                    @endif
                </div>

            @else
                {{-- No Activities Found --}}
                <div class="bg-white shadow-sm sm:rounded-lg p-12 
                            text-center">
                    <div class="text-6xl mb-4">📭</div>
                    <p class="text-xl text-gray-500">
                        No activities found for this date.
                    </p>
                    <p class="text-gray-400 mt-2">
                        Try selecting a different date or
                        <a href="{{ route('activities.create') }}"
                           class="text-blue-600 hover:underline">
                            create a new activity
                        </a>.
                    </p>
                </div>
            @endif

        </div>
    </div>
</x-app-layout>