@extends('./layout/index')

@section('title', 'Selamat datang!')

<!-- hides header -->
@section('header')
@endsection

@section('content')
    <div class="bg-lego">
        <div class="container-center">
            <div>
                <h1 class="brand-hero">Kejar Matrikulasi</h1>       
                <form class="card-384">
                    @csrf
                    <div class="form-group">
                        <label for="username">Username</label>
                        <input type="text" name="username" class="form-control" id="username" autocomplete="off" placeholder="Ketik username">
                    </div>
                    <div class="form-group-last">
                        <label for="password">Password</label>
                        <input type="password" name="password" class="form-control" id="password" autocomplete="off" placeholder="Ketik password">
                    </div>
                    <button type="submit" class="btn btn-login">MASUK</button>
                </form>
            </div>
        </div>
    </div>
    <div class="bg-lego-mobile"></div>
@endsection
