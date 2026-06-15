<h1>Tambah Cabang</h1>

<form action="{{ route('branches.store') }}" method="POST">
    @csrf

    <label>Nama Cabang</label><br>
    <input type="text" name="name" value="{{ old('name') }}"><br>
    @error('name')
        <small style="color: red;">{{ $message }}</small><br>
    @enderror

    <br>

    <label>Kota</label><br>
    <input type="text" name="city" value="{{ old('city') }}"><br>
    @error('city')
        <small style="color: red;">{{ $message }}</small><br>
    @enderror

    <br>

    <label>Alamat</label><br>
    <textarea name="address">{{ old('address') }}</textarea><br>
    @error('address')
        <small style="color: red;">{{ $message }}</small><br>
    @enderror

    <br>

    <button type="submit">Simpan</button>
    <a href="{{ route('branches.index') }}">Kembali</a>
</form>