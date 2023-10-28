<?php

namespace App\Actions\Fortify;

use App\Models\User;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Laravel\Fortify\Contracts\UpdatesUserProfileInformation;

class UpdateUserProfileInformation implements UpdatesUserProfileInformation
{
    /**
     * Validate and update the given user's profile information.
     *
     * @param  array<string, string>  $input
     */
    public function update(User $user, array $input): void
    {
        Validator::make($input, [
            'name' => ['required', 'string', 'max:255'],

            'email' => [
                'required',
                'string',
                'email',
                'max:255',
                Rule::unique('users')->ignore($user->id),
            ],
            'phone' => ['nullable', 'string', 'max:255'],
            'company' => ['nullable', 'string', 'max:255'],
            'country' => ['nullable', 'string', 'max:255'],
            'address' => ['nullable', 'string', 'max:255'],
            'profile_picture' => ['nullable', 'image'],
        ])->validate();

        $this->uploadProfilePicture($input);

        if (
            $input['email'] !== $user->email &&
            $user instanceof MustVerifyEmail
        ) {
            $this->updateVerifiedUser($user, $input);
        } else {
            $user->forceFill([
                'name' => $input['name'],
                'email' => $input['email'],
                'phone' => $input['phone'],
                'company' => $input['company'],
                'country' => $input['country'],
                'address' => $input['address'],
                'profile_picture' => $input['profile_picture'],
            ])->save();
        }
    }

    protected function uploadProfilePicture(&$input)
    {
        if (request()->hasFile('profile_picture')) {
            $uploadedFile = $input['profile_picture'];

            $fileName = $uploadedFile->storeAs(
                'profile',
                'profile-user-' . request()->user()->id .
                    '.' .
                    $uploadedFile->getClientOriginalExtension()
            );
            $input['profile_picture'] = $fileName;
        }
    }

    /**
     * Update the given verified user's profile information.
     *
     * @param  array<string, string>  $input
     */
    protected function updateVerifiedUser(User $user, array $input): void
    {
        $user->forceFill([
            'name' => $input['name'],
            'email' => $input['email'],
            'phone' => $input['phone'],
            'company' => $input['company'],
            'country' => $input['country'],
            'address' => $input['address'],
            'profile_picture' => $input['profile_picture'],
            'email_verified_at' => null,
        ])->save();

        $user->sendEmailVerificationNotification();
    }
}
