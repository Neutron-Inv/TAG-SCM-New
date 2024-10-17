<?php 

    require_once __DIR__ . '/vendor/autoload.php';
    $mpdf = new \Mpdf\Mpdf(['orientation' => 'L']);
    $mpdf->SetFont('Calibri');
    $mpdf->showImageErrors = true;
    $mpdf->setFooter('{PAGENO}');
    $html = file_get_contents('index.php');
    $mpdf->WriteHTML("");
    $mpdf->WriteHTML($html);
    $mpdf->shrink_tables_to_fit = 1;
    $mpdf->Output();
    $name = "pdf_file_name.pdf";
    // $mpdf->Output($name, 'F');
    // if(file_exists($name)){
    //     unlink($name);
    // }else{
    //     $mpdf->Output($name, 'F');
    //     header("Location: file.php");hshshhsshshhshshshshs
    // }
?>