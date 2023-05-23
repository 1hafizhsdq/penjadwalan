<div class="modal fade" id="modal-foto">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="modal-title-foto">Form Ubah Foto</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="form-foto">
                    <meta name="csrf-token" content="{{ csrf_token() }}" />
                    @csrf
                    <div class="form-group">
                        <label class="mt-2">Foto Profil</label>
                        <input type="file" class="form-control" name="image_profile" id="image_profile">
                    </div>
            </div>
            <div class="modal-footer justify-content-between">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                <button type="button" id="sv" class="btn btn-primary">Simpan</button>
            </div>
            </form>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<!-- /.modal -->
