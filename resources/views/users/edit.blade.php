<h1>Edit User</h1>

<form action="{{ route('users.update', $user->id) }}" method="POST">
    @csrf
    @method('PUT')

    <label>Cabang</label><br>
    <select name="branch_id">
        @foreach($branches as $branch)
            <option value="{{ $branch->id }}" {{ $user->branch_id == $branch->id ? 'selected' : '' }}>
                {{ $branch->name }}
            </option>
        @endforeach
    </select>

    <br><br>

    <label>Nama</label><br>
    <input type="text" name="name" value="{{ old('name', $user->name) }}">

    <br><br>

    <label>Email</label><br>
    <input type="email" name="email" value="{{ old('email', $user->email) }}">

    <br><br>

    <label>Password Baru</label><br>
    <input type="password" name="password">
    <small>Kosongkan jika tidak ingin mengganti password</small>

    <br><br>

    <label>Role</label><br>
    <select name="role">
        <option value="admin" {{ $user->role == 'admin' ? 'selected' : '' }}>Admin</option>
        <option value="kasir" {{ $user->role == 'kasir' ? 'selected' : '' }}>Kasir</option>
        <option value="owner" {{ $user->role == 'owner' ? 'selected' : '' }}>Owner</option>
    </select>

    <br><br>

    <button type="submit">Update</button>
    <a href="{{ route('users.index') }}">Kembali</a>
</form>