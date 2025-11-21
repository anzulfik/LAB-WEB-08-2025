<div class="inline">
    <button type="button"
        onclick="openDeleteModal('{{ $action }}')"
        class="gradient-red text-white text-sm font-medium px-4 py-2 rounded-2xl shadow-md hover:brightness-110">
        {{ $label ?? 'Hapus' }}
    </button>

    @once
        <div id="deleteModal" class="fixed inset-0 hidden justify-center bg-black/40 backdrop-blur-sm items-center modal-bg z-50">
            <div class="bg-white/60 backdrop-blur-md rounded-xl p-6 shadow-xl text-center max-w-sm mx-auto">
                <p class="text-lg font-semibold text-gray-800 mb-5">
                    {{ $message ?? 'Yakin ingin menghapus data ini?' }}
                </p>

                <div class="flex justify-center gap-4">
                    <form id="deleteForm" method="POST">
                        @csrf
                        @method('DELETE')
                        <button type="submit"
                                class="gradient-red text-white font-semibold px-5 py-2 rounded-2xl shadow-md transition">
                            Ya, Hapus
                        </button>
                    </form>

                    <button onclick="closeModal()"
                            class="bg-gray-300 hover:bg-gray-400 text-gray-800 font-semibold px-5 py-2 rounded-2xl shadow-md transition">
                        Batal
                    </button>
                </div>
            </div>
        </div>

        <script>
        function openDeleteModal(url) {
            document.getElementById('deleteForm').action = url;
            document.getElementById('deleteModal').classList.remove('hidden');
            document.getElementById('deleteModal').classList.add('flex');
        }
        function closeModal() {
            document.getElementById('deleteModal').classList.add('hidden');
        }
        </script>
    @endonce
</div>
