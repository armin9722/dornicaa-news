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
                        <div class="bg-primary bg-opacity-10 rounded p-4 p-sm-5">
                            <h2>ثبت نام در سایت </h2>
                            <!-- Form START -->
                            <form class="mt-4" action="{{route("auth.register.post")}}" method="post" id="registerForm" enctype="multipart/form-data">
                                @csrf
                                @error('general')
                                <div class="text-danger">
                                    {{$message}}
                                </div>
                                @enderror
                                <div class="mb-3">
                                    <label class="form-label" for="first_name">نام</label>
                                    <input type="text" class="form-control" id="first_name" name="first_name"
                                           value="{{old("first_name")}}">
                                </div>
                                @error('first_name')
                                <div class="text-danger">
                                    {{$message}}
                                </div>
                                @enderror
                                <div class="mb-3">
                                    <label class="form-label" for="last_name">نام خانوادگی</label>
                                    <input type="text" class="form-control" id="last_name" name="last_name"
                                           value="{{old("last_name")}}">
                                </div>
                                @error('last_name')
                                <div class="text-danger">
                                    {{$message}}
                                </div>
                                @enderror
                                <!-- National Code -->
                                <div class="mb-3">
                                    <label class="form-label" for="national_code">کدملی</label>
                                    <input type="text" class="form-control" id="national_code" name="national_code"
                                           value="{{old("national_code")}}" maxlength="10" pattern="[0-9]{10}">
                                    @error('national_code')
                                    <div class="text-danger">
                                        {{$message}}
                                    </div>
                                    @enderror
                                </div>
                                <!-- Gender -->
                                <div class="mb-3">
                                    <label class="form-label" for="gender">جنسیت</label>
                                    <select class="form-control" id="gender" name="gender" required>
                                        @foreach(\App\Enums\Gender::all() as $value => $label)
                                            <option value="{{ $value }}" {{ old('gender') == $value ? 'selected' : '' }}>
                                                {{ $label }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('gender')
                                    <div class="text-danger">
                                        {{$message}}
                                    </div>
                                    @enderror
                                </div>
                                <!-- Mobile -->
                                <div class="mb-3">
                                    <label class="form-label" for="mobile">شماره همراه</label>
                                    <input type="tel" class="form-control @error('mobile') is-invalid @enderror" id="mobile" name="mobile"
                                           value="{{old("mobile")}}" maxlength="11" pattern="09[0-9]{9}">
                                    @error('mobile')
                                    <div class="invalid-feedback d-block">
                                        {{$message}}
                                    </div>
                                    @enderror
                                </div>


                                <!-- Avatar/Image Upload -->
                                <div class="mb-3">
                                    <label class="form-label" for="image">عکس</label>
                                    <input type="file" class="form-control" id="image" name="image"
                                           accept="image/*">
                                    <small class="form-text text-muted">فرمت‌های مجاز: JPG, PNG, GIF (حداکثر800kb)</small>
                                    @error('image')
                                    <div class="text-danger">
                                        {{$message}}
                                    </div>
                                    @enderror
                                </div>
                                <!-- Username -->
                                <div class="mb-3">
                                    <label class="form-label" for="username">نام کاربری</label>
                                    <input type="text" class="form-control" id="username" name="username"
                                           value="{{old("username")}}">
                                    @error('username')
                                    <div class="text-danger">
                                        {{$message}}
                                    </div>
                                    @enderror
                                </div>
                                <!-- Province -->
                                <div class="mb-3">
                                    <label class="form-label" for="province_id">استان</label>
                                    <select class="form-control" id="province_id" name="province_id" onchange="filterCities()">
                                        <option value="">انتخاب کنید</option>
                                        @foreach(\App\Models\Province::all() as $province)
                                            <option value="{{ $province->id }}" {{ old('province_id') == $province->id ? 'selected' : '' }}>
                                                {{ $province->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('province_id')
                                    <div class="text-danger">
                                        {{$message}}
                                    </div>
                                    @enderror
                                </div>
                                <!-- City -->
                                <div class="mb-3">
                                    <label class="form-label" for="city_id">شهرستان</label>
                                    <select class="form-control" id="city_id" name="city_id">
                                        <option value="">ابتدا استان را انتخاب کنید</option>
                                        @foreach(\App\Models\City::all() as $city)
                                            <option value="{{ $city->id }}"
                                                    data-province-id="{{ $city->province_id }}"
                                                    {{ old('city_id') == $city->id ? 'selected' : '' }}
                                                    class="city-option">
                                                {{ $city->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('city_id')
                                    <div class="text-danger">
                                        {{$message}}
                                    </div>
                                    @enderror
                                </div>
                                <!-- Military Service Status - Only show for males (gender = 0) -->
                                @if(old('gender') != 1)
                                <div class="mb-3 military-service-field">
                                    <label class="form-label" for="military_service_status">وضعیت نظام وظیفه</label>
                                    <select class="form-control" id="military_service_status" name="military_service_status">
                                        @foreach(\App\Enums\MilitaryServiceStatus::all() as $value => $label)
                                            @if($value != 0) {{-- Skip "ندارد" (None) option --}}
                                                <option value="{{ $value }}" {{ old('military_service_status') == $value ? 'selected' : '' }}>
                                                    {{ $label }}
                                                </option>
                                            @endif
                                        @endforeach
                                    </select>
                                    @error('military_service_status')
                                    <div class="text-danger">
                                        {{$message}}
                                    </div>
                                    @enderror
                                </div>
                                @else
                                <!-- Hidden input for females - automatically set to 0 (None) -->
                                <input type="hidden" name="military_service_status" value="0">
                                @endif
                                <!-- Email -->
                                <div class="mb-3">
                                    <label class="form-label" for="exampleInputEmail1">پست الکترونیکی</label>
                                    <input type="email" class="form-control" id="exampleInputEmail1" name="email" value="{{old('email')}}">
                                    @error('email')
                                    <div class="text-danger">
                                        {{$message}}
                                    </div>
                                    @enderror
                                </div>
                                <!-- Password -->
                                <div class="mb-3">
                                    <label class="form-label" for="exampleInputPassword1">رمز عبور</label>
                                    <input type="password" class="form-control" id="exampleInputPassword1" name="password">
                                    @error('password')
                                    <div class="text-danger">
                                        {{$message}}
                                    </div>
                                    @enderror
                                </div>
                                <!-- Password Confirmation -->
                                <div class="mb-3">
                                    <label class="form-label" for="exampleInputPassword2">تایید رمز عبور</label>
                                    <input type="password" class="form-control" id="exampleInputPassword2" name="password_confirmation">
                                    @error('password_confirmation')
                                    <div class="text-danger">
                                        {{$message}}
                                    </div>
                                    @enderror
                                </div>

                                <!-- Security Code -->
                                <div class="mb-3">
                                    <label class="form-label d-flex justify-content-between align-items-center">
                                        <span>کد امنیتی</span>
                                        <span class="badge bg-dark fs-5">{{ $securityCode ?? '' }}</span>
                                    </label>
                                    <input type="text"
                                           class="form-control @error('security_code') is-invalid @enderror"
                                           name="security_code"
                                           inputmode="numeric"
                                           dir="rtl"
                                           placeholder="کد نمایش داده شده را وارد کنید"
                                           value="{{ old('security_code') }}">

                                    @error('security_code')
                                    <div class="invalid-feedback d-block">
                                        {{$message}}
                                    </div>
                                    @enderror
                                </div>

                                <!-- Button -->
                                <div class="row align-items-center">
                                    <div class="col-sm-4">
                                        <button type="submit" class="btn btn-success">ثبت نام</button>
                                    </div>
                                    <div class="col-sm-8 text-sm-end">
                                        <span>آیا قبلا ثبت نام کرده اید؟ <a href="{{route("auth.login.index")}}"><u>ورود</u></a></span>
                                    </div>
                                </div>
                            </form>
                            <!-- Form END -->

                            <script>
                                function filterCities() {
                                    const provinceSelect = document.getElementById('province_id');
                                    const citySelect = document.getElementById('city_id');
                                    const selectedProvinceId = provinceSelect.value;

                                    // Get all city options
                                    const cityOptions = citySelect.querySelectorAll('.city-option');

                                    // Get currently selected city (for preserving old input)
                                    const selectedCityId = citySelect.value;

                                    if (selectedProvinceId) {
                                        // Show/hide cities based on province
                                        cityOptions.forEach(option => {
                                            const provinceId = option.getAttribute('data-province-id');
                                            option.hidden = provinceId !== selectedProvinceId;
                                        });

                                        // Update placeholder
                                        const placeholder = citySelect.querySelector('option[value=""]');
                                        if (placeholder) {
                                            placeholder.textContent = 'انتخاب کنید';
                                            placeholder.hidden = false;
                                        }

                                        // Restore selected city if it belongs to the selected province
                                        if (selectedCityId) {
                                            const selectedOption = citySelect.querySelector(`option[value="${selectedCityId}"]`);
                                            if (selectedOption && selectedOption.getAttribute('data-province-id') === selectedProvinceId) {
                                                citySelect.value = selectedCityId;
                                            } else {
                                                citySelect.value = '';
                                            }
                                        }
                                    } else {
                                        // Hide all cities if no province selected
                                        cityOptions.forEach(option => {
                                            option.hidden = true;
                                        });

                                        // Reset city selection
                                        citySelect.value = '';

                                        // Show placeholder
                                        const placeholder = citySelect.querySelector('option[value=""]');
                                        if (placeholder) {
                                            placeholder.textContent = 'ابتدا استان را انتخاب کنید';
                                            placeholder.hidden = false;
                                        }
                                    }
                                }

                                // Run on page load to handle old input values
                                document.addEventListener('DOMContentLoaded', function() {
                                    filterCities();
                                });
                            </script>

                            <style>
                                /* Hide military service field when gender select has female (value="1") selected */
                                #gender[value="1"] ~ .military-service-field,
                                form:has(#gender option[value="1"]:checked) . {
                                    display: none !important;
                                }

                                /* Show hidden input when gender is female */
                                form:has(#gender option[value="1"]:checked) #military_hidden {
                                    display: block !important;
                                }

                                /* Hide hidden input when gender is male */
                                form:has(#gender option[value="0"]:checked) #military_hidden,
                                form:has(#gender option[value=""]:checked) #military_hidden {
                                    display: none !important;
                                }
                            </style>

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
