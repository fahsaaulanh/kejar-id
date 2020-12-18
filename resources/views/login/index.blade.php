@extends('./layout/index')

@section('title', 'Selamat datang!')

<!-- hides header -->
@section('header')
@endsection

@section('content')
    <div class="bg-lego">
        <div class="container-center">
            <div>
                <h1 class="brand-hero">Kejar.id</h1>
                <form class="card-384" action="{{ url('/login') }}" method="POST">
                    @csrf
                    <div class="form-group">
                        <label for="username">Username</label>
                        <input type="text" name="username" class="form-control" id="username" autocomplete="off" placeholder="Ketik username">
                    </div>
                    <div class="form-group-last">
                        <label for="password">Password</label>
                        <div class="input-group input-group-password">
                            <input type="password" name="password" class="form-control" id="password" autocomplete="off" placeholder="Ketik password">
                            <div class="input-group-append">
                                <button tabindex="-1" class="btn btn-outline-light" type="button"><i class="kejar-hide-password"></i></button>
                            </div>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-login">MASUK</button>
                    <div class="col-12 text-center">
                        <label class="label">Untuk bantuan, hubungi CS Kejar.id <a href="https://wa.me/6282261997532" target="_blank">di sini</a></label>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="bg-lego-mobile"></div>
@endsection
