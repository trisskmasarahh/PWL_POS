<div class="modal-dialog">
     <div class="modal-content">
         <div class="modal-header">
             <h5 class="modal-title">Detail Suplier</h5>  <!-- Changed from User to Suplier -->
             <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                 <span aria-hidden="true">&times;</span>
             </button>
         </div>
         <div class="modal-body">
             <table class="table table-bordered table-striped table-hover table-sm">
                 <tr>
                     <th>ID Suplier</th>
                     <td>{{ $suplier->id }}</td>
                 </tr>
                 <tr>
                     <th>Nama Suplier</th>
                     <td>{{ $suplier->nama_suplier }}</td>
                 </tr>
                 <tr>
                     <th>Kontak</th>
                     <td>{{ $suplier->kontak }}</td>
                 </tr>
                 <tr>
                     <th>Alamat</th>
                     <td>{{ $suplier->alamat }}</td>
                 </tr>
             </table>
         </div>
         <div class="modal-footer">
             <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
         </div>
     </div>
 </div>