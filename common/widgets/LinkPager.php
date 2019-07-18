<?php
namespace common\widgets;

use Yii;
use yii\helpers\Html;

class LinkPager extends \yii\widgets\LinkPager
{
    public $firstPageLabel = '首页';

    public $nextPageLabel = '下一页';

    public $prevPageLabel = '上一页';

    public $lastPageLabel = '末页';

    /**
     * @var int 可以显示的页面按钮的最大数量。
     */
    public $maxButtonCount = 5;

    /**
     * @var bool 只有一个页面存在时不隐藏小部件。
     */
    public $hideOnSinglePage = false;

    /**
     * {pageButtons} {customPage} {pageSize}
     */
    public $template = '<div class="form-inline" ><div class="form-group">{pageButtons}</div> <div class="form-group">{customPage}</div><div class="form-group"> {pageSize}</div></div>';

    /**
     * pageSize list
     */
    public $pageSizeList = [10, 20, 30, 50];

    /**
     *
     * Margin style for the  pageSize control
     */
    public $pageSizeMargin = [
        'margin-left' => '5px',
        'margin-right' => '5px',
    ];

    /**
     * customPage width
     */
    public $customPageWidth = 50;

    /**
     * Margin style for the  customPage control
     */
    public $customPageMargin = [
        'margin-left' => '5px',
        'margin-right' => '5px',
    ];

    /**
     * Jump
     */
    public $customPageBefore = '跳转';
    /**
     * Page
     */
    public $customPageAfter = '';

    /**
     * pageSize style
     */
    public $pageSizeOptions = [
        'class' => 'form-control',
        'style' => [
            'display' => 'inline-block',
            'width' => 'auto',
            'margin-top' => '0px',
        ],
    ];

    /**
     * customPage style
     */
    public $customPageOptions = [
        'class' => 'form-control',
        'style' => [
            'display' => 'inline-block',
            'margin-top' => '0px',
        ],
    ];


    public function init()
    {
        parent::init();
        if ($this->pageSizeMargin) {
            Html::addCssStyle($this->pageSizeOptions, $this->pageSizeMargin);
        }
        if ($this->customPageWidth) {
            Html::addCssStyle($this->customPageOptions, 'width:' . $this->customPageWidth . 'px;');
        }
        if ($this->customPageMargin) {
            Html::addCssStyle($this->customPageOptions, $this->customPageMargin);
        }
    }


    /**
     * Executes the widget.
     * This overrides the parent implementation by displaying the generated page buttons.
     */
    public function run()
    {
        if ($this->registerLinkTags) {
            $this->registerLinkTags();
        }
        echo $this->renderPageContent();
    }

    protected function renderPageContent()
    {
        return preg_replace_callback('/\\{([\w\-\/]+)\\}/', function ($matches) {
            $name = $matches[1];
            if ('customPage' == $name) {
                return $this->renderCustomPage();
            } else if ('pageSize' == $name) {
                return $this->renderPageSize();
            } else if ('pageButtons' == $name) {
                return $this->renderPageButtons();
            }
            return '';
        }, $this->template);
    }


    protected function renderPageSize()
    {
        $pageSizeList = [];
        foreach ($this->pageSizeList as $value) {
            $pageSizeList[$value] = $value;
        }
        //$linkurl =  $this->pagination->createUrl($page);
        return Html::dropDownList($this->pagination->pageSizeParam, $this->pagination->getPageSize(), $pageSizeList, $this->pageSizeOptions);
    }

    protected function renderCustomPage()
    {
        $pageCount = $this->pagination->getPageCount();
        if ($pageCount < 2 && $this->hideOnSinglePage) {
            return '';
        }
        $page = 1;
        $params = Yii::$app->getRequest()->queryParams;
        if (isset($params[$this->pagination->pageParam])) {
            $page = intval($params[$this->pagination->pageParam]);
            if ($page < 1) {
                $page = 1;
            } else if ($page > $pageCount) {
                $page = $pageCount;
            }
        }
        return $this->customPageBefore . Html::textInput($this->pagination->pageParam, $page, $this->customPageOptions) . $this->customPageAfter;
    }

}