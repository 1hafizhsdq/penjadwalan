<div class="modal fade" id="modal-user" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form class="row g-3" id="form-user">
                    @csrf
                    <input type="hidden" name="id" id="id">
                    <div class="col-md-12">
                        <div class="form-floating mb-2">
                            <input type="text" class="form-control" id="name" name="name" placeholder="Nama">
                            <label for="name">Nama</label>
                        </div>
                        <div class="form-floating mb-2">
                            <input type="text" class="form-control" id="username" name="username" placeholder="Username">
                            <label for="username">Username</label>
                        </div>
                        <div class="form-floating mb-2">
                            <input type="text" class="form-control" id="email" name="email" placeholder="Email">
                            <label for="email">Email</label>
                        </div>
                        <div class="form-floating mb-2 selectIng">
                            <select class="form-select" id="floatingSelect" aria-label="Role" name="role">
                                <option value="" selected>-- Pilih Role --</option>
                                @foreach ($role as $rl)
                                <option value="{{$rl->id}}">{{$rl->role}}</option>
                                @endforeach
                            </select>
                            <label for="floatingSelect">Role</label>
                        </div>
                    </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                <button type="submit" id="sv" class="btn btn-primary">Simpan</button>
                <button class="btn btn-primary" type="button" disabled="" style="display: none;">
                    <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                    Loading...
                </button>
            </div>
            </form>
        </div>
    </div>
</div>
