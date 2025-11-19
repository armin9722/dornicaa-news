<!DOCTYPE html>
<html lang="fa" dir="rtl">

<head>
    <title>
        {{config("project.title")}}
        |@isset($title)
            {{$title}}
        @endisset
    </title>
    <!-- Meta Tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="author" content="Blogzine">


    <!-- Dark mode -->
    <script>
        const storedTheme = localStorage.getItem('theme')

        const getPreferredTheme = () => {
            if (storedTheme) {
                return storedTheme
            }
            return window.matchMedia('(prefers-color-scheme: dark)').matches ? 'dark' : 'light'
        }

        const setTheme = function (theme) {
            if (theme === 'auto' && window.matchMedia('(prefers-color-scheme: dark)').matches) {
                document.documentElement.setAttribute('data-bs-theme', 'dark')
            } else {
                document.documentElement.setAttribute('data-bs-theme', theme)
            }
        }

        setTheme(getPreferredTheme())

        window.addEventListener('DOMContentLoaded', () => {
            var el = document.querySelector('.theme-icon-active');
            if(el !== 'undefined' && el != null) {
                const showActiveTheme = theme => {
                    const activeThemeIcon = document.querySelector('.theme-icon-active use')
                    const btnToActive = document.querySelector(`[data-bs-theme-value="${theme}"]`)
                    const svgOfActiveBtn = btnToActive.querySelector('.mode-switch use').getAttribute('href')

                    document.querySelectorAll('[data-bs-theme-value]').forEach(element => {
                        element.classList.remove('active')
                    })

                    btnToActive.classList.add('active')
                    activeThemeIcon.setAttribute('href', svgOfActiveBtn)
                }

                window.matchMedia('(prefers-color-scheme: dark)').addEventListener('change', () => {
                    if (storedTheme !== 'light' || storedTheme !== 'dark') {
                        setTheme(getPreferredTheme())
                    }
                })

                showActiveTheme(getPreferredTheme())

                document.querySelectorAll('[data-bs-theme-value]')
                    .forEach(toggle => {
                        toggle.addEventListener('click', () => {
                            const theme = toggle.getAttribute('data-bs-theme-value')
                            localStorage.setItem('theme', theme)
                            setTheme(theme)
                            showActiveTheme(theme)
                        })
                    })

            }
        })

    </script>

    <!-- Favicon: use SVG icon with ICO fallback from assets/images -->
    <link rel="icon" href="{{ asset('assets/images/logo-icon.svg') }}" type="image/svg+xml">
    <link rel="shortcut icon" href="{{ asset('assets/images/favicon.ico') }}">

    <!-- Plugins CSS -->
    <link rel="stylesheet" type="text/css" href="{{asset("assets/vendor/font-awesome/css/all.min.css")}}">
    <link rel="stylesheet" type="text/css" href="{{asset("assets/vendor/bootstrap-icons/bootstrap-icons.css")}}">
    <link rel="stylesheet" type="text/css" href="{{asset("assets/vendor/tiny-slider/tiny-slider.css")}}">
    <link rel="stylesheet" type="text/css" href="{{asset("assets/vendor/plyr/plyr.css")}}">

    <!-- Theme CSS -->
    <link id="style-switch" rel="stylesheet" type="text/css" href="{{asset("assets/css/style-rtl.css")}}">

</head>

<body>
<!-- Preloader START -->
<div class="preloader">
    <div class="loader">
        <div class="sh1"></div>
        <div class="sh2"></div>
    </div>
</div>

<!-- Login Modal -->
<div class="modal fade" id="loginModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content p-4">

            <h4 class="mb-3">ورود به حساب کاربری</h4>

            <form action="{{route('auth.login.post')}}" method="post">
                @csrf

                @error('general')
                <div class="alert alert-danger">{{$message}}</div>
                @enderror

                <div class="mb-3">
                    <label for="email1" class="form-label">پست الکترونیکی</label>
                    <input type="email" class="form-control" id="email1" name="email" value="{{old('email')}}">
                </div>
                @error('email')
                <div class="text-danger">{{$message}}</div>
                @enderror

                <div class="mb-3">
                    <label for="exampleInputPassword1" class="form-label">رمز عبور</label>
                    <input type="password" class="form-control" id="exampleInputPassword1" name="password">
                </div>
                @error('password')
                <div class="text-danger">{{$message}}</div>
                @enderror

                <div class="d-flex justify-content-between align-items-center mt-3">
                    <button type="submit" class="btn btn-success">ورود</button>
                    <span>ثبت نام نکرده‌اید؟
                        <a href="{{route('auth.register.index')}}">
                            <u>ثبت نام</u>
                        </a>
                    </span>
                </div>
            </form>

        </div>
    </div>
</div>



<!-- Header -->
@includeUnless(isset($rawLayout),"layout.header")

@yield('content')


<!-- Footer -->
@includeUnless(isset($rawLayout),"layout.footer")
@if ($errors->any())
    <script>
        var myModal = new bootstrap.Modal(document.getElementById('loginModal'));
        myModal.show();
    </script>
@endif



<!-- Back to top -->
<div class="back-top"><i class="bi bi-arrow-up-short"></i></div>

<!-- =======================
JS libraries, plugins and custom scripts -->

<!-- Bootstrap JS -->


<script src="{{asset("assets/vendor/bootstrap/dist/js/bootstrap.bundle.min.js")}}"></script>

<!-- Vendors -->
<script src="{{asset("assets/vendor/tiny-slider/tiny-slider-rtl.js")}}"></script>
<script src="{{asset("assets/vendor/sticky-js/sticky.min.js")}}"></script>
<script src="{{asset("assets/vendor/plyr/plyr.js")}}"></script>

<!-- Template Functions -->
<script src="{{asset("assets/js/functions.js")}}"></script>
</body>

</html>
