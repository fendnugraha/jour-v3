<x-layouts.app>
    <x-slot:title>{{ $title }}</x-slot:title>
    <h2 class="text-xl font-semibold text-black dark:text-white mb-4">{{ $journal->trx_type }} - {{ $warehouse_cash }}
    </h2>
    <div class="bg-white rounded-xl p-4 grid grid-cols-4 gap-4 mb-3">
        <div class="col-span-2">
            <form action="{{ route('journal.update', $journal->id) }}" method="post">
                @csrf
                @method('PUT')
                <div class="mb-3">
                    <label for="date_issued" class="form-label">Tanggal</label>
                    <input type="datetime-local" name="date_issued" value="{{ $journal->date_issued }}"
                        class="w-full border text-sm rounded-lg px-4 py-2 @error('date_issued') border-red-500 @enderror"
                        required>
                    @error('date_issued') <span class="text-red-500">{{ $message }}</span> @enderror
                </div>
                @php
                $journal->debt_code == $warehouse_cash ? $debt_status = 'hidden' : $debt_status = '';
                $journal->cred_code == $warehouse_cash ? $cred_status = 'hidden' : $cred_status = '';
                @endphp
                <div class="mb-3 {{ $debt_status }}">
                    <label for="debt_code" class="">Nama Akun</label>
                    <div class="col-sm-8">
                        <select name="debt_code" id="debt_code"
                            class="w-full border text-sm rounded-lg px-4 py-2 @error('debt_code') border-red-500 @enderror">
                            <option value="">Pilih Akun</option>
                            @foreach ($account as $coa)
                            <option value="{{ $coa->acc_code }}" {{ $coa->acc_code == $journal->debt_code ?
                                'selected' : ''
                                }}>
                                {{ $coa->acc_name }}</option>
                            @endforeach
                        </select>
                    </div>
                    @error('debt_code') <span class="text-red-500">{{ $message }}</span> @enderror
                </div>
                <div class="mb-3 {{ $cred_status }}">
                    <label for="cred_code" class="">Nama Akun</label>
                    <div class="col-sm-8">
                        <select name="cred_code" id="cred_code"
                            class="w-full border text-sm rounded-lg px-4 py-2 @error('cred_code') border-red-500 @enderror">
                            <option value="">Pilih Akun</option>
                            @foreach ($account as $coa)
                            <option value="{{ $coa->acc_code }}" {{ $coa->acc_code == $journal->cred_code ?
                                'selected' : ''
                                }}>
                                {{ $coa->acc_name }}</option>
                            @endforeach
                        </select>
                    </div>
                    @error('cred_code') <span class="text-red-500">{{ $message }}</span> @enderror
                </div>
                <div class="mb-3">
                    <label for="amount" class="form-label">Jumlah</label>
                    <input type="number" name="amount"
                        class="w-full border text-sm rounded-lg px-4 py-2 @error('amount') border-red-500 @enderror"
                        value="{{ $journal->amount }}">
                    @error('amount') <span class="text-red-500">{{ $message }}</span> @enderror
                </div>
                <div class="mb-3">
                    <label for="fee_amount" class="form-label">Fee (admin)</label>
                    <input type="number" name="fee_amount"
                        class="w-full border text-sm rounded-lg px-4 py-2 @error('fee_amount') border-red-500 @enderror"
                        value="{{ $journal->fee_amount }}">
                    @error('fee_amount') <span class="text-red-500">{{ $message }}</span> @enderror
                </div>
                <div class="mb-3">
                    <label for="description" class="form-label">Keterangan</label>
                    <textarea name="description"
                        class="w-full border text-sm rounded-lg px-4 py-2 @error('description') border-red-500 @enderror"
                        required>{{ $journal->description }}</textarea>
                    @error('description') <span class="text-red-500">{{ $message }}</span> @enderror
                </div>
                <div class="form-check mb-3">
                    <input class="" type="checkbox" value="1" id="flexCheckChecked" name="status" {{ $journal->status ==
                    1 ? 'checked' : '' }}>
                    <label class="form-check-label" for="flexCheckChecked">
                        Sudah diambil
                    </label>
                </div>
                <div class="grid grid-cols-2 gap-2 mt-4">
                    <button type="submit" class="w-full bg-blue-500 text-white p-2 rounded-lg">Simpan</button>
                    <a href="{{ route('journal.index') }}"
                        class="w-full bg-red-500 text-white text-center p-2 rounded-lg">Kembali</a>
                </div>
            </form>
        </div>
    </div>
</x-layouts.app>