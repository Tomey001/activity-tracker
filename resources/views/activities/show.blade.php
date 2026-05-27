<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                👁️ Activity Details
            </h2>
            <a href="{{ route('activities.index') }}"
               class="text-blue-600 hover:underline">
                ← Back to Activities
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">

            {{-- Success Message --}}
            @if(session('success'))
                <div class="bg-green-100 border border-green-400 
                            text-green-700 px-4 py-3 rounded mb-6">
                    {{ session('success') }}
                </div>
            @endif

            {{-- Activity Card --}}
            <div class="bg-white shadow-sm sm:rounded-lg p-6 mb-6">
                <div class="flex justify-between items-start">
                    <div>
                        <h3 class="text-2xl font-bold text-gray-800 mb-2">
                            {{ $activity->title }}
                        </h3>
                        <p class="text-gray-600 mb-4">
                            {{ $activity->description ?? 'No description.' }}
                        </p>
                        <div class="flex gap-4 text-sm text-gray-500">
                            <span>📅 
                                {{ $activity->activity_date->format('d M Y') }}
                            </span>
                            <span>👤 {{ $activity->user->name }}</span>
                            <span>🕐 
                                {{ $activity->created_at->format('d M Y H:i') }}
                            </span>
                        </div>
                    </div>
                    <div class="flex flex-col gap-2 items-end">
                        @if($activity->status === 'done')
                            <span class="bg-green-100 text-green-800 
                                         px-3 py-1 rounded-full font-semibold">
                                ✅ Done
                            </span>
                        @else
                            <span class="bg-yellow-100 text-yellow-800 
                                         px-3 py-1 rounded-full font-semibold">
                                ⏳ Pending
                            </span>
                        @endif
                        <a href="{{ route('activities.edit', $activity->id) }}"
                           class="bg-yellow-500 hover:bg-yellow-600 text-white 
                                  px-4 py-1 rounded text-sm">
                            ✏️ Edit
                        </a>
                    </div>
                </div>
            </div>

            {{-- Audit Trail / Logs --}}
            <div class="bg-white shadow-sm sm:rounded-lg p-6">
                <h4 class="text-lg font-bold text-gray-800 mb-4">
                    📜 Activity History (Audit Trail)
                </h4>

                @if($logs->count() > 0)
                    <div class="space-y-4">
                        @foreach($logs as $log)
                        <div class="border-l-4 border-blue-400 pl-4 py-2">
                            <div class="flex justify-between items-start">
                                <div>
                                    <p class="font-semibold text-gray-800">
                                        {{ $log->user->name }}
                                    </p>
                                    <p class="text-sm text-gray-600">
                                        @if($log->old_status === null)
                                            Created with status:
                                            <span class="font-semibold">
                                                {{ ucfirst($log->new_status) }}
                                            </span>
                                        @else
                                            Changed status from
                                            <span class="font-semibold 
                                                text-red-600">
                                                {{ ucfirst($log->old_status) }}
                                            </span>
                                            to
                                            <span class="font-semibold 
                                                text-green-600">
                                                {{ ucfirst($log->new_status) }}
                                            </span>
                                        @endif
                                    </p>
                                    @if($log->remark)
                                        <p class="text-sm text-gray-500 mt-1">
                                            💬 {{ $log->remark }}
                                        </p>
                                    @endif
                                </div>
                                <span class="text-xs text-gray-400 
                                             whitespace-nowrap ml-4">
                                    🕐 {{ $log->created_at
                                            ->format('d M Y H:i:s') }}
                                </span>
                            </div>
                        </div>
                        @endforeach
                    </div>
                @else
                    <p class="text-gray-500">No history yet.</p>
                @endif
            </div>

        </div>
    </div>
</x-app-layout>