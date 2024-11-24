<?php

namespace App\Http\Controllers;

use App\Models\Contact;
use App\Models\SpeedTestLog;
use Illuminate\Http\Request;

class ContactController extends Controller
{
    public function index()
    {
        $contacts = Contact::all();
        $logs = SpeedTestLog::latest()->get();

        return view('contacts.index', compact('contacts', 'logs'));
    }

    public function manualInsert(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'phone' => 'required',
            'email' => 'required|email',
        ]);
    
        // Start the timer for measuring execution time
        $start = microtime(true);
    
        // Insert the record into the database
        Contact::create($request->only(['name', 'phone', 'email']));
    
        // End the timer and calculate execution time
        $executionTime = microtime(true) - $start;
    
        // Log the operation in speed_test_logs
        SpeedTestLog::create([
            'operation' => 'Manual Insert',
            'num_records' => 1,
            'execution_time' => $executionTime,
        ]);
    
        // Redirect to the index route and display a success message
        return redirect()->route('contacts.index')->with('success', 'Manually inserted 1 record in ' . number_format($executionTime, 6) . ' seconds.');
    }
    

    public function randomInsert(Request $request)
    {
        $request->validate(['num_records' => 'required|integer|min:1']);
    
        // Start timer for the insert operation
        $startTime = microtime(true);
    
        // Prepare random records
        $data = [];
        for ($i = 0; $i < $request->num_records; $i++) {
            $data[] = [
                'name' => 'Random_' . rand(1000, 9999),
                'phone' => '987654' . rand(1000, 9999),
                'email' => 'random_user_' . rand(1000, 9999) . '@example.com',
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }
    
        // Insert into the database
        Contact::insert($data);
    
        // End timer
        $executionTime = microtime(true) - $startTime;
    
        // Log the operation
        SpeedTestLog::create([
            'operation' => 'Insert',
            'num_records' => $request->num_records,
            'execution_time' => $executionTime,
        ]);
    
        return redirect()->route('contacts.index')->with('success', "{$request->num_records} random records inserted in " . number_format($executionTime, 6) . " seconds.");
    }
    


    public function editMultiple(Request $request)
{
    // Validate the input to ensure a valid number is provided
    $request->validate(['num_records' => 'required|integer|min:1']);

    // Get the number of records to edit
    $numRecords = $request->num_records;

    // Start the timer for editing
    $startTime = microtime(true);

    // Fetch the first N records to edit
    $recordsToEdit = Contact::take($numRecords)->get();

    if ($recordsToEdit->isEmpty()) {
        return redirect()->route('contacts.index')->with('error', "No records available to edit.");
    }

    // Edit each record
    foreach ($recordsToEdit as $record) {
        $record->update([
            'name' => 'Edited_' . rand(1000, 9999),
            'phone' => '987654' . rand(1000, 9999),
            'email' => 'edited_user_' . rand(1000, 9999) . '@example.com',
        ]);
    }

    // End the timer for editing
    $endTime = microtime(true);
    $executionTime = $endTime - $startTime;

    // Log the operation in speed_test_logs
    SpeedTestLog::create([
        'operation' => 'Edit Multiple',
        'num_records' => $numRecords,
        'execution_time' => $executionTime,
    ]);

    // Redirect with success message
    return redirect()->route('contacts.index')->with('success', "Edited $numRecords records in " . number_format($executionTime, 6) . " seconds.");
}


public function deleteMultiple(Request $request)
{
    // Validate the input to ensure a valid number is provided
    $request->validate(['num_records' => 'required|integer|min:1']);

    // Get the number of records to delete
    $numRecords = $request->num_records;

    // Start the timer for deletion
    $startTime = microtime(true);

    // Fetch the first N records to delete
    $recordsToDelete = Contact::take($numRecords)->get();

    if ($recordsToDelete->isEmpty()) {
        return redirect()->route('contacts.index')->with('error', "No records available to delete.");
    }

    // Delete each record
    foreach ($recordsToDelete as $record) {
        $record->delete();
    }

    // End the timer for deletion
    $endTime = microtime(true);
    $executionTime = $endTime - $startTime;

    // Renumber IDs in the database
    $this->renumberIds();

    // Log the operation in speed_test_logs
    SpeedTestLog::create([
        'operation' => 'Delete Multiple',
        'num_records' => $numRecords,
        'execution_time' => $executionTime,
    ]);

    // Redirect with success message
    return redirect()->route('contacts.index')->with('success', "Deleted $numRecords records in " . number_format($executionTime, 6) . " seconds and renumbered IDs.");
}

public function editForm($id)
{
    // Fetch the record by ID
    $contact = Contact::find($id);

    if (!$contact) {
        return redirect()->route('contacts.index')->with('error', 'Record not found.');
    }

    return view('contacts.edit', compact('contact'));
}
public function update(Request $request, $id)
{
    $request->validate([
        'name' => 'required',
        'phone' => 'required',
        'email' => 'required|email',
    ]);

    // Fetch the record
    $contact = Contact::find($id);

    if (!$contact) {
        return redirect()->route('contacts.index')->with('error', 'Record not found.');
    }

    // Start the timer for editing
    $startTime = microtime(true);

    // Update the record
    $contact->update($request->only(['name', 'phone', 'email']));

    // End the timer
    $endTime = microtime(true);
    $executionTime = $endTime - $startTime;

    // Log the operation in speed_test_logs
    SpeedTestLog::create([
        'operation' => 'Manual Edit',
        'num_records' => 1,
        'execution_time' => $executionTime,
    ]);

    return redirect()->route('contacts.index')->with('success', "Record updated in " . number_format($executionTime, 6) . " seconds.");
}
public function delete($id)
{
    // Fetch the record
    $contact = Contact::find($id);

    if (!$contact) {
        return redirect()->route('contacts.index')->with('error', 'Record not found.');
    }

    // Start the timer for deletion
    $startTime = microtime(true);

    // Delete the record
    $contact->delete();

    // End the timer
    $endTime = microtime(true);
    $executionTime = $endTime - $startTime;

    // Renumber IDs after deletion
    $this->renumberIds();

    // Log the operation in speed_test_logs
    SpeedTestLog::create([
        'operation' => 'Manual Delete',
        'num_records' => 1,
        'execution_time' => $executionTime,
    ]);

    return redirect()->route('contacts.index')->with('success', "Record deleted in " . number_format($executionTime, 6) . " seconds and IDs renumbered.");
}


    private function renumberIds()
{
    // Fetch all records sorted by the current ID
    $contacts = Contact::orderBy('id')->get();

    // Reset ID starting from 1
    $newId = 1;

    foreach ($contacts as $contact) {
        // Update the ID with the new sequential value
        $contact->id = $newId;
        $contact->saveQuietly(); // Save without triggering events
        $newId++;
    }

    // Reset the auto-increment value in the database
    $db = \DB::statement("ALTER TABLE contacts AUTO_INCREMENT = $newId");
}

}

