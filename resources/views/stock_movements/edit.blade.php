<h1>Edit Stock Movement</h1>

<form action="{{ route('stock-movements.update', $stockMovement->id) }}" method="POST">
    @csrf
    @method('PUT')

    <label>User</label>
    <select name="user_id">
        @foreach($users as $user)
            <option value="{{ $user->id }}"
                {{ $stockMovement->user_id == $user->id ? 'selected' : '' }}>
                {{ $user->name }}
            </option>
        @endforeach
    </select>

    <br><br>

    <label>Stock</label>
    <select name="stock_id">
        @foreach($stocks as $stock)
            <option value="{{ $stock->id }}"
                {{ $stockMovement->stock_id == $stock->id ? 'selected' : '' }}>
                {{ $stock->product->name }}
            </option>
        @endforeach
    </select>

    <br><br>

    <label>Tipe</label>
    <select name="type">
        <option value="IN"
            {{ $stockMovement->type == 'IN' ? 'selected' : '' }}>
            IN
        </option>

        <option value="OUT"
            {{ $stockMovement->type == 'OUT' ? 'selected' : '' }}>
            OUT
        </option>
    </select>

    <br><br>

    <label>Quantity</label>
    <input type="number"
           name="quantity"
           value="{{ $stockMovement->quantity }}">

    <br><br>

    <label>Tanggal</label>
    <input type="date"
           name="movement_date"
           value="{{ $stockMovement->movement_date }}">

    <br><br>

    <button type="submit">
        Update
    </button>

    <a href="{{ route('stock-movements.index') }}">
        Kembali
    </a>
</form>