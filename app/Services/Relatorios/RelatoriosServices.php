<?php
namespace App\Services\Relatorios;

use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use NumberFormatter;

class RelatoriosServices {
    
    protected $model;    
    protected $data;
    protected $date;
    protected $name = 'relatorio';
    protected $view;
    protected $orientation = '';

    public function __construct()
    {
        $this->date = Carbon::now()->setTimezone('America/Sao_Paulo');
    }

    public function config($request) {}

    public function make($request) {
        $this->config($request);
        
        
        // echo '<pre>'; print_r($this->data->cliente); die;
        $pdf = Pdf::loadView($this->view, [
            'data' => $this->data,
            'date' =>  $this->date->format('d/m/Y H:i:s'),
            'formatter' => new NumberFormatter('pt_BR',  NumberFormatter::CURRENCY)
        ])->setPaper('a4', $this->orientation);
        // return view($this->view, [
        //     'data' => $this->data,
        //     'date' => $date->format('d/m/Y H:i:s')
        // ] );
        // $pdf = Pdf::loadView($this->view, $this->data);
        header('');
        return $pdf->stream("{$this->name}_{$this->date->format('d_m_Y_H_i_s')}.pdf");
        //return $pdf->download("{$this->name}.pdf");
    }

}