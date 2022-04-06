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
                            <th>Caption</th>
                            <th>Opsi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($data as $row)
                        <tr>
                            <td>{{$loop->iteration}}</td>
                            <td>{{$row->category->name}}</td>
                            <td>{{$row->caption}}</td>
                            <td>
                                <a href="#" class="btn btn-info" title="edit" data-toggle="modal" data-target="#modal"
                                    onclick="edit('{{$row['id']}}','{{$row['gallery_category_id']}}','{{$row['caption']}}','{{$row['source']}}')">
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
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalTitle"></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="formSubmit">
                <div class="modal-body">
                    <div class="form-row">
                        <div class="col-md">
                            <div class="form-group">
                                <label for="">Kategori</label>
                                <select class="form-control" name="gallery_category_id" id="gallery_category_id"
                                    placeholder="Ketegori">
                                    <option value="">Pilih Kategori</option>
                                    @foreach ($category as $row)
                                    <option value="{{$row->id}}">{{$row->name}}</option>
                                    @endforeach
                                    <div id="gallery_category_idInvalid" class="invalid-feedback"></div>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="">Caption</label>
                                <input type="text" class="form-control" name="caption" id="caption" placeholder="Caption">
                                <div id="captionInvalid" class="invalid-feedback"></div>
                            </div>
                            <div class="form-group">
                                <label for="">Gambar</label>
                                <input type="file" class="form-control" name="source" id="source"
                                    placeholder="source">
                                <div id="sourceInvalid" class="invalid-feedback"></div>
                                <img id="preview" src="/upload/images/default.png" alt="preview" class="img-fluid mt-3"
                                    style="width: 30%; height: 30%;" />
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer" id="modalFooter">
                </div>
            </form>
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
    function readURL(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            reader.onload = function(e) {
                $('#preview').attr('src', e.target.result);
            }
            reader.readAsDataURL(input.files[0]);
        }
    }
    $("#source").change(function() {
        readURL(this);
    });
    // global url
    let url = '{{ url("/admin/gallery/") }}';
    function requestData() {
        let formData = new FormData($('#formSubmit')[0]);
        formData.append('_token', "{{ csrf_token() }}")
        return formData;
    }
    function resetModal() {
        $('.modal .form-control').prop('class', 'form-control');
        $('.invalid-feedback').text('');
        $('#caption').val('');
        $('#post_category_id').val('').change();
        $('#source').val('');
        $('#preview').attr('src', '/upload/images/default.png');
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
    function edit(id, gallery_category_id, caption, source) {
        $('#modalTitle').text('Edit {{$title}}');
        resetModal();
        $('#gallery_category_id').val(gallery_category_id).change();
        $('#caption').val(caption);
        $('#preview').attr('src', source);
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
            contentType : false,
            processData : false,
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
            url: url+'/update/'+id,
            type: 'post',
            dataType: 'json',
            data: requestData(),
            contentType : false,
            processData : false,
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
