@extends('layouts.app')

@section('content')
<div class="container" style="margin-top:120px;">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <ul class="nav nav-tabs card-header-tabs">
                        <li class="nav-item">
                            <a class="nav-link active" href="#login" data-toggle="tab">Log In</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#signup" data-toggle="tab">Sign Up</a>
                        </li>
                    </ul>
                </div>

                <div class="card-body">
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <div class="tab-content">
                        <div id="login" class="tab-pane fade show active">
                            <h1 class="text-center">Login</h1>
                            <form action="{{ route('login') }}" method="post">
                                @csrf
                                <div class="form-group">
                                    <label for="email">Email Address<span class="text-danger">*</span></label>
                                    <input type="email" name="email" id="email" class="form-control" required>
                                </div>
                                <div class="form-group">
                                    <label for="password">Password<span class="text-danger">*</span></label>
                                    <input type="password" name="password" id="password" class="form-control" required>
                                </div>
                                <p class="forgot"><a href="#">Forgot Password</a></p>
                                <button class="btn btn-primary btn-block">Log In</button>
                            </form>
                        </div>

                        <div id="signup" class="tab-pane fade">
                            <h1 class="text-center">Sign Up</h1>
                            <form action="{{ route('register') }}" method="post">
                                @csrf
                                <div class="form-group">
                                    <label for="username">UserName<span class="text-danger">*</span></label>
                                    <input type="text" name="name" id="username" class="form-control" required>
                                </div>
                                <div class="form-group">
                                    <label for="email">Email<span class="text-danger">*</span></label>
                                    <input type="email" name="email" id="email" class="form-control" required>
                                </div>
                                <div class="form-group">
                                    <label for="password">Password<span class="text-danger">*</span></label>
                                    <input type="password" name="password" id="password" class="form-control" required>
                                </div>
                                <button type="submit" class="btn btn-success btn-block">Get Started</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.7.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/js/bootstrap.min.js"></script>
<script>
    $('.form').find('input, textarea').on('keyup blur focus', function (e) {
        var $this = $(this),
            label = $this.prev('label');

        if (e.type === 'keyup') {
            if ($this.val() === '') {
                label.removeClass('active highlight');
            } else {
                label.addClass('active highlight');
            }
        } else if (e.type === 'blur') {
            if ($this.val() === '') {
                label.removeClass('active highlight');
            } else {
                label.removeClass('highlight');
            }
        } else if (e.type === 'focus') {
            if ($this.val() === '') {
                label.removeClass('highlight');
            } else if ($this.val() !== '') {
                label.addClass('highlight');
            }
        }
    });

    $('.nav-tabs a').on('click', function (e) {
        e.preventDefault();

        // クリックしたタブのhref属性を取得
        var target = $(this).attr('href');

        // クリックしたタブに対応するコンテンツを表示
        $(target).tab('show');

        // クリックしたタブをアクティブにし、他のタブを非アクティブにする
        $(this).addClass('active');
        $(this).siblings().removeClass('active');
        $(target).siblings().removeClass('show active');
        $(target).addClass('show active');
    });
</script>
@endsection
