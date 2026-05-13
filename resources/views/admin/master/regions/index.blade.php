<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('Master Wilayah (Region)') }}
            </h2>
            <a href="{{ route('admin.regions.create') }}"
                class="bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-2 px-4 rounded text-sm">
                Tambah Region Baru
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div
                class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg text-gray-900 dark:text-gray-100 p-6">
                @if(session('success'))
                    <x-alert type="success" :message="session('success')" />
                @endif

                @if(session('error'))
                    <x-alert type="error" :message="session('error')" />
                @endif


                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="border-b dark:border-gray-700">
                            <th class="py-2 px-4">Nama Region</th>
                            <th class="py-2 px-4">Jumlah Area</th>
                            <th class="py-2 px-4 text-right">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($regions as $region)
                            <tr class="border-b dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-700 transition">
                                <td class="py-2 px-4">{{ $region->name }}</td>
                                <td class="py-2 px-4 text-sm text-gray-500">{{ $region->areas_count }} Area</td>
                                <td class="py-2 px-4 text-right flex justify-end gap-2">
                                    <a href="{{ route('admin.regions.edit', $region->id) }}"
                                        class="text-indigo-600 hover:text-indigo-900">Ubah</a>
                                    <form action="{{ route('admin.regions.destroy', $region->id) }}" method="POST"
                                        onsubmit="return confirm('Apakah Anda yakin? Menghapus Region akan menghapus semua Area di dalamnya.')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-600 hover:text-red-900">Hapus</button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>

                <div class="mt-4">
                    {{ $regions->links() }}
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
