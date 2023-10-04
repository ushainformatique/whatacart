<?php
/**
 * @copyright Copyright (c) 2017 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://github.com/ushainformatique/yiichimp/blob/master/LICENSE.md
 */
namespace usni\library\widgets;

use usni\library\dto\DetailViewDTO;
use usni\library\utils\Html;
use usni\library\utils\ArrayUtil;
/**
 * Extends functionality related to detail view
 *
 * @package usni\library\widgets
 */
class DetailView extends \yii\widgets\DetailView
{
    /**
     * inheritdoc
     */
    public $options     = ['class' => 'table table-striped table-detail detail-view'];
    
    /**
     * View using which form is decorated. If false no decoration would be done
     * @var string 
     */
    public $decoratorView = '@usni/library/views/layouts/detail.php';
    
    /**
     * Detail view DTO carrying view data.
     * @var DetailViewDTO 
     */
    public $detailViewDTO;
    
    /**
     * Action toolbar widget options. If no class is passed, DetailActionToolbar widget would be
     * used as the default widget
     * @var array 
     */
    public $actionToolbar = [];
    
    /**
     * @var string the caption of the detail table
     * @see captionOptions
     */
    public $caption;
    
    /**
     * If detail view has to be rendered in modal display
     * @var boolean 
     */
    public $modalDisplay;
    
    /**
     * inheritdoc
     */
    public function init()
    {
        if($this->model == null)
        {
            $this->model = $this->detailViewDTO->getModel();
        }
        if($this->modalDisplay == null)
        {
            $this->modalDisplay = $this->detailViewDTO->getModalDisplay();
        }
        ob_start();
        ob_implicit_flush(false);
        parent::init();
    }
    
    /**
     * inheritdoc
     */
    public function run()
    {
        parent::run();
        //Get the detail content
        $detailContent = ob_get_clean();
        if($this->decoratorView !== false)
        {
            $params        = ['title' => $this->caption,
                              'content' => $detailContent,
                              'toolbar' => null];
            if($this->actionToolbar !== false)
            {
                $params['toolbar'] = $this->renderToolbar();
            }
            echo $this->getView()->render($this->decoratorView, $params);
        }
        else
        {
            echo $detailContent;
        }
    }
    
    /**
     * Renders the toolbar element.
     * @return boolean|string the rendered toolbar element.
     */
    public function renderToolbar()
    {
        if($this->modalDisplay)
        {
            return '';
        }
        /* @var $class DetailActionToolbar */
        $actionToolbar = $this->actionToolbar;
        $class = ArrayUtil::remove($actionToolbar, 'class', DetailActionToolbar::className());
        $actionToolbar['view'] = $this->getView();
        return $class::widget($actionToolbar);
    }
    
    /**
     * Renders the caption element.
     * @return boolean|string the rendered caption element or `false` if no caption element should be rendered.
     */
    public function renderCaption()
    {
        if (!empty($this->caption))
        {
            return Html::tag('h6', FA::icon('book') . $this->caption, $this->captionOptions);
        }
        else
        {
            return false;
        }
    }
    
    /**
     * Renders the detail view
     * @return string
     */
    public function renderDetail()
    {
        $rows = [];
        $i = 0;
        foreach ($this->attributes as $attribute) 
        {
            $rows[] = $this->renderAttribute($attribute, $i++);
        }

        $options = $this->options;
        $tag     = ArrayUtil::remove($options, 'tag', 'table');
        return Html::tag($tag, implode("\n", $rows), $options);
    }
}