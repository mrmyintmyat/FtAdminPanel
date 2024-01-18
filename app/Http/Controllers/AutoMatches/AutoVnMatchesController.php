<?php

namespace App\Http\Controllers\AutoMatches;

use RandomUserAgent;
use Illuminate\Support\Carbon;
use voku\helper\HtmlDomParser;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Http;

class AutoVnMatchesController extends Controller
{
    private $encryptionKey = "ht3tMyatauNg1288";
    private $referer = "https://www.channelemea.com/";

    public function scrapeMatches()
    {
        $user_agent = $this->getRandomUserAgent();
        $url = 'https://vebotv.ca/';
        $response = Http::withHeaders(['referer' => 'https://www.channelemea.com/', 'User-Agent' => $user_agent])->get($url);
        $htmlContent = $response->body();
        return $htmlContent;
    }

    private function getRandomUserAgent()
    {
        // Your logic to get a random user agent, replace this with your implementation
        return 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/58.0.3029.110 Safari/537.3';
    }

    private function scrapeMatchesFromHtml($htmlContent)
    {
        // Use HtmlDomParser to parse HTML content
        $dom = HtmlDomParser::str_get_html($htmlContent);

        $currentDateTime = now();
        $allMatches = [];

        foreach ($dom->find('.match-main-option') as $matchItem) {
            try {
                // Extract competition name
                $competitionName = $matchItem->find('.competition-label-option div[itemprop="name"]', 0)->plaintext;
return $matchItem;
                // Extract match details
                $matchLink = $matchItem->find('a.match-link', 0);
                $matchUrl = $matchLink->find('meta[itemprop="url"]', 0)->content;
                $matchStartDate = $matchLink->find('meta[itemprop="startDate"]', 0)->content;
                $matchStartDateTime = Carbon::parse($matchStartDate);

                $homeTeamScore = $awayTeamScore = '';

                try {
                    $scoreOpt = $matchItem->find('.match-score-option.match-score-live.owards', 0);
                    list($homeTeamScore, $awayTeamScore) = explode(' - ', $scoreOpt->plaintext);
                } catch (\Exception $e) {
                    // Handle score extraction exception
                }

                $matchStatus = $currentDateTime >= $matchStartDateTime || $currentDateTime->addMinutes(10) >= $matchStartDateTime
                    ? 'Live'
                    : 'vs';

                // Extract home and away teams
                $homeTeamName = $matchItem->find('.home-name.match-team div[itemprop="name"]', 0)->plaintext;
                $awayTeamName = $matchItem->find('.away-name.match-team div[itemprop="name"]', 0)->plaintext;
                $homeTeamLogo = $matchLink->find('.home-name img', 0)->src;
                $awayTeamLogo = $matchLink->find('.away-name img', 0)->src;

                $serverList = [];

                if ($matchStatus == 'Live') {
                    $response = Http::withHeaders(['referer' => $this->referer, 'User-Agent' => ''])->get($matchUrl);
                    $htmlContent = $response->body();
                    $linksItem = (new HtmlDomParser())->str_get_html($htmlContent)->find('.author-list a');
                    $serverUrlList = [];

                    foreach ($linksItem as $link) {
                        $link = $link->href;
                        $serverUrl = $this->getM3u8Url($link);

                        if ($serverUrl && $this->checkUrl($serverUrl, $this->referer)) {
                            $serverUrlList[] = $serverUrl;
                        }
                    }

                    foreach ($serverUrlList as $i => $finalServerUrl) {
                        $serverDetails = [
                            'name' => "Server $i",
                            'url' => $finalServerUrl,
                            'header' => ['referer' => $this->referer, 'User-Agent' => ''],
                        ];
                        $serverList[] = $serverDetails;
                    }
                }

                $matchData = [
                    'match_time' => strval($matchStartDateTime->timestamp),
                    'home_team_name' => $homeTeamName,
                    'home_team_logo' => $this->checkLogo($homeTeamLogo),
                    'homeTeamScore' => $homeTeamScore,
                    'away_team_name' => $awayTeamName,
                    'away_team_logo' => $this->checkLogo($awayTeamLogo),
                    'awayTeamScore' => $awayTeamScore,
                    'cover_image' => '',
                    'league_name' => $competitionName,
                    'match_status' => $matchStatus,
                    'servers' => $serverList,
                ];

                if (count($serverList) > 0 || $matchStatus == 'vs') {
                    $allMatches[] = $matchData;
                } else {
                    Log::info('Bad');
                }
            } catch (\Exception $exception) {
                Log::error('Error processing match item: ' . $exception->getMessage());
            }
        }

        // Clear memory after parsing
        $dom->clear();

        return $allMatches;
    }

    private function encryptAES($data)
    {
        try {
            $key = $this->encryptionKey;
            $iv = random_bytes(16);

            $cipher = openssl_encrypt($data, 'aes-256-cbc', $key, 0, $iv);
            $encryptedData = base64_encode($cipher);

            return json_encode([
                'iv' => base64_encode($iv),
                'encrypted_data' => $encryptedData,
            ]);
        } catch (\Exception $e) {
            // Handle encryption error
            return null;
        }
    }

    private function checkLogo($url)
    {
        if ($url != "") {
            $response = Http::get($url);

            if ($response->successful()) {
                return $url;
            } else {
                return 'https://origin-media.wedodemos.com/upload/images/nologo.png';
            }
        } else {
            return '';
        }
    }

    private function getM3u8Url($url)
    {
        $response = Http::withHeaders(['referer' => $this->referer, 'User-Agent' => ''])->get($url);
        $pattern = '/var\s+stream_link\s+=\s+"(https:\/\/[^"]+)"/';
        preg_match($pattern, $response->body(), $matches);

        return $matches[1] ?? '';
    }

    private function checkUrl($url, $referer)
    {
        try {
            $headers = $referer ? ['referer' => $referer, 'User-Agent' => ''] : [];
            $response = Http::withHeaders($headers)->get($url, ['timeout' => 5]);

            if ($response->successful()) {
                return true;
            } else {
                Log::info("Status Code: {$response->status()}");
                return false;
            }
        } catch (\Exception $e) {
            Log::info("An error occurred: {$e->getMessage()}");
            return false;
        }
    }
}
