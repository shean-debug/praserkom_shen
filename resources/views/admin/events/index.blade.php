<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Kelola Event</h2>
            <a href="{{ route('events.create') }}" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded font-semibold text-sm">
                + Tambah Event
            </a>
        </div>
    </x-slot>

    <div class="py-12 max-w-6xl mx-auto sm:px-6 lg:px-8">
        @if(session('success'))
            <div class="mb-4 p-3 bg-green-100 text-green-700 rounded">{{ session('success') }}</div>
        @endif
        @if(session('error'))
            <div class="mb-4 p-3 bg-red-100 text-red-700 rounded">{{ session('error') }}</div>
        @endif

        <div class="bg-white rounded-lg shadow-sm border overflow-x-auto">
            <table class="w-full text-left text-sm">
                <thead class="bg-gray-50 text-gray-600 uppercase text-xs">
                    <tr>
                        <th class="p-3">Poster</th>
                        <th class="p-3">Judul</th>
                        <th class="p-3">Kategori</th>
                        <th class="p-3">Harga Tiket</th>
                        <th class="p-3">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($events as $event)
                        <tr class="border-t">
                            <td class="p-3">
                                @if($event->image)
                                    <img src="{{ asset('storage/' . $event->image) }}" class="w-16 h-16 object-cover rounded">
                                @else
                                    <span class="text-gray-400">-</span>
                                @endif
                            </td>
                            <td class="p-3 font-medium">{{ $event->title }}</td>
                            <td class="p-3">{{ $event->category ?: '-' }}</td>
                            <td class="p-3">Rp {{ number_format($event->ticket_price, 0, ',', '.') }}</td>
                            <td class="p-3">
                                <div class="flex items-center gap-3">
                                    <a href="{{ route('events.edit', $event->id) }}" class="text-blue-600 hover:underline font-semibold">Edit</a>

                                    <form action="{{ route('events.destroy', $event->id) }}" method="POST"
                                          onsubmit="return confirm('Yakin hapus event ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-600 hover:underline font-semibold">Hapus</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="5" class="p-6 text-center text-gray-500">Belum ada event.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="mt-4">{{ $events->links() }}</div>
    </div>
</x-app-layout>
