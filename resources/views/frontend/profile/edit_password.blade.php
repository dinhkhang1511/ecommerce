@extends('layouts.frontend.app')
@section('content')
@foreach ($errors->all() as $error)
    <li>{{ $error }}</li>
@endforeach
<section class="checkout spad">
    <div class="container">
        <div class="checkout__form">
            <form action="{{ url('edit-password') }}" method="POST">
                @csrf
                <div class="row edit-input-btn">
                    <div class="col-12">
                        <h6 class="checkout__title">Change Password</h6>
                        <div class="row justify-content-md-center align-items-center">
                            <img src="/{{ $user->avatar }}" class="avatar" style="width: 100px; height: 100px; margin: auto">

                            <div class="col-lg-12">
                                <div class="checkout__input">
                                    <p>Current Password <span>*</span></p>
                                    <input type="password" placeholder="Current Password" name="current_password" autocomplete="off">
                                    @error('current_password') 
                                        <div class="error">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-lg-12">
                                <div class="checkout__input">
                                    <p>New Password <span>*</span></p>
                                    <input type="password" placeholder="New Password" name="new_password" autocomplete="off">
                                    @error('new_password') 
                                        <div class="error">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            
                        </div>
                    </div>
                </div>
                <button type="submit" class="site-btn mt-5">SAVE</button>
            </form>
        </div>
    </div>
</section>
@endsection
