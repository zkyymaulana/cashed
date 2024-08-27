<x-layout>
    <x-slot:title>Tambah Product</x-slot:title>

    <div class="container">
        <div class="row">
            <div class="col-4">
                <div class="card">
                    <div class="card-body">
                        <form action="{{ route('products.store') }}" method="post" enctype="multipart/form-data">
                            @csrf

                            <div class="mb-3">
                                <label for="category_id" class="form-label">Category</label>
                                <select name="category_id" id="category_id" class="form-control">
                                    @forelse ($categories as $category)
                                        <option value="{{ $category->id }}">{{ $category->name }}</option>
                                    @empty
                                        <option>Belum ada category</option>
                                    @endforelse
                                </select>
                            </div>

                            <x-text-input label="Nama" name="name" placeholder="Masukkan nama product"
                                value="{{ old('name') }}"></x-text-input>

                            <x-text-input label="Harga" name="price" type="number"
                                placeholder="Masukkan harga product" value="{{ old('price') }}"></x-text-input>

                            <div class="mb-3">
                                <label for="image" class="form-label">Gambar</label>
                                <input class="form-control" type="file" id="image" name="image"
                                    accept="image/jpeg,image/png">
                                @error('image')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>

                            <x-text-input label="Stok" name="stock" type="number" placeholder="Masukkan stok product" value="{{ old('stock') }}"></x-text-input> <!-- Tambahkan input stock -->
                            <x-text-input label="Diskon (%)" name="discount" type="number" placeholder="Masukkan diskon product" value="{{ old('discount', 0) }}"></x-text-input> <!-- Tambahkan input discount dengan default 0 -->

                            <div class="form-check form-switch mb-3">
                                <input class="form-check-input" type="checkbox" role="switch" id="active"
                                    name="active" @checked(!old() || old('active') == 'on')>
                                <label class="form-check-label" for="active">Aktif</label>
                            </div>

                            <div class="d-flex justify-content-between">
                                <a href="{{ route('products.index') }}" class="btn btn-danger">Batal</a>
                                <button type="submit" class="btn btn-dark">Simpan</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-layout>