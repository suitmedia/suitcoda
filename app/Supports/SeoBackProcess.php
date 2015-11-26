<?php

namespace Suitcoda\Supports;

use Suitcoda\Model\Url;

class SeoBackProcess
{
    protected $url;

    protected $destination;

    protected $option;

    /**
     * Class constructor
     *
     * @param Url $url []
     */
    public function __construct(Url $url)
    {
        $this->url = $url;
    }

    /**
     * Set url for checker
     *
     * @param string $url []
     * @return void
     */
    public function setUrl($url)
    {
        $this->url = $this->url->ByUrl($url)->first();
    }

    /**
     * Set destination folder for result checker
     *
     * @param string $destination []
     * @return void
     */
    public function setDestination($destination)
    {
        $this->destination = $destination;
    }

    /**
     * Set option for checker
     *
     * @param string $option []
     * @return void
     */
    public function setOption($option)
    {
        $this->option = $option;
    }

    /**
     * Run checker
     *
     * @return void
     */
    public function run()
    {
        $json = [];
        $json = array_add($json, 'name', 'BackendSeo Checker');
        $json = array_add($json, 'url', $this->url->url);
        $json = array_add($json, 'checking', []);

        $project = $this->url->project;
        $projectUrls = $project->urls()->where('id', '>', $this->url->id)->get();
        if ($this->option['title-similar'] || $this->option['desc-similar']) {
            foreach ($projectUrls as $url) {
                $this->getErrorDescription($json, $url);
            }
        }

        if ($this->option['depth'] && $this->url->depth > 3) {
            $desc = 'The url depth in this url is more than 3. It\'s recommended that the depth no more than 3 layer.';
            array_push($json['checking'], ['error' => 'warning', 'desc' => $desc]);
        }
        
        if (!is_dir(base_path($this->destination))) {
            mkdir(base_path($this->destination), 0777, true); // true for recursive create
        }
        $result = fopen(base_path($this->destination) . "resultBackendSEO.json", "w");
        fwrite($result, json_encode($json, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES));
        fclose($result);
    }

    /**
     * Check if url get error or not
     *
     * @param array $json []
     * @param object $url []
     * @return void
     */
    protected function getErrorDescription($json, $url)
    {
        if ($this->option['title-similar'] && strcmp($this->url->title, $url->title) == 0) {
            $desc = 'The title tag in this url exactly same with the title tag in url : ' . $url->url .
                '. Please change so there are no same title tag.';
            array_push($json['checking'], ['error' => 'error', 'desc' => $desc]);
        }
        if ($this->option['desc-similar'] && strcmp($this->url->desc, $url->desc) == 0) {
            $desc = 'The description tag in this url exactly same with the description tag in url : ' .
                $url->url . '. Please change so there are no same description tag.';
            array_push($json['checking'], ['error' => 'error', 'desc' => $desc]);
        }
    }
}
