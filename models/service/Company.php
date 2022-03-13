<?php

namespace app\models\service;

class Company extends \app\models\db\Company
{
    /**
     * @return string
     */
    public function generateToken()
    {
        return md5($this->name . $this->url . mktime(0));
    }

    /**
     * @param string $token
     * @return bool
     */
    public function checkToken(string $token)
    {
        $company = self::find()->where(['access_token' => $token])->one();
        if (empty($company)) {
            return false;
        }

        return true;
    }
}
