<?php

namespace Modules\Setting\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Appsetting;
use App\Scopes\Asc;
use App\Traits\PictureResizeTrait;
use App\Traits\PictureTrait;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;
use Modules\Setting\Entities\Application;
use Modules\Setting\Entities\Currency;
use Modules\Setting\Entities\Language;
use Modules\Setting\Http\Requests\ApplicationRequest;

class ApplicationController extends Controller
{

    use PictureTrait, PictureResizeTrait;

    public function __construct()
    {
        $this->middleware('permission:read_application')->only('application');
        $this->middleware('permission:update_application')->only(['edit', 'update']);
        $this->middleware(['demo'])->only(['update']);
    }

    public function application()
    {
        $app        = Application::first();
        $currencies = Currency::withoutGlobalScopes([Asc::class])->whereStatus(1)->get();
        $langs      = Language::withoutGlobalScopes([Asc::class])->get();
        return view('setting::application', [
            'currencies' => $currencies,
            'app'        => $app,
            'langs'      => $langs,
        ]);
    }

    public function update(ApplicationRequest $request, $id)
    {

        $app = Application::findOrFail($id);

        $old                        = $app->logo;
        $old_sidebar_logo           = $app->sidebar_logo;
        $old_sidebar_collapsed_logo = $app->sidebar_collapsed_logo;
        $old_login_image            = $app->old_login_image;
        $oldFavicon                 = $app->favicon;
        $oldFooterLogo              = $app->footer_logo;
        $oldAppLogo                 = $app->app_logo;
        $oldMobileMenuImage         = $app->mobile_menu_image;

        $app->fill($request->except(['logo', 'favicon', 'fixed_date', 'sidebar_logo', 'footer_logo', 'app_logo', 'mobile_menu_image']));

        if ($request->hasFile('logo')) {

            if ($old) {
                $this->deleteFile($old);
            }

            $request_file = $request->file('logo');
            $name         = time() . 'logo.' . $request_file->getClientOriginalExtension();
            $path         = Storage::disk('public')->putFileAs('application', $request_file, $name);
            Image::make($request_file)->save(public_path('storage/' . $path));
            $app->logo = $path;
        }

        if ($request->hasFile('sidebar_logo')) {

            if ($old_sidebar_logo) {
                $this->deleteFile($old_sidebar_logo);
            }

            $request_file = $request->file('sidebar_logo');
            $name         = time() . 'sidebar-logo.' . $request_file->getClientOriginalExtension();
            $path         = Storage::disk('public')->putFileAs('application', $request_file, $name);
            Image::make($request_file)->save(public_path('storage/' . $path));
            $app->sidebar_logo = $path;
        }

        if ($request->hasFile('sidebar_collapsed_logo')) {

            if ($old_sidebar_collapsed_logo) {
                $this->deleteFile($old_sidebar_collapsed_logo);
            }

            $request_file = $request->file('sidebar_collapsed_logo');
            $name         = time() . 'sidebar-collapsed-logo.' . $request_file->getClientOriginalExtension();
            $path         = Storage::disk('public')->putFileAs('application', $request_file, $name);
            Image::make($request_file)->save(public_path('storage/' . $path));
            $app->sidebar_collapsed_logo = $path;
        }

        if ($request->hasFile('login_image')) {

            if ($old_login_image) {
                $this->deleteFile($old_login_image);
            }

            $request_file = $request->file('login_image');
            $name         = time() . 'login-image.' . $request_file->getClientOriginalExtension();
            $path         = Storage::disk('public')->putFileAs('application', $request_file, $name);
            Image::make($request_file)->save(public_path('storage/' . $path));
            $app->login_image = $path;
        }

        if ($request->hasFile('favicon')) {

            if ($oldFavicon) {
                $this->deleteFile($oldFavicon);
            }

            $request_file = $request->file('favicon');
            $name         = time() . 'favicon.' . $request_file->getClientOriginalExtension();
            $path         = Storage::disk('public')->putFileAs('application', $request_file, $name);
            Image::make($request_file)->save(public_path('storage/' . $path));
            $app->favicon = $path;
        }

        if ($request->hasFile('footer_logo')) {

            if ($oldFooterLogo) {
                $this->deleteFile($oldFooterLogo);
            }

            $request_file = $request->file('footer_logo');
            $name         = time() . 'footer_logo.' . $request_file->getClientOriginalExtension();
            $path         = Storage::disk('public')->putFileAs('application', $request_file, $name);
            Image::make($request_file)->save(public_path('storage/' . $path));
            $app->footer_logo = $path;
        }

        if ($request->hasFile('app_logo')) {

            if ($oldAppLogo) {
                $this->deleteFile($oldAppLogo);
            }

            $request_file = $request->file('app_logo');
            $name         = time() . 'app_logo.' . $request_file->getClientOriginalExtension();
            $path         = Storage::disk('public')->putFileAs('application', $request_file, $name);
            Image::make($request_file)->save(public_path('storage/' . $path));
            $app->app_logo = $path;
        }

        if ($request->hasFile('mobile_menu_image')) {

            if ($oldMobileMenuImage) {
                $this->deleteFile($oldMobileMenuImage);
            }

            $request_file = $request->file('mobile_menu_image');
            $name         = time() . 'mobile_menu_image.' . $request_file->getClientOriginalExtension();
            $path         = Storage::disk('public')->putFileAs('application', $request_file, $name);
            Image::make($request_file)->save(public_path('storage/' . $path));
            $app->mobile_menu_image = $path;
        }

        $app->fixed_date = $request->fixed_date;
        $app->update();

        $app_settings      = Appsetting::first();
        $app_settings_data = [
            'website_title'      => $app->title,
            'footer_text'        => $app->footer_text,
            'copy_right'         => $app->copy_right,
            'time_zone'          => $app->time_zone,
            'ltl_rtl'            => $app->rtl_ltr,
            'logo'               => $app->logo,
            'footer_logo'        => $app->footer_logo,
            'favicon'            => $app->favicon,
            'app_logo'           => $app->app_logo,
            'mobile_menu_image'  => $app->mobile_menu_image,
            'newstriker_status'  => $app->newstriker_status,
            'preloader_status'   => $app->preloader_status,
            'speed_optimization' => $app->speed_optimization,
        ];

        if ($app_settings) {
            $app_settings->update($app_settings_data);
        } else {
            Appsetting::create($app_settings_data);
        }

        cache()->forget('appSetting');
        cache()->forever('appSetting', $app);

        return redirect()->back()->with('success', localize('application_updated'));
    }

    public function appSetting()
    {
        $app = Appsetting::first();
        return view('setting::app_setting', compact('app'));
    }

    public function updateAppSetting(Request $request)
    {
        Appsetting::updateOrCreate([
            'id' => 1,
        ], $request->all());

        Toastr::success(localize('app_setting_updated_successfully'));
        return redirect()->route('app.index');
    }

}
