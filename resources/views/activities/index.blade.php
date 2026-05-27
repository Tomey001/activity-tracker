<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <div>
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        📋 All Activities
    </h2>
    <p class="text-sm text-gray-500 mt-1">
        Manage and track all daily activities
    </p>
</div>
            <a href="{{ route('activities.create') }}"
               class="bg-blue-600 hover:bg-blue-700 text-white font-bold 
                      py-2 px-4 rounded">
                + New Activity
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            {{-- Success Message --}}
            @if(session('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 
                            px-4 py-3 rounded mb-6">
                    {{ session('success') }}
                </div>
            @endif

            {{-- Activities Table --}}
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    @if($activities->count() > 0)
                        <table class="w-full text-left border-collapse">
                           <thead>
    <tr class="bg-gray-50 border-b-2 border-gray-200">
        <th class="py-3 px-4 text-gray-600 text-sm font-semibold">
            #
        </th>
        <th class="py-3 px-4 text-gray-600 text-sm font-semibold">
            Title
        </th>
        <th class="py-3 px-4 text-gray-600 text-sm font-semibold">
            Date
        </th>
        <th class="py-3 px-4 text-gray-600 text-sm font-semibold">
            Status
        </th>
        <th class="py-3 px-4 text-gray-600 text-sm font-semibold">
            Created By
        </th>
        <th class="py-3 px-4 text-gray-600 text-sm font-semibold">
            Last Updated
        </th>
        <th class="py-3 px-4 text-gray-600 text-sm font-semibold">
            Actions
        </th>
    </tr>
</thead>
                            <tbody>
                                @foreach($activities as $activity)
                                <tr class="border-b border-gray-100 
                                           hover:bg-gray-50">
                                    <td class="py-3 px-4 text-gray-500">
                                        {{ $activity->id }}
                                    </td>
                                    <td class="py-3 px-4 font-medium">
                                        {{ $activity->title }}
                                    </td>
                                    <td class="py-3 px-4 text-gray-600">
                                        {{ $activity->activity_date
                                            ->format('d M Y') }}
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
    {{ $activity->updated_at->diffForHumans() }}
</td>
                                    </td>
                                    <td class="py-3 px-4">
                                        <a href="{{ route('activities.show', 
                                                $activity->id) }}"
                                           class="text-blue-600 
                                                  hover:underline mr-3">
                                            View
                                        </a>
                                        <a href="{{ route('activities.edit', 
                                                $activity->id) }}"
                                           class="text-yellow-600 
                                                  hover:underline mr-3">
                                            Edit
                                        </a>
                                        <form method="POST"
                                            action="{{ route('activities.destroy',
                                                $activity->id) }}"
                                            style="display:inline"
                                            onsubmit="return confirm(
                                                'Are you sure?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                class="text-red-600 
                                                       hover:underline">
                                                Delete
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>

                        {{-- Pagination --}}
                        <div class="mt-4">
                            {{ $activities->links() }}
                        </div>

                    @else
                        <div class="text-center py-12 text-gray-500">
                            <div class="text-5xl mb-4">📭</div>
                            <p class="text-xl">No activities yet.</p>
                            <a href="{{ route('activities.create') }}"
                               class="mt-4 inline-block bg-blue-600 
                                      text-white px-6 py-2 rounded 
                                      hover:bg-blue-700">
                                Create Your First Activity
                            </a>
                        </div>
                    @endif
                </div>
            </div>

        </div>
    </div>
</x-app-layout>