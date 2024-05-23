<div class="modal fade" id="mdlCreate" tabindex="-1" role="dialog" aria-labelledby="createLabel" aria-hidden="true" data-bs-backdrop="static">
    <div class="modal-dialog" role="document" style="min-width: 50%;">
        <div class="modal-content p-4">
            <div class="d-flex justify-content-between align-items-center">
                <p class="m-0">Add Task</p>
                <button type="button" id="btnSubmitClose" name="btnSubmitClose" class="btn" data-bs-dismiss="modal" aria-label="Close"><i class="fa-solid fa-xmark"></i></button>
            </div>
            <form id="frmCreate" method="POST" action="{{ route('tasks.store') }}" enctype="multipart/form-data" onsubmit="return submitCreate(event)">
            @csrf
                <div class="modal-body">
                    <div class="d-flex gap-3">
                        <div class="d-flex flex-column w-100">
                            <input type="text" id="txtTask" name="txtTask" class="form-control" placeholder="Enter Task" autocomplete="off" />
                            <span id="spnTask" name="spnTask" class="invalid-feedback" role="alert" style="display: block; height: 20px; pointer-events: none;"></span>
                        </div>
                        <button type="submit" id="btnSubmitCreate" name="btnSubmitCreate" class="btn btn-success" style="margin-bottom: 24px">Add</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
