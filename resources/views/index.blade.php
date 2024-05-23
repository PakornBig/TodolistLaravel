@extends('layout')
@section('title')
TODOLIST APP
@endsection
@section('content')
<style>
    .btn-success-hover-disabled:hover {
        background-color: #198754 !important;
        border-color: #198754 !important;
        color: #FFFFFF !important;
        cursor: default !important;
    }
    .btn-danger-hover-disabled:hover {
        background-color: #dc3545 !important;
        border-color: #dc3545 !important;
        color: #FFFFFF !important;
        cursor: default !important;
    }
</style>
<div class="card border-0 shadow mb-5">
    <h1 class="d-flex justify-content-center m-0 pt-4 fw-bold">TODOLIST APP</h1>
    <div class="card-content">
        <div class="d-flex flex-column justify-content-center align-items-center">
            <div class="d-flex justify-content-end align-items-center w-75">
                <button class="btn btn-success" onclick="getCreate();">Add Task</button>
            </div>
            <div class="table-responsive w-75 pt-2">
                <table class="table table-borderless">
                    <thead style="background-color: #D0F5F1">
                      <tr>
                        <th scope="col" class="text-center fw-bolder" style="width: 10%; border-top-left-radius: 8px">No.</th>
                        <th scope="col" class="fw-bolder" style="width: 70%">Task</th>
                        <th scope="col" class="text-center fw-bolder">Edit</th>
                        <th scope="col" class="text-center fw-bolder" style="border-top-right-radius: 8px">Delete</th>
                      </tr>
                    </thead>
                    <tbody>
                        @foreach ($tasks as $row)
                            <tr>
                                <td class="text-center">{{ $tasks->firstItem()+$loop->index }}</td>
                                <td>{{$row->TASK}}</td>
                                <td class="text-center">
                                    <button class="btn btn-primary" onclick="getEdit({{ $row->ID }})">Edit</button>
                                </td>
                                <td class="text-center">
                                    <button class="btn btn-danger" onclick="confirmDelete({{ $row->ID }})">Delete</button>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="d-flex justify-content-between align-items-center w-75 pb-4">
                <p>แสดง {{ $tasks->firstItem() }}-{{ $tasks->lastItem() }} รายการ จาก {{ $tasks->total() }} รายการ</p>
    
                <div class="d-flex justify-content-end">
                    <a class="btn btn-success btn-circle btn-sm @if($tasks->onFirstPage()) disabled @endif" href="{{ $tasks->previousPageUrl() }}" aria-label="ก่อนหน้า" ><i class="fa fa-chevron-left"></i></a>
                    <div class="d-flex align-items-center">
                        <p class="m-0 ml-1 mr-1">Page </p>
                        <div class="dropdown">
                            <button class="dropdown-toggle btn btn-outline-secondary btn-sm" type="button" id="pageDropdown" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" @if ($tasks->lastPage() <= 1) disabled @endif>
                                {{ $tasks->currentPage() }}
                            </button>
                            <div class="dropdown-menu" aria-labelledby="pageDropdown">
                                @for ($page = 1; $page <= $tasks->lastPage(); $page++)
                                    <a class="dropdown-item" href="{{ $tasks->url($page) }}">{{ $page }}</a>
                                @endfor
                            </div>
                        </div>
                        <p class="m-0 ml-1 mr-1"> Of {{ $tasks->lastPage() }}</p>
                    </div>
                    <a class="btn btn-success btn-sm btn-circle @if(!$tasks->hasMorePages()) disabled @endif" role="button" href="{{ $tasks->nextPageUrl() }}" aria-label="ถัดไป"><i class="fa fa-chevron-right"></i></a>
                </div>
            </div>
        </div>
    </div>
</div>
@include('create_modal')
@include('edit_modal')
<script>
    function getCreate() {
        $("#mdlCreate").modal('show');
    }
</script>
<script>
    function submitCreate(event) {
        event.preventDefault();
        var txtTask = $('#txtTask').val();
        var isValid = true;

        if (txtTask.trim() === '') {
            $('#txtTask').addClass('is-invalid');
            $('#spnTask').html('กรุณาระบุ');
            isValid = false;
        } else {
            $('#txtTask').removeClass('is-invalid');
            $('#spnTask').html('');
        }

        if (isValid) {
            confirmCreate();
        }
    }

    function confirmCreate() {
        Swal.fire({
            title: "ยืนยันการบันทึกข้อมูล",
            text: "เมื่อกดยืนยันข้อมูลจะถูกบันทึกทันที",
            icon: 'question',
            showCancelButton: true,
            confirmButtonText: 'ยืนยัน',
            cancelButtonText: 'ยกเลิก'
        }).then((result) => {
            if (result.isConfirmed) {
                document.getElementById('frmCreate').submit();
            }
        });
        return false;
    }
</script>
<script>
    function getEdit(ID) {
        $.ajax({
            url: 'edit_task/' + ID,
            type: 'GET',
            success: function(data) {
                console.log(data);
                $('#hdfEditId').val(data.task.ID);
                $('#txtEditTask').val(data.task.TASK);

                $('#mdlEdit').modal('show');

            }
        });
    }
</script>
<script>
    function submitUpdate(event) {
        event.preventDefault();

        var txtEditTask = $('#txtEditTask').val();

        var isValid = true;

        if (txtEditTask.trim() === '') {
            $('#txtEditTask').addClass('is-invalid');
            $('#spnEditTask').html('กรุณาระบุ');
            isValid = false;
        } else {
            $('#txtEditTask').removeClass('is-invalid');
            $('#spnEditTask').html('');
        }

        if (isValid) {
            confirmUpdate();
        } else {
            return false;
        }
    }

    function confirmUpdate() {
        Swal.fire({
            title: "ยืนยันการแก้ไขข้อมูล",
            text: "เมื่อแก้ไขข้อมูลแล้วข้อมูลจะถูกเปลี่ยนแปลงทันที",
            icon: 'question',
            showCancelButton: true,
            confirmButtonText: 'ยืนยัน',
            cancelButtonText: 'ยกเลิก'
        }).then((result) => {
            if (result.isConfirmed) {
                document.getElementById('frmUpdate').submit();
            }
        });
    }
</script>
<script type="text/javascript">
    function confirmDelete(ID) {
        Swal.fire({
            title: "ยืนยันการลบข้อมูล",
            html: "เมื่อลบแล้วข้อมูลจะถูกเปลี่ยนแปลงทันที",
            icon: 'question',
            showCancelButton: true,
            confirmButtonText: 'ยืนยัน',
            cancelButtonText: 'ยกเลิก'
        }).then((result) => {
            if (result.isConfirmed) {
                window.location.href = '/delete/' + ID;
            }
        });
        return false;
    }
</script>
@if(session('alert'))
    <script>
        let alertData = @json(session('alert'));

        Swal.fire({
            icon: alertData.icon,
            title: alertData.title,
            text: alertData.message,
            showConfirmButton: false,
            timer: 3000
        });
    </script>
@endif
@endsection

