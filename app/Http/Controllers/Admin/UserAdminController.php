<?php

namespace App\Http\Controllers\Admin;

use App\DataTables\Admin\UserAdminDataTable;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use RealRashid\SweetAlert\Facades\Alert;

class UserAdminController extends Controller
{
    protected string $view = 'apps.admin.registered-user.customers.';

    /**
     * Display a listing of the resource.
     */
    public function index(UserAdminDataTable $dataTable)
    {
        $title = 'Delete User!';
        $text = "Are you sure you want to delete?";
        confirmDelete($title, $text);
        return $dataTable->render($this->view . 'index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        Alert::success('Successfully Create!', 'User has been created!');
        return redirect()->back();
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $user = $this->findOrFailUser($id);
        return response()->view($this->view . 'show', ['user' => $user]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        return response()->view($this->view . 'form', [
            'user' => $this->findOrFailUser($id),
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $this->updateOrCreateUser($request, $id);
        Alert::success('Successfully Update!', 'User has been updated!');
        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $user = $this->findOrFailUser($id);
        $user->delete();
        Alert::success('Successfully Deleted!', 'User has been deleted!');
        return redirect()->back();
    }

    /**
     * Fetch User by ID or fail.
     */
    private function findOrFailUser(string $id): User
    {
        return User::findOrFail($id);
    }

    /**
     * Save or update a User.
     */
    private function updateOrCreateUser(Request $request, string $id = null): User
    {
        DB::beginTransaction();
        try {
            $data = $request->only([
                'name',
                'email',
                'phone',
                'date_of_birth',
                'gender',
                'nationality',
                'identification_number',
                'upload_documents',
                'submission'
            ]);

            $user = User::updateOrCreate(
                ['id' => $id],
                array_merge($data, [
                    'status_submission' => $data['submission'],
                ])
            );

            DB::commit();
            return $user;
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }
}
