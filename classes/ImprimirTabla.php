<?php
require('fpdf/fpdf.php');

class ImprimirTabla extends FPDF{
    protected $widths;
    protected $aligns;
    protected $h;

    function SetWidths($w)
    {
        // Set the array of column widths
        $this->widths = $w;
    }

    function SetAligns($a)
    {
        // Set the array of column alignments
        $this->aligns = $a;
    }

    function cabecera(){
        $i=0;
        $x=10;
        $y=45;
        $this->SetXY($x, $y);
        $this->SetFont('Times', 'B', 9);
        $cab=["S.ANTERIOR","FECHA","ENTRADA","SALIDA","S.ACTUAL"];
        for ($i=0;$i<=4;$i++){
            $w = $this->widths[$i];
            $a = isset($this->aligns[$i]) ? $this->aligns[$i] : 'L';
            // Save the current position
            $x = $this->GetX();
            $y = $this->GetY();
            // Draw the border
            $this->Rect($x,$y,$w,5);
            // Print the text
            $this->MultiCell($w,5,$cab[$i],0,$a);
            // Put the position to the right of the cell
            $this->SetXY($x+$w,$y);
        }
        $x=10;
        $y=50;
        $this->SetXY($x, $y);
    }
    function colocar_saldo($saldo_anterior,$saldo_actual)
    {
        $x=10;
        $y=35;
        $this->SetXY($x, $y);
        $this->SetFont('Times', 'B', 10);
        $this->Cell(190,10,'Saldo Anterior: '.$saldo_anterior,0,1,'L');
        $x=10;
        $y=35;
        $this->SetXY($x, $y);
        $this->Cell(190,10,'Saldo Actual: '.$saldo_actual,0,1,'R');
        $x=10;
        $y=40;
        $this->SetXY($x, $y);
    }
    function saldo_actual($data){
        
    }
    function sforma($dato){
        $resp=explode('-',$dato);
        $result=$resp[2].'/'.$resp[1].'/'.$resp[0];
        return $result;
    }
    function cabecera2($fd,$fh){
        $x=10;
        $y=10;
        $ini=$this->sforma($fd);
        $fini=$this->sforma($fh);
        $this->SetXY($x, $y);
        $this->SetFont('Times', 'B', 14);
        $this->Cell(190,10,'BALANCE GENERAL',0,1,'C');
        $this->SetFont('Times', 'B', 12);
        $this->Cell(190,10,'DESDE: '.$ini.' HASTA: '.$fini,0,1,'C');
        $x=10;
        $y=30;
        $this->SetXY($x, $y);
    }
    function Row($data)
    {
        $nb = 0;
        for($i=0;$i<(count($data));$i++)
        {
            $nb = max($nb,$this->NbLines($this->widths[$i],$data[$i]));
        }
        $h = 5*$nb;

        // Issue a page break first if needed
        $this->CheckPageBreak($h);
        
        // Draw the cells of the row
        for($i=0;$i<(count($data));$i++)
        {
            $w = $this->widths[$i];
            $a = isset($this->aligns[$i]) ? $this->aligns[$i] : 'L';
            // Save the current position
            $x = $this->GetX();
            $y = $this->GetY();
            // Draw the border
            $this->Rect($x,$y,$w,$h);
            // Print the text
            $this->MultiCell($w,5,$data[$i],0,$a);
            // Put the position to the right of the cell
            $this->SetXY($x+$w,$y);
        }
        // Go to the next line
        $this->Ln($h);
    }

    function CheckPageBreak($h)
    {
        // If the height h would cause an overflow, add a new page immediately
        if($this->GetY()+$h>$this->PageBreakTrigger)
        {
            $this->AddPage($this->CurOrientation);
        }
    }

    function NbLines($w, $txt)
    {
        // Compute the number of lines a MultiCell of width w will take
        if(!isset($this->CurrentFont)){
            $this->Error('NO SE HA SELECCIONADO UNA FUENTE');
        }
            
        $cw = $this->CurrentFont['cw'];
        if($w==0){
            $w = $this->w-$this->rMargin-$this->x;
        }
            
        $wmax = ($w-2*$this->cMargin)*1000/$this->FontSize;
        $s = str_replace("\r",'',(string)$txt);
        $nb = strlen($s);
        if($nb>0 && $s[$nb-1]=="\n")
        {
        $nb--;
        }
        $sep = -1;
        $i = 0;
        $j = 0;
        $l = 0;
        $nl = 1;
        while($i<$nb)
        {
            $c = $s[$i];
            if($c=="\n")
            {
                $i++;
                $sep = -1;
                $j = $i;
                $l = 0;
                $nl++;
                continue;
            }
            if($c==' ')
                $sep = $i;
            $l += $cw[$c];
            if($l>$wmax)
            {
                if($sep==-1)
                {
                    if($i==$j)
                        $i++;
                }
                else
                    $i = $sep+1;
                $sep = -1;
                $j = $i;
                $l = 0;
                $nl++;
            }
            else
                $i++;
        }
        return $nl;
    }

}
