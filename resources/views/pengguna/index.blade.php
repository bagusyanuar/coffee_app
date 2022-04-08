@extends('base')

@section('css')
@endsection

@section('content')
    @if (\Illuminate\Support\Facades\Session::has('success'))
        <script>
            Swal.fire("Berhasil!", '{{\Illuminate\Support\Facades\Session::get('success')}}', "success")
        </script>
    @endif
    <div class="container-fluid pt-3">
        <div class="d-flex align-items-center justify-content-between mb-3">
            <p class="font-weight-bold mb-0" style="font-size: 20px">Halaman Pengguna</p>
            <ol class="breadcrumb breadcrumb-transparent mb-0">
                <li class="breadcrumb-item">
                    <a href="/dashboard">Dashboard</a>
                </li>
                <li class="breadcrumb-item active" aria-current="page">Pengguna
                </li>
            </ol>
        </div>
        <div class="w-100 p-2">
            <div class="text-right mb-2 pr-3">
                <a href="/pengguna/tambah" class="btn btn-primary"><i class="fa fa-plus mr-1"></i><span class="font-weight-bold">Tambah</span></a>
            </div>
            <table id="table-data" class="display w-100 table table-bordered">
                <thead>
                <tr>
                    <th width="10%" class="text-center">#</th>
                    <th>Username</th>
                    <th>Hak Akses</th>
                    <th width="20%" class="text-center">Action</th>
                </tr>
                </thead>
                <tbody>
                @foreach($data as $v)
                    <tr>
                        <td width="10%" class="text-center">{{ $loop->index + 1 }}</td>
                        <td>{{ $v->username }}</td>
                        <td>{{ $v->role }}</td>
                        <td class="text-center">
                            <a href="/pengguna/edit/{{ $v->id }}" class="btn btn-sm btn-warning btn-edit" data-id="{{ $v->id }}"><i class="fa fa-edit"></i></a>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>

@endsection

@section('js')
    <script type="text/javascript">
        $(document).ready(function () {
            $('#table-data').DataTable();
        });
    </script>
@endsection
