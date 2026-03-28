@extends('layouts.wrapper-admin', ['title' => 'Tag'])

@section('content')
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0">Tags</h1>
                    </div><!-- /.col -->
                </div><!-- /.row -->
            </div><!-- /.container-fluid -->
        </div>
        <!-- /.content-header -->

        <!-- Main content -->
        <section class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-1 mb-3">
                        <a href="{{ route('admin.tag.create') }}" class="btn btn-primary">Добавить</a>
                    </div>
                </div>
                <!-- /.row -->
                <div class="row">
                    <div class="col-6">
                        <div class="card">
                            <!-- /.card-header -->
                            <div class="card-body table-responsive p-0">
                                <table class="table table-hover text-nowrap">
                                    <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Название</th>
                                        <th>Просмотр</th>
                                        <th>Обновление</th>
                                        <th>Удаление</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($tags as $tag)
                                        <tr>
                                            <td>{{ $tag->id }}</td>
                                            <td>{{ $tag->title }}</td>
                                            <td><a href="{{ route('admin.tag.show', $tag->id) }}">Info</a></td>
                                            <td><a href="{{ route('admin.tag.edit', $tag->id) }}" class="text-success">Edit</a></td>
                                            <td>
                                                <form action="{{ route('admin.tag.destroy', $tag->id)}}"
                                                      method="post">
                                                    @csrf
                                                    @method('delete')
                                                    <button type="submit" class="border-0 bg-transparent">
                                                        Delete
                                                    </button>
                                                </form>
                                            </td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>
                            <!-- /.card-body -->
                        </div>
                        <!-- /.card -->
                    </div>
                </div>
                <!-- /.row -->
                <!-- /.content -->
            </div>
        </section>
    </div>



@endsection
