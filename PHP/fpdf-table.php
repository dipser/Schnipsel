<?php


    $settings = [
        'columns' => [
            [ 'width' => $page_width / 2, 'align' => 'L' ], // Column width
            [ 'width' => $page_width / 2 / 2 ],
            [ 'width' => $page_width / 2 / 2 ],
        ],
        'header' => [
            [ 'text' => 'title' ],
            [ 'text' => 'title' ],
            [ 'text' => 'title' ],
        ],
        'rows' => [
            //['col', 'col', 'col'],
            // ...
        ]
    ];
    $this->table($settings_eigeneperson);






    private function table($settings = [])
    {
        // Header
        if ( is_array($settings['header']) ) {
            foreach($settings['columns'] as $column_i => $column) {
                $header = $settings['header'][$column_i];
                $w = $column['width'] ?? 0;
                $h = $column['height'] ?? 0;
                $text = $header['text'] ?? '';
                $border = $header['border'] ?? $column['border'] ?? 0;
                $align = $header['align'] ?? $column['align'] ?? 'C';
                $this->pdf->Cell($w,$h,$text,$border,0,$align);
            }
            $this->pdf->SetY($this->pdf->GetY() + 2);
            $this->pdf->Ln();
        }

        // Data
        foreach($settings['rows'] as $row) {
            $_h = 0;
            foreach($settings['columns'] as $column_i => $column) {
                $w = $column['width'] ?? 0;
                $h = $row['height'] ?? $column['height'] ?? 0;
                $text = !is_array($row[$column_i]) ? $row[$column_i] : ($row[$column_i]['text'] ?? '');
                $border = $row['border'] ?? $column['border'] ?? 0;
                $align = $row['align'] ?? $column['align'] ?? 'C';

                #$this->pdf->Cell($w,$h,$text,$border,0,$align);
                // Multiline-Fix mit MultiCell
                $x = $this->pdf->GetX() + $w;
                $y = $this->pdf->GetY();
                $this->pdf->MultiCell($w,$h,$text,$border,$align);
                if ( $this->pdf->GetY() - $y > $_h ) $_h = $this->pdf->GetY() - $y;
                $this->pdf->SetXY($x,$y);
            }
            $this->pdf->SetY($y + $_h + 2);
            #$this->pdf->Ln();
        }
    }
