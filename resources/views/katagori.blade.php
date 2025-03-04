<!DOCTYPE html>
<html>
<head>
    <title>Data Katagori Barang</title>
</head>
<body>
    <h1>Data Katagori Barang</h1>
    <table border="1" cellpadding="2" cellspacing="0">
        <tr>
            <th>ID</th>
            <th>Kode Katagori</th>
            <th>Nama Katagori</th>
        </tr>
        @foreach ($data as $d)
        <tr>
            <td>{{ $d->katagori_id }}</td>
            <td>{{ $d->katagori_kode }}</td>
            <td>{{ $d->katagori_nama }}</td>
        </tr>
        @endforeach
    </table>
</body>
</html>