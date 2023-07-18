<?php

/**
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2016 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Application\Controller;

require_once 'vendor/autoload.php';

use Dompdf\Dompdf;
use Dompdf\Options;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

class IndexController extends AbstractActionController
{
    public function indexAction()
    {
        // Crie uma instância do Dompdf
        $options = new Options();
        $options->setTempDir('temp');
        // $options->set('enable_remote', true); // Define a fonte padrão (opcional)
        $dompdf = new Dompdf();
        $dompdf->setOptions($options);

        $path = 'C:\Versionamento\teste\teste\public\img\logo.png';
        $type = pathinfo($path, PATHINFO_EXTENSION);
        $data = file_get_contents($path);
        $base64 = 'data:image/' . $type . ';base64,' . base64_encode($data);

        // Renderize o conteúdo HTML que deseja incluir no PDF
        $html = file_get_contents('C:/Versionamento/teste/teste/module/Application/view/application/index/pdf.html');
        $html = str_replace('{{ IMAGE }}', $base64, $html);
        // Carregue o conteúdo HTML no Dompdf
        $dompdf->loadHtml($html, 'UTF-8');

        // $dompdf->setPaper('A4');

        // Renderize o PDF
        $dompdf->render();

        // Salve o PDF em um arquivo
        $dompdf->output();

        $dompdf->stream('neodent.pdf', ['Attachment' => false]);
    }
}
