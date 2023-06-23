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
        $this->Image('../../media/pictures/rdc.JPG', 10, 6, 15);
        $this->Image('../../media/pictures/qr-site-isdr.JPG', 122, 73, 15);
        $this->Image('../../media/pictures/qr-site-isdr.JPG', 122, 145, 15);

        // Police Arial gras 15
        $this->SetFont('Arial', 'B', 7);
        // Décalage à droite
        $this->Cell(10);
        // Titre
        $this->SetFont('Arial', 'B', 8);
        $this->Cell(110, 10, 'INSTITUT SUPERIEUR DE DEVELOPPEMENT RURAL DE BUKAVU', 0, 0, 'C');
        $this->Ln(5);
        $this->SetFont('Arial', 'B', 8);
        $this->Cell(120, 10, 'ISDR - BUKAVU', 0, 0, 'C');
        $this->Ln(5);
        $this->SetFont('Arial', 'B', 8);
        $this->Cell(120, 10, 'B.P. 2849/BUKAVU', 0, 0, 'C');
        $this->Ln(5);
        $this->SetDrawColor(34, 139, 34);
        $this->Line(10, 35, 148 - 10, 35);
        $this->SetFont('Arial', '', 8);
        $this->Cell(120, 10, 'Site web: https://www.isdrbukavu.ac.cd', 0, 0, 'C');
        $this->SetDrawColor(34, 139, 34);
        $this->Line(10, 45, 148 - 10, 45);
        $this->Ln(10);
        $this->SetFont('Arial', 'B', 8);
        $this->Cell(120, 10, 'Administration de Budget', 0, 0, 'C');

        //Decalage a droite
        $this->Cell(10);
        //logo isdr
        $this->Image('../../media/pictures/logoisdr.jpg', 125, 6, 15);
        // Saut de ligne
        $this->Ln(10);
    }

// Pied de page
    function Footer() {
        // Positionnement à 1,5 cm du bas
        $this->SetY(-15);
        // Police Arial italique 8
        $this->SetFont('Arial', 'I', 8);
        // Numéro de page
        $this->Cell(0, 10, utf8_decode('Imprimé à l\'ISDR-Bukavu, le ') . date('d/m/Y') . " " . date('H:i'), 0, 0, 'C');
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
