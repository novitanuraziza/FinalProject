<?php

namespace App\Actions\Fortify;

use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use App\Notifications\NewMember;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Notification;
use Laravel\Fortify\Contracts\CreatesNewUsers;

class CreateNewUser implements CreatesNewUsers
{
    use PasswordValidationRules;

    /**
     * Validate and create a newly registered user.
     *
     * @param  array  $input
     * @return \App\Models\User
     */
    public function create(array $input)
    {
        Validator::make($input, [
            'name' => ['required', 'string', 'max:255'],
            'email' => [
                'required',
                'string',
                'email',
                'max:255',
                Rule::unique(User::class),
            ],
            'password' => $this->passwordRules(),
        ])->validate();

        $role = Role::where('name', 'member')->first();

        $user = User::create([
            'name' => $input['name'],
            'username' => $input['name'] .'-'. Str::random(6),
            'email' => $input['email'],
            'password' => Hash::make($input['password']),
        ]);

        $user->assignRole($role);

        $admin = User::role('admin')->get();

        Notification::send($admin, new NewMember($user));

        return $user;
    }
}
