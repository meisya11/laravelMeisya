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
        <div>
            <a href="https://wa.me/{{ $user->phone }}">📱 Hubungi Saya</a>
        </div>
    </div>
    @foreach ($user->pesanan as $pesanan)
        <ul>
            <li><strong>ID Pesanan:</strong> {{ $pesanan->id }}</li>
            <li><strong>Jam Antar:</strong> {{ $pesanan->order_time }}</li>
            <li><strong>Alamat:</strong> {{ $pesanan->alamat }}</li>
            <br>
            <a href="{{ route('detailantar', ['id' => $pesanan->id]) }}" class="btn btn-info"><i
                    class="fas fa-map-marker-alt"></i>
                Peta</a>
        </ul>
        <b>Produk Pesanan:</b>
        <table>
            <thead>
                <tr>
                    <th>Nama Produk</th>
                    <th>Jumlah Produk</th>
                    <th>Detail Produk</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($pesanan->detail as $d)
                    <tr>
                        <td>{{ $d->order_name }}</td>
                        <td>{{ $d->quantity }}</td>
                        <td>{{ $d->detail_order }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        <button class="btn btn-success" onclick="confirmApproval('{{ $pesanan->id }}')">
            Ambil Pesanan
        </button>
    @endforeach
</div>
<script>
    function updateStatus(id, status) {
        document.querySelector(`#statusForm${id} select[name="status"]`).value = status;

        document.querySelector(`#statusForm${id}`).submit();
    }

    function confirmApproval(id) {
        if (confirm("Anda yakin ingin mengambil pesanan ini?")) {
            approvePesanan(id);
        } else {
            alert("Ambil Pesanan dibatalkan.");
        }
    }

    function approvePesanan(id) {
        $.ajax({
            type: "POST",
            url: '/ambilpesanan/' + id,
            data: {
                "_token": "{{ csrf_token() }}",
            },
            success: function(data) {
                alert(data.message);
                window.location = "/riwayatpesanan/" + id;
            },
            error: function(error) {
                console.log(error);
                alert("Terjadi kesalahan saat mengambil pesanan ini.");
            }
        });
    }
</script>
