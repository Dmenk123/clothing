<?php defined('BASEPATH') OR exit('No direct script access allowed');

require_once("./vendor/dompdf/dompdf/autoload.inc.php");
use Dompdf\Dompdf;


class Pdf_gen
{
  public function generate($html, $filename='', $stream=TRUE, $paper = 'A4', $orientation = "portrait")
  {
    $dompdf = new Dompdf();
    $dompdf->loadHtml($html);
    $dompdf->setPaper($paper, $orientation);
    $dompdf->set_base_path("./assets/bootstrap/css/bootstrap.min.css");
    $dompdf->render();
    if ($stream) {
        $dompdf->stream($filename.".pdf", array("Attachment" => false));
		exit(0);
    } else {
        return $dompdf->output(['isRemoteEnabled' => true]);
    }
  }
}