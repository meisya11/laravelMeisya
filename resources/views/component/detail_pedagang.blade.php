<style>
    table {
        width: 100%;
        border-collapse: collapse;
    }

    th,
    td {
        padding: 8px;
        text-align: left;
        border-bottom: 1px solid #ddd;
    }

    th {
        background-color: #f2f2f2;
    }

    tr:hover {
        background-color: #f5f5f5;
    }
</style>
<div class="container">
    <div class="d-flex align-items-center">
        <h1 class="mb-0 mr-3">{{ $user->name }}</h1>
        <div style="display: flex; align-items: center;">
            <a href="https://wa.me/{{ $user->phone }}" style="margin-right: 10px;">📱 Hubungi Saya</a>
        </div>
    </div>
    <ul>
        <li><strong>Jam Operasional:</strong> {{ $profile->jam }}-{{ $profile->sampai }}</li>
        <li><strong>Kategori Toko:</strong> {{ $profile->kategori }}</li>
        <li><strong>Deskripsi Toko:</strong> {{ $profile->deskripsi }}</li>
    </ul>
    <b>Produk:</b>
    <table>
        <thead>
            <tr>
                <th>Nama Produk</th>
                <th>Jumlah Produk</th>
                <th>Harga Produk</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($user->product as $product)
                <tr>
                    <td>{{ $product->nama }}</td>
                    <td>{{ $product->jumlah }}</td>
                    <td>{{ $product->harga }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
