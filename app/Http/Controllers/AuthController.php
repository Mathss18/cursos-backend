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
                'url' => 'https://www.youtube.com/embed/ujnjkz2KXHA',
                'title' => 'A OAB já liberou o marketing digital.',
                'thumbnail' => 'https://i3.ytimg.com/vi/ujnjkz2KXHA/maxresdefault.jpg',
                'description'=> 'Vídeo de curso'
            ],
            [
                'url' => 'https://www.youtube.com/embed/ujnjkz2KXHA',
                'title' => 'Faculdade NENHUMA te mostrou esse caminho!',
                'thumbnail' => 'https://i3.ytimg.com/vi/B7lYuFFtpt0/maxresdefault.jpg',
                'description'=> 'Vídeo de curso'
            ],
            [
                'url' => 'https://www.youtube.com/embed/EIzashjwA3k',
                'title' => 'Você não fica sem dinheiro por sua Holding não ter atividade econômica.',
                'thumbnail' => 'https://i3.ytimg.com/vi/EIzashjwA3k/maxresdefault.jpg',
                'description'=> 'Vídeo de curso'
            ],
            [
                'url' => 'https://www.youtube.com/embed/dau3lHmU5eU',
                'title' => 'Seus clientes precisam conhecer esse número!',
                'thumbnail' => 'https://i3.ytimg.com/vi/dau3lHmU5eU/maxresdefault.jpg',
                'description'=> 'Vídeo de curso'
            ],
        ]), 200);
    }
}
