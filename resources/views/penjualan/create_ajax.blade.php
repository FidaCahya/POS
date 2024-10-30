<form action="{{ url('/penjualan/store_ajax') }}" method="POST" id="form-tambah">
    @csrf
    <div id="modal-master" class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Tambah Data Penjualan</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label>Level Pengguna</label>
                    <select name="user_id" id="user_id" class="form-control" required>
                        <option value="">- Pilih User -</option>
                        @foreach ($user as $l)
                            <option value="{{ $l->user_id }}">{{ $l->nama }}</option>
                        @endforeach
                    </select>
                    <small id="error-level_id" class="error-text form-text text-danger"></small>
                </div>
                <div class="form-group">
                    <label>Pembeli</label>
                    <input value="" type="text" name="pembeli" id="pembeli" class="form-control" required>
                    <small id="error-pembeli" class="error-text form-text text-danger"></small>
                </div>
                <div class="form-group">
                    <label>Kode Penjualan</label>
                    <input value="" type="text" name="penjualan_kode" id="penjualan_kode" class="form-control" required>
                    <small id="error-nama" class="error-text form-text text-danger"></small>
                </div>
                <div class="form-group">
                    <label>Tanggal Penjualan</label>
                    <input value="" type="datetime-local" name="penjualan_tanggal" id="penjualan_tanggal" class="form-control" required>
                    <small id="error-password" class="error-text form-text text-danger"></small>
                </div>

                <div class="form-group">
                    <label>Detail Penjualan</label>
                    <table id="detail-table" class="table">
                        <thead>
                            <tr>
                                <th>Nama Barang</th>
                                <th>Harga</th>
                                <th>Jumlah</th>
                                <th>Total</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>
                                    <select name="detail[0][barang_id]" class="form-control barang-select" required>
                                        <option value="">- Pilih Barang -</option>
                                        @foreach ($barang as $b) <!-- Pastikan menggunakan $b -->
                                            <option value="{{ $b->barang_id }}" data-harga="{{ $b->harga_jual }}">{{ $b->barang_nama }}</option>
                                        @endforeach
                                    </select>
                                </td>
                                <td><input type="number" name="detail[0][harga]" class="form-control harga" required readonly></td>
                                <td><input type="number" name="detail[0][jumlah]" class="form-control jumlah" required></td>
                                <td><input type="number" name="detail[0][total]" class="form-control total" readonly></td>
                                <td><button type="button" class="btn btn-danger remove-row">Hapus</button></td>
                            </tr>
                        </tbody>
                    </table>
                    <button type="button" id="add-row" class="btn btn-primary">Tambah Detail</button>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" data-dismiss="modal" class="btn btn-warning">Batal</button>
                <button type="submit" class="btn btn-primary">Simpan</button>
            </div>
        </div>
    </div>
</form>

<script>
    $(document).ready(function() {
        // Validasi untuk form utama
        $("#form-tambah").validate({
            rules: {
                user_id: {
                    required: true,
                    number: true
                },
                pembeli: {
                    required: true,
                    minlength: 3,
                    maxlength: 50
                },
                penjualan_kode: {
                    required: true,
                    minlength: 3,
                    maxlength: 20
                },
                penjualan_tanggal: {
                    required: true,
                    date: true
                }
            },
            submitHandler: function(form) {
                $.ajax({
                    url: form.action,
                    type: form.method,
                    data: $(form).serialize(),
                    success: function(response) {
                        if (response.status) {
                            $('#myModal').modal('hide');
                            Swal.fire({
                                icon: 'success',
                                title: 'Berhasil',
                                text: response.message
                            });
                            dataPenjualan.ajax.reload();
                        } else {
                            $('.error-text').text('');
                            $.each(response.msgField, function(prefix, val) {
                                $('#error-' + prefix).text(val[0]);
                            });
                            Swal.fire({
                                icon: 'error',
                                title: 'Terjadi Kesalahan',
                                text: response.message
                            });
                        }
                    }
                });
                return false;
            },
            errorElement: 'span',
            errorPlacement: function(error, element) {
                error.addClass('invalid-feedback');
                element.closest('.form-group').append(error);
            },
            highlight: function(element, errorClass, validClass) {
                $(element).addClass('is-invalid');
            },
            unhighlight: function(element, errorClass, validClass) {
                $(element).removeClass('is-invalid');
            }
        });

        // Fungsi untuk menambahkan dan menghapus baris detail
        let rowCount = 1;
        $('#add-row').click(function() {
            $('#detail-table tbody').append(`
                <tr>
                    <td>
                        <select name="detail[${rowCount}][barang_id]" class="form-control barang-select" required>
                            <option value="">- Pilih Barang -</option>
                            @foreach ($barang as $item)
                                <option value="{{ $item->id }}" data-harga="{{ $item->harga }}">{{ $item->nama }}</option>
                            @endforeach
                        </select>
                    </td>
                    <td><input type="number" name="detail[${rowCount}][harga]" class="form-control harga" required readonly></td>
                    <td><input type="number" name="detail[${rowCount}][jumlah]" class="form-control jumlah" required></td>
                    <td><input type="number" name="detail[${rowCount}][total]" class="form-control total" readonly></td>
                    <td><button type="button" class="btn btn-danger remove-row">Hapus</button></td>
                </tr>
            `);
            rowCount++;
        });

        $(document).on('change', '.barang-select', function() {
            let harga = $(this).find('option:selected').data('harga');
            $(this).closest('tr').find('.harga').val(harga);
            calculateTotal($(this).closest('tr'));
        });

        $(document).on('change', '.jumlah', function() {
            calculateTotal($(this).closest('tr'));
        });

        function calculateTotal(tr) {
            let harga = tr.find('.harga').val();
            let jumlah = tr.find('.jumlah').val();
            let total = harga * jumlah;
            tr.find('.total').val(total);
        }

        $(document).on('click', '.remove-row', function() {
            $(this).closest('tr').remove();
        });
    });
</script>