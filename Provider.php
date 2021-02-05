<?php

namespace StarCatmeow\SocialiteProviderCatmeowAuth;

use SocialiteProviders\Manager\OAuth2\AbstractProvider;
use SocialiteProviders\Manager\OAuth2\User;

class Provider extends AbstractProvider
{
    /**
     * Unique Provider Identifier.
     */
    const IDENTIFIER = 'CATMEOWAUTH';

    /**
     * {@inheritdoc}
     */
    protected $scopes = [''];

    /**
     * {@inheritdoc}
     */
    protected function getAuthUrl($state)
    {
        return $this->buildAuthUrlFromBase('https://openid.starcatmeow.cn/auth', $state);
    }

    /**
     * {@inheritdoc}
     */
    protected function getTokenUrl()
    {
        return 'https://openid.starcatmeow.cn/token';
    }

    /**
     * {@inheritdoc}
     */
    protected function getUserByToken($token)
    {
        $response = $this->getHttpClient()->get('https://openid.starcatmeow.cn/me?access_token='+$token);

        $user = json_decode($response->getBody(), true);

        return $user;
    }

    /**
     * {@inheritdoc}
     */
    protected function mapUserToObject(array $user)
    {
        return (new User())->setRaw($user)->map([
            'id'       => $user['sub'],
            'nickname' => $user['name'],
            'name'     => null,
            'email'    => $user['email'],
            'avatar'   => null,
        ]);
    }

    /**
     * {@inheritdoc}
     */
    protected function getTokenFields($code)
    {
        return array_merge(parent::getTokenFields($code), [
            'grant_type' => 'authorization_code'
        ]);
    }
}
