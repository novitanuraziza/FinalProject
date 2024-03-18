@extends('layouts.backend.app', ['title' => 'Profile'])

@section('content')
    <div class="row">
        <div class="col-12 col-lg-3">
            <div class="card card-primary card-outline">
                <div class="card-body box-profile">
                    <div class="text-center">
                        <img class="profile-user-img img-fluid img-circle border-0" src="{{ $user->avatar }}"
                            alt="User profile picture">
                    </div>
                    <h3 class="profile-username text-center">{{ $user->name }}</h3>
                    <p class="text-muted text-center">{{ $user->about }}</p>
                    <ul class="list-group list-group-unbordered">
                        <li class="list-group-item">
                            <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-brand-instagram"
                                width="24" height="24" viewBox="0 0 24 24" stroke-width="1.25" stroke="currentColor"
                                fill="none" stroke-linecap="round" stroke-linejoin="round">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                <rect x="4" y="4" width="16" height="16" rx="4"></rect>
                                <circle cx="12" cy="12" r="3"></circle>
                                <line x1="16.5" y1="7.5" x2="16.5" y2="7.501"></line>
                            </svg>
                            {{ $user->instagram }}
                        </li>
                        <li class="list-group-item">
                            <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-brand-github"
                                width="24" height="24" viewBox="0 0 24 24" stroke-width="1.25" stroke="currentColor"
                                fill="none" stroke-linecap="round" stroke-linejoin="round">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                <path
                                    d="M9 19c-4.3 1.4 -4.3 -2.5 -6 -3m12 5v-3.5c0 -1 .1 -1.4 -.5 -2c2.8 -.3 5.5 -1.4 5.5 -6a4.6 4.6 0 0 0 -1.3 -3.2a4.2 4.2 0 0 0 -.1 -3.2s-1.1 -.3 -3.5 1.3a12.3 12.3 0 0 0 -6.2 0c-2.4 -1.6 -3.5 -1.3 -3.5 -1.3a4.2 4.2 0 0 0 -.1 3.2a4.6 4.6 0 0 0 -1.3 3.2c0 4.6 2.7 5.7 5.5 6c-.6 .6 -.6 1.2 -.5 2v3.5">
                                </path>
                            </svg>
                            {{ $user->github }}
                        </li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="col-12 col-lg-9">
            <div class="card">
                <div class="card-header p-2">
                    <ul class="nav nav-pills">
                        <li class="nav-item"><a class="nav-link active" href="#profile" data-toggle="tab">Profile</a></li>
                        <li class="nav-item"><a class="nav-link" href="#password" data-toggle="tab">Password</a></li>
                    </ul>
                </div>
                <div class="card-body">
                    <div class="tab-content">
                        <div class="tab-pane active" id="profile">
                            <form class="form-horizontal" action="{{ route('member.profile.update', $user->id) }}"
                                method="POST" enctype="multipart/form-data">
                                @csrf
                                @method('PUT')
                                <x-upload-file title="Avatar" name="avatar" :value="$user->avatar" />
                                <x-input title="Full Name" type="text" name="name" :value="$user->name" placeholder="" />
                                <x-input title="Username" type="text" name="username" :value="$user->username" placeholder="" />
                                <div class="form-group">
                                    <label>Email</label>
                                    <input type="email" name="email" class="form-control" value="{{ $user->email }}"
                                        disabled>
                                </div>
                                <x-input title="Github" type="text" name="github" :value="$user->github"
                                    placeholder="your github" />
                                <x-input title="Instagram" type="text" name="instagram" :value="$user->instagram"
                                    placeholder="your instagram" />
                                <x-textarea title="About Me" name="about" placeholder="Cuma Hooman yang suka Laravel"
                                    value="">
                                    {{ $user->about }}</x-textarea>
                                <div class="form-group">
                                    <button type="submit" class="btn btn-success">
                                        <i class="fas fa-check mr-1"></i> Update Profile
                                    </button>
                                </div>
                            </form>
                        </div>
                        <div class="tab-pane" id="password">
                            <form class="form-horizontal" action="{{ route('member.profile.password', $user->id) }}"
                                method="POST">
                                @csrf
                                @method('PUT')
                                <x-input title="Current Password" type="password" name="current_password" value=""
                                    placeholder="" />
                                <x-input title="New Password" type="password" name="password" value=""
                                    placeholder="" />
                                <x-input title="Password Confirmation" type="password" name="password_confirmation"
                                    value="" placeholder="" />
                                <div class="form-group row">
                                    <button type="submit" class="btn btn-success">
                                        <i class="fas fa-check mr-1"></i> Update Password
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
