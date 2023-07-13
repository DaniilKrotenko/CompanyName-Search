<?php

namespace App\Http\Controllers;

use App\Models\Company;
use Illuminate\Http\Request;

class CompanyController extends Controller
{
    public function index(Request $request)
    {
        $perPage = $request->input('per_page', 3);
        $page = $request->input('page');

        $query = Company::query();

        if ($page) {
            $companies = $query->with('positions.user')
                ->paginate($perPage, ['*'], 'page', $page);
        } else {
            $companies = $query->with('positions.user')->get();
        }

        $responseData = [
            'data' => [],
        ];

        foreach ($companies as $company) {
            $companyData = [
                'id' => $company->id,
                'name' => $company->name,
                'address' => $company->address,
                'users' => [],
            ];

            foreach ($company->positions as $position) {
                $user = $position->user;
                $userData = [
                    'id' => $user->id,
                    'name_last' => $user->last_name,
                    'name_first' => $user->first_name,
                    'email' => $user->email,
                    'position' => $position->position,
                ];
                $companyData['users'][] = $userData;
            }

            $responseData['data'][] = $companyData;
        }

        return response()->json($responseData);
    }

    public function search(Request $request)
    {
        $query = $request->input('query');

        $companies = Company::with(['positions.user'])
            ->where('name', 'LIKE', "%{$query}%")
            ->orWhere('address', 'LIKE', "%{$query}%")
            ->get();

        $responseData = [
            'data' => [],
        ];

        foreach ($companies as $company) {
            $companyData = [
                'id' => $company->id,
                'name' => $company->name,
                'address' => $company->address,
                'users' => [],
            ];

            foreach ($company->positions as $position) {
                $user = $position->user;
                $userData = [
                    'id' => $user->id,
                    'name_last' => $user->last_name,
                    'name_first' => $user->first_name,
                    'email' => $user->email,
                    'position' => $position->position,
                ];
                $companyData['users'][] = $userData;
            }

            $responseData['data'][] = $companyData;
        }

        return response()->json($responseData);
    }
}
