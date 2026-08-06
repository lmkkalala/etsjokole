<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
?>

<?php

class PDF extends FPDF {

// En-tête
    function Header() {
        // Logo
        // $this->Image('../../../media/pictures-entreprise/logo_aretn.png', 10, 12, 15);

        // Police Arial gras 15
        $this->SetFont('Arial', 'B', 7);
        // Décalage à droite
        $this->Cell(10);
        // Titre
        $this->SetFont('Arial', 'B', 14);
        $this->Cell(110, 10, 'Ets JOKOLE', 0, 0, 'C');
        $this->Ln(5);
        $this->SetFont('Arial', 'B', 8);
        $this->Cell(130, 10, 'Adresse: Kamanyola/Sud-Kivu/DRC', 0, 0, 'C');
        $this->Ln(4);
        $this->SetFont('Arial', 'B', 8);
        $this->Cell(130, 10, decode('Tél. +243 995130124'), 0, 0, 'C');
        $this->SetDrawColor(34, 139, 34);
        //premiere ligne
        $this->Line(10, 27, 148 - 10, 27);
        $this->SetDrawColor(34, 139, 34);
        //Deuxieme ligne
        $this->Line(10, 31, 148 - 10, 31);
        $this->Ln(5);
        $this->SetFont('Arial', 'B', 8);
        
        $this->Cell(120, 10, 'Facture', 0, 0, 'C');

        //Decalage a droite
        $this->Cell(10);
        //logo isdr
//        $this->Image('../../media/pictures/logo_school.jpeg', 125, 12, 12);
        // Saut de ligne
        $this->Ln(5);
    }

// Pied de page
    function Footer() {
        // Positionnement à 1,5 cm du bas
        $this->SetY(-15);
        // Police Arial italique 8
        $this->SetFont('Arial', 'I', 8);
        // Numéro de page
        $this->Cell(0, 10, utf8_decode('Imprimé à Kamanyola/RDC, le ') . date('d/m/Y') . " " . date('H:i'), 0, 0, 'C');
        $this->Ln(5);
        $this->Cell(0, 10, 'Page ' . $this->PageNo() . '/{nb}', 0, 0, 'C');
    }

    var $widths;
    var $aligns;

    function SetWidths($w) {
        //Set the array of column widths
        $this->widths = $w;
    }

    function SetAligns($a) {
        //Set the array of column alignments
        $this->aligns = $a;
    }

    function Row($data) {

        //Calculate the height of the row
        $nb = 0;
        for ($i = 0; $i < count($data); $i++)
            $nb = max($nb, $this->NbLines($this->widths[$i], $data[$i]));
        $h = 5 * $nb;
        //Issue a page break first if needed
        $this->CheckPageBreak($h);
        //Draw the cells of the row
        for ($i = 0; $i < count($data); $i++) {
            $w = $this->widths[$i];
            $a = isset($this->aligns[$i]) ? $this->aligns[$i] : 'L';
            //Save the current position
            $x = $this->GetX();
            $y = $this->GetY();
            //Draw the border
            $this->Rect($x, $y, $w, $h);
            //Print the text
            $this->MultiCell($w, 5, $data[$i], 0, $a);
            //Put the position to the right of the cell
            $this->SetXY($x + $w, $y);
        }
        //Go to the next line
        $this->Ln($h);
    }

    function CheckPageBreak($h) {
        //If the height h would cause an overflow, add a new page immediately
        if ($this->GetY() + $h > $this->PageBreakTrigger)
            $this->AddPage($this->CurOrientation);
    }

    function NbLines($w, $txt) {
        //Computes the number of lines a MultiCell of width w will take
        $cw = &$this->CurrentFont['cw'];
        if ($w == 0)
            $w = $this->w - $this->rMargin - $this->x;
        $wmax = ($w - 2 * $this->cMargin) * 1000 / $this->FontSize;
        $s = str_replace("\r", '', $txt);
        $nb = strlen($s);
        if ($nb > 0 and $s[$nb - 1] == "\n")
            $nb--;
        $sep = -1;
        $i = 0;
        $j = 0;
        $l = 0;
        $nl = 1;
        while ($i < $nb) {
            $c = $s[$i];
            if ($c == "\n") {
                $i++;
                $sep = -1;
                $j = $i;
                $l = 0;
                $nl++;
                continue;
            }
            if ($c == ' ')
                $sep = $i;
            $l += $cw[$c];
            if ($l > $wmax) {
                if ($sep == -1) {
                    if ($i == $j)
                        $i++;
                } else
                    $i = $sep + 1;
                $sep = -1;
                $j = $i;
                $l = 0;
                $nl++;
            } else
                $i++;
        }
        return $nl;
    }

}

function decode($val) {
    return utf8_decode($val);
}
?>
