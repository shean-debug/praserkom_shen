<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Edit Event</h2>
    </x-slot>

    <div class="py-12 max-w-2xl mx-auto sm:px-6 lg:px-8">
        <form action="{{ route('events.update', $event->id) }}" method="POST" enctype="multipart/form-data" class="bg-white p-6 rounded-lg shadow-sm border">
            @csrf
            @method('PUT')

            <div class="mb-4">
                <label class="block font-medium mb-1">Judul Event</label>
                <input type="text" name="title" value="{{ old('title', $event->title) }}" class="w-full border rounded p-2" required>
                @error('title') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
            </div>

            <div class="mb-4">
                <label class="block font-medium mb-1">Kategori</label>
                <select name="category" class="w-full border rounded p-2" required>
                    <option value="">-- Pilih Kategori --</option>
                    @foreach(['Musik', 'Festival', 'Seminar'] as $cat)
                        <option value="{{ $cat }}" {{ old('category', $event->category) == $cat ? 'selected' : '' }}>{{ $cat }}</option>
                    @endforeach
                </select>
                @error('category') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
            </div>

            <div class="mb-4">
                <label class="block font-medium mb-1">Harga Tiket (Rp)</label>
                <input type="number" name="ticket_price" value="{{ old('ticket_price', $event->ticket_price) }}" class="w-full border rounded p-2" required>
                @error('ticket_price') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
            </div>

            <div class="mb-4">
                <label class="block font-medium mb-1">Deskripsi</label>
                <textarea name="description" rows="3" class="w-full border rounded p-2" required>{{ old('description', $event->description) }}</textarea>
                @error('description') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
            </div>

            <div class="mb-4">
                <label class="block font-medium mb-1">Poster Baru (Opsional)</label>
                <input type="file" name="image" class="w-full border rounded p-2">
                @if($event->image)
                    <img src="{{ asset('storage/' . $event->image) }}" class="w-24 h-24 object-cover mt-2 rounded">
                @endif
                @error('image') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
            </div>

            <div class="flex gap-3">
                <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2.5 rounded font-semibold">Update Data</button>
                <a href="{{ route('events.index') }}" class="px-6 py-2.5 rounded border font-semibold text-gray-700">Batal</a>
            </div>
        </form>
    </div>
</x-app-layout>
