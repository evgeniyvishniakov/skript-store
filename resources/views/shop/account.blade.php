@extends('shop.components.layout')

@section('content')


    <div class="account tabs">
        <div class="account-avatar-name">
            <div id="avatar-image"
                 class="img-thumbnail"
                 alt="Avatar" style="background: url('{{ Auth::user()->avatar ? asset('storage/' . Auth::user()->avatar) : '' }}') center/contain no-repeat;"></div>
            <div id="name-value" class="fw-bold">{{ Auth::user()->name }}</div>
        </div>
        <nav class="tabs__nav">
            <button class="tabs__btn active" data-tab="tab-1">Orders</button>
            <button class="tabs__btn" data-tab="tab-2">Fevorit</button>
            <button class="tabs__btn" data-tab="tab-3">Profile</button>
            <button class="tabs__btn" data-tab="tab-4">Change password</button>
            <button class="tabs__btn" data-tab="tab-5">Support</button>
            <button class="tabs__btn" id="exit">Exit account</button>
        </nav>

        <div class="tabs__content">
            <div class="tabs__panel active" id="tab-1">
                <h3>Orders</h3>
                <p>Здесь будут отображаться все ваши загруженные скрипты. Вы можете редактировать, удалять или просматривать статистику по каждому из них.</p>
            </div>

            <div class="tabs__panel" id="tab-2">
                <h3>Избранное</h3>
                <p>Выбарные скрипты</p>
            </div>
            <!-- Профиль -->
            <div class="tabs__panel" id="tab-3">
                <h3>Profile</h3>
                <div class="container">
                    <div class="row justify-content-center">
                        <div class="col-md-12">
                            <div class="card">
                                <div class="card-body">
                                    <div id="alert-container"></div>
                                    <form id="profile-form" method="POST" action="{{ route('account.update') }}" enctype="multipart/form-data">
                                        @csrf
                                        @method('PUT')
                                        <!-- Аватар -->
                                        <div class="row mb-4">
                                            <div class="col-md-12">
                                                <h5>Avatar</h5>

                                                <div id="avatar-display" @if(!Auth::user()->avatar) style="display: none;" @endif>
                                                        <img id="avatar-image" src="{{ Auth::user()->avatar ? asset('storage/' . Auth::user()->avatar) : '' }}"
                                                             class="img-thumbnail"
                                                             alt="Avatar"
                                                             style="max-width: 150px; max-height: 150px;">

                                                        <div class="ms-3">
                                                            <button type="button" class="btn btn-sm btn-primary mb-2" onclick="showAvatarEdit()">
                                                                edit
                                                            </button>
                                                        </div>
                                                </div>

                                                <div id="avatar-edit" class="" @if(Auth::user()->avatar) style="display: none;" @endif>
                                                    <!-- Добавьте этот label для кастомной кнопки -->
                                                    <label for="avatar-input" class="custom-file-upload">
                                                        Choose File
                                                    </label>
                                                    <input type="file" name="avatar" id="avatar-input" class="form-control">
                                                    <div id="avatar-error" class="invalid-feedback" style="display: none;"></div>
                                                    <small class="form-text text-muted">Maximum size: 1MB. Formats: JPG, PNG, GIF.</small>
                                                    <div class="mt-2">
                                                        @if(Auth::user()->avatar)
                                                            <button type="button" class="btn btn-sm btn-secondary" onclick="hideAvatarEdit()">
                                                                Cancel
                                                            </button>
                                                        @endif
                                                        <button type="button" class="btn btn-sm btn-success" id="save-avatar-btn">
                                                            Save
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Полное имя -->
                                        <div class="row mb-4">
                                            <div class="col-md-12">
                                                <h5>Full name</h5>
                                                <div id="name-display" @if(!Auth::user()->name) style="display: none;" @endif>
                                                    <div id="name-value" class="fw-bold">{{ Auth::user()->name }}</div>
                                                        <button type="button" class="btn btn-sm btn-primary ms-3" onclick="showNameEdit()">
                                                            edit
                                                        </button>
                                                </div>
                                                <div id="name-edit" @if(Auth::user()->name) style="display: none;" @endif>
                                                    <input type="text"
                                                           name="name"
                                                           id="name-input"
                                                           class="form-control"
                                                           value="{{ Auth::user()->name }}"
                                                           required>
                                                    <div id="name-error" class="invalid-feedback" style="display: none;"></div>

                                                    <div class="mt-2">
                                                        @if(Auth::user()->name)
                                                            <button type="button" class="btn btn-sm btn-secondary" onclick="hideNameEdit()">
                                                                Cancel
                                                            </button>
                                                        @endif

                                                        <button type="button" class="btn btn-sm btn-success" id="save-name-btn">
                                                            Save
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Email -->
                                        <div class="row mb-4">
                                            <div class="col-md-12">
                                                <h5>Email</h5>
                                                <div id="email-display" @if(!Auth::user()->email) style="display: none;" @endif>
                                                            <span id="email-value">{{ Auth::user()->email ?: 'Not specified' }}</span>
                                                            <span id="email-verification-badge" class="badge {{ Auth::user()->email_verified_at ? 'bg-success' : 'bg-danger' }} ms-2">
                                                {{ Auth::user()->email_verified_at ? 'Confirmed' : 'Not confirmed' }}</span>
                                                        <button type="button" class="btn btn-sm btn-primary ms-3" onclick="showEmailEdit()">
                                                            edit
                                                        </button>
                                                </div>
                                                <div id="email-edit" @if(Auth::user()->email) style="display: none;" @endif>
                                                    <input type="email"
                                                           name="email"
                                                           id="email-input"
                                                           class="form-control"
                                                           value="{{ Auth::user()->email }}"
                                                           required>
                                                    <div id="email-error" class="invalid-feedback" style="display: none;"></div>

                                                    <small class="form-text text-muted">
                                                        After changing your email, you will need to verify it again.
                                                    </small>

                                                    <div class="mt-2">
                                                        @if(Auth::user()->email)
                                                            <button type="button" class="btn btn-sm btn-secondary" onclick="hideEmailEdit()">
                                                                Cancel
                                                            </button>
                                                        @endif

                                                        <button type="button" class="btn btn-sm btn-success" id="save-email-btn">
                                                            Save
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Подписка на обновления -->
                                        <div class="row mb-3">
                                            <div class="col-md-12">
                                                <h5>Subscription</h5>
                                                <div class="form-check">
                                                    <input class="form-check-input"
                                                           type="checkbox"
                                                           name="newsletter_subscription"
                                                           id="newsletter_subscription"
                                                           value="1"
                                                        {{ Auth::user()->newsletter_subscription ? 'checked' : '' }}>
                                                    <label class="form-check-label" for="newsletter_subscription">
                                                        Subscribe to the newsletter for updates
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>


            </div>
            <!-- Смена пароля -->
            <div class="tabs__panel" id="tab-4">
                <h3>Change password</h3>
                <div class="card mt-4">
                    <div class="card-body pass-chang-body">
                        <div id="password-change-container">
                            <div class="mb-3">
                                <label for="current-password" class="form-label">Current Password</label>
                                <input type="password" class="form-control" id="current-password" required>
                                <div id="current-password-error" class="invalid-feedback" style="display: none;"></div>
                            </div>

                            <div class="mb-3">
                                <label for="new-password" class="form-label">New Password</label>
                                <input type="password" class="form-control" id="new-password" required>
                                <div id="new-password-error" class="invalid-feedback" style="display: none;"></div>
                                <small class="form-text text-muted">
                                    The password must contain at least 8 characters, including uppercase and lowercase letters, numbers and special characters.
                                </small>
                            </div>

                            <div class="mb-3">
                                <label for="new-password-confirmation" class="form-label">Repeat new password
                                </label>
                                <input type="password" class="form-control" id="new-password-confirmation" required>
                                <div id="new-password-confirmation-error" class="invalid-feedback" style="display: none;"></div>
                            </div>

                            <button type="button" class="btn btn-primary" id="change-password-btn">
                                <i class="fas fa-save me-1"></i> Change password
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <div class="tabs__panel" id="tab-5">
                <h3>Поддержка</h3>
                <p>Здесь форма поддержики</p>
            </div>
        </div>
    </div>

@endsection
