<div class="modal fade" id="modal-activity" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form class="row g-3" id="form-activity">
                    @csrf
                    <input type="hidden" name="schedule_id" id="schedule_id">
                    <div class="col-md-12">
                        <div class="form-floating">
                            <input type="text" class="form-control" id="activity" name="activity" placeholder="Progres">
                            <label for="activity">Progres</label>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-floating">
                            <input type="text" class="form-control" id="progres" name="progres" placeholder="Progres">
                            <label for="progres">Prosentase Progres</label>
                        </div>
                    </div>
                    <div class="col-md-12" id="dynamicFile">
                        <label for="foto">Foto</label><br>
                        <a id="addFoto" class="btn btn-primary mb-2"><i class="bi bi-plus-square"></i> Tambah Foto</a>
                    </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                <button type="button" id="sv" class="btn btn-primary">Simpan</button>
                <button class="btn btn-primary" type="button" disabled="" style="display: none;">
                    <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                    Loading...
                </button>
            </div>
            </form>
        </div>
    </div>
</div>
