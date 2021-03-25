@extends('shop.layout.markup')

@section('title')
    Mobile Varification | {{config('app.name')}}
@endsection

@section('page')
<div class="container mt-3">
    <div class="row justify-content-center">
        <div class="col-md-8">

            @if (session('status'))
                <div class="alert alert-danger">
                    {{ session('status') }}
                </div>
            @endif

            <div class="card">

                <div class="card-header">{{ __('Mobile Verification') }}</div>

                <div class="card-body">
                    <form method="POST" action="{{ route('otp') }}">
                        @csrf
                        <div class="form-group row">
                            <input value=" {{$id}} " name="id" hidden>
                            <label for="mobile" class="col-md-4 col-form-label text-md-right">{{ __('Mobile No') }}</label>
                            <div class="col-md-6">
                                <input id="mobile" type="text" class="form-control" name="mobile"
                                value=" {{substr($mobile, 0,4).'*****'.substr($mobile, 9,10)}} " readonly>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="otp" class="col-md-4 col-form-label text-md-right">{{ __('OTP') }}</label>

                            <div class="col-md-6">
                                <input id="otp" type="text" class="form-control" name="otp" required>
                            </div>
                        </div>


                        <div class="form-group row mb-0">
                            <div class="col-md-8 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Submit') }}
                                </button>
                            </div>
                        </div>
                    </form>



                </div>
            </div>
        </div>
    </div>
</div>
@endsection
