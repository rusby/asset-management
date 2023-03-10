@extends('layouts.app')

@section('content')
<style>
    .modal-barang {
        width: 750px;
        right: 125px;
    }

    @media screen {
        #printSection {
            display: none;
        }
    }

    @media print {
        body * {
            visibility:hidden;
        }
        #printSection, #printSection * {
            visibility:visible;
        }
        #printSection {
            padding:20px;
            position:absolute;
            left:0;
            top:0;
        }
    }


</style>
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">List Barang</div>
                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    <div class="container mt-3">
                        <a class="btn btn-success" href="javascript:void(0)" id="tambahBarang"> Tambah Barang</a>
                        <div class="table-responsive mt-2">
                            <table class="table table-bordered yajra-datatable">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Name</th>
                                        <th>Deskripsi</th>
                                        <th>Status</th>
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
<div id="formTambahBarang" class="modal fade" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog ">
        <div class="modal-content modal-barang ">
            <div class="modal-header">
                <h4 class="modal-title" id="modelHeading"></h4>
            </div>
            <div class="modal-body">
                <form id="formAddBarang" name="formAddBarang" class="form-horizontal" enctype="multipart/form-data">
                    <div class="form-group mt-2">
                        <label for="nama_barang" class="col-sm-2 control-label">Nama Barang</label>
                        <div class="col-sm-12 mt-1">
                            <input type="text" class="form-control" id="nama_barang" name="nama_barang" placeholder="Enter Nama Barang" value="" required="">
                        </div>
                    </div>
                    <div class="form-group mt-2">
                        <label class="col-sm-2 control-label">Deskripsi</label>
                        <div class="col-sm-12 mt-1">
                            <textarea id="deskripsi" name="deskripsi" required="" placeholder="Enter Deskripsi" class="form-control"></textarea>
                        </div>
                    </div>
                    <div class="form-group mt-2">
                        <label class="col-sm-2 control-label">Status</label>
                        <div class="col-sm-12 mt-1">
                            <select name="status_in" class="form-control" class="status_in" id="status_in">
                                <option value="Milik">Milik</option>
                                <option value="Sewa">Sewa</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group mt-2">
                        <label class="col-sm-2 control-label">File</label>
                        <div class="col-sm-12 mt-1">
                            <input id="gambar" type="file" name="gambar" class="form-control">
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
<div id="formUbahBarang" class="modal fade" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog ">
        <div class="modal-content modal-barang ">
            <div class="modal-header">
                <h4 class="modal-title" id="modelHeading"></h4>
            </div>
            <div class="modal-body">
                <form id="formUpdateBarang" method="POST" name="formUpdateBarang" class="form-horizontal" enctype="multipart/form-data">
                   <input type="hidden" name="id_barang" id="id_barang">
                    <div class="form-group mt-2">
                        <label for="nama_barang_edit" class="col-sm-2 control-label">Nama Barang</label>
                        <div class="col-sm-12 mt-1">
                            <input type="text" class="form-control" id="nama_barang_edit" name="nama_barang_edit" placeholder="Enter Nama Barang" value="" required="">
                        </div>
                    </div>
                    <div class="form-group mt-2">
                        <label class="col-sm-2 control-label">Deskripsi</label>
                        <div class="col-sm-12 mt-1">
                            <textarea id="deskripsi_edit" name="deskripsi_edit" required="" placeholder="Enter Deskripsi" class="form-control"></textarea>
                        </div>
                    </div>
                    <div class="form-group mt-2">
                        <label class="col-sm-2 control-label">Status</label>
                        <div class="col-sm-12 mt-1">
                            <select name="status_in_edit" class="form-control" class="status_in_edit" id="status_in_edit">
                                <option value="Milik">Milik</option>
                                <option value="Sewa">Sewa</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group mt-2">
                        <label class="col-sm-2 control-label">File</label>
                        <div class="col-sm-12 mt-1">
                            <input id="gambar_edit" type="file" name="gambar_edit" class="form-control">
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

<!-- Form edit barang -->
<div id="formGenerateCodeBarang" class="modal fade" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog ">
        <div class="modal-content modal-barang ">
            <div class="modal-header">
                <h4 class="modal-title" id="modelHeading" >QR CODE</h4>
            </div>
            <div class="modal-body">
            <div class="container">
                <center>
                <div class="row mt-5 text-center qrcode" id="qrcode">
                   
                </div>
                </center>
                <div class="col-sm-offset-2 col-sm-12 mt-5">
                    <input name="idbarang" type="hidden" id="idbarang">
                    <button type="print" class="btn btn-primary" id="btnPrint" onclick="printQrcode()">Print</button>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
            </div>
        </div>
    </div>
</div>


@endsection
<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.js"></script>  
<script type="text/javascript">
  $(function () {
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    var table = $('.yajra-datatable').DataTable({
        processing: true,
        serverSide: true,
        ajax: "{{ route('barangs.index') }}",
        columns: [
            {data: 'DT_RowIndex', name: 'DT_RowIndex'},
            {data: 'nama_barang', name: 'nama_barang'},
            {data: 'deskripsi', name: 'deskripsi'},
            {data: 'status_in', name: 'status_in'},
            {
                data: 'action', 
                name: 'id', 
                orderable: true, 
                searchable: true
            },
        ]
    }); 

    $('#tambahBarang').click(function () {
        // $('#saveBtn').val("tambah-barang");
        $('#id_barang').val('');
        $('#formAddBarang').trigger("reset");
        // $('#modelHeading').html("Tambah Barang");
        $('#formTambahBarang').modal('show');
    });


    $('body').on('click', '.editBarang', function () {
        var id = $(this).data('id');
        $.ajax({
          url: "{{ route('barangs.index') }}" +"/" + id+"/edit",
          method: 'get',
          data: { id: id},
          success: function(response) {
            $('#formUbahBarang').modal('show');
            $.each(response , function (key, value) {
                console.log(value.id);
                $('#id_barang').val(value.id);
                $('#nama_barang_edit').val(value.nama_barang);
                $('#deskripsi_edit').val(value.deskripsi);
                $('#status_in_edit').val(value.status_in);

            });
          }
        });
    }); 
         
    $("#formAddBarang").submit(function(e) {
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
                data: $('#formAddBarang').serialize(),
                url: "{{ url('barangs') }}",
                method: 'POST',
                data: fd,
                cache: false,
                contentType: false,
                processData: false,
                dataType: 'json',
                success: function (data) {
                    $('#formAddBarang').trigger("reset");
                    $('#formTambahBarang').modal('hide');
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

    $("#formUpdateBarang").submit(function(e) {
        e.preventDefault();
        const formData = new FormData(this);
        formData.append('_method', 'put');
        var id = $('#id_barang').val();
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
                data: $('#formUpdateBarang').serialize(),
                url: "{{ url('barangs') }}" +"/" + id,
                method: 'POST',
                data: formData,
                cache: false,
                contentType: false,
                processData: false,
                dataType: 'json',
                success: function (data) {
                    $('#formUbahBarang').modal('hide');
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


    $('body').on('click', '.deleteBarang', function () {
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
              url: "{{ url('barangs') }}"+'/'+id,
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
          url: "{{ route('barangs.index') }}" +"/" + id+"/edit",
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
