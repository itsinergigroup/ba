<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('Master Distributor') }}
            </h2>
            <a href="{{ route('admin.distributors.create') }}"
                class="bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-2 px-4 rounded text-sm">
                Tambah Distributor Baru
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            @if(session('success'))
                <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 shadow-sm" role="alert">
                    {{ session('success') }}
                </div>
            @endif

            <!-- Filter Section -->
            <div class="bg-white dark:bg-gray-800 shadow-sm sm:rounded-lg overflow-hidden">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <form action="{{ route('admin.distributors.index') }}" method="GET"
                        class="flex flex-col md:flex-row gap-4 items-end">
                        <div class="flex-1">
                            <label for="search"
                                class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Cari
                                Distributor</label>
                            <input type="text" id="search" name="search" value="{{ request('search') }}"
                                placeholder="Cari nama distributor..."
                                class="w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-sm">
                        </div>
                        <div class="flex gap-2">
                            <button type="submit"
                                class="bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2 rounded-md transition text-sm font-medium">
                                Filter
                            </button>
                            @if(request()->filled('search'))
                                <a href="{{ route('admin.distributors.index') }}"
                                    class="bg-gray-200 dark:bg-gray-700 text-gray-700 dark:text-gray-200 hover:bg-gray-300 dark:hover:bg-gray-600 px-4 py-2 rounded-md transition text-sm font-medium">
                                    Reset
                                </a>
                            @endif
                        </div>
                    </form>
                </div>
            </div>

            <!-- Table Section -->
            <div class="bg-white dark:bg-gray-800 shadow-sm sm:rounded-lg overflow-hidden">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <div class="overflow-x-auto">
                        <table class="w-full text-left border-collapse">
                            <thead>
                                <tr class="bg-gray-50 dark:bg-gray-700 border-b dark:border-gray-600">
                                    <th
                                        class="py-3 px-4 text-xs font-semibold uppercase tracking-wider text-gray-500 dark:text-gray-400">
                                        Nama Distributor</th>
                                    <th
                                        class="py-3 px-4 text-xs font-semibold uppercase tracking-wider text-gray-500 dark:text-gray-400 text-right">
                                        Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                                @forelse($distributors as $distributor)
                                    <tr class="hover:bg-gray-50 dark:hover:bg-gray-700 transition">
                                        <td class="py-3 px-4 text-sm font-medium">{{ $distributor->name }}</td>
                                        <td class="py-3 px-4 text-right">
                                            <div class="flex justify-end gap-3 text-sm">
                                                <a href="{{ route('admin.distributors.edit', $distributor->id) }}"
                                                    class="text-indigo-600 hover:text-indigo-900 font-medium">Ubah</a>
                                                <form action="{{ route('admin.distributors.destroy', $distributor->id) }}"
                                                    method="POST" onsubmit="return confirm('Apakah Anda yakin?')">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit"
                                                        class="text-red-600 hover:text-red-900 font-medium">Hapus</button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="2" class="py-12 text-center text-gray-500 dark:text-gray-400 italic">
                                            Data distributor tidak ditemukan.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <!-- Pagination -->
                    <div class="mt-6">
                        {{ $distributors->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>