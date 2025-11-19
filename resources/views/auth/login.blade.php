@extends("layout.app")
@section("content")
    <!-- **************** MAIN CONTENT START **************** -->
    <main>

        <!-- =======================
        Inner intro START -->
        <section>
            <div class="container">
                <div class="row">
                    <div class="col-md-10 col-lg-8 col-xl-6 mx-auto">
                        <div class="p-4 p-sm-5 bg-primary bg-opacity-10 rounded">
                            <h2>ورود به حساب کاربری</h2>
                            <!-- Form START -->
                            <form class="mt-4" action="{{route("auth.login.post")}}" method="post">
                                @csrf
                                @error('general')
                                <div class="alert alert-danger">
                                    {{$message}}
                                </div>
                                @enderror
                                <!-- Email -->

                                <div class="mb-3">
                                    <label class="form-label" for="email1">پست الکترونیکی</label>
                                    <input type="email" class="form-control" id="email1" name="email"
                                           value="{{old("email")}}">
                                </div>
                                @error('email')
                                <div class="text-danger">
                                    {{$message}}
                                </div>
                                @enderror
                                <!-- Password -->
                                <div class="mb-3">
                                    <label class="form-label" for="exampleInputPassword1">رمز عبور</label>
                                    <input type="password" class="form-control" id="exampleInputPassword1" name="password">
                                </div>
                                @error('password')
                                <div class="text-danger">
                                    {{$message}}
                                </div>
                                @enderror
                                <!-- Button -->
                                <div class="row align-items-center">
                                    <div class="col-sm-4">
                                        <button type="submit" class="btn btn-success">ورود </button>
                                    </div>
                                    <div class="col-sm-8 text-sm-end">
                                        <span>آیا هنوز ثبت نام نکرده اید؟ <a href="{{route("auth.register.index")}}"><u>ثبت نام</u></a></span>
                                    </div>
                                </div>
                            </form>
                            <!-- Form END -->


                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- =======================
        Inner intro END -->

    </main>
    <!-- **************** MAIN CONTENT END **************** -->
@endsection
