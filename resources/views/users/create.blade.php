<h1>Tambah User</h1>

<form action="{{ route('users.store') }}" method="POST">
    @csrf

    <label>Cabang</label><br>
    <select name="branch_id">
        @foreach($branches as $branch)
            <option value="{{ $branch->id }}">{{ $branch->name }}</option>
        @endforeach
    </select>

    <br><br>

    <label>Nama</label><br>
    <input type="text" name="name" value="{{ old('name') }}">

    <br><br>

    <label>Email</label><br>
    <input type="email" name="email" value="{{ old('email') }}">

    <br><br>

    <label>Password</label><br>
    <input type="password" name="password">

    <br><br>

    <label>Role</label><br>
    <select name="role">
        <option value="admin">Admin</option>
        <option value="kasir">Kasir</option>
        <option value="owner">Owner</option>
    </select>

    <br><br>

    <button type="submit">Simpan</button>
    <a href="{{ route('users.index') }}">Kembali</a>
</form>