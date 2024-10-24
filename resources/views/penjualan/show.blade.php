@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Daftar Rekap Penjualan</h2>
    <table class="table table-bordered table-striped table-hover table-sm">
        <thead>
            <tr>
                <th>ID</th>
                <th>Nama User</th>
                <th>Pembeli</th>
                <th>Kode Penjualan</th>
                <th>Tanggal Penjualan</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach($penjualan as $data)
            <tr>
                <td>{{ $data->id }}</td>
                <td>{{ $data->nama_user }}</td>
                <td>{{ $data->pembeli }}</td>
                <td>{{ $data->kode_penjualan }}</td>
                <td>{{ $data->tanggal_penjualan->format('Y-m-d H:i:s') }}</td>
                <td>
                    <button type="button" class="btn btn-info btn-detail" data-id="{{ $data->id }}">Detail</button>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <!-- Modal untuk Menampilkan Detail -->
    <div id="modal-master" class="modal fade" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Detail Penjualan</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <!-- Isi modal akan dimuat di sini oleh AJAX -->
                </div>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
    $(document).ready(function() {
        // Event listener untuk tombol detail
        $('.btn-detail').click(function() {
            var penjualan_id = $(this).data('id'); // Dapatkan ID penjualan yang di klik

            $.ajax({
                url: '/penjualan/show/' + penjualan_id, // URL untuk request ke controller
                type: 'GET',
                success: function(data) {
                    // Memuat data yang diterima ke dalam modal-body
                    $('#modal-master .modal-body').html(data);

                    // Tampilkan modal setelah data dimuat
                    $('#modal-master').modal('show');
                },
                error: function() {
                    alert('Gagal memuat data. Silakan coba lagi.');
                }
            });
        });
    });
</script>
@endsection