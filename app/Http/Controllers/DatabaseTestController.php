<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Dotenv\Dotenv;
use Illuminate\Support\Str;

class DatabaseTestController extends Controller
{
    public function showTestForm()
    {
        return view('database');
    }

    public function testConnection(Request $request)
    {
        $request->validate([
            'db_name' => 'required|string',
            'db_username' => 'required|string',
            'db_password' => 'required|string',
        ]);

        $dbName = $request->input('db_name');
        $dbUsername = $request->input('db_username');
        $dbPassword = $request->input('db_password');

        config(['database.connections.temp' => [
            'driver' => 'mysql',
            'host' => 'localhost',
            'database' => $dbName,
            'username' => $dbUsername,
            'password' => $dbPassword,
            'charset' => 'utf8mb4',
            'collation' => 'utf8mb4_unicode_ci',
            'prefix' => '',
            'strict' => true,
            'engine' => null,
        ]]);

        try {
            $connection = DB::connection('temp')->getPdo();
            $connected = $connection !== null;
            if ($connected) {
                // Update .env file
                $envFile = base_path('.env');

                // Read current .env file
                $currentEnv = file_get_contents($envFile);

                // Replace database configuration in .env
                $currentEnv = preg_replace('/DB_DATABASE=.*/', "DB_DATABASE={$dbName}", $currentEnv);
                $currentEnv = preg_replace('/DB_USERNAME=.*/', "DB_USERNAME={$dbUsername}", $currentEnv);
                $currentEnv = preg_replace('/DB_PASSWORD=.*/', "DB_PASSWORD={$dbPassword}", $currentEnv);

                // Save updated .env file
                file_put_contents($envFile, $currentEnv);

                $response = '<p style="color: white; margin-left: 15px; ">Connection successful.</p>';
            } else {
                $response = '<p style="color: red;">Connection failed.</p>';
            }
        } catch (\Exception $e) {
            $response = '<p style="color: red;">Connection error: ' . $e->getMessage() . '</p>';
        }

        return view('database', ['response' => $response]);
    }
}
