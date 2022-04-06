@extends('admin.layout.layout')
@section('content')
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>{{ $title }}</h1>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">

        <!-- Default box -->
        <div class="card">
            <div class="card-body">
                <div class="form-row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="">Nama Instansi</label>
                            <input type="text" class="form-control" id="name" placeholder="Nama" value="{{$data->name ?? ''}}">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="">Telepon</label>
                            <input type="text" class="form-control" id="phone" placeholder="telepon" value="{{$data->phone ?? ''}}">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="">Email</label>
                            <input type="text" class="form-control" id="email" placeholder="Email" value="{{$data->email ?? ''}}">
                        </div>
                    </div>
                </div>
                <div class="form-row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="">Alamat Instansi</label>
                            <textarea class="form-control" rows="3" id="office_address" placeholder="Alamat">{{$data->office_address ?? ''}}</textarea>
                        </div>
                        <div class="form-group">
                            <label for="">Visi</label>
                            <textarea class="form-control" rows="3" id="vision" placeholder="Visi Instansi">{{$data->vision ?? ''}}</textarea>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="">Deskripsi Instansi</label>
                            <textarea class="form-control" rows="3" id="about"
                            placeholder="Deskripsi Instansi">{{$data->about ?? ''}}</textarea>
                        </div>
                        <div class="form-group">
                            <label for="">Misi</label>
                            <textarea class="form-control" rows="3" id="mission" placeholder="Misi Instansi">{{$data->mission ?? ''}}</textarea>
                        </div>
                    </div>
                </div>
            </div>
            <!-- /.card-body -->
            <div class="card-footer">
                <a href="#" class="btn btn-success" onclick="update('{{$data->id}}')">
                    <li class="fas fa-save"></li>
                    Simpan
                </a>
            </div>
            <!-- /.card-footer-->
        </div>
        <!-- /.card -->

    </section>
    <!-- /.content -->
</div>
@endsection
@section('script')
<script>
    function resetForm(){
        $('.form-control').prop('class', 'form-control');
        $('.invalid-feedback').text('');
        $('#name').val('');
        $('#phone').val('');
        $('#email').val('');
        $('#office_address').val('');
        $('#vision').val('');
        $('#about').val('');
        $('#mission').val('');
    }
    function requestData() {
        return {
            _token: '{{csrf_token()}}',
            name: $('#name').val(),
            phone: $('#phone').val(),
            email: $('#email').val(),
            office_address: $('#office_address').val(),
            about: $('#about').val(),
            vision: $('#vision').val(),
            mission: $('#mission').val(),
        }
    }
    function update(id) {
        resetForm()
        $(".modal .form-control").attr('class', 'form-control is-valid')
        $.ajax({
            url: "url('/company-info/" + id,
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
                console.log(res);
                $.each(res.responseJSON.errors, function(i, data) {
                    $('#' + data[0][0]).attr("class", data[0][1]);
                    $('#' + data[0][0]+"Invalid").text(data[0][2]);
                });
            },
        })
    }
</script>
@endsection

