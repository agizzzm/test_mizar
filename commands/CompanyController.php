<?php

namespace app\commands;

use Yii;
use app\models\service\Company;
use yii\console\Controller;
use yii\console\ExitCode;

/**
 * This command creates new company and returns its token
 *
 */
class CompanyController extends Controller
{
    public $name;
    public $url;

    public function options($actionID)
    {
        return array_merge(parent::options($actionID), $this->args());
    }

    public function args()
    {
        return [
            'name',
            'url',
        ];
    }

    public function actionCreate()
    {
        foreach ($this->args() as $arg) {
            if (empty($this->{$arg})) {
                echo sprintf("%s can't be empty", $arg);

                return ExitCode::IOERR;
            }
        }

        if (!filter_var($this->url, FILTER_VALIDATE_URL)) {
            echo sprintf("%s is not a valid url", $this->url);
        }

        $name = strip_tags(addslashes($this->name));

        $company = new Company();
        $company->name = $name;
        $company->url = $this->url;
        $company->access_token = $company->generateToken();
        if (!$company->save()) {
            Yii::error("can't create company");
            Yii::error(var_export($company->getErrors(), true));
            echo "can't create company";

            return ExitCode::IOERR;
        }

        echo $company->access_token;

        return ExitCode::OK;
    }
}
