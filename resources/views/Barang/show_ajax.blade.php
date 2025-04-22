<div class="modal-dialog">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title">Detail barang</h5>  <!-- Changed from User to barang -->
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body">
            <table class="table table-bordered table-striped table-hover table-sm">
                <tr>
                    <th>ID</th>
                    <td>{{ $barang->barang_id }}</td>
                </tr>
                <tr>
                    <th>Kode Barang</th>
                    <td>{{ $barang->barang_kode }}</td>
                </tr>
                <tr>
                    <th>Nama Barang</th>
                    <td>{{ $barang->barang_nama }}</td>
                </tr>
                <tr>
                    <th>Katagori</th>
                    <td>{{ $barang->katagori->katagori_nama }}</td>
                </tr>
                <tr>
                    <th>Harga Beli</th>
                    <td>{{ $barang->harga_beli }}</td>
                </tr>
                <tr>
                    <th>Harga Jual</th>
                    <td>{{ $barang->harga_jual }}</td>
                </tr>
            </table>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
        </div>
    </div>
</div>