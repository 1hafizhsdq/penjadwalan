<div class="modal fade" id="modal-schedule" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form class="row g-3" id="form-schedule">
                    @csrf
                    <input type="hidden" name="id" id="id">
                    <div class="form-floating mb-2 selectIngProject">
                        <select class="select2-modal form-select" id="project_id" aria-label="Project" name="project_id">
                            <option value="" selected>-- Pilih Project --</option>
                            @foreach ($projects as $project)
                            <option value="{{$project->id}}">{{$project->project}}</option>
                            @endforeach
                        </select>
                        <label for="floatingSelect">Project</label>
                    </div>
                    <div class="col-md-12">
                        <div class="form-floating">
                            <input type="date" class="form-control" id="start_date" name="start_date" placeholder="Tanggal Mulai">
                            <label for="start_date">Tanggal Mulai</label>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-floating">
                            <input type="date" class="form-control" id="due_date" name="due_date" placeholder="Deadline">
                            <label for="due_date">Deadline</label>
                        </div>
                    </div>
                    <div class="form-floating mb-2 selectIngUser">
                        <select class="select2-modal form-select" id="user_id" aria-label="Engineer" name="user_id">
                            <option value="" selected>-- Pilih Engineer --</option>
                            @foreach ($users as $users)
                            <option value="{{$users->id}}">{{$users->name}}</option>
                            @endforeach
                        </select>
                        <label for="floatingSelect">Engineer</label>
                    </div>
                    <div class="form-floating mb-2 selectIngStatusUrgent">
                        <select class="form-select" id="floatingSelect" aria-label="Status Urgent" name="status_urgent">
                            <option value="BIASA">BIASA</option>
                            <option value="URGENT">URGENT</option>
                        </select>
                        <label for="floatingSelect">Status Urgent</label>
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
