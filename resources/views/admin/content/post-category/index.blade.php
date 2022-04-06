@extends('admin.layout.layout')
@section('css')
<!-- DataTables -->
<link rel="stylesheet" type="text/css" href="/dist/DataTables/datatables.min.css" />
@endsection
@section('content')
<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>{{$title}}</h1>
                </div>
                <div class="col-sm-6 ">
                    <button type="button" class="btn btn-success float-right" onclick="formAdd()" data-toggle="modal"
                        data-target="#modal">
                        <li class="fas fa-plus"></li>
                        Tambah
                    </button>
                </div>
            </div>
    </section>
    <section class="content">
        <div class="card">
            <div class="card-body">
                <table class="table table-bordered table-hover">
                    <thead>
                        <tr>
                            <th style="width: 5%">No.</th>
                            <th>Kategori</th>
                            <th>Opsi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($data as $row)
                        <tr>
                            <td>{{$loop->iteration}}</td>
                            <td>{{$row['name']}}</td>
                            <td>
                                <a href="#" class="btn btn-info" title="edit" data-toggle="modal" data-target="#modal"
                                    onclick="edit('{{$row['id']}}','{{$row['name']}}')">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <a href="#" class="btn btn-danger" title="hapus" onclick="drop('{{$row['id']}}')">
                                    <i class="fas fa-trash-alt"></i>
                                </a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </section>
</div>
<!-- Modal -->
<div class="modal fade" id="modal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalTitle"></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label for="">Nama</label>
                    <input type="text" class="form-control" id="name" placeholder="Nama">
                    <div id="nameInvalid" class="invalid-feedback"></div>
                </div>
            </div>
            <div class="modal-footer" id="modalFooter">
            </div>
        </div>
    </div>
</div>
@endsection
@section('plugins')
<!-- DataTables  & Plugins -->
<script type="text/javascript" src="/dist/DataTables/datatables.min.js"></script>
@endsection
@section('script')
<script>
    $(document).ready(function() {
        $('.table').dataTable()
    });
    // global url
    let url = '{{ url("/admin/post-category/") }}';
    function requestData() {
        return {
            _token: '{{ csrf_token() }}',
            name: $('#name').val(),
        }
    }
    function resetModal() {
        $('.modal .form-control').prop('class', 'form-control');
        $('.invalid-feedback').text('');
        $('#name').val('');
    }
    function formAdd() {
        $('#modalTitle').text('Tambah {{$title}}');
        resetModal();
        $('#modalFooter').html(`
            <button type="button" class="btn btn-success" onclick="create()">
                <li class="fas fa-plus"></li>
                Tambah
            </button>
        `);
    }
    function edit(id, name) {
        $('#modalTitle').text('Edit {{$title}}');
        resetModal();
        $('#name').val(name);
        $('#modalFooter').html(`
            <button type="button" class="btn btn-success" onclick="update('${id}')">
                <li class="fas fa-save"></li>
                Simpan
            </button>
        `);
    }
    // create
    function create() {
        $(".invalid-feedback").text('')
        $(".modal .form-control").attr('class', 'form-control is-valid')
        $.ajax({
            url: url,
            type: 'post',
            dataType: 'json',
            data: requestData(),
            success: function(res) {
                console.log(res);
                if (res.success == true) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Berhasil',
                        text: 'Data ditambahkan',
                    }).then((done) => {
                        location.reload()
                    })
                }else if(res.success == false){
                    Swal.fire({
                        icon: 'error',
                        title: 'Gagal',
                        text: 'Data gagal ditambahkan',
                    })
                }else if(res.success == 'error'){
                    Swal.fire({
                        icon: 'error',
                        title: 'Gagal',
                        text: 'Ketegori telah terdaftar',
                    })
                }
            },
            error: function(res) {
                console.log(res);
                $.each(res.responseJSON.errors, function(i, data) {
                    $('#' + data[0][0]).attr("class", data[0][1]);
                    $('#' + data[0][0]+"Invalid").text(data[0][2]);
                });
            },
        })
    }
    // update
    function update(id) {
        $(".invalid-feedback").text('')
        $(".modal .form-control").attr('class', 'form-control is-valid')
        $.ajax({
            url: url+'/'+id,
            type: 'put',
            dataType: 'json',
            data: requestData(),
            success: function(res) {
                console.log(res);
                if (res.success == true) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Berhasil',
                        text: 'Data disimpan',
                    }).then((done) => {
                        location.reload()
                    })
                }else if(res.success == false){
                    Swal.fire({
                        icon: 'error',
                        title: 'Gagal',
                        text: 'Data gagal disimpan',
                    })
                }
            },
            error: function(res) {
                $.each(res.responseJSON.errors, function(i, data) {
                    $('#' + data[0][0]).attr("class", data[0][1]);
                    $('#' + data[0][0]+"Invalid").text(data[0][2]);
                });
            },
        })
    }
    // delete
    function drop(id) {
        Swal.fire({
            icon: 'warning',
            title: 'Hapus data?',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            confirmButtonText: 'Lanjutkan!',
            cancelButtonColor: '#d33',
            cancelButtonText: 'Tidak!'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: url + '/' + id,
                    type: 'delete',
                    dataType: 'json',
                    data: {
                        "_token": "{{ csrf_token() }}",
                    },
                    success: function(res) {
                        console.log(res);
                        if (res.success == true) {
                            Swal.fire({
                                icon: 'success',
                                title: 'Berhasil',
                                text: 'Data dihapus',
                            }).then((done) => {
                                location.reload()
                            })
                        }else if(res.success == false){
                            Swal.fire({
                                icon: 'error',
                                title: 'Gagal',
                                text: 'Data gagal dihapus',
                            })
                        }
                    },
                    error: function() {
                        Swal.fire(
                            'Gagal!',
                            'Data tidak dapat dihapus',
                            'error'
                        )
                    }
                });
            }
        })
    }
</script>
@endsection
