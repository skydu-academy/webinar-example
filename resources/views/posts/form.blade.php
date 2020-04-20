@extends('layouts.app2')
@section('content')
<div class="container-fluid">
    <!-- /.row -->
    <div class="row">
        <div class="col-8">
            <div class="card card-primary">
                <!-- form start -->
                <form role="form" action="{{ route('posts.store') }}" method="post">
                    @csrf
                    <div class="card-body">
                        <div class="form-group">
                            <label for="title">Judul</label>
                            <input type="text" class="form-control" name="title" id="title" placeholder="Masukkan judul">
                            @error('title')
                                <h5 class="text-danger">{{ $message }}</h5>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="content">Konten</label>
                            <textarea id="content" name="content" rows="5"></textarea>
                        </div>
                    </div>
                    <!-- /.card-body -->
                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </div>
                </form>
            </div>
            <!-- /.card -->
        </div>
    </div>
</div>
@endsection
