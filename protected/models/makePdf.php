<?php

Yii::import('application.vendors.*');
require_once('dompdf/autoload.inc.php');
spl_autoload_unregister(array('YiiBase','autoload'));
spl_autoload_register(array('YiiBase','autoload'));
use Dompdf\Dompdf;

class makePdf
{
  private $_dompdf;

  private $_html;

  /**
   * Init
   */
  public function __construct()
  {
    $this->_dompdf = new DOMPDF();
    $this->_dompdf->base_path = Yii::app()->request->baseUrl;
  }

  /**
   * set paper size
   *
   * @param string $size
   * @param string $orientation
   */
  public function setSize($size, $orientation='portrait')
  {
    $this->_dompdf->set_paper($size, $orientation);
  }

  public function renderPartial($view, $params)
  {
    $html = Yii::app()->controller->renderPartial($view, $params, true, true);
    $this->_html .= $html;
  }

  public function stream($name)
  {
    $this->_dompdf->load_html($this->_html);
    $this->_dompdf->render();
    $this->_dompdf->stream($name,array('Attachment'=>0));
   
  }
} 
?>