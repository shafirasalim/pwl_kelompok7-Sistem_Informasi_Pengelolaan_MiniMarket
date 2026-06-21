<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('Audit Log Sistem') }}
            </h2>
            <a href="{{ route('audit-logs.pdf', request()->all()) }}" target="_blank" 
               class="bg-red-600 text-white px-4 py-2 rounded hover:bg-red-700 flex items-center gap-2">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                </svg>
                Download PDF
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            <!-- Filter -->
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6 mb-6">
                <form action="{{ route('audit-logs.index') }}" method="GET" class="grid grid-cols-1 md:grid-cols-4 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Aksi</label>
                        <select name="action" class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                            <option value="">Semua Aksi</option>
                            <option value="create" {{ $request->action == 'create' ? 'selected' : '' }}>Create</option>
                            <option value="update" {{ $request->action == 'update' ? 'selected' : '' }}>Update</option>
                            <option value="delete" {{ $request->action == 'delete' ? 'selected' : '' }}>Delete</option>
                        </select>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">User</label>
                        <select name="user_id" class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                            <option value="">Semua User</option>
                            @foreach($users as $user)
                                <option value="{{ $user->id }}" {{ $request->user_id == $user->id ? 'selected' : '' }}>{{ $user->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Tanggal Mulai</label>
                        <input type="date" name="start_date" value="{{ $request->start_date }}" 
                               class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Tanggal Akhir</label>
                        <input type="date" name="end_date" value="{{ $request->end_date }}" 
                               class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                    </div>

                    <div class="md:col-span-4 flex gap-2 mt-2">
                        <button type="submit" class="bg-indigo-600 text-white px-4 py-2 rounded hover:bg-indigo-700">
                            Filter
                        </button>
                        <a href="{{ route('audit-logs.index') }}" class="bg-gray-300 text-gray-700 px-4 py-2 rounded hover:bg-gray-400">
                            Reset
                        </a>
                    </div>
                </form>
            </div>

            <!-- Statistik Ringkas -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
                <div class="bg-white dark:bg-gray-800 p-4 rounded-lg shadow">
                    <div class="text-sm text-gray-500 dark:text-gray-400">Total Audit Log</div>
                    <div class="text-2xl font-bold text-indigo-600 dark:text-indigo-400">{{ $auditLogs->total() }}</div>
                </div>
                <div class="bg-white dark:bg-gray-800 p-4 rounded-lg shadow">
                    <div class="text-sm text-gray-500 dark:text-gray-400">Create</div>
                    <div class="text-2xl font-bold text-green-600 dark:text-green-400">
                        {{ \App\Models\AuditLog::where('action', 'create')->count() }}
                    </div>
                </div>
                <div class="bg-white dark:bg-gray-800 p-4 rounded-lg shadow">
                    <div class="text-sm text-gray-500 dark:text-gray-400">Update</div>
                    <div class="text-2xl font-bold text-yellow-600 dark:text-yellow-400">
                        {{ \App\Models\AuditLog::where('action', 'update')->count() }}
                    </div>
                </div>
            </div>

            <!-- Tabel Audit Log -->
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                        <thead class="bg-gray-50 dark:bg-gray-700">
                            <tr>
                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase">Waktu</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase">User</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase">Aksi</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase">Model</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase">IP Address</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase">Perubahan Data</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                            @forelse($auditLogs as $log)
                            <tr class="hover:bg-gray-50 dark:hover:bg-gray-700">
                                <td class="px-4 py-3 whitespace-nowrap text-xs text-gray-900 dark:text-gray-100">
                                    <div>{{ $log->created_at->format('d/m/Y') }}</div>
                                    <div class="text-gray-500">{{ $log->created_at->format('H:i:s') }}</div>
                                </td>
                                <td class="px-4 py-3 whitespace-nowrap text-xs text-gray-900 dark:text-gray-100">
                                    {{ $log->user->name ?? 'System' }}
                                </td>
                                <td class="px-4 py-3 whitespace-nowrap text-xs">
                                    @if($log->action == 'create')
                                        <span class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200">CREATE</span>
                                    @elseif($log->action == 'update')
                                        <span class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-200">UPDATE</span>
                                    @elseif($log->action == 'delete')
                                        <span class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-200">DELETE</span>
                                    @endif
                                </td>
                                <td class="px-4 py-3 whitespace-nowrap text-xs text-gray-900 dark:text-gray-100">
                                    <div class="font-medium">{{ class_basename($log->model_type) }}</div>
                                    <div class="text-gray-500">ID: {{ $log->model_id }}</div>
                                </td>
                                <td class="px-4 py-3 whitespace-nowrap text-xs text-gray-900 dark:text-gray-100 font-mono">
                                    {{ $log->ip_address ?? '-' }}
                                </td>
                                <td class="px-4 py-3 text-xs">
                                    <button onclick="showDetail({{ $log->id }})" 
                                            class="text-indigo-600 hover:text-indigo-900 dark:text-indigo-400 dark:hover:text-indigo-300 font-medium">
                                        Lihat Detail →
                                    </button>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="6" class="px-4 py-8 text-center text-gray-500 dark:text-gray-400">
                                    Tidak ada audit log untuk periode ini
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Pagination -->
            <div class="mt-6">
                {{ $auditLogs->links() }}
            </div>
        </div>
    </div>

    <!-- Modal Detail -->
    <div id="detailModal" class="hidden fixed z-50 inset-0 overflow-y-auto">
        <div class="flex items-center justify-center min-h-screen pt-4 px-4 pb-20 text-center">
            <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" onclick="closeModal()"></div>
            <div class="inline-block align-bottom bg-white dark:bg-gray-800 rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-2xl sm:w-full">
                <div class="bg-white dark:bg-gray-800 px-4 pt-5 pb-4 sm:p-6">
                    <h3 class="text-lg leading-6 font-medium text-gray-900 dark:text-gray-100 mb-4" id="modalTitle">
                        Detail Audit Log
                    </h3>
                    <div id="modalContent" class="space-y-4">
                        <!-- Content will be populated by JavaScript -->
                    </div>
                </div>
                <div class="bg-gray-50 dark:bg-gray-700 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                    <button onclick="closeModal()" 
                            class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-indigo-600 text-base font-medium text-white hover:bg-indigo-700 focus:outline-none sm:ml-3 sm:w-auto sm:text-sm">
                        Tutup
                    </button>
                </div>
            </div>
        </div>
    </div>

    <script>
        const auditLogs = @json($auditLogs);

        function showDetail(logId) {
            const log = auditLogs.data.find(l => l.id == logId);
            if (log) {
                document.getElementById('modalTitle').textContent = 
                    `Detail ${log.action.toUpperCase()} - ${log.model_type} #${log.model_id}`;
                
                let content = `
                    <div class="grid grid-cols-2 gap-4 text-sm">
                        <div>
                            <div class="text-gray-500 dark:text-gray-400">Waktu</div>
                            <div class="font-medium dark:text-gray-100">${new Date(log.created_at).toLocaleString('id-ID')}</div>
                        </div>
                        <div>
                            <div class="text-gray-500 dark:text-gray-400">User</div>
                            <div class="font-medium dark:text-gray-100">${log.user?.name || 'System'}</div>
                        </div>
                        <div>
                            <div class="text-gray-500 dark:text-gray-400">IP Address</div>
                            <div class="font-medium dark:text-gray-100">${log.ip_address || '-'}</div>
                        </div>
                        <div>
                            <div class="text-gray-500 dark:text-gray-400">User Agent</div>
                            <div class="font-medium dark:text-gray-100 text-xs">${log.user_agent || '-'}</div>
                        </div>
                    </div>
                `;

                if (log.action === 'create' && log.new_data) {
                    content += `
                        <div>
                            <div class="text-green-600 dark:text-green-400 font-semibold mb-2">DATA BARU:</div>
                            <pre class="bg-gray-100 dark:bg-gray-900 p-3 rounded text-xs overflow-x-auto">${JSON.stringify(log.new_data, null, 2)}</pre>
                        </div>
                    `;
                } else if (log.action === 'update') {
                    if (log.old_data || log.new_data) {
                        content += `
                            <div class="grid grid-cols-2 gap-4">
                                ${log.old_data ? `
                                <div>
                                    <div class="text-yellow-600 dark:text-yellow-400 font-semibold mb-2">DATA LAMA:</div>
                                    <pre class="bg-gray-100 dark:bg-gray-900 p-3 rounded text-xs overflow-x-auto">${JSON.stringify(log.old_data, null, 2)}</pre>
                                </div>
                                ` : ''}
                                ${log.new_data ? `
                                <div>
                                    <div class="text-green-600 dark:text-green-400 font-semibold mb-2">DATA BARU:</div>
                                    <pre class="bg-gray-100 dark:bg-gray-900 p-3 rounded text-xs overflow-x-auto">${JSON.stringify(log.new_data, null, 2)}</pre>
                                </div>
                                ` : ''}
                            </div>
                        `;
                    }
                } else if (log.action === 'delete' && log.old_data) {
                    content += `
                        <div>
                            <div class="text-red-600 dark:text-red-400 font-semibold mb-2">DATA YANG DIHAPUS:</div>
                            <pre class="bg-gray-100 dark:bg-gray-900 p-3 rounded text-xs overflow-x-auto">${JSON.stringify(log.old_data, null, 2)}</pre>
                        </div>
                    `;
                }

                document.getElementById('modalContent').innerHTML = content;
                document.getElementById('detailModal').classList.remove('hidden');
            }
        }

        function closeModal() {
            document.getElementById('detailModal').classList.add('hidden');
        }

        // Close modal on Escape key
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') {
                closeModal();
            }
        });
    </script>
</x-app-layout>