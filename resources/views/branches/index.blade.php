<h1>Data Cabang</h1>

<a href="{{ route('branches.create') }}">Tambah Cabang</a>

@if (session('success'))
    <p style="color: green;">{{ session('success') }}</p>
@endif

<table border="1" cellpadding="10">
    <tr>
        <th>No</th>
        <th>Nama Cabang</th>
        <th>Alamat</th>
        <th>Kota</th>
        <th>Aksi</th>
    </tr>

    @foreach ($branches as $branch)
        <tr>
            <td>{{ $loop->iteration }}</td>
            <td>{{ $branch->name }}</td>
            <td>{{ $branch->city }}</td>
            <td>{{ $branch->address }}</td>
            <td>
                <a href="{{ route('branches.edit', $branch->id) }}">Edit</a>

                <form action="{{ route('branches.destroy', $branch->id) }}" method="POST" style="display:inline;">
                    @csrf
                    @method('DELETE')

                    <button type="submit" onclick="return confirm('Yakin ingin menghapus cabang ini?')">
                        Hapus
                    </button>
                </form>
            </td>
        </tr>
    @endforeach
</table>