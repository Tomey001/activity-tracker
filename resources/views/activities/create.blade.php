<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            ➕ Create New Activity
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">

                    <form method="POST" action="{{ route('activities.store') }}">
                        @csrf

                        {{-- Title --}}
                        <div class="mb-4">
                            <label class="block text-gray-700 font-semibold mb-2">
                                Activity Title *
                            </label>
                            <input type="text"
                                name="title"
                                value="{{ old('title') }}"
                                placeholder="e.g. Daily SMS count compared to SMS logs"
                                class="w-full border border-gray-300 rounded 
                                       px-3 py-2 focus:outline-none 
                                       focus:border-blue-500
                                       @error('title') border-red-500 @enderror">
                            @error('title')
                                <p class="text-red-500 text-sm mt-1">
                                    {{ $message }}
                                </p>
                            @enderror
                        </div>

                        {{-- Description --}}
                        <div class="mb-4">
                            <label class="block text-gray-700 font-semibold mb-2">
                                Description (optional)
                            </label>
                            <textarea name="description"
                                rows="3"
                                placeholder="Add more details about this activity..."
                                class="w-full border border-gray-300 rounded 
                                       px-3 py-2 focus:outline-none 
                                       focus:border-blue-500">
                                {{ old('description') }}
                            </textarea>
                        </div>

                        {{-- Status --}}
                        <div class="mb-4">
                            <label class="block text-gray-700 font-semibold mb-2">
                                Status *
                            </label>
                            <select name="status"
                                class="w-full border border-gray-300 rounded 
                                       px-3 py-2 focus:outline-none 
                                       focus:border-blue-500">
                                <option value="pending" 
                                    {{ old('status') == 'pending' 
                                        ? 'selected' : '' }}>
                                    ⏳ Pending
                                </option>
                                <option value="done" 
                                    {{ old('status') == 'done' 
                                        ? 'selected' : '' }}>
                                    ✅ Done
                                </option>
                            </select>
                        </div>

                        {{-- Activity Date --}}
                        <div class="mb-6">
                            <label class="block text-gray-700 font-semibold mb-2">
                                Activity Date *
                            </label>
                            <input type="date"
                                name="activity_date"
                                value="{{ old('activity_date', date('Y-m-d')) }}"
                                class="w-full border border-gray-300 rounded 
                                       px-3 py-2 focus:outline-none 
                                       focus:border-blue-500
                                       @error('activity_date') 
                                           border-red-500 
                                       @enderror">
                            @error('activity_date')
                                <p class="text-red-500 text-sm mt-1">
                                    {{ $message }}
                                </p>
                            @enderror
                        </div>

                        {{-- Buttons --}}
                        <div class="flex gap-4">
                            <button type="submit"
                                class="bg-blue-600 hover:bg-blue-700 
                                       text-white font-bold py-2 px-6 rounded">
                                💾 Save Activity
                            </button>
                            <a href="{{ route('activities.index') }}"
                               class="bg-gray-300 hover:bg-gray-400 
                                      text-gray-800 font-bold py-2 px-6 rounded">
                                Cancel
                            </a>
                        </div>

                    </form>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>