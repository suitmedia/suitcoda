<?php

namespace Suitcoda\Supports;

use Suitcoda\Model\Scope;

class ScopesCheckerGenerator
{
    protected $scope;

    protected $subDir = [
        'SEO' => 'seo/',
        'Performance' => 'performance/',
        'Code Quality' => 'linter/',
        'Social Media' => 'socmed/'
    ];

    public function __construct(Scope $scope)
    {
        $this->scope = $scope;
    }

    public function generateCommand($overallScopes, $name)
    {
        $scopeByName = $this->scope->getByName($name);

        $overallScopes = (int)$overallScopes;
        foreach ($scopeByName->subScopes as $subScope) {
            if (($overallScopes & $subScope->code) > 0) {
                if (strcmp($scopeByName->name, 'backendSeo') == 0) {
                    return $scopeByName->command->command_line;
                }
                return 'nodejs ' .
                    $this->getSubDirCommand($scopeByName->category) .
                    $scopeByName->command->command_line;
            }
        }
        return null;
    }

    public function generateParameters($overallScopes, $name)
    {
        $scopeByName = $this->scope->getByName($name);

        $parameters = [];
        $overallScopes = (int)$overallScopes;
        foreach ($scopeByName->subScopes as $subScope) {
            if (($overallScopes & $subScope->code) > 0) {
                array_push($parameters, $subScope->parameter);
            }
        }
        $parameters = implode(' ', $parameters);

        return !empty($parameters) ? $parameters : null;
    }

    public function generateUrl($url)
    {
        return ' --url ' . $url->url;
    }

    public function generateDestination($project, $inspection)
    {
        return ' --destination public/files/' . $project->name . '/' . $inspection->sequence_number . '/ ';
    }

    public function getSubDirCommand($category)
    {
        return array_get($this->subDir, $category, '');
    }

    public function getByType($type)
    {
        return $this->scope->byType($type)->get();
    }
}
