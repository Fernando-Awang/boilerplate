@extends('admin.layout.layout')
@section('content')
<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>{{$title}}</h1>
                </div>
            </div>
    </section>
    <section class="content">
        <div class="card">
            <div class="card-body">
                <table id="example2" class="table table-bordered table-hover">
                    <thead>
                        <tr>
                            <th>No.</th>
                            <th>Nama</th>
                            <th>Email</th>
                            <th>Opsi</th>
                        </tr>
                    </thead>
                    <tbody>
                       @foreach ($data as $row)
                        <td>{{$loop->iteration}}</td>
                        <td>{{$row['name']}}</td>
                        <td>{{$row['email']}}</td>
                        <td>
                            <a href="#" class="btn btn-info" title="edit">
                                <i class="fas fa-edit"></i>
                            </a>
                            <a href="#" class="btn btn-danger" title="hapus">
                                <i class="fas fa-trash-alt"></i>
                            </a>
                        </td>
                       @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </section>
</div>
@endsection
@section('script')
<script>
    
</script>
@endsection

