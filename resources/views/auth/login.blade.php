@extends('adminlte::auth.login')

@section('auth_header')
    <h4 class="text-center">Login</h4>
@stop

@section('auth_body')
    <form action="{{ route('post.login') }}" method="POST">
        @csrf
        @method('POST')
        {{-- Field Username --}}
        <div class="input-group mb-3">
            <input type="text" name="username" class="form-control" placeholder="Username" value="{{ old('username') }}"
                autofocus required>
            <div class="input-group-append">
                <div class="input-group-text"><span class="fas fa-user"></span></div>
            </div>
        </div>

        {{-- Field Password --}}
        <div class="input-group mb-3">
            <input type="password" name="password" class="form-control" placeholder="Password" required>
            <div class="input-group-append">
                <div class="input-group-text"><span class="fas fa-lock"></span></div>
            </div>
        </div>

        {{-- Tombol Login --}}
        <button type="submit" class="btn btn-primary btn-block">Login</button>
    </form>
@stop

@section('auth_footer')
@stop

@section('js')
    @if (session('msg_error'))
        <script>
            toastr.error("{{ session('msg_error') }}", {
                timeOut: 3000,
                closeButton: true,
                progressBar: true
            });
        </script>
    @endif

    @if (session('msg_success'))
        <script>
            toastr.success("{{ session('msg_success') }}", {
                timeOut: 3000,
                closeButton: true,
                progressBar: true
            });
        </script>
    @endif
@stop
