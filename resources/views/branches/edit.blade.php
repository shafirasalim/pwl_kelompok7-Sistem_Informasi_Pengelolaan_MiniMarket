<h1>Edit Cabang</h1>

<form action="{{ route('branches.update', $branch->id) }}" method="POST">
    @csrf
    @method('PUT')

    <label>Nama Cabang</label><br>
    <input type="text" name="name" value="{{ old('name', $branch->name) }}"><br>
    @error('name')
        <small style="color: red;">{{ $message }}</small><br>
    @enderror

    <br>

    <label>Kota</label><br>
    <input type="text" name="city" value="{{ old('city', $branch->city) }}"><br>
    @error('city')
        <small style="color: red;">{{ $message }}</small><br>
    @enderror

    <br>

    <label>Alamat</label><br>
    <textarea name="address">{{ old('address', $branch->address) }}</textarea><br>
    @error('address')
        <small style="color: red;">{{ $message }}</small><br>
    @enderror

    <br>

    <button type="submit">Update</button>
    <a href="{{ route('branches.index') }}">Kembali</a>
</form>