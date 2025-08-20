@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')
    <h1>Dashboard</h1>
@stop

@section('content')
    <div class="row">
        {{-- Total Sekolah --}}
        <div class="col-md-4">
            <div class="small-box bg-info">
                <div class="inner">
                    <h3>{{ $total_sekolah }}</h3>
                    <p>Total Sekolah</p>
                </div>
                <div class="icon">
                    <i class="fas fa-school"></i>
                </div>
                <a href="{{ route('admin.sekolah') }}" class="small-box-footer">Lihat <i
                        class="fas fa-arrow-circle-right"></i></a>
            </div>
        </div>

        {{-- Total Anggota --}}
        <div class="col-md-4">
            <div class="small-box bg-success">
                <div class="inner">
                    <h3>{{ $total_anggota }}</h3>
                    <p>Total Anggota</p>
                </div>
                <div class="icon">
                    <i class="fas fa-users"></i>
                </div>
                <a href="{{ route('admin.anggota') }}" class="small-box-footer">Lihat <i
                        class="fas fa-arrow-circle-right"></i></a>
            </div>
        </div>

        {{-- Total Simpanan --}}
        <div class="col-md-4">
            <div class="small-box bg-warning">
                <div class="inner">
                    <h3>{{ $total_simpanan }}</h3>
                    <p>Total Simpanan</p>
                </div>
                <div class="icon">
                    <i class="fas fa-wallet"></i>
                </div>
                <a href="{{ route('admin.simpanan') }}" class="small-box-footer">Lihat <i
                        class="fas fa-arrow-circle-right"></i></a>
            </div>
        </div>
    </div>

    <div class="row">
        {{-- Total Pinjaman --}}
        <div class="col-md-4">
            <div class="small-box bg-warning">
                <div class="inner">
                    <h3>{{ $total_pinjaman }}</h3>
                    <p>Total Pinjaman</p>
                </div>
                <div class="icon">
                    <i class="fas fa-hand-holding-usd"></i>
                </div>
                <a href="{{ route('admin.pinjaman') }}" class="small-box-footer">Lihat <i
                        class="fas fa-arrow-circle-right"></i></a>
            </div>
        </div>

        {{-- Total Pembayaran Angsuran --}}
        <div class="col-md-4">
            <div class="small-box bg-success">
                <div class="inner">
                    <h3>{{ $total_angsuran }}</h3>
                    <p>Total Pembayaran Angsuran</p>
                </div>
                <div class="icon">
                    <i class="fas fa-hand-holding-usd"></i>
                </div>
                <a href="{{ route('admin.pinjaman') }}" class="small-box-footer">Lihat <i
                        class="fas fa-arrow-circle-right"></i></a>
            </div>
        </div>

        {{-- Total Penarikan --}}
        <div class="col-md-4">
            <div class="small-box bg-info">
                <div class="inner">
                    <h3>{{ $total_penarikan }}</h3>
                    <p>Total Penarikan</p>
                </div>
                <div class="icon">
                    <i class="fas fa-hand-holding-usd"></i>
                </div>
                <a href="{{ route('admin.penarikan') }}" class="small-box-footer">Lihat <i
                        class="fas fa-arrow-circle-right"></i></a>
            </div>
        </div>
    </div>

    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
        @csrf
    </form>
@stop

@section('css')
    {{-- Tambahkan CSS custom kalau perlu --}}
@stop

@section('js')
    @if (session('msg_success'))
        <script>
            toastr.success("{{ session('msg_success') }}", {
                timeOut: 3000,
                closeButton: true,
                progressBar: true
            });
        </script>
    @endif

    @if (session('msg_error'))
        <script>
            toastr.error("{{ session('msg_error') }}", {
                timeOut: 3000,
                closeButton: true,
                progressBar: true
            });
        </script>
    @endif
@stop
