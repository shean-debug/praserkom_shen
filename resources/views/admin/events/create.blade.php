<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Tambah Tiket</h2>
    </x-slot>

    <div class="py-12 max-w-2xl mx-auto sm:px-6 lg:px-8">
        <form action="{{ route('events.store') }}" method="POST" enctype="multipart/form-data" class="bg-white p-6 rounded-lg shadow-sm border">
            @csrf

            <div class="mb-4">
                <label class="block font-medium mb-1">Nama Tiket</label>
                <input type="text" name="title" value="{{ old('title') }}" class="w-full border rounded p-2" required>
                @error('title')
                    <span class="text-red-500 text-sm">{{ $message }}</span>
                @enderror
            </div>

            <div class="mb-4">
                <label class="block font-medium mb-1">Kategori</label>
                <select name="category" class="w-full border rounded p-2" required>
                    <option value="">-- Pilih Kategori --</option>
                    <option value="Musik" {{ old('category') == 'Musik' ? 'selected' : '' }}>Musik</option>
                    <option value="Festival" {{ old('category') == 'Festival' ? 'selected' : '' }}>Festival</option>
                    <option value="Seminar" {{ old('category') == 'Seminar' ? 'selected' : '' }}>Seminar</option>
                </select>
                @error('category')
                    <span class="text-red-500 text-sm">{{ $message }}</span>
                @enderror
            </div>

            <div class="mb-4">
                <label class="block font-medium mb-1">Harga (Rp)</label>
                <input type="number" name="ticket_price" value="{{ old('ticket_price') }}" class="w-full border rounded p-2" required>
                @error('ticket_price')
                    <span class="text-red-500 text-sm">{{ $message }}</span>
                @enderror
            </div>

            <div class="mb-4">
                <label class="block font-medium mb-1">Deskripsi</label>
                <textarea name="description" class="w-full border rounded p-2" rows="3" required>{{ old('description') }}</textarea>
                @error('description')
                    <span class="text-red-500 text-sm">{{ $message }}</span>
                @enderror
            </div>

            <div class="mb-4">
                <label class="block font-medium mb-1">Gambar Tiket</label>
                <input type="file" name="image" class="w-full border rounded p-2">
                @error('image')
                    <span class="text-red-500 text-sm">{{ $message }}</span>
                @enderror
            </div>

            <button type="submit" class="bg-green-600 hover:bg-green-700 text-white px-6 py-2.5 rounded font-semibold">
                Simpan Data
            </button>
        </form>
    </div>
</x-app-layout>
