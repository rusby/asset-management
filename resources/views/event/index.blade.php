@extends('layouts.app')

@section('content')
<style>
    .modal-event {
        width: 750px;
        right: 125px;
    }
</style>
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">List Event</div>
                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    <div class="container mt-3">
                        <a class="btn btn-success" href="javascript:void(0)" id="tambahEvent"> Tambah Event</a>
                        <div class="table-responsive mt-2">
                            <table class="table table-bordered yajra-datatable">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Name</th>
                                        <th>Lokasi</th>
                                        <th>Jadwal</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- form tambah barang -->
<div id="formTambahEvent" class="modal fade" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog ">
        <div class="modal-content modal-event ">
            <div class="modal-header">
                <h4 class="modal-title" id="modelHeading"></h4>
            </div>
            <div class="modal-body">
                <form id="formAddEvent" name="formAddEvent" class="form-horizontal" enctype="multipart/form-data">
                    <div class="form-group mt-2">
                        <label for="nama_event" class="col-sm-2 control-label">Nama Event</label>
                        <div class="col-sm-12 mt-1">
                            <input type="text" class="form-control" id="nama_event" name="nama_event" placeholder="Enter Nama Event" value="" required="">
                        </div>
                    </div>
                    <div class="form-group mt-2">
                        <label class="col-sm-2 control-label">Lokasi</label>
                        <div class="col-sm-12 mt-1">
                            <textarea id="lokasi" name="lokasi" required="" placeholder="Enter lokasi" class="form-control"></textarea>
                        </div>
                    </div>
                    <div class="form-group mt-2">
                        <label class="col-sm-2 control-label">Jadwal</label>
                        <div class="col-sm-12 mt-1">
                        <input type="text" class="form-control" name="jadwal" placeholder="Enter Jadwal" id="jadwal">
                        </div>
                    </div>
                    <div class="col-sm-offset-2 col-sm-10 mt-2">
                     <button type="submit" class="btn btn-primary" id="saveBtn" value="create">Save changes
                     </button>
                     <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Form edit barang -->
<div id="formUbahEvent" class="modal fade" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog ">
        <div class="modal-content modal-event ">
            <div class="modal-header">
                <h4 class="modal-title" id="modelHeading"></h4>
            </div>
            <div class="modal-body">
                <form id="formUpdateEvent" method="POST" name="formUpdateEvent" class="form-horizontal" enctype="multipart/form-data">
                   <input type="hidden" name="id_event" id="id_event">
                    <div class="form-group mt-2">
                        <label for="nama_event_edit" class="col-sm-2 control-label">Nama Event</label>
                        <div class="col-sm-12 mt-1">
                            <input type="text" class="form-control" id="nama_event_edit" name="nama_event_edit" placeholder="Enter Nama Event" value="" required="">
                        </div>
                    </div>
                    <div class="form-group mt-2">
                        <label class="col-sm-2 control-label">lokasi</label>
                        <div class="col-sm-12 mt-1">
                            <textarea id="lokasi_edit" name="lokasi_edit" required="" placeholder="Enter lokasi" class="form-control"></textarea>
                        </div>
                    </div>
                    <div class="form-group mt-2">
                        <label class="col-sm-2 control-label">Jadwal</label>
                        <div class="col-sm-12 mt-1">
                        <input type="text" class="form-control" name="jadwal_edit" placeholder="Enter Jadwal_edit" id="jadwal_edit">
                        </div>
                    </div>
                    <div class="col-sm-offset-2 col-sm-10 mt-2">
                     <button type="submit" class="btn btn-primary" id="updateBtn" value="create">Save changes
                     </button>
                     <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@endsection
<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.js"></script>  
<script type="text/javascript">
  $(function () {
    flatpickr('#jadwal', {dateFormat: "Y-m-d H:i:s"});
    flatpickr('#jadwal_edit', {dateFormat: "Y-m-d H:i:s"});

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    var table = $('.yajra-datatable').DataTable({
        processing: true,
        serverSide: true,
        ajax: "{{ route('events.index') }}",
        columns: [
            {data: 'DT_RowIndex', name: 'DT_RowIndex'},
            {data: 'nama_event', name: 'nama_event'},
            {data: 'lokasi', name: 'lokasi'},
            {data: 'jadwal', name: 'jadwal'},
            {
                data: 'action', 
                name: 'id', 
                orderable: true, 
                searchable: true
            },
        ]
    }); 

    $('#tambahEvent').click(function () {
        $('#id_event').val('');
        $('#formAddEvent').trigger("reset");
        $('#formTambahEvent').modal('show');
    });


    $('body').on('click', '.editEvent', function () {
        var id = $(this).data('id');
        $.ajax({
          url: "{{ route('events.index') }}" +"/" + id+"/edit",
          method: 'get',
          data: { id: id},
          success: function(response) {
            $('#formUbahEvent').modal('show');
            $.each(response , function (key, value) {
                console.log(value.id);
                $('#id_event').val(value.id);
                $('#nama_event_edit').val(value.nama_event);
                $('#lokasi_edit').val(value.lokasi);
                $('#jadwal_edit').val(value.jadwal);

            });
          }
        });
    }); 
         
    $("#formAddEvent").submit(function(e) {
        e.preventDefault();
        const fd = new FormData(this);
        Swal.fire({
          title: 'Are you sure?',
          text: "You won't be able to added this!",
          icon: 'warning',
          showCancelButton: true,
          confirmButtonColor: '#3085d6',
          cancelButtonColor: '#d33',
          confirmButtonText: 'Yes, add data!'
        }).then((result) => {
          if (result.isConfirmed) {
            $.ajax({
                data: $('#formAddEvent').serialize(),
                url: "{{ url('events') }}",
                method: 'POST',
                data: fd,
                cache: false,
                contentType: false,
                processData: false,
                dataType: 'json',
                success: function (data) {
                    $('#formAddEvent').trigger("reset");
                    $('#formTambahEvent').modal('hide');
                    Swal.fire(
                    'Added!',
                    'Your file has been added.',
                    'success'
                    )
                    table.draw();           
                },
                error: function (data) {
                    console.log('Error:', data);
                    $('#saveBtn').html('Save Changes');
                }
            });           
          }
        });
    });

    $("#formUpdateEvent").submit(function(e) {
        e.preventDefault();
        const formData = new FormData(this);
        formData.append('_method', 'put');
        var id = $('#id_event').val();
        Swal.fire({
          title: 'Are you sure?',
          text: "You won't be able to update this!",
          icon: 'warning',
          showCancelButton: true,
          confirmButtonColor: '#3085d6',
          cancelButtonColor: '#d33',
          confirmButtonText: 'Yes, update it!'
        }).then((result) => {
          if (result.isConfirmed) {
            $.ajax({
                data: $('#formUpdateEvent').serialize(),
                url: "{{ url('events') }}" +"/" + id,
                method: 'POST',
                data: formData,
                cache: false,
                contentType: false,
                processData: false,
                dataType: 'json',
                success: function (data) {
                    $('#formUbahEvent').modal('hide');
                    Swal.fire(
                    'Updated!',
                    'Your file has been updated.',
                    'success'
                    )
                    table.draw();           
                },
                error: function (data) {
                    console.log('Error:', data);
                    $('#updateBtn').html('Save Changes');
                }
            });           
          }
        });
    });


    $('body').on('click', '.deleteEvent', function () {
        var id = $(this).data("id");
        Swal.fire({
          title: 'Are you sure?',
          text: "You won't be able to revert this!",
          icon: 'warning',
          showCancelButton: true,
          confirmButtonColor: '#3085d6',
          cancelButtonColor: '#d33',
          confirmButtonText: 'Yes, delete it!'
        }).then((result) => {
          if (result.isConfirmed) {
            $.ajax({
              url: "{{ url('events') }}"+'/'+id,
              method: 'POST',
              data:{'_method':'DELETE'},
              success: function(response) {
                console.log(response);
                Swal.fire(
                  'Deleted!',
                  'Your file has been deleted.',
                  'success'
                )
                table.draw(); 
              }
            });
          }
        });
       
    });

    $('body').on('click', '.generateCode', function () {
        var id = $(this).data('id');
        $.ajax({
          url: "{{ route('events.index') }}" +"/" + id+"/edit",
          method: 'get',
          data: { id: id},
          success: function(response) {
            $('#formGenerateCodeBarang').modal('show');
            $.each(response , function (key, value) {
                $('.qrcode').html(value.qrcode);
            });
          }
        });
    })


});

function printQrcode(){
    printElement(document.getElementById("qrcode"));
    window.print();
}

function printElement(elem, append, delimiter) {
    var domClone = elem.cloneNode(true);
    var $printSection = document.getElementById("printSection");
    if (!$printSection) {
        var $printSection = document.createElement("div");
        $printSection.id = "printSection";
        document.body.appendChild($printSection);
    }

    if (append !== true) {
        $printSection.innerHTML = "";
    }

    else if (append === true) {
        if (typeof(delimiter) === "string") {
            $printSection.innerHTML += delimiter;
        }
        else if (typeof(delimiter) === "object") {
            $printSection.appendChlid(delimiter);
        }
    }

    $printSection.appendChild(domClone);
}


</script>
</html>
