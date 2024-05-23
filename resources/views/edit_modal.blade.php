<div class="modal fade" id="mdlEdit" tabindex="-1" role="dialog" aria-labelledby="createLabel" aria-hidden="true" data-bs-backdrop="static">
    <div class="modal-dialog" role="document" style="min-width: 50%;">
        <div class="modal-content p-4">
            <div class="d-flex justify-content-between align-items-center">
                <p class="m-0">Edit Task</p>
                <button type="button" id="btnSubmitClose" name="btnSubmitClose" class="btn" data-bs-dismiss="modal" aria-label="Close"><i class="fa-solid fa-xmark"></i></button>
            </div>
            <form id="frmUpdate" method="POST" action="{{ route('tasks.update') }}" enctype="multipart/form-data" onsubmit="return submitUpdate(event)">
            @csrf
                <div class="modal-body">
                    <div class="d-flex gap-3">
                        <div class="d-flex flex-column w-100">
                            <input type="hidden" id="hdfEditId" name="hdfEditId"/>
                            <input type="text" id="txtEditTask" name="txtEditTask" class="form-control" placeholder="Enter Task" autocomplete="off" />
                            <span id="spnEditTask" name="spnEditTask" class="invalid-feedback" role="alert" style="display: block; height: 20px; pointer-events: none;"></span>
                        </div>
                        <button type="submit" id="btnSubmitEdit" name="btnSubmitEdit" class="btn btn-success" style="margin-bottom: 24px">Edit</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
