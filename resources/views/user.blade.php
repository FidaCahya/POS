<!DOCTYPE html>
<html>
<head>
    <title>Data User</title>
</head>
<body>
    <h1>Data User</h1>
    <a href= "{{url("/user/tambah")}}">+ Tambah User</a>
    
    <!-- Menampilkan jumlah pengguna -->
    {{-- <table border="1" cellpadding="2" cellspacing="0">
        <tr>
            <th>Jumlah Pengguna</th>
        </tr>
        <tr>
            <td>{{ $totalUsers }}</td>
        </tr>
    </table>
    <br> --}}

    <!-- Menampilkan daftar pengguna -->
    <table border="1" cellpadding="2" cellspacing="0">
        <tr>
            <th>ID</th>
            <th>Username</th>
            <th>Nama</th>
            <th>ID Level Pengguna</th>
        </tr>

        @foreach ($data as $d)
        <tr>
            <td>{{ $d->user_id }}</td>
            <td>{{ $d->username }}</td>
            <td>{{ $d->nama }}</td>
            <td>{{ $d->level_id }}</td>
            <td>
                <a href="{{ url('/user/ubah/' . $d->user_id) }}">Ubah</a> | 
                <a href="{{ url('/user/hapus/' . $d->user_id) }}">Hapus</a>
            </td>
        </tr>
        @endforeach
    </table>
</body>
</html>

