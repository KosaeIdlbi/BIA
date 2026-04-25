<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Support\Facades\Auth;
use Livewire\Livewire;

class RouteServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot()
    {
        // Limit::perMinute(3);   //ثلالث محاولات في الدقيقة 
        // Limit::perHour(100);   //مئة محاولة في الساعة 


        // by($request->user("guard name")->id); المحاولات تحسب لمعرف المستخدم الموثق

        // by($request->ip()); كل المحاولات من نفس الجهاز/الشبكة تُحسب معًا


        //(by($request->email)) المحاولات تُحسب لكل بريد على حدة
        //إذا أخطأ المستخدم في كتابة البريد، تُحسب على البريد الخاطئ وليس على البريد الصحيح


        //RateLimiter اذا لم يتجاوز الحد لا يتم تنفيذ أي رد خاص من
        // الذي استدعاه Route أو الـ Controller بل الطلب يكمل بشكل طبيعي إلى الـ 


        // Controllerالأفضل أن يبقى التحقق من البريد في الـ ـ 
        // RateLimiter وظيفته الأساسية هي التحكم في عدد الطلبات وليس التحقق من صحة البيانات.

        //middleware("throttle:user-verification-links")
        RateLimiter::for('user-verification-links', function () {
            $id = Auth::id();
            return Limit::perMinutes(30, 1)->by($id)
                ->response(function () use ($id) {
                    return redirect()->route('user.verify.edit')
                        ->with('maxAttempts', $id);
                    // ->with('maxAttempts', 'try agin after 30 minutes');
                });
        });
        RateLimiter::for('user-password-reset-links', function ($request) {
            return Limit::perMinutes(30, 1)->by($request->email)
                ->response(function () use ($request) {
                    return redirect()->route('user.password.create')
                        ->with('maxAttempts', $request->email);
                    // ->with('maxAttempts', 'try agin after 30 minutes');
                });
        });


        RateLimiter::for('admin-verification-links', function () {
            $id = Auth::guard("admin")->id();
            return Limit::perMinutes(30, 1)->by($id)
                ->response(function () use ($id) {
                    return redirect()->route('admin.verify.edit')
                        ->with('maxAttempts', $id);
                    // ->with('maxAttempts', 'try agin after 30 minutes');
                });
        });
        RateLimiter::for('admin-password-reset-links', function ($request) {
            return Limit::perMinutes(30, 1)->by($request->email)
                ->response(function ()  use ($request) {
                    return redirect()->route('admin.password.create')
                        ->with('maxAttempts', $request->email);
                    // ->with('maxAttempts', 'try agin after 30 minutes');
                });
        });
    }
}
