<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Schema; // Import the Schema facade
use Illuminate\Support\Str;
use App\Models\User;
use Illuminate\Support\Facades\File;

class AdminSetupController extends Controller
{
    public function showAdminForm()
    {
        return view('setupadmin');
    }

    public function setupAdmin(Request $request)
    {
        $username = $request->input('username');
        $password = $request->input('password');
        $confirm_password = $request->input('confirm_password');

        $errors = [];

        // Validate username: at least 5 lowercase letters
        if (strlen($username) < 5 || !ctype_lower($username)) {
            $errors[] = '<p style="color: red;">Username must be at least 5 lowercase letters.</p>';
        }

        // Validate password: at least 8 characters and contains at least 1 special character
        if (strlen($password) < 8 || !preg_match('/[!@#$%^&*(),.?":{}|<>]/', $password)) {
            $errors[] = '<p style="color: red;">Password must be at least 8 characters long and contain at least one special character.</p>';
        }

        // Validate confirm password: must match password
        if ($password !== $confirm_password) {
            $errors[] = '<p style="color: red;">Passwords do not match.</p>';
        }

        // If there are errors, return the view with errors
        if (!empty($errors)) {
            return view('setupadmin', ['response' => implode('', $errors)]);
        }

        // If validation passes, hash the password with a random salt
        $salt = Str::random(16);
        $hashedPassword = Hash::make($password . $salt);

        // Perform any additional setup tasks here
        try {
            // Load the existing .env file content
            $envPath = base_path('.env');
            $envContent = File::get($envPath);

            // Update or add the SETUP and PASSWORD_SALT variables
            $envContent = preg_replace('/^SETUP=.*$/m', 'SETUP="TRUE"', $envContent);
            if (!preg_match('/^SETUP=.*$/m', $envContent)) {
                $envContent .= PHP_EOL . 'SETUP="TRUE"';
            }

            $envContent = preg_replace('/^PASSWORD_SALT=.*$/m', 'PASSWORD_SALT=' . $salt, $envContent);
            if (!preg_match('/^PASSWORD_SALT=.*$/m', $envContent)) {
                $envContent .= PHP_EOL . 'PASSWORD_SALT=' . $salt;
            }

            // Save the updated .env file content
            File::put($envPath, $envContent);

            // Check if the users table exists, create it if not
            if (!Schema::hasTable('users')) {
                Schema::create('users', function ($table) {
                    $table->id();
                    $table->string('username')->unique();
                    $table->string('password');
                    $table->timestamps();
                });
            }

            // Create a new user in the database
            $user = new User();
            $user->username = $username;
            $user->password = $hashedPassword;
            $user->save();

            $response = '<p style="color: white; margin-left: 15px;">Admin setup successful.</p>';
        } catch (\Exception $e) {
            $response = '<p style="color: red;">Error setting up admin: ' . $e->getMessage() . '</p>';
        }

        return view('setupadmin', ['response' => $response]);
    }
}
