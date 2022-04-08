@extends('admin.layout.layout')
@section('css')
<!-- DataTables -->
<link rel="stylesheet" type="text/css" href="/dist/DataTables/datatables.min.css" />
{{-- summernote --}}
<link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.css" rel="stylesheet">
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
                    <a href="{{ route('admin.post') }}" class="btn btn-primary float-right">
                        <li class="fas fa-arrow-left"></li>
                        Kembali
                    </a>
                </div>
            </div>
    </section>
    <section class="content">
        <div class="card">
            <form id="formSubmit">
                <div class="card-body">
                    <div class="form-row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="">Kategori</label>
                                <select class="form-control" name="post_category_id" id="post_category_id"
                                    placeholder="Ketegori">
                                    <option value="">Pilih Kategori</option>
                                    @foreach ($category as $row)
                                    <option value="{{$row->id}}">{{$row->name}}</option>
                                    @endforeach
                                    <div id="post_category_idInvalid" class="invalid-feedback"></div>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="">Judul</label>
                                <input type="text" class="form-control" name="title" id="title" placeholder="Judul">
                                <div id="titleInvalid" class="invalid-feedback"></div>
                            </div>
                            <div class="form-group">
                                <label for="">Thumbnail</label>
                                <input type="file" class="form-control" name="thumbnail" id="thumbnail"
                                    placeholder="thumbnail">
                                <div id="thumbnailInvalid" class="invalid-feedback"></div>
                                <img id="preview" src="/upload/images/default.png" alt="preview" class="img-fluid mt-3"
                                    style="width: 20%; height: 20%;" />
                            </div>
                        </div>
                        <div class="col-md-8">
                            <div class="form-group">
                                <label for="">Konten</label>
                                <textarea name="content" class="form-control" id="content" cols="30" rows="12"
                                    placeholder="Konten"></textarea>
                                <div id="contentInvalid" class="invalid-feedback"></div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-footer" id="cardFooter">
                </div>
            </form>
        </div>
    </section>
</div>
<!-- Modal -->
<div class="modal fade" id="modal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalTitle"></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

        </div>
    </div>
</div>
@endsection
@section('plugins')
<!-- DataTables  & Plugins -->
<script type="text/javascript" src="/dist/DataTables/datatables.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.js"></script>
@endsection
@section('script')
<script>
    $(document).ready(function() {
        $('.table').dataTable()
        $('#content').summernote({
            placeholder: 'Konten Artikel',
            tabsize: 2,
            height: 220,
            toolbar: [
            ['style', ['style']],
            ['font', ['bold', 'underline', 'clear']],
            ['color', ['color']],
            ['para', ['ul', 'ol', 'paragraph']],
            ['table', ['table']],
            ['insert', ['link',]],
            ['view', ['codeview', 'help']]
            ]
        });
        resetForm()
        if ("{{$setForm}}" == 'create') {
            formAdd()
        }
        if ("{{$setForm}}" == 'edit') {
            edit("{{$id}}")
        }
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
    $("#thumbnail").change(function() {
        readURL(this);
    });
    // global url
    let url = '{{ url("/admin/post/") }}';
    function requestData() {
        let formData = new FormData($('#formSubmit')[0]);
        formData.append('_token', "{{ csrf_token() }}")
        return formData;
    }
    function resetForm() {
        $('.modal .form-control').prop('class', 'form-control');
        $('.invalid-feedback').text('');
        $('#title').val('');
        $('#post_category_id').val('').change();
        $('#thumbnail').val('');
        $('#content').summernote('code', '');
        $('#preview').attr('src', '/upload/images/default.png');
    }
    function formAdd() {
        $('#cardFooter').html(`
        <button type="button" class="btn btn-success" onclick="create()">
            <li class="fas fa-plus"></li>
            Tambah
        </button>
        `);
    }
    function edit(id) {
        $.ajax({
            url: url+"/"+id,
            type: 'get',
            dataType: 'json',
            success: function(res) {
                console.log(res);
                $('#post_category_id').val(res.post_category_id);
                $('#title').val(res.title);
                $('#preview').attr('src',res.thumbnail);
                $('#content').summernote('code', res.content);
            },
        })
        $('#cardFooter').html(`
            <button type="button" class="btn btn-success" onclick="update('${id}')">
                <li class="fas fa-save"></li>
                Simpan
            </button>
            <button type="button" class="btn btn-danger" onclick="drop(`+id+`)">
                <li class="fas fa-trash-alt"></li>
                Hapus
            </button>
        `);
    }
    // create
    function create() {
        $(".invalid-feedback").text('')
        $(".card .form-control").attr('class', 'form-control is-valid')
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
                        location = '{{ url("/admin/post") }}';
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
                        text: 'Post telah terdaftar',
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
        $(".card .form-control").attr('class', 'form-control is-valid')
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
                        location = '{{ url("/admin/post") }}';
                    })
                }else if(res.success == false){
                    Swal.fire({
                        icon: 'error',
                        title: 'Gagal',
                        text: 'Data gagal disimpan',
                    })
                }else if(res.success == 'error'){
                    Swal.fire({
                        icon: 'error',
                        title: 'Gagal',
                        text: 'Post telah terdaftar',
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
                                location = '{{ url("/admin/post") }}';
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
