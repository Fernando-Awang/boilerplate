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
                    <a href="{{route('admin.post.create')}}" class="btn btn-success float-right">
                        <li class="fas fa-plus"></li>
                        Tambah
                    </a>
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
                            <th>Judul</th>
                            <th>Kategori</th>
                            <th>Author</th>
                            <th>Opsi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($data as $row)
                        <tr>
                            <td>{{$loop->iteration}}</td>
                            <td>{{$row->title}}</td>
                            <td>{{$row->category->name}}</td>
                            <td>{{$row->get_author->name}}</td>
                            <td>
                                <a href="{{ route('admin.post.edit', ['id'=>$row['id']]) }}" class="btn btn-info" title="edit">
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
