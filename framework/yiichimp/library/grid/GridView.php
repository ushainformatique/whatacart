<?php
/**
 * @copyright Copyright (c) 2017 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://github.com/ushainformatique/yiichimp/blob/master/LICENSE.md
 */
namespace usni\library\grid;

use usni\library\utils\Html;
use yii\grid\DataColumn;
use usni\UsniAdaptor;
use yii\bootstrap\Modal;
use yii\widgets\Pjax;
use usni\library\utils\StringUtil;
use yii\helpers\Inflector;
/**
 * Extends @GridView to render the grid using bootstrap.
 * 
 * @package usni\library\grid
 */
class GridView extends \yii\grid\GridView
{
    /**
     * If detail view would be modal.
     * @var boolean
     */
    public $isModalDetailView;
    
    /**
     * @inheritdoc
     */
    public $captionOptions = ['class' => 'panel-title'];
    
    /**
     * @inheritdoc
     */
    public $tableOptions = ['class' => 'table dataTable no-footer'];
    
    /**
     * @inheritdoc
     */
    public $summaryOptions = ['class' => 'dataTables_info'];
    
    /**
     * @var string Class name for the model whose data is displayed in the grid
     */
    public $modelClass;
    
    /**
     * @inheritdoc
     */
    public $layout = "<div class='panel panel-default'>
                       <div class='panel-heading'>{caption}</div>
                       <div class='dataTable'>
                            <div class='datatable-scroll'>{items}</div>
                            <div class='datatable-footer'>{summary}{pager}</div>
                        </div>
                      </div>";
    
    /**
     * Modal detail view file
     * @var string 
     */
    public $modalDetailView     = '@usni/library/views/_modalview.php';
    
    /**
     * Pjax id for the grid view
     * @var string 
     */
    public $pjaxId;
    
    /**
     * Enable pjax for the grid view
     * @var string 
     */
    public $enablePjax = true;
    
    /**
     * Html options for the container in which grid view is wrapped.
     * @var string 
     */
    public $containerOptions = ["class" => "grid-container"];
    
    /**
     * @inheritdoc
     */
    public $pager = ['class' => '\usni\library\widgets\LinkPager'];
    
    /**
     * inheritdoc
     */
    public function init()
    {
        parent::init();
        if($this->isModalDetailView === null)
        {
            $modalDisplayParam = UsniAdaptor::app()->request->getQueryParam('modal-display');
            if($modalDisplayParam == null || $modalDisplayParam == 'yes')
            {
                $this->isModalDetailView = true;
            }
            else
            {
                $this->isModalDetailView = false;
            }
        }
        if($this->pjaxId == null)
        {
            $this->pjaxId = $this->id . '-pjax';
        }
    }
    
    /**
     * inheritdoc
     */
    public function run()
    {
        echo Html::beginTag('div', $this->containerOptions);
        if($this->enablePjax)
        {
            Pjax::begin(['id' => $this->pjaxId, 'enablePushState' => false, 'timeout' => 4000]);
        }
        parent::run();
        if($this->enablePjax)
        {
            Pjax::end();
        }
        if($this->isModalDetailView)
        {
            echo $this->renderModalDetailView();
        }
        echo Html::endTag('div');
    }
    
    /**
     * @inheritdoc
     */
    public function renderItems()
    {
        $columnGroup = $this->renderColumnGroup();
        $tableHeader = $this->showHeader ? $this->renderTableHeader() : false;
        $tableBody = $this->renderTableBody();
        $tableFooter = $this->showFooter ? $this->renderTableFooter() : false;
        $content = array_filter([
            $columnGroup,
            $tableHeader,
            $tableFooter,
            $tableBody,
        ]);
        return Html::tag('table', implode("\n", $content), $this->tableOptions);
    }

    /**
     * @inheritdoc
     */
    public function renderSection($name)
    {
        switch ($name)
        {
            case "{caption}":
                return $this->renderCaption();
            default:
                return parent::renderSection($name);
        }
    }

    /**
     * @inheritdoc
     */
    public function renderCaption()
    {
        if (!empty($this->caption))
        {
            return Html::tag('h6', $this->caption, $this->captionOptions);
        }
        else
        {
            return parent::renderCaption();
        }
    }

    /**
     * Creates column objects and initializes them.
     */
    protected function initColumns()
    {
        parent::initColumns();
        foreach ($this->columns as $index => $column)
        {
            if ($column instanceof DataColumn)
            {
                /* @var $column Column */
                $column->sortLinkOptions = ['class' => 'sorting'];
                $this->columns[$index] = $column;
            }
        }
    }
    
    /**
     * Renders detailview modal.
     * @return string
     */
    public function renderModalDetailView()
    {
        $title      = \Yii::t('yii', 'View') . ' ' . Inflector::camel2words(StringUtil::basename($this->modelClass));
        $output     = $this->renderFile($this->modalDetailView, ['modalId' => 'gridContentModal',
                                                    'size'    => Modal::SIZE_LARGE,
                                                    'title'   => $title,
                                                    'body'    => null,
                                                    'footer'  => null]);
        $this->registerModalDetailScript();
        return $output;
    }
    
    /**
     * Registers script.
     * @return void
     */
    public function registerModalDetailScript()
    {
        $script     = "$('#gridContentModal').on('show.bs.modal', function (event) {
                       var button = $(event.relatedTarget) // Button that triggered the modal
                       var url = button.data('url') // Extract info from data-* attributes
                       $(this).find('.modal-body').load(url);
                      })";
        $this->getView()->registerJs($script);
    }
}