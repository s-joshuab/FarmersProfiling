<?php

namespace App\Http\Controllers\Admin;


use Carbon\Carbon;
use App\Models\User;
use App\Models\Barangays;
use App\Models\provinces;
use App\Models\AuditTrail;
use App\Models\ImageUpload;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Models\municipalities;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\DB;
use Spatie\Activitylog\LogOptions;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Storage;
use Spatie\Activitylog\Models\Activity;
use Illuminate\Support\Facades\Validator;
use Spatie\Activitylog\Traits\LogsActivity;
use Symfony\Component\HttpFoundation\StreamedResponse;
use Illuminate\Support\Facades\File;


date_default_timezone_set('Asia/Manila');
class SettingsController extends Controller
{

    use LogsActivity;

    /**
     * Display a listing of the resource.
     */

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly(['name', 'username', 'user_type']);
    }
    /**
     * Display a listing of the resource.
     */

public function audit(Request $request)
{
    $dateFilter = $request->input('date_filter');
    $activitiesQuery = Activity::orderBy('created_at', 'desc');

    // Check if it's the last day of the month
    $now = Carbon::now();
    $isLastDayOfMonth = $now->isLastOfMonth();

    if ($isLastDayOfMonth) {
        // Perform actions to reset or clear the audit trail data
        // For example, you can truncate the table or delete records
        DB::table('activity_log')->truncate(); // This will delete all records in the 'activities' table
    }

    if ($dateFilter !== 'all') {
        if ($dateFilter === 'today') {
            $activitiesQuery->whereDate('created_at', $now->toDateString());
        } elseif ($dateFilter === 'yesterday') {
            $activitiesQuery->whereDate('created_at', $now->subDay()->toDateString());
        } elseif ($dateFilter === 'this_week') {
            $startOfWeek = $now->startOfWeek()->toDateString();
            $endOfWeek = $now->endOfWeek()->toDateString();
            $activitiesQuery->whereBetween('created_at', [$startOfWeek, $endOfWeek]);
        } elseif ($dateFilter === 'this_month') {
            $startOfMonth = $now->startOfMonth()->toDateString();
            $endOfMonth = $now->endOfMonth()->toDateString();
            $activitiesQuery->whereBetween('created_at', [$startOfMonth, $endOfMonth]);
        }
    }

    // Use chunk to process the records in smaller batches
    $activities = [];
    $activitiesQuery->chunk(200, function ($chunk) use (&$activities) {
        foreach ($chunk as $activity) {
            // Process each activity
            // You can move your existing code logic here
            $activities[] = $activity; // Store the processed activity
        }
    });

    return view('admin.settings.audittrail', compact('activities'));
}






    public function profile()
    {
        $user = Auth::user(); // Fetch the authenticated user
        $provinces = provinces::all();
        $municipalities = municipalities::all();
        $barangays = Barangays::all();
        // Fetch additional data as needed
        $someData = User::where('id', $user->id)->get(); // Replace with your actual query

        return view('admin.settings.profile', compact('user', 'provinces', 'municipalities', 'barangays', 'someData'));
    }


    public function updateProfile(Request $request, $id)
    {
        $user = User::findOrFail($id);

        // Validate the form data for updating user details
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'email' => [
                'required',
                'email',
                Rule::unique('users')->ignore($user->id),
            ],
            'phone_number' => 'required|numeric',
            'provinces_id' => 'required',
            'municipalities_id' => 'required',
            'barangays_id' => 'required',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput()->with('error', 'Validation failed.');
        }

        // Update the user's profile information
         $updatedAttributes = [
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'phone_number' => $request->input('phone_number'),
            'barangays_id' => $request->input('barangays_id'), // Add this line
        ];

        // Handle profile image upload if a new image was provided
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageData = base64_encode(file_get_contents($image->getPathname()));

            // Update the user's profile image data in the database
            $user->image = $imageData;
            $user->save();
        }

        activity()
            ->causedBy(auth()->user()) // Assuming you're logged in
            ->performedOn($user) // The user being updated
            ->withProperties(['attributes' => $updatedAttributes]) // Include updated attributes
            ->log('Updated his/her profile');

        // Update the user's attributes
        $user->update($updatedAttributes);

        return redirect('profile')->with('success', 'Profile updated successfully');
    }


    public function updatePassword(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $validator = Validator::make($request->all(), [
            'current_password' => 'required',
            'new_password' => 'required|min:6|confirmed',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput()->with('error', 'Error occurred during password update.');
        }

        // Verify the current password
        if (!Hash::check($request->input('current_password'), $user->password)) {
            return redirect()->back()->withInput()->with('error', 'Current password is incorrect.');
        }

        $updatedAttributes = [
            'password' => bcrypt($request->input('new_password')),
        ];

        activity()
            ->causedBy(auth()->user()) // Assuming you're logged in
            ->performedOn($user) // The user being updated
            ->withProperties(['attributes' => $updatedAttributes]) // Include updated attributes
            ->log('Updated his/her password');

        // Update the user's attributes
        $user->update($updatedAttributes);

        // Redirect to a success page or show a success message
        return redirect('profile')->with('success', 'Password updated successfully.');
    }







   public function backup()
    {
        return view('admin.settings.sysbackup');
    }


public function performManualBackup(Request $request)
{
    $databaseName = config('database.connections.mysql.database');
    $fileName = 'backupdata_' . date('Y_m_d_His') . '.sql';

    return new StreamedResponse(function () use ($databaseName) {
        $tables = DB::select('SHOW TABLES');
        $dbKey = 'Tables_in_' . $databaseName;

        foreach ($tables as $tableObj) {
            $table = $tableObj->$dbKey;

            // Get table create statement
            $createStmt = DB::select("SHOW CREATE TABLE `$table`")[0]->{'Create Table'};
            echo "-- Table structure for `$table`\n\n$createStmt;\n\n";

            // Dump table data
            $rows = DB::table($table)->get();

            if (!$rows->isEmpty()) {
                echo "-- Dumping data for `$table`\n\n";
                foreach ($rows as $row) {
                    $values = array_map(function ($value) {
                        return is_null($value) ? 'NULL' : DB::getPdo()->quote($value);
                    }, (array)$row);

                    $columns = implode('`, `', array_keys((array)$row));
                    $valuesStr = implode(', ', $values);

                    echo "INSERT INTO `$table` (`$columns`) VALUES ($valuesStr);\n";
                }
                echo "\n\n";
            }
        }
    }, 200, [
        "Content-Type" => "application/sql",
        "Content-Disposition" => "attachment; filename=\"$fileName\"",
    ]);
}


public function restoreBackup(Request $request)
{
    $request->validate([
        'sql_file' => 'required|file|mimes:sql',
    ]);

    try {
        $file = $request->file('sql_file');
        $sqlPath = $file->getRealPath();
        $sqlContent = File::get($sqlPath);

        Log::info('SQL file path: ' . $sqlPath);
        Log::info('SQL file preview: ' . substr($sqlContent, 0, 500));

        // Remove comments and empty lines
        $lines = explode("\n", $sqlContent);
        $statements = [];
        $statement = '';

        foreach ($lines as $line) {
            $line = trim($line);

            // Skip comments and empty lines
            if ($line == '' || strpos($line, '--') === 0 || strpos($line, '/*') === 0) {
                continue;
            }

            $statement .= ' ' . $line;

            // End of statement
            if (substr(trim($line), -1) == ';') {
                $statements[] = $statement;
                $statement = '';
            }
        }

        // Begin restore process
        DB::beginTransaction();
        DB::unprepared('SET FOREIGN_KEY_CHECKS=0;');

        foreach ($statements as $sql) {
            try {
                DB::unprepared($sql);
            } catch (\Exception $e) {
                Log::error("Error executing statement: $sql\nError: " . $e->getMessage());
                throw $e;
            }
        }

        DB::unprepared('SET FOREIGN_KEY_CHECKS=1;');
        DB::commit();

        return redirect()->back()->with('success', 'Database restored successfully!');
    } catch (\Exception $e) {
        DB::rollBack();
        Log::error('Restore failed: ' . $e->getMessage());

        return redirect()->back()->with('error', 'Restore failed: ' . $e->getMessage());
    }
}





    // public function performDatabaseUpload(Request $request)
    // {
    //     $request->validate([
    //         'database_file' => 'required|mimes:sql|max:10240',
    //         'new_database_name' => 'required|string|max:255',
    //     ]);

    //     $databaseFile = $request->file('database_file');
    //     $newDatabaseName = $request->input('new_database_name');

    //     // Move the uploaded SQL file to storage
    //     $uploadPath = storage_path('app/uploads/');
    //     $uploadedFileName = 'uploaded_database_' . date('Y_m_d_His') . '.sql';
    //     $databaseFile->move($uploadPath, $uploadedFileName);

    //     try {
    //         // Create a new database and import the SQL file
    //         $this->createAndImportDatabase($newDatabaseName, $uploadPath . $uploadedFileName);

    //         // Clean up: delete the uploaded SQL file
    //         Storage::delete('uploads/' . $uploadedFileName);

    //         Log::info("Database upload and creation completed successfully for database: $newDatabaseName");

    //         return redirect()->back()->with('success', "Database upload and creation completed successfully for database: $newDatabaseName");
    //     } catch (\Exception $e) {
    //         Log::error("Database upload and creation failed for database: $newDatabaseName. Error: " . $e->getMessage());
    //         return redirect()->back()->with('error', "Database upload and creation failed for database: $newDatabaseName");
    //     }
    // }

    // protected function createAndImportDatabase($databaseName, $filePath)
    // {
    //     // Create a new database
    //     $this->createNewDatabase($databaseName);

    //     // Import the SQL file into the new database
    //     $this->importSqlFile($databaseName, $filePath);
    // }

    // protected function createNewDatabase($databaseName)
    // {
    //     $dbConnection = config('database.connections.mysql');

    //     try {
    //         $pdo = new \PDO("mysql:host={$dbConnection['host']};port={$dbConnection['port']}", $dbConnection['username'], $dbConnection['password']);
    //         $pdo->exec("CREATE DATABASE IF NOT EXISTS $databaseName");
    //         $pdo = null;
    //         Log::info("Database $databaseName created successfully");
    //     } catch (\PDOException $e) {
    //         Log::error("Error creating database $databaseName: " . $e->getMessage());
    //         throw $e; // Rethrow the exception to indicate a failure
    //     }
    // }

    // protected function importSqlFile($databaseName, $filePath)
    // {
    //     $dbConnection = config('database.connections.mysql');
    //     $password = $dbConnection['password'] ? "-p{$dbConnection['password']}" : "";
    //     $command = "mysql --host={$dbConnection['host']} --port={$dbConnection['port']} --user={$dbConnection['username']} $password $databaseName < $filePath";
    //     shell_exec($command);
    //     Log::info("SQL file imported into database: $databaseName");
    // }



}
