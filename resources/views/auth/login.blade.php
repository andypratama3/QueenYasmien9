<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Login</title>

    <link rel="stylesheet" href="{{ asset('assets/login/style.css') }}">
</head>
<body>
    <br>
    <div class="cont">
        <div class="form sign-in">
            <h2>Welcome</h2>

            <form action="{{ route('login') }}" method="POST">
                @csrf
                <label>
                    <span>Email</span>
                    <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email') }}" required />
                    @error('email')
                        <div class="alert alert-danger">{{ $message }}</div>
                    @enderror
                </label>

                <label>
                    <span>Password</span>
                    <input type="password" name="password" class="form-control @error('password') is-invalid @enderror" required />
                    @error('password')
                        <div class="alert alert-danger">{{ $message }}</div>
                    @enderror
                </label>
                <p class="forgot-pass"><a href="{{ route('password.request') }}">Forgot password?</a></p>
                <button type="submit" class="submit">Sign In</button>
            </form>
        </div>

        <div class="sub-cont">
            <div class="img">
                <div class="img__text m--up">
                    <h3>Don't have an account? Please Sign up!</h3>
                </div>
                <div class="img__text m--in">
                    <h3>If you already have an account, just sign in.</h3>
                </div>
                <div class="img__btn">
                    <span class="m--up">Sign Up</span>
                    <span class="m--in">Sign In</span>
                </div>
            </div>

            <div class="form sign-up">
                <h2>Create your Account</h2>
                <form action="{{ route('register') }}" method="POST">
                    @csrf
                    <label>
                        <span>Name</span>
                        <input type="text" name="name" value="{{ old('name') }}" required />
                    </label>
                    <label>
                        <span>Email</span>
                        <input type="email" name="email" value="{{ old('email') }}" required />
                    </label>
                    <label>
                        <span>Password</span>
                        <input type="password" name="password" required />
                    </label>
                    <button type="submit" class="submit">Sign Up</button>
                </form>
            </div>
        </div>
    </div>

    <script>
        document.querySelector('.img__btn').addEventListener('click', function() {
            document.querySelector('.cont').classList.toggle('s--signup');
        });
    </script>

</body>
</html>
