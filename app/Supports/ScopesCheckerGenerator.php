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

    /**
     * Class constructor
     *
     * @param Scope $scope []
     */
    public function __construct(Scope $scope)
    {
        $this->scope = $scope;
    }

    /**
     * Generate command with the given scope name
     *
     * @param  string $overallScopes []
     * @param  string $name []
     * @return string
     */
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

    /**
     * Generate parameters with the given scope name
     *
     * @param  string $overallScopes []
     * @param  string $name []
     * @return string
     */
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

    /**
     * Generate url with parameter command prefix
     *
     * @param  Suitcoda\Model\Url $url []
     * @return string
     */
    public function generateUrl($url)
    {
        return ' --url ' . $url->url;
    }

    /**
     * Generate destination with parameter command prefix
     * @param  Suitcoda\Model\Project $project []
     * @param  Suitcoda\Model\Inspection $inspection []
     * @return string
     */
    public function generateDestination($project, $inspection)
    {
        return ' --destination public/files/' . $project->name . '/' . $inspection->sequence_number . '/ ';
    }

    /**
     * Get sub directory for command with the given category
     *
     * @param  string $category []
     * @return string
     */
    public function getSubDirCommand($category)
    {
        return array_get($this->subDir, $category, '');
    }

    /**
     * Get scope with the given type
     *
     * @param  string $type []
     * @return Suitcoda\Model\Scope
     */
    public function getByType($type)
    {
        return $this->scope->byType($type)->get();
    }
}
