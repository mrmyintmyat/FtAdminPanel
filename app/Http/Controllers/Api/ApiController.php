<?php

namespace App\Http\Controllers\Api;

use GuzzleHttp\Client;
use App\Models\HighLight;
use App\Models\AppSetting;
use Illuminate\Http\Request;
use App\Models\FootballMatch;
use App\Http\Controllers\Controller;

class ApiController extends Controller
{
    private function encryptAES($data, $encryptionKey) {
        try {
            $key = "ht3tMyatauNg1288";
            $iv = openssl_random_pseudo_bytes(16);
            $dataAsString = json_encode($data);
            // $data = json_decode($data, true);
            $padded_data = openssl_encrypt(
                $dataAsString,
                "aes-128-cbc",
                $key,
                OPENSSL_RAW_DATA,
                $iv
            );

            if ($padded_data === false) {
                throw new Exception('Encryption failed');
            }

            $iv_base64 = base64_encode($iv);
            $encrypted_data_base64 = base64_encode($padded_data);

            return json_encode([
                $iv_base64 => $encrypted_data_base64
            ]);
        } catch (Exception $e) {
            echo $e->getMessage();
            return null;
        }
}

    public function matches(Request $request)
    {
        $count = $request->input('count', 10);
        $matches = FootballMatch::orderBy('match_time')
            ->take($count)
            ->get();
        // return $matches;
        // Iterate through matches and build a custom response
        $customResponse = [];
        foreach ($matches as $match) {
            $servers = json_decode($match->servers, true); // Decode the JSON "servers" attribute
            $serverDetails = [];

            // Iterate through servers and extract relevant details
            foreach ($servers as $server) {
                $serverDetails[] = [
                    'name' => $server['name'],
                    'url' => $server['url'],
                    'referer' => $server['referer'],
                ];
            }

          
            $customMatch = [
                'id' => $match->id,
                'match_time' => $match->match_time,
                'home_team_name' => $match->home_team_name,
                'home_team_logo' => $match->home_team_logo,
                'home_team_score' => $match->home_team_score !== null ? (string)$match->home_team_score : "",
                'away_team_name' => $match->away_team_name,
                'away_team_logo' => $match->away_team_logo,
                'away_team_score' => $match->away_team_score !== null ? (string)$match->away_team_score : "",
                'league_name' => $match->league_name,
                'league_logo' => $match->league_logo,
                'servers' => $serverDetails,
            ];

            // Add the custom match entry to the response array
            $customResponse[] = $customMatch;
        }
        $datas = $this->encryptAES($customResponse, 'GG');
        return $datas;
    }

    public function app_setting()
    {
        $setting = AppSetting::select('serverDetails', 'sponsorGoogle', 'sponsorText', 'sponsorBanner', 'sponsorInter')>
        $datas = $this->encryptAES($setting, 'ht3tMyatauNg1288');
        return $datas;
    }

    public function highlights(Request $request)
    {
        $count = $request->input('count', 10);
        $matches = HighLight::orderBy('match_time')
            ->take($count)
            ->get();
        // Iterate through matches and build a custom response
        $customResponse = [];
        foreach ($matches as $match) {
            $servers = json_decode($match->servers, true); // Decode the JSON "servers" attribute
            $serverDetails = [];

            // Iterate through servers and extract relevant details
            foreach ($servers as $server) {
                $serverDetails[] = [
                    'name' => $server['name'],
                    'url' => $server['url'],
                    'referer' => $server['referer'],
                ];
            }

            // Create a custom match entry without "match_status" but with "servers"
            $customMatch = [
                'id' => $match->id,
                'match_time' => $match->match_time,
                'home_team_name' => $match->home_team_name,
                'home_team_logo' => $match->home_team_logo,
                'home_team_score' => $match->home_team_score !== null ? (string)$match->home_team_score : "",
                'away_team_name' => $match->away_team_name,
                'away_team_logo' => $match->away_team_logo,
                'away_team_score' => $match->away_team_score !== null ? (string)$match->away_team_score : "",
                'league_name' => $match->league_name,
                'league_logo' => $match->league_logo,
                'servers' => $serverDetails,
            ];

            // Add the custom match entry to the response array
            $customResponse[] = $customMatch;
        }

        $datas = $this->encryptAES($customResponse, 'GG');
        return $datas;
    }
}
