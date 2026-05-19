<x-admin-layout>
    <x-slot name="header">
        Edit Anggota: {{ $member->name }}
    </x-slot>

    <div class="max-w-3xl">
        <form action="{{ route('admin.members.update', $member->id) }}" method="POST" class="bg-white dark:bg-slate-800 rounded-2xl shadow-sm border border-gray-100 dark:border-slate-700 overflow-hidden">
            @csrf
            @method('PUT')
            
            <div class="p-6 sm:p-8 space-y-8">
                <!-- Validation Errors -->
                @if ($errors->any())
                    <div class="p-4 rounded-xl bg-rose-50 dark:bg-rose-500/10 border border-rose-200 dark:border-rose-500/20 text-rose-600 dark:text-rose-400">
                        <div class="flex items-start">
                            <i class="ti ti-alert-circle w-5 h-5 mr-3 mt-0.5"></i>
                            <div>
                                <h3 class="text-sm font-semibold">Terdapat kesalahan pengisian form:</h3>
                                <ul class="mt-2 text-sm list-disc list-inside space-y-1">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    </div>
                @endif

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Nama Lengkap -->
                    <div class="md:col-span-2">
                        <label for="name" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-1.5">Nama Lengkap <span class="text-rose-500">*</span></label>
                        <input type="text" name="name" id="name" value="{{ old('name', $member->name) }}" required class="block w-full rounded-xl border-gray-300 dark:border-slate-600 bg-white dark:bg-slate-900 text-gray-900 dark:text-white shadow-sm focus:border-amber-500 focus:ring-amber-500 sm:text-sm py-2.5 transition-colors">
                    </div>

                    <!-- Email -->
                    <div>
                        <label for="email" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-1.5">Alamat Email <span class="text-rose-500">*</span></label>
                        <input type="email" name="email" id="email" value="{{ old('email', $member->email) }}" required class="block w-full rounded-xl border-gray-300 dark:border-slate-600 bg-white dark:bg-slate-900 text-gray-900 dark:text-white shadow-sm focus:border-amber-500 focus:ring-amber-500 sm:text-sm py-2.5 transition-colors">
                    </div>

                    <!-- NIM / NIP -->
                    <div>
                        <label for="student_id" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-1.5">NIM / NIP</label>
                        <input type="text" name="student_id" id="student_id" value="{{ old('student_id', $member->student_id) }}" class="block w-full rounded-xl border-gray-300 dark:border-slate-600 bg-white dark:bg-slate-900 text-gray-900 dark:text-white shadow-sm focus:border-amber-500 focus:ring-amber-500 sm:text-sm py-2.5 transition-colors">
                    </div>

                    <!-- No HP -->
                    <div>
                        <label for="phone" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-1.5">Nomor Handphone</label>
                        <input type="text" name="phone" id="phone" value="{{ old('phone', $member->phone) }}" class="block w-full rounded-xl border-gray-300 dark:border-slate-600 bg-white dark:bg-slate-900 text-gray-900 dark:text-white shadow-sm focus:border-amber-500 focus:ring-amber-500 sm:text-sm py-2.5 transition-colors">
                    </div>

                    <!-- Status -->
                    <div>
                        <label for="status" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-1.5">Status <span class="text-rose-500">*</span></label>
                        <select id="status" name="status" required class="block w-full rounded-xl border-gray-300 dark:border-slate-600 bg-white dark:bg-slate-900 text-gray-900 dark:text-white shadow-sm focus:border-amber-500 focus:ring-amber-500 sm:text-sm py-2.5 transition-colors">
                            <option value="active" {{ old('status', $member->status) == 'active' ? 'selected' : '' }}>Aktif</option>
                            <option value="suspended" {{ old('status', $member->status) == 'suspended' ? 'selected' : '' }}>Suspended</option>
                        </select>
                    </div>

                    <!-- Alamat -->
                    <div class="md:col-span-2">
                        <label for="address" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-1.5">Alamat Lengkap</label>
                        <textarea id="address" name="address" rows="3" class="block w-full rounded-xl border-gray-300 dark:border-slate-600 bg-white dark:bg-slate-900 text-gray-900 dark:text-white shadow-sm focus:border-amber-500 focus:ring-amber-500 sm:text-sm py-2.5 transition-colors">{{ old('address', $member->address) }}</textarea>
                    </div>

                    <div class="md:col-span-2 border-t border-gray-100 dark:border-slate-700 my-2 pt-6">
                        <h4 class="text-sm font-semibold text-gray-900 dark:text-white mb-1">Ganti Password</h4>
                        <p class="text-xs text-gray-500 dark:text-slate-400 mb-4">Kosongkan jika tidak ingin mengubah password anggota ini.</p>
                    </div>

                    <!-- Password -->
                    <div>
                        <label for="password" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-1.5">Password Baru</label>
                        <input type="password" name="password" id="password" class="block w-full rounded-xl border-gray-300 dark:border-slate-600 bg-white dark:bg-slate-900 text-gray-900 dark:text-white shadow-sm focus:border-amber-500 focus:ring-amber-500 sm:text-sm py-2.5 transition-colors">
                    </div>

                    <!-- Konfirmasi Password -->
                    <div>
                        <label for="password_confirmation" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-1.5">Konfirmasi Password</label>
                        <input type="password" name="password_confirmation" id="password_confirmation" class="block w-full rounded-xl border-gray-300 dark:border-slate-600 bg-white dark:bg-slate-900 text-gray-900 dark:text-white shadow-sm focus:border-amber-500 focus:ring-amber-500 sm:text-sm py-2.5 transition-colors">
                    </div>
                </div>
            </div>

            <!-- Footer Actions -->
            <div class="bg-gray-50 dark:bg-slate-800/50 px-6 py-4 flex items-center justify-end gap-3 border-t border-gray-100 dark:border-slate-700">
                <a href="{{ route('admin.members.index') }}" class="inline-flex items-center px-4 py-2.5 border border-gray-300 dark:border-slate-600 shadow-sm text-sm font-medium rounded-xl text-gray-700 dark:text-gray-300 bg-white dark:bg-slate-800 hover:bg-gray-50 dark:hover:bg-slate-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-amber-500 dark:focus:ring-offset-slate-900 transition-colors">
                    Batal
                </a>
                <button type="submit" class="inline-flex items-center px-4 py-2.5 border border-transparent shadow-sm text-sm font-medium rounded-xl text-white bg-amber-500 hover:bg-amber-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-amber-500 dark:focus:ring-offset-slate-900 shadow-amber-500/30 transition-colors">
                    <i class="ti ti-device-floppy mr-2 -ml-1 text-lg"></i>
                    Simpan Perubahan
                </button>
            </div>
        </form>
    </div>
</x-admin-layout>
