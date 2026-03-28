@extends('layouts.wrapper-admin', ['title' => 'Posts'])

@section('content')
    <h2>Posts</h2>

    <a href="{{ route('admin.post.create') }}" class="btn btn-primary">Add post</a>

    <table class="table table-hover mt-4">
        <thead>
        <tr>
            <th>ID</th>
            <th>Post Title</th>
            <th></th>
            <th></th>
            <th></th>
        </tr>
        </thead>
        <tbody>
        @foreach($posts as $post)
            <tr>
                <td>{{ $post->id }}</td>
                <td>{{ $post->title }}</td>
                <td><a href="{{ route('admin.post.show', $post->id) }}">Info</a></td>
                <td><a href="{{ route('admin.post.edit', $post->id) }}" class="text-success">Edit</a></td>
                <td>
                    <form action="{{ route('admin.post.destroy', $post->id)}}"
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


@endsection
