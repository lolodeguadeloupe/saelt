<?php

namespace App\Exports;

use App\Models\LigneCommandeLocation;
use App\Models\LocationVehicule\VehiculeLocation;
use Barryvdh\DomPDF\PDF;
use Dompdf\FontMetrics;
use Illuminate\Support\Facades\Log;

class GeneratePDF
{

    public static function generatePDFFacture($data)
    {
        //return view('front.pdf-facturation', $data);
        //dd($data);
        $pdf = app(PDF::class)->loadView('front.pdf-facturation', $data);
        $canvas = $pdf->getDomPDF()->get_canvas();
        $w = $canvas->get_width(); /*600;*/
        $h = $canvas->get_height(); /*700; */
        $font = $pdf->getDomPDF()->getFontMetrics();
        $bold = $font->get_font("helvetica", "bold");
        $regular = $font->get_font("helvetica");
        $count_page = $canvas->get_page_number();
        //$pdf->setPaper(array(0, 0, 700, 8000 * $count_page), "portrait");
        $canvas->page_text(
            $w - 60,
            $h - 28,
            "page: {PAGE_NUM} of {PAGE_COUNT}",
            $bold,
            6,
            array(0, 0, 0)
        );
        $canvas->page_text($w - 570, $h - 28, "Saelt voyage", $regular, 6);
        return self::save_doc("Facture-" . $data['data']['id'], $pdf);
    }

    public static function generatePDFinfoConducteur($id)
    {
        $data = LigneCommandeLocation::find($id)->toArray();
        $data['vehicule_technique'] = VehiculeLocation::find($data['location_id'])->info_tech()->first()->toArray();
        $pdf = app(PDF::class)->loadView('front.pdf-info-conduite', ['data' => $data]);
        $canvas = $pdf->getDomPDF()->get_canvas();
        $w = $canvas->get_width(); /*600;*/
        $h = $canvas->get_height(); /*700; */
        $font = $pdf->getDomPDF()->getFontMetrics();
        $bold = $font->get_font("helvetica", "bold");
        $regular = $font->get_font("helvetica");
        $canvas->page_text(
            $w - 60,
            $h - 28,
            "page: {PAGE_NUM} of {PAGE_COUNT}",
            $bold,
            6,
            array(0, 0, 0)
        );
        $canvas->page_text($w - 570, $h - 28, "Saelt voyage", $regular, 6);
        return $pdf->download("détail conducteur " . $data['immatriculation'] . '.pdf');
    }

    public static function generateVoucher($view, $data, $file_name, $voucher)
    {
        $pdf = app(PDF::class)->loadView($view, $data);
        return self::save_doc($file_name . "-" . parse_date_string(now()) . "-" . $voucher->id, $pdf, "vouchers");
    }


    public static function save_doc($name, $dompdf, $path = "facturations")
    {
        $fileSystem = new \Illuminate\Filesystem\Filesystem();

        if (!$fileSystem->isDirectory(public_path($path))) {
            $fileSystem->makeDirectory(public_path($path));
        }
        $dompdf->save(public_path($path . "/" . $name . ".pdf"));
        return public_path($path . "/" . $name . ".pdf");
    }

    public static function delete_doc($doc){
        $fileSystem = new \Illuminate\Filesystem\Filesystem();
        if ($fileSystem->exists($doc)) {
            $fileSystem->delete($doc);
        }
        return true;
    }
}
