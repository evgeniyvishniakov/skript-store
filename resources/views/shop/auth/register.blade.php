
@extends('shop.components.layout')

@section('content')

    <div class="login__container container">
        <div class="login__inner">
            <a href="{{ route('shop.home') }}" class="login__logo">
                <img class="brand-logo-dark" src="{{ asset('shop/images/logo4.png')  }}" alt=""/>
            </a>
            <h1 class="login__title">Create new account</h1>
            <form id="registerForm" method="POST" action="{{ route('shop.signup.create') }}">
                    @csrf
                    <div class="field">
                        <div class="field__label">Full name</div>
                        <input class="field__input " placeholder="Jamie Davis" type="text" name="name" required >
                        <div id="nameError" class="error-message"></div>
                    </div>
                    <div class="field">
                        <div class="field__label">Email</div>
                        <input class="field__input form-control @error('email') is-invalid @enderror" id="email"  placeholder="designer@example.com" type="email" name="email" required="">
                        <div id="emailError" class="error-message" style="display: none;"></div>
                    </div>
                    <div class="field">
                        <div class="field__label">Password</div>
                        <input class="field__input" minlength="8" pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}" placeholder="password" id="password" type="password" name="password" maxlength="40" required="" autocomplete="new-password">
                        <div class="password-requirements" style="display: none;">
                            The password must contain:
                            <ul>
                                <li id="req-length">≥8 characters</li>
                                <li id="req-uppercase">1 capital letter (A-Z)</li>
                                <li id="req-lowercase">1 lowercase letter (a-z)</li>
                                <li id="req-number">1 figure (0-9)</li>
                                <li id="req-special">1 special character (!@#$%^&*_+-=)</li>
                            </ul>
                        </div>
                        <button class="field__action" type="button" aria-label="Show password">
                            <!----><svg width="24" id="no_hidden" height="24"><path d="M12 4c4.517 0 7.994 2.902 10.426 6.753h0l.119.191.078.138.063.132a1.88 1.88 0 0 1 .112.339 2.16 2.16 0 0 1 0 .893 1.88 1.88 0 0 1-.112.339h0l-.063.132-.078.138-.119.192C19.994 17.098 16.517 20 12 20s-7.994-2.902-10.426-6.753h0l-.161-.264-.067-.129-.031-.068a1.88 1.88 0 0 1-.112-.339 2.16 2.16 0 0 1 0-.894 1.88 1.88 0 0 1 .112-.339 2.12 2.12 0 0 1 .063-.132h0l.078-.138.303-.479C4.181 6.759 7.597 4 12 4zm0 2c-3.646 0-6.633 2.494-8.735 5.821h0l-.111.178.293.463C5.538 15.647 8.459 18 12 18c3.646 0 6.634-2.494 8.735-5.821h0l.109-.181-.291-.46C18.463 8.353 15.542 6 12 6zm0 2a4 4 0 1 1 0 8 4 4 0 1 1 0-8zm0 2a2 2 0 1 0 0 4 2 2 0 1 0 0-4z"></path></svg>
                            <!----><svg width="24" id="hidden" height="24"><path d="M3.613 2.21l.094.083 3.652 3.649c.05.041.096.087.138.139l10.414 10.413c.058.046.112.1.16.16l3.636 3.639a1 1 0 0 1-1.32 1.497l-.094-.083-3.154-3.153C15.548 19.486 13.831 20 12 20c-4.404 0-7.819-2.759-10.241-6.466l-.303-.478-.078-.138a2.12 2.12 0 0 1-.063-.132 1.88 1.88 0 0 1-.112-.339 2.16 2.16 0 0 1 0-.894c.067-.293.141-.436.373-.802.947-1.499 2.153-2.952 3.618-4.143L2.293 3.707a1 1 0 0 1 1.32-1.497zm-.102 9.234l-.355.552V12l.111.179C5.367 15.506 8.355 18 12 18c1.282 0 2.504-.32 3.667-.918l-1.635-1.636A3.99 3.99 0 0 1 12 16a4 4 0 0 1-4-4 3.99 3.99 0 0 1 .554-2.031L6.617 8.032c-1.227.964-2.27 2.163-3.106 3.412zM12 4c4.517 0 7.994 2.902 10.426 6.753l.119.191.078.138.063.132a1.88 1.88 0 0 1 .112.339 2.16 2.16 0 0 1 0 .895c-.067.293-.142.436-.373.802a18.39 18.39 0 0 1-1.441 1.973 1 1 0 1 1-1.533-1.284c.397-.475.751-.951 1.061-1.414l.335-.52-.001-.007-.109-.177C18.634 8.494 15.646 6 12 6a7.59 7.59 0 0 0-1.111.082 1 1 0 1 1-.292-1.979C11.059 4.035 11.527 4 12 4zm-2 8a2 2 0 0 0 2 2c.178 0 .352-.023.518-.068l-2.451-2.45A2.01 2.01 0 0 0 10 12z"></path></svg><!---->
                        </button>
                    </div>
                    <input type="submit" name="submit" class="btn btn--submit" value="Sign up">
                </form>
            <div class="login__hint">Already have an account? <a href="{{ route('shop.login') }}">Log in</a></div>
        </div>
    </div>
    <script src="{{ asset('shop/js/core.min.js')  }}"></script>
    <script src="{{ asset('shop/js/script.js')  }}"></script>
@endsection
