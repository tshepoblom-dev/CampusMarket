<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
class IntallerValid
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next):Response
    {
        $path = $request->path();
        if (!$this->alreadyInstalled()) {
            if ( $path === 'install'  ||  $path=="install/requirements" ||  $path=="install/permission" ||  $path=="install/demo" || $path== 'install/environment' ||  $path== 'install/purchase-code' || $path=="install/import-demo" ||  $path=='install/database'||  $path=="install/final" || $path=="localhost/*") {
                return $next($request);
            }
            return Response()->view('installer.index');
        }else{
            if ($path === 'install' || $path=="install/requirements" ||  $path=="install/permission" ) {
                return redirect('404');
                // return $next($request);
            }
        }
        return $next($request);
    }

    /**
     * If application is already installed.
     *
     * @return
     */
    public function alreadyInstalled()
    {
        return file_exists(storage_path('installed'));
    }

}
