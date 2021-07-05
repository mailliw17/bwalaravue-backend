@extends('layouts.default')

@section('content')
<div class="card">
    <div class="card-header">
        <strong>Tambah Foto Barang</strong>
    </div>
    <div class="card-body card-block"> 
        {{-- KALAU GAMBAR WAJIB TAMBAHIN ENCTYPE --}}
        <form action="{{route('product-galleries.store')}}" method="POST" enctype="multipart/form-data">
        @csrf

        <div class="form-group">
            <label for="name" class="form-control-label">Nama Barang</label>

            <select name="products_id" class="form-control  @error('products_id') is-invalid @enderror">
                @foreach ($products as $product)
                    <option value="{{$product->id}}">
                        {{$product->name}}
                    </option>
                @endforeach
            </select>

            @error('name')
                <div class="text-muted">{{$message}}</div>
            @enderror
        </div>

        <div class="form-group">
            <label for="photo" class="form-control-label">Upload Foto</label>


            {{-- accept itu utk menyaring agar menerima file gambar saja --}}
            <input type="file" class="form-control @error('photo') is-invalid @enderror" name="photo" value="{{old('photo')}}" accept="image/*" />

            @error('photo')
                <div class="text-muted">{{$message}}</div>
            @enderror
        </div>

        <div class="form-group">
            <label for="is_default" class="form-control-label">Jadikan Default</label>

            <br>

            <label>
                <input type="radio" class="form-control @error('is_default') is-invalid @enderror" name="is_default" value="1" />Yes
            </label>

            &nbsp;

            <label>
                <input type="radio" class="form-control @error('is_default') is-invalid @enderror" name="is_default" value="0" />No.
            </label>
            

            @error('is_default')
                <div class="text-muted">{{$message}}</div>
            @enderror
        </div>

        <div class="form-group">
            <button type="submit" class="btn btn-primary btn-block">Tambah Foto Barang</button>
        </div>
        </form>
    </div>
</div>
@endsection