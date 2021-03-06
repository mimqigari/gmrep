<?php

namespace App\Installer\Controllers;

use App\Http\Controllers\Api\AkApi;
use App\Installer\Helpers\RequirementsChecker;

class HomeController extends InstallerController
{
    public function index(RequirementsChecker $checker, AkApi $api)
    {
        $purchase = $api->getAccessCode(config('buzzy.item_id'));
        $activation = empty($purchase);

        $requirements = $checker->check(
            config('buzzy.requirements')
        );
        return view('installer.install.home', compact('requirements', 'activation'));
    }
}
