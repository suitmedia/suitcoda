<?php

namespace Suitcoda\Pagination;

use Illuminate\Pagination\BootstrapThreePresenter;

class CustomPresenter extends BootstrapThreePresenter
{
    /**
     * Convert the URL window into Bootstrap HTML.
     *
     * @return string
     */
    public function render()
    {
        if ($this->hasPages()) {
            return sprintf(
                '<ul class="pagination">%s %s %s</ul>',
                $this->getPreviousButton('Prev'),
                $this->getLinks(),
                $this->getNextButton('Next')
            );
        }

        return '';
    }

    /**
     * Get HTML wrapper for disabled text.
     *
     * @param  string  $text
     * @return string
     */
    protected function getDisabledTextWrapper($text)
    {
        return '<li><a href="javascript:void(0)">'.$text.'</a></li>';
    }

    /**
     * Get HTML wrapper for active text.
     *
     * @param  string  $text
     * @return string
     */
    protected function getActivePageWrapper($text)
    {
        return '<li><a class="active" href="javascript:void(0)">'.$text.'</a></li>';
    }
}
