<div class="modal-dialog">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title">Detail Katagori</h5>  <!-- Changed from User to Kategori -->
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body">
            <table class="table table-bordered table-striped table-hover table-sm">
                <tr>
                    <th>ID</th>
                    <td>{{ $katagori->katgori_id }}</td>
                </tr>
                <tr>
                    <th>Kode Katagori</th>
                    <td>{{ $katagori->katagori_kode }}</td>
                </tr>
                <tr>
                    <th>Nama Katagori</th>
                    <td>{{ $katagori->katagori_nama }}</td>
                </tr>
            </table>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
        </div>
    </div>
</div>