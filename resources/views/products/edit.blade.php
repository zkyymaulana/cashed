<x-layout>
    <x-slot:title>Edit Product</x-slot:title>

    <div class="container">
        <div class="row">
            <div class="col-4">
                <div class="card">
                    <div class="card-body">
                    <form action="{{ route('products.update', ['product' => $product->id]) }}" method="post" enctype="multipart/form-data">
    @csrf
    @method('put')  

                            <div class="mb-3">
                                <label for="category_id" class="form-label">Category</label>
                                <select name="category_id" id="category_id" class="form-control">
                                    @forelse ($categories as $category)
                                        <option value="{{ $category->id }}"
                                            @if ($category->id == $product->category_id) selected @endif>
                                            {{ $category->name }}
                                        </option>
                                    @empty
                                        <option>Belum ada category</option>
                                    @endforelse
                                </select>
                            </div>

                            <x-text-input label="Nama" name="name" placeholder="Masukkan nama product"
                                value="{{ old('name', $product->name) }}"></x-text-input>

                            <x-text-input label="Harga" name="price" type="number"
                                placeholder="Masukkan harga product"
                                value="{{ old('price', $product->price) }}"></x-text-input>

                            <div class="mb-3">
                                <label for="image" class="form-label">Gambar</label>
                                <input class="form-control" type="file" id="image" name="image"
                                    accept="image/jpeg,image/png">
                                <div class="form-text">Kosongi bila tidak ingin mengupdate</div>
                            </div>

                            <x-text-input label="Stok" name="stock" type="number" placeholder="Masukkan stok product" value="{{ old('stock', $product->stock) }}"></x-text-input> <!-- Tambahkan input stock -->
                            
    <x-text-input label="Diskon (%)" name="discount" type="number" placeholder="Masukkan diskon product" value="{{ old('discount', $product->discount) }}"></x-text-input> <!-- Tambahkan input discount -->

                            <div class="form-check form-switch mb-3">
                                <input class="form-check-input" type="checkbox" role="switch" id="active"
                                    name="active" @checked((!old() && $category->active) || old('active') == 'on')>
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