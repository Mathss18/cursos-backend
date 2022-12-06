<?php

namespace App\Http\Controllers;

use App\Enum\StatusEnum;
use App\Enum\User\UserTypeEnum;
use App\Models\User;
use App\Services\ResponseService;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');

        if (!auth()->attempt($credentials)) {
            return response()->json(ResponseService::respond(false, 401, 'Invalid Credentials'), 401);
        }

        $token = auth()->user()->createToken('bearer');

        return response()->json(ResponseService::respond(true, 200, 'Success', $token->plainTextToken), 200);
    }

    public function register(Request $request)
    {
        try {
            $user = new User;
            $user->name = $request->input('name');
            $user->email = $request->input('email');
            $user->password = bcrypt($request->input('password'));
            $user->type = UserTypeEnum::ADMIN;
            $user->status = StatusEnum::ACTIVE;
            $user->save();
        } catch (\Exception $ex) {
            dd($ex);
            return response()->json(ResponseService::respond(false, 401, 'Error creating User'), 401);
        }
        return response()->json(ResponseService::respond(false, 200, 'Success', $user), 200);
    }

    public function logout()
    {
        // auth()->user()->tokens()->delete(); // removes all user tokens
        auth()->user()->currentAccessToken()->delete(); // removes current user tokens

        return response()->json(ResponseService::respond(true, 204, 'Logout Success'), 204);
    }

    public function videos(Request $request)
    {
        return response()->json(ResponseService::respond(true, 200, 'Success', [
            [
                'url' => 'https://www.youtube.com/embed/az6OYFS7AUA',
                'title' => 'Matemática Básica - Aula 1 - Adição',
                'thumbnail' => 'https://i3.ytimg.com/vi/az6OYFS7AUA/maxresdefault.jpg',
                'description'=> 'Vídeo de curso'
            ],
            [
                'url' => 'https://www.youtube.com/embed/oSzh7TjIsjs',
                'title' => 'Matemática Básica - Aula 2 - Subtração',
                'thumbnail' => 'https://i3.ytimg.com/vi/oSzh7TjIsjs/maxresdefault.jpg',
                'description'=> 'Vídeo de curso'
            ],
            [
                'url' => 'https://www.youtube.com/embed/BetgRvNQEC0',
                'title' => 'Matemática Básica - Aula 3 - Multiplicação',
                'thumbnail' => 'https://i3.ytimg.com/vi/BetgRvNQEC0/maxresdefault.jpg',
                'description'=> 'Vídeo de curso'
            ],
            [
                'url' => 'https://www.youtube.com/embed/GpnfZHB3Rpw',
                'title' => 'Matemática Básica - Aula 4 - Divisão',
                'thumbnail' => 'https://i3.ytimg.com/vi/GpnfZHB3Rpw/maxresdefault.jpg',
                'description'=> 'Vídeo de curso'
            ],
        ]), 200);
    }
}
