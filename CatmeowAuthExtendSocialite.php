<?php

namespace StarCatmeow\SocialiteProviderCatmeowAuth;

use SocialiteProviders\Manager\SocialiteWasCalled;

class CatmeowAuthExtendSocialite
{
    /**
     * Execute the provider.
     */
    public function handle(SocialiteWasCalled $socialiteWasCalled)
    {
        $socialiteWasCalled->extendSocialite('catmeowauth', __NAMESPACE__.'\Provider');
    }
}
