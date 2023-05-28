<div class="modal fade" id="modal-done" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form class="row g-3" id="form-done">
                    @csrf
                    <input type="hidden" name="uuid" id="uuid">
                    <div class="col-md-12">
                        <div class="form-floating">
                            <input type="text" class="form-control" id="information" name="information" placeholder="Keterangan">
                            <label for="information">Keterangan</label>
                        </div>
                    </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                <button type="submit" id="sv-done" class="btn btn-primary">Simpan</button>
                <button class="btn btn-primary" type="button" disabled="" style="display: none;">
                    <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                    Loading...
                </button>
            </div>
            </form>
        </div>
    </div>
</div>
