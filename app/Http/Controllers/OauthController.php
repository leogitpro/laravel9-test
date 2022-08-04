<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class OAuthController extends Controller
{
    public function github(Request $request)
    {
        if(!Config::get('oauth.github.client_id') || !Config::get('oauth.github.client_secret') || !Config::get('oauth.github.url_authorize') || !Config::get('oauth.github.url_accesstoken') || !Config::get('oauth.github.url_userprofile')) {
            abort(429, 'Config github oauth first!');
        }

        // 注意修改 .env 的 APP_URL 配置与 GitHub 中的配置一样.
        $callback = url()->route('oauth.oauth', ['from' => 'github']);
        $goUrl = Config::get('oauth.github.url_authorize') . '?' . implode('&', [
            'client_id=' . Config::get('oauth.github.client_id'),
            'redirect_uri=' . urlencode($callback),
            'state=' . Str::random(),
            'allow_signup=false',
        ]);
        // return $goUrl;
        Log::info(sprintf('Github oauth callback: %s', $goUrl));
        return redirect($goUrl);
    }


    public function ukr(Request $request)
    {
        if(!Config::get('oauth.ukr.client_id') || !Config::get('oauth.ukr.client_secret') || !Config::get('oauth.ukr.url_authorize') || !Config::get('oauth.ukr.url_accesstoken') || !Config::get('oauth.ukr.url_userprofile')) {
            abort(429, 'Config ukr oauth first!');
        }

        // 注意修改 .env 的 APP_URL 配置与 GitHub 中的配置一样.
        // $callback = url()->route('oauth.oauth', ['from' => 'ukr']);
        $callback = url()->route('oauth.oauth');
        $goUrl = Config::get('oauth.ukr.url_authorize') . '?' . implode('&', [
            'client_id=' . Config::get('oauth.ukr.client_id'),
            'redirect_uri=' . urlencode($callback),
            'state=' . Str::random(),
        ]);
        // return $goUrl;
        Log::info(sprintf('Ukr oauth callback: %s', $goUrl));
        return redirect($goUrl);
    }

    public function oauth(Request $request)
    {
        Log::debug('OAuthed params:' . print_r($request->all(), true));
        $from = $request->input('from');
        if ('github' == $from) {
            $code = $request->input('code');
            if (!$code) {
                abort(402, 'Invalid Code');
            } else {
                $response = Http::accept('application/json')->post(Config::get('oauth.github.url_accesstoken'), [
                    'client_id' => Config::get('oauth.github.client_id'),
                    'client_secret' => Config::get('oauth.github.client_secret'),
                    'code' => $code,
                ])->throw();
                if (!$response->successful()) {
                    abort(404, 'Token access failure');
                } else {
                    $data = $response->json();
                    Log::debug('GitHub Oauthed:' . print_r($data, true));
                    $token = data_get($data,'access_token');
                    $tokenType = data_get($data,'token_type');
                    if ('bearer' == $tokenType && $token) {
                        $response = Http::accept('application/json')->withToken($token)->get(Config::get('oauth.github.url_userprofile'))->throw();
                        if (!$response->successful()) {
                            abort(404, 'User information fetch failed');
                        } else {
                            Log::debug('GitHub User:' . print_r($response->json(), true));
                            return response()->json($response->json())->setEncodingOptions(JSON_UNESCAPED_UNICODE);
                            // return $this->outputJson($response->json());
                        }
                    } else {
                        abort(404, 'Invalid access token');
                    }
                }
            }
        }
        else {
        // if ('ukr' == $from) {
            $code = $request->input('code');
            if (!$code) {
                abort(402, 'Invalid Code');
            } else {
                $response = Http::accept('application/json')->post(Config::get('oauth.ukr.url_accesstoken'), [
                    'client_id' => Config::get('oauth.ukr.client_id'),
                    'client_secret' => Config::get('oauth.ukr.client_secret'),
                    'grant_type' => 'authorization_code',
                    'code' => $code,
                ])->throw();
                if (!$response->successful()) {
                    abort(404, 'Token access failure');
                } else {
                    $data = $response->json();
                    Log::debug('Ukr Oauthed:' . print_r($data, true));
                    $token = data_get($data,'access_token');
                    $tokenType = data_get($data,'token_type');
                    if ('bearer' == $tokenType && $token) {
                        $response = Http::accept('application/json')->withToken($token)->get(Config::get('oauth.ukr.url_userprofile'))->throw();
                        if (!$response->successful()) {
                            abort(404, 'User information fetch failed');
                        } else {
                            Log::debug('Ukr User:' . print_r($response->json(), true));
                            return response()->json($response->json())->setEncodingOptions(JSON_UNESCAPED_UNICODE);
                            // return $this->outputJson($response->json());
                        }
                    } else {
                        abort(404, 'Invalid access token');
                    }
                }
            }
        }

        return '';
    }
}
