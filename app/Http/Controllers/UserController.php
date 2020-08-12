<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\User;
use Exception;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    /**
     * @param Request $request
     * @return LengthAwarePaginator
     */
    public function index(Request $request): LengthAwarePaginator
    {
        $query = User::query();

        if ($request->filled('sortBy')) {
            $query->orderBy($request->sortBy[0], $request->sortDesc[0] === 'true' ? 'DESC' : 'ASC');
        }

        return $query->paginate($request->itemsPerPage, '*', 'page', $request->page);
    }

    /**
     * @param User $user
     * @return JsonResponse
     * @throws Exception
     */
    public function destroy(User $user): JsonResponse
    {
        $user->delete();
        return response()->json(['message' => 'User was deleted.']);
    }

    /**
     * @param User $user
     * @param UpdateUserRequest $request
     * @return JsonResponse
     */
    public function update(User $user, UpdateUserRequest $request): JsonResponse
    {
        $user->username = $request->username;
        $user->email = $request->email;
        $user->save();

        return response()->json(['message' => 'User was updated.']);
    }

    /**
     * @param CreateUserRequest $request
     * @return JsonResponse
     */
    public function store(CreateUserRequest $request): JsonResponse
    {
        User::create([
            'username' => $request->username,
            'email' => $request->email,
            'password' => Hash::make($request->password)
        ]);

        return response()->json(['message' => 'User was created.']);
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function updatePassword(Request $request): JsonResponse
    {
        if (!$request->password || strlen($request->password) < 3) {
            abort(422, 'Please enter a valid password.');
        }
        if (!Hash::check($request->oldPassword, Auth::user()->getAuthPassword())) {
            abort(422, 'The old password you entered doesn\'t match your password.');
        }
        $user = Auth::user();
        $user->password = Hash::make($request->password);
        $user->save();

        return response()->json(['message' => 'Your password was changed.']);
    }
}
