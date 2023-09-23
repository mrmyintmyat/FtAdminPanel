<?php

namespace App\Http\Controllers;

use App\Models\AppSetting;
use Illuminate\Http\Request;

class AppSettingController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        AppSetting::create([
            'serverDetails' => [
                'url' => 'https://raw.githubusercontent.com/devhtetmyat/git_server/main',
                'mainUrl' => 'https://app.fotliv.com',
                'privacyUrl' => 'https://fotliv.com',
            ],
            'sponsorGoogle' => [
                'status' => true,
                'android_banner' => 'ca-app-pub-4917606691315098/2487011314',
                'android_inter' => 'ca-app-pub-4917606691315098/6816288504',
                'android_appopen' => 'ca-app-pub-4917606691315098/6784498912',
                'ios_banner' => 'ca-app-pub-3940256099942544/2934735716',
                'ios_inter' => 'ca-app-pub-3940256099942544/4411468910',
                'ios_appopen' => 'ca-app-pub-3940256099942544/5662855259',
            ],
            'sponsorText' => [
                'status' => true,
                'text' => 'If you are facing with streaming Error, you can switch servers or contact to Admin > info.fotliv@gmail.com',
            ],
            'sponsorBanner' => [
                'status' => true,
                'adImage' => 'https://blogger.googleusercontent.com/img/a/AVvXsEhvN2qDLcM7V0_rQSIP1R5JOaAeQ3u4hIkSMpZItQJHK0W-mqssvhOIlmW2j4BI5r3lBanvOqiBjfe4OxAtVr_jQ2DHL4q3pt-ZZxLdNXRuXiTs40rcIFJx-1P296Jpr9kQNsUSNpTCaxNx8tW4wXtIBlJ-HUEk9UhCGD8WzdEsohHuIsLNxiDokbMAcLAu',
                'adUrl' => 'https://t.me/fotliv',
            ],
            'sponsorInter' => [
                'status' => True,
                'adImage' => 'https://blogger.googleusercontent.com/img/a/AVvXsEiKPpMPU46wIezJsp7CRyFuUe5Z1EHrS7B4nz7SWjvWMemSCAQ2OzuDns5JIxzDJ2nhecanpKj_NqR4U8iUNHhYY0EM3q8SBud6-S6ZeFox_o8AgK4819pYjME2g-w1RPUvKSAX2zPpWAN7Uwe0Qh5Hl92D7r4eQ9MbVg2bdS2P_6SgsVdxr7NLy-C_84B_',
                'adUrl' => 'https://fotliv.com'
            ],
        ]);

        $datas = AppSetting::find(3);
        $id = $datas->id;
        $serverDetails = $datas->serverDetails;
        $sponsorGoogle = $datas->sponsorGoogle;
        $sponsorText = $datas->sponsorText;
        $sponsorBanner = $datas->sponsorBanner;
        $sponsorInter = $datas->sponsorInter;

        return view('app-setting', compact('id', 'serverDetails', 'sponsorGoogle', 'sponsorText', 'sponsorBanner', 'sponsorInter'));
    }

    public function update(Request $request, $id)
    {
        $sponsorGoogle_status = $request->sponsorGoogle_status;
        $sponsorText_status = $request->sponsorText_status;
        $sponsorBanner_status = $request->sponsorBanner_status;
        $sponsorInter_status = $request->sponsorInter_status;

        $datas = AppSetting::find($id);

        $datas->serverDetails = [
            'url' => $request->url,
            'mainUrl' => $request->mainUrl,
            'privacyUrl' => $request->privacyUrl,
        ];

        $datas->sponsorGoogle = [
            'status' => $this->status_check($sponsorGoogle_status),
            'android_banner' => $request->android_banner,
            'android_inter' => $request->android_inter,
            'android_appopen' => $request->android_appopen,
            'ios_banner' => $request->ios_banner,
            'ios_inter' => $request->ios_inter,
            'ios_appopen' => $request->ios_appopen,
        ];

        $datas->sponsorText = [
            'status' => $this->status_check($sponsorText_status),
            'text' => $request -> text,
        ];

        $datas->sponsorBanner = [
            'status' => $this->status_check($sponsorBanner_status),
            'adImage' => $request->banner_adImage,
            'adUrl' => $request->banner_adUrl,
        ];

        $datas->sponsorInter = [
            'status' => $this->status_check($sponsorInter_status),
            'adImage' => $request->inter_adImage,
            'adUrl' => $request->inter_adUrl,
        ];

        $datas->save();

        return redirect()->back()->with('success', 'Update Success');
    }

    private function status_check($data){
        if ($data === 'on') {
            return true;
        } else{
            return false;
        }
    }
}
