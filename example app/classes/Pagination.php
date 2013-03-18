<?php

namespace classes;
/**
 * Pagination
 *
 * This provides a pagination object to help showing data.
 *
 * PHP version 5
 *
 * @category PHP
 * @package  Minimal-php-mvc
 * @author   Nicolas Lattuada <nicolaslattuada@ymail.com>
 * @license  http://www.gnu.org/licenses/lgpl.html LGPL Licence
 * @version  Release: @package_version@
 * @link     http://github.com/nicolaslattuada/minimal-php-mvc
 */

class Pagination
{
        
    /**
     * @var $before : the url that will be parsed in the url before the page number.
     * @var $after  : the url that will be parsed in the url after the page number.
     *
     * @var $paginatorItems : the numbers of items composing the paginator
     *
     * @var $separator : when we have more items to show than what we set up 
     * with $paginatorItems we will use this string as separator between them
     * 
     * @var $linkPattern : the pattern that will be sprintf'd for generating 
     * the links, params will be :
     * $before(%s), the number of the page(%d),
     * $after(%s), the content of the link(%s)
     *
     * @var $currentPattern : the pattern that will be sprintf'd 
     * to show the current page item, the only param is the page number
     *
     * @var $leftClicker : symbol used to navigate to previous page
     * @var $rightClicker : symbol used to navigate to next page
     *
     * @var $toFirst : symbol used to navigate to first page
     * @var $toLast  : symbol used to navigate to last page
     *
     * @var $add : added to the number representation of the content of link item
     * set to 1 with start at one method
     *
     * @var $curPage : the current page
     * @var $totalPages : number of pages
     * @var $html : markup to be printed when echoing the object
     */

    private $before = '', $after = '', $paginatorItems = 10, $separator = '...',
        $linkPattern = ' <a href="%s/%d/%s">%s</a> ', $currentPattern = ' <span>%d</span> ',
        $leftClicker = '&larr;', $rightClicker = '&rarr;',
        $toFirst = '&lt;|', $toLast = '|&gt;',
        $add = 0, $curPage, $totalPages, $html = ''; 

    function __construct(&$data, $curPage = 0, $itemsPerPage = 10){
        $start = $curPage * $itemsPerPage;
        $end   = $start + $itemsPerPage;

        for($i = $start; $i < $end; $i++){
            $toShow[] = isset($data[$i]) ? $data[$i] : new ViewVars;
        }

        $totalPages = ceil( count($data) / $itemsPerPage );
        $data = $toShow;
        $this->setup($curPage, $totalPages);
        return $this;
    }

    function before($before){
        $this->before = trim($before, '/');
        return $this;
    }

    function after($after){
        $this->after = trim($after, '/');
        return $this;
    }

    function setClikers($leftClicker, $rightClicker){
        $this->leftClicker  = $leftClicker;
        $this->rightClicker = $rightClicker;
    }
    
    function setFirstLast($first, $last){
        $this->toFirst  = $first;
        $this->toLast   = $last;
    }

    function setPatterns($linkPattern, $currentPattern){
        $this->linkPattern = $linkPattern;
        $this->currentPattern = $currentPattern;
    }

    function startAtOne(){
        $this->add = 1;
    }

    private function setup($curPage, $totalPages){
        $this->curPage = $curPage;
        $this->totalPages = $totalPages;
    }

    private function render(){
        $html = '';
        $lastShown = -1;
        $initNum = $this->paginatorItems / 3;


        if($this->curPage > $initNum)
            $html .= sprintf($this->linkPattern, $this->before, 0,
                                                 $this->after, $this->toFirst);

        if($this->curPage!=0)
            $html .= sprintf($this->linkPattern, $this->before, $this->curPage - 1, 
                                                 $this->after, $this->leftClicker);

        for($i = 0; $i < $this->totalPages; $i++){
            if($this->totalPages > $this->paginatorItems){
                if($i > $initNum && $i < $this->totalPages - $initNum && 
                    !( $i > $this->curPage - ($initNum/2 + 1) && $i < $this->curPage + ($initNum/2 + 1) ) ){
                    continue;
                }
            }

            if($lastShown != $i-1)
                $html .= $this->separator;

            if($i!=$this->curPage){
                $html .= sprintf($this->linkPattern, $this->before, $i,
                                                     $this->after, $i + $this->add);
            }else{
                $html .= sprintf($this->currentPattern, $i + $this->add);
            }
            $lastShown = $i;
        }

        if($this->curPage!=$this->totalPages - 1)
            $html .= sprintf($this->linkPattern, $this->before, $this->curPage + 1,
                                                 $this->after, $this->rightClicker);
 
        if($this->curPage < $this->totalPages - $initNum)
            $html .= sprintf($this->linkPattern, $this->before, $this->totalPages - 1,
                                                 $this->after, $this->toLast);
       
        $this->html = $html;
    }

    function __toString(){
        $this->render();
        return $this->html;
    }

}
