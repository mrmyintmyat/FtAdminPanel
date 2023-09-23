@php
    use Carbon\Carbon;
@endphp
@extends('layouts.home')
@section('style')
    <style>
        .hover_menu_tag a:nth-child(5) {
            border-left: 3px solid #ff0505 !important;
            background: rgba(255, 255, 255, 0.251);
        }

        #SvgjsG1016 * {
            height: 100px;
        }
    </style>
@endsection
@section('page')
    @if (!session('error'))
        <div class="card text-start mt-lg-2 rounded-0 px-lg-0 px-2 mb-3">
            <div class="card-body pe-0">
                <div class="d-flex mt-3 w-100">
                    <form action="/app_setting/{{$id}}" class="w-100 row d-flex justify-content-around px-2 g-3" method="post">
                        @csrf @method('PUT')

                        <div class="col-lg-5 shadow-sm p-3">
                            <div>
                                <h4>serverDetails</h4>
                            </div>
                            <div class="row mb-3">
                                <label for="url" class="form-label ">
                                    URL
                                </label>

                                <div class="">
                                    <input id="url" type="text" class="form-control  rounded-0" name="url"
                                        value="{{ $serverDetails['url'] }}" required="" autocomplete="url"
                                        autofocus="">

                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="mainUrl" class="form-label  d-flex align-items-center">
                                    MAIN URL
                                </label>
                                <div>
                                    <input id="mainUrl" type="text" class="form-control  rounded-0" name="mainUrl"
                                        value="{{ $serverDetails['mainUrl'] }}" autocomplete="mainUrl">
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="privacyUrl" class="form-label ">PRIVACY URL</label>

                                <div class="">
                                    <input id="privacyUrl" type="text" class="form-control  rounded-0" name="privacyUrl"
                                        value="{{ $serverDetails['privacyUrl'] }}" autocomplete="privacyUrl">

                                </div>
                            </div>
                        </div>

                        <div class="col-lg-5 shadow-sm p-3">
                            <div>
                                <h4 class="d-flex">sponsorGoogle
                                    <div class="form-check form-switch ms-3">
                                        <input class="form-check-input" name="sponsorGoogle_status" type="checkbox" role="switch" id="flexSwitchCheckChecked" {{ ($sponsorGoogle['status']) ? 'checked' : '' ; }}>
                                      </div>
                                </h4>
                            </div>
                            <div class="nav nav-tabs" id="nav-tab" role="tablist">
                                <button class="nav-link active" id="nav-android-tab" data-bs-toggle="tab"
                                    data-bs-target="#nav-android" type="button" role="tab" aria-controls="nav-android"
                                    aria-selected="true">Android</button>
                                <button class="nav-link" id="nav-Ios-tab" data-bs-toggle="tab" data-bs-target="#nav-Ios"
                                    type="button" role="tab" aria-controls="nav-Ios" aria-selected="false">Ios</button>
                            </div>
                            <div class="tab-content" id="nav-tabContent">
                                <div class="tab-pane fade show active" id="nav-android" role="tabpanel"
                                    aria-labelledby="nav-android-tab" tabindex="0">
                                    <div class="row mb-3">
                                        <label for="android_banner" class="form-label ">
                                            Android_banner
                                        </label>

                                        <div class="">
                                            <input id="android_banner" type="text" class="form-control  rounded-0"
                                                name="android_banner" value="{{ $sponsorGoogle['android_banner'] }}"
                                                required="" autocomplete="android_banner" autofocus="">

                                        </div>
                                    </div>

                                    <div class="row mb-3">
                                        <label for="android_inter" class="form-label ">
                                            Android_inter
                                        </label>

                                        <div class="">
                                            <input id="android_inter" type="text" class="form-control  rounded-0"
                                                name="android_inter" value="{{ $sponsorGoogle['android_inter'] }}"
                                                required="" autocomplete="android_inter" autofocus="">

                                        </div>
                                    </div>

                                    <div class="row mb-3">
                                        <label for="android_appopen" class="form-label ">
                                            Android_appopen
                                        </label>

                                        <div class="">
                                            <input id="android_appopen" type="text" class="form-control  rounded-0"
                                                name="android_appopen" value="{{ $sponsorGoogle['android_appopen'] }}"
                                                required="" autocomplete="android_appopen" autofocus="">

                                        </div>
                                    </div>
                                </div>
                                <div class="tab-pane fade" id="nav-Ios" role="tabpanel" aria-labelledby="nav-Ios-tab"
                                    tabindex="0">
                                    <div class="row mb-3">
                                        <label for="ios_banner" class="form-label ">
                                            Ios_banner
                                        </label>

                                        <div class="">
                                            <input id="ios_banner" type="text" class="form-control  rounded-0"
                                                name="ios_banner" value="{{ $sponsorGoogle['ios_banner'] }}"
                                                required="" autocomplete="ios_banner" autofocus="">

                                        </div>
                                    </div>

                                    <div class="row mb-3">
                                        <label for="ios_inter" class="form-label ">
                                            Ios_inter
                                        </label>

                                        <div class="">
                                            <input id="ios_inter" type="text" class="form-control  rounded-0"
                                                name="ios_inter" value="{{ $sponsorGoogle['ios_inter'] }}" required=""
                                                autocomplete="ios_inter" autofocus="">

                                        </div>
                                    </div>

                                    <div class="row mb-3">
                                        <label for="ios_appopen" class="form-label ">
                                            Ios_appopen
                                        </label>

                                        <div class="">
                                            <input id="ios_appopen" type="text" class="form-control  rounded-0"
                                                name="ios_appopen" value="{{ $sponsorGoogle['ios_appopen'] }}"
                                                required="" autocomplete="ios_appopen" autofocus="">

                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-lg-5 shadow-sm p-3">
                            <div>
                                <h4 class="d-flex">sponsorText
                                    <div class="form-check form-switch ms-3">
                                        <input class="form-check-input" name="sponsorText_status" type="checkbox" role="switch" id="flexSwitchCheckChecked" {{ ($sponsorText['status']) ? 'checked' : '' ; }}>
                                    </div>
                                </h4>
                            </div>
                            <div class="row mb-3">
                                <label for="text" class="form-label ">
                                    Text
                                </label>

                                <div class="">
                                    <textarea class="form-control rounded-0" id="text" rows="3" name="text" required autocomplete="text"
                                        autofocus="">{{ $sponsorText['text'] }}
                                </textarea>

                                </div>
                            </div>

                        </div>

                        <div class="col-lg-5 shadow-sm p-3">
                            <div>
                                <h4 class="d-flex">sponsorBanner
                                    <div class="form-check form-switch ms-3">
                                        <input class="form-check-input" name="sponsorBanner_status" type="checkbox" role="switch" id="flexSwitchCheckChecked" {{ ($sponsorBanner['status']) ? 'checked' : '' ; }}>
                                    </div>
                                </h4>
                            </div>
                            <div class="row mb-3">
                                <label for="banner_adImage" class="form-label ">
                                    Ad Image
                                </label>

                                <div class="">
                                    <input id="banner_adImage" type="text" class="form-control  rounded-0" name="banner_adImage"
                                        value="{{ $sponsorBanner['adImage'] }}" required="" autocomplete="banner_adImage"
                                        autofocus="">

                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="banner_adUrl" class="form-label  d-flex align-items-center">
                                    Ad URL
                                </label>
                                <div>
                                    <input id="banner_adUrl" type="text" class="form-control  rounded-0" name="banner_adUrl"
                                        value="{{ $sponsorBanner['adUrl'] }}" autocomplete="banner_adUrl">
                                </div>
                            </div>
                        </div>

                        <div class="col-lg-11 shadow-sm p-3">
                            <div>
                                <h4 class="d-flex">sponsorInter
                                    <div class="form-check form-switch ms-3">
                                        <input class="form-check-input" name="sponsorInter_status" type="checkbox" role="switch" id="flexSwitchCheckChecked" {{ ($sponsorInter['status']) ? 'checked' : '' ; }}>
                                    </div>
                                </h4>
                            </div>
                            <div class="row mb-3">
                                <label for="inter_adImage" class="form-label ">
                                    Ad Image
                                </label>

                                <div class="">
                                    <input id="inter_adImage" type="text" class="form-control  rounded-0" name="inter_adImage"
                                        value="{{ $sponsorInter['adImage'] }}" required="" autocomplete="inter_adImage"
                                        autofocus="">

                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="inter_adUrl" class="form-label  d-flex align-items-center">
                                    Ad URL
                                </label>
                                <div>
                                    <input id="inter_adUrl" type="text" class="form-control  rounded-0" name="inter_adUrl"
                                        value="{{ $sponsorInter['adUrl'] }}" autocomplete="inter_adUrl">
                                </div>
                            </div>
                        </div>

                        <div class="row mb-0 col-11 mt-3 p-0">
                            <div class="w-100 p-0">
                                <button type="submit" class="btn py-2 bg-menu w-100 text-white">
                                    UPDATE
                                </button>
                            </div>
                        </div>

                </div>
                </form>

            </div>
        </div>
        </div>
    @else
        <h3 class="mt-3">Match Not found</h3>
    @endif
@endsection