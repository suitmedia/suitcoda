<?php

use Illuminate\Database\Seeder;
use Suitcoda\Model\Scope;
use Suitcoda\Model\SubScope;

class SubScopeTableSeeder extends Seeder
{
    protected $code = 1;

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $seoCheckingList = [
            'Title Tag Checking' => '--title',
            'Header Tag Checking' => '--header',
            'Footer Tag Checking' => '--footer',
            'Favicon Checking' => '--favicon',
            'ARIA Landmark Checking' => '--aria',
            'Alt Text on Image' => '--noalt',
            'Internationalization - i18n' => '--i18n',
            'Necessary Meta Tag Checking' => '--meta',
            'Heading (h1) checking' => '--heading'
        ];

        $backendSeoCheckingList = [
            'Title Tag Similarity Checking' => '--title-similar',
            'Meta Tag Description Similarity Checking' => '--desc-similar',
            'Url Depth Checking' => '--depth'
        ];

        $socialMediaCheckingList = [
            'Open Graph Protocol' => '--opengraph',
            'Twitter Cards' => '--twittercard',
            'Facebook Insights' => '--facebookinsight'
        ];

        $standAloneChecker = [
            'HTML Validation by W3 Validator' => 'html',
            'CSS Validation by CSSLint' => 'css',
            'JS Validation by JSHint' => 'js',
            'Google Page Speed - Mobile' => 'gPagespeedMobile',
            'Google Page Speed - Desktop' => 'gPagespeedDesktop',
            'Yahoo YSlow' => 'ySlow'
        ];

        $scope = Scope::getByName('seo');
        foreach ($seoCheckingList as $name => $parameter) {
            $this->addNewSubSopes($scope, $name, $parameter);
        }

        $scope = Scope::getByName('backendSeo');
        foreach ($backendSeoCheckingList as $name => $parameter) {
            $this->addNewSubSopes($scope, $name, $parameter);
        }

        foreach ($standAloneChecker as $name => $parameter) {
            $scope = Scope::getByName($parameter);

            $this->addNewSubSopes($scope, $name, '');
        }

        $scope = Scope::getByName('socialMedia');
        foreach ($socialMediaCheckingList as $name => $parameter) {
            $this->addNewSubSopes($scope, $name, $parameter);
        }
    }

    protected function addNewSubSopes($scope, $name, $parameter)
    {
        $model = factory(SubScope::class)->make([
            'name' => $name,
            'code' => $this->code,
            'parameter' => $parameter
        ]);
        $scope->subScopes()->save($model);
        $this->code *= 2;
    }
}
