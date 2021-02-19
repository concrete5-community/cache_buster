<?php

namespace Concrete\Package\CacheBuster\Controller\SinglePage\Dashboard\System\Optimization;

use Concrete\Core\Page\Controller\DashboardPageController;
use Concrete\Core\Routing\Redirect;

final class CacheBuster extends DashboardPageController
{
    public function view()
    {
        return Redirect::to('/dashboard/system/optimization/cache_buster/settings');
    }
}
