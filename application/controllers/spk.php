<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Spk extends MY_Controller {

	public function __construct(){

		parent::__construct();

		$this->load->library(['form_validation']);
		$this->load->helper(['url']);

		date_default_timezone_set("ASIA/JAKARTA");

	}

	public function index(){
    // if(in_array('subkriteria-list', permissions($this->session->userdata())))
    // {
      // $this->render_backend('spk/hasil');
    // }
    // else
    // {
    //   message(false,'','403! Anda tidak memiliki ijin akses pada halaman ini!'); 
    //   redirect('home'); 
    // } 
    
    $kriteria = $this->kriteria();

    $subkriteria = $this->subkriteria($kriteria);

    $tabel_rekap = $this->rekapitulasiJalan();

    $roc_sub = $this->rocSub($kriteria,$subkriteria,$tabel_rekap);

    $roc_utility = $this->rocUtility($roc_sub,$kriteria,$subkriteria);

    $data['roc_utility'] = $roc_utility;

    $this->render_backend('spk/hasil',$data);

	}

  public function detail_spk()
  {
    $kriteria = $this->kriteria();

    $subkriteria = $this->subkriteria($kriteria);

    $tabel_rekap = $this->rekapitulasiJalan();

    $roc_sub = $this->rocSub($kriteria,$subkriteria,$tabel_rekap);

    $roc_utility = $this->rocUtility($roc_sub,$kriteria,$subkriteria);

    $array['kriteria'] = $kriteria;
    $array['subkriteria'] = $subkriteria;
    $array['tabel_rekap'] = $tabel_rekap;
    $array['roc_sub'] = $roc_sub;
    $array['roc_utility'] = $roc_utility;

    $this->render_backend('spk/detail-spk',$array);
  }

  public function rocUtility($roc_sub,$kriteria,$subkriteria)
  {
    $roc_utility = array();

    foreach($roc_sub as $key => $val)
    {
      $roc_utility[$key]['id_master_jalan'] = $val['id_master_jalan'];
      $roc_utility[$key]['no_ruas'] = $val['no_ruas'];
      $roc_utility[$key]['nama_jalan'] = $val['nama_jalan'];
      $roc_utility[$key]['kec'] = $val['kec'];

      $roc_utility[$key][getConfigValues('KRITERIA_BAIK')[0]] = $val[getConfigValues('KRITERIA_BAIK')[0]] * $kriteria[array_search(getConfigValues('KRITERIA_BAIK')[0], array_column($kriteria, 'kriteria'))]['bobot'];

      $roc_utility[$key][getConfigValues('KRITERIA_SEDANG')[0]] = $val[getConfigValues('KRITERIA_SEDANG')[0]] * $kriteria[array_search(getConfigValues('KRITERIA_SEDANG')[0], array_column($kriteria, 'kriteria'))]['bobot'];

      $roc_utility[$key][getConfigValues('KRITERIA_RUSAK_RINGAN')[0]] = $val[getConfigValues('KRITERIA_RUSAK_RINGAN')[0]] * $kriteria[array_search(getConfigValues('KRITERIA_RUSAK_RINGAN')[0], array_column($kriteria, 'kriteria'))]['bobot'];

      $roc_utility[$key][getConfigValues('KRITERIA_RUSAK_BERAT')[0]] = $val[getConfigValues('KRITERIA_RUSAK_BERAT')[0]] * $kriteria[array_search(getConfigValues('KRITERIA_RUSAK_BERAT')[0], array_column($kriteria, 'kriteria'))]['bobot'];

      $roc_utility[$key]['total'] = $roc_utility[$key][getConfigValues('KRITERIA_BAIK')[0]] + $roc_utility[$key][getConfigValues('KRITERIA_SEDANG')[0]] + $roc_utility[$key][getConfigValues('KRITERIA_RUSAK_RINGAN')[0]] + $roc_utility[$key][getConfigValues('KRITERIA_RUSAK_BERAT')[0]];

    }

    return $roc_utility;
  }

  public function rocSub($kriteria,$subkriteria,$tabel_rekap)
  {
    $roc_sub = array();
    foreach($tabel_rekap as $key => $val)
    {
      $roc_sub[$key]['id_master_jalan'] = $val['id_master_jalan'];
      $roc_sub[$key]['no_ruas'] = $val['no_ruas'];
      $roc_sub[$key]['nama_jalan'] = $val['nama_jalan'];
      $roc_sub[$key]['kec'] = $val['kec'];
      foreach($subkriteria as $key1 => $sub)
      {
        foreach($sub['sub'] as $key2 => $subsub)
        {
          if($sub['id_kriteria'] == getConfigValues('KRITERIA_BAIK')[0])
          {
            $prosentase_kriteria_baik = number_format(($val[$sub['id_kriteria']] / $val['total_length']) * 100,2);

            if($prosentase_kriteria_baik >= pecah($subsub['sub_kriteria'])[0] && $prosentase_kriteria_baik <= pecah($subsub['sub_kriteria'])[1])
            {
              $roc_sub[$key][$sub['id_kriteria']] = $subsub['bobot'];
            }
          }

          if($sub['id_kriteria'] == getConfigValues('KRITERIA_SEDANG')[0])
          {
            $prosentase_kriteria_baik = number_format(($val[$sub['id_kriteria']] / $val['total_length']) * 100,2);

            if($prosentase_kriteria_baik >= pecah($subsub['sub_kriteria'])[0] && $prosentase_kriteria_baik <= pecah($subsub['sub_kriteria'])[1])
            {
              $roc_sub[$key][$sub['id_kriteria']] = $subsub['bobot'];
            }
          }

          if($sub['id_kriteria'] == getConfigValues('KRITERIA_RUSAK_RINGAN')[0])
          {
            $prosentase_kriteria_baik = number_format(($val[$sub['id_kriteria']] / $val['total_length']) * 100,2);

            if($prosentase_kriteria_baik >= pecah($subsub['sub_kriteria'])[0] && $prosentase_kriteria_baik <= pecah($subsub['sub_kriteria'])[1])
            {
              $roc_sub[$key][$sub['id_kriteria']] = $subsub['bobot'];
            }
          }

          if($sub['id_kriteria'] == getConfigValues('KRITERIA_RUSAK_BERAT')[0])
          {
            $prosentase_kriteria_baik = number_format(($val[$sub['id_kriteria']] / $val['total_length']) * 100,2);

            if($prosentase_kriteria_baik >= pecah($subsub['sub_kriteria'])[0] && $prosentase_kriteria_baik <= pecah($subsub['sub_kriteria'])[1])
            {
              $roc_sub[$key][$sub['id_kriteria']] = $subsub['bobot'];
            }
          }
        }
      }
    }
    return $roc_sub;
  }

  public function kriteria()
  {
    $sql = "SELECT * FROM kriteria";
    $data = $this->db->query($sql);

    $W = $this->bobot($data->num_rows());

    $kriteria = array();

    foreach($data->result_array() as $key => $val)
    {
      if(array_key_exists($val['rangking'],$W) == true)
      {
        $kriteria[$key]['id_kriteria'] = $val['id'];
        $kriteria[$key]['rangking'] = $val['rangking'];
        $kriteria[$key]['bobot'] = $W[$val['rangking']];
      }
    }

    return $kriteria;
  }

  public function subkriteria($kriteria)
  {
    $sql = "SELECT * FROM sub_kriteria";
    $data_sub = $this->db->query($sql);

    $Ws = $this->bobot($data_sub->num_rows());

    $subkriteria = array();

    foreach($kriteria as $key => $val)
    {
      $subkriteria[$key]['id_kriteria'] = $val['id_kriteria'];
      foreach($data_sub->result_array() as $key1 => $sub)
      {
        if(array_key_exists($sub['rangking'],$Ws) == true)
        {
          $subkriteria[$key]['sub'][$key1]['sub_kriteria'] = $sub['sub_kriteria'];
          $subkriteria[$key]['sub'][$key1]['rangking'] = $sub['rangking'];
          $subkriteria[$key]['sub'][$key1]['bobot'] = $Ws[$sub['rangking']];
        }
      }
    }
    return $subkriteria;
  }

  public function rekapitulasiJalan()
  {
        $tabel_rekap = array();

    $sql = "SELECT * FROM master_jalan";
    $data_jalan = $this->db->query($sql);

    if($data_jalan->num_rows() > 0)
    {
      foreach($data_jalan->result_array() as $key => $val)
      {
        $tabel_rekap[$key]['id_master_jalan'] = $val['id'];
        $tabel_rekap[$key]['no_ruas'] = $val['no_ruas'];
        $tabel_rekap[$key]['nama_jalan'] = $val['prefiks'].' '.$val['nama_jalan'];  
        $tabel_rekap[$key]['kec'] = $val['kec'];
        $tabel_rekap[$key]['total_length'] = $val['total_length'];

        $sql = "SELECT * FROM detail_master_jalan WHERE master_jalan_id = '".$val['id']."'";
        $data_detail_jalan = $this->db->query($sql);
        if($data_detail_jalan->num_rows() > 0)
        {
          foreach($data_detail_jalan->result_array() as $key1 => $value)
          {
            $get_kriteria = $this->db->query("SELECT * FROM kriteria WHERE id='".$value['kriteria_id']."' LIMIT 1");
            if($get_kriteria->num_rows() > 0)
            {
              if($get_kriteria->result_array()[0]['id'] == $value['kriteria_id'])
              {
                $tabel_rekap[$key][$get_kriteria->result_array()[0]['id']] = $value['length'];
              }
            }
          }
        }
      }
    }
    return $tabel_rekap;
  }

  function bobot($num_rows)
    {
        $count = $num_rows;
        $W = array();
        $k = array();

        for($i = 1 ; $i <= $count; $i++)
        {
            for($j = $i ; $j <= $count; $j++)
            {
                $k[$i][$j] = 1 / $j;
            }
            $W[$i] = array_sum($k[$i]) / $count;
        }
        // dd('test');

        return $W;
    }

    public function export_to_excel()
    {
      include APPPATH.'third_party/PHPExcel/PHPExcel.php';
      $excel = new PHPExcel();
      $excel->getProperties()->setCreator('SMARTER ROC')
      ->setLastModifiedBy('SMARTER ROC')
      ->setTitle("SPK SMARTER ROC")
      ->setSubject("SPK")
      ->setDescription("Laporan Excel SPK")
      ->setKeywords("SPK");

      $style_col = array(
        'font' => array('bold' => true),
        'alignment' => array(
          'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
          'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER
        ),
        'borders' => array(
          'top' => array('style'  => PHPExcel_Style_Border::BORDER_THIN),
          'right' => array('style'  => PHPExcel_Style_Border::BORDER_THIN),
          'bottom' => array('style'  => PHPExcel_Style_Border::BORDER_THIN),
          'left' => array('style'  => PHPExcel_Style_Border::BORDER_THIN),
        )
      );

      $style_row = array(
        'alignment' => array(
          'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER
        ),
        'borders' => array(
          'top' => array('style'  => PHPExcel_Style_Border::BORDER_THIN),
          'right' => array('style'  => PHPExcel_Style_Border::BORDER_THIN),
          'bottom' => array('style'  => PHPExcel_Style_Border::BORDER_THIN),
          'left' => array('style'  => PHPExcel_Style_Border::BORDER_THIN)
        ),
      );

        $excel->setActiveSheetIndex(0)->setCellValue('A1', "Laporan Analisis SPK SMARTER ROC");
        $excel->getActiveSheet()->mergeCells('A1:J1');
        $excel->getActiveSheet()->getStyle('A1')->getFont()->setBold(TRUE);
        $excel->getActiveSheet()->getStyle('A1')->getFont()->setSize(15);
        $excel->getActiveSheet()->getStyle('A1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        

        $excel->setActiveSheetIndex(0)->setCellValue('A3', "No");
        $excel->getActiveSheet()->mergeCells('A3:A4');
        $excel->setActiveSheetIndex(0)->setCellValue('B3', "No Ruas");
        $excel->getActiveSheet()->mergeCells('B3:B4');
        $excel->setActiveSheetIndex(0)->setCellValue('C3', "Nama Jalan");
        $excel->getActiveSheet()->mergeCells('C3:C4');
        $excel->setActiveSheetIndex(0)->setCellValue('D3', "Kecamatan");
        $excel->getActiveSheet()->mergeCells('D3:D4');
        $excel->setActiveSheetIndex(0)->setCellValue('E3', "Kondisi Jalan");
        $excel->getActiveSheet()->mergeCells('E3:H3');
        $excel->setActiveSheetIndex(0)->setCellValue('E4', "Kondisi Baik");
        $excel->setActiveSheetIndex(0)->setCellValue('F4', "Kondisi Sedang");
        $excel->setActiveSheetIndex(0)->setCellValue('G4', "Kondisi Rusak Ringan");
        $excel->setActiveSheetIndex(0)->setCellValue('H4', "Kondisi Rusak Berat");
        $excel->setActiveSheetIndex(0)->setCellValue('I3', "Total Panjang");
        $excel->getActiveSheet()->mergeCells('I3:I4');
        $excel->setActiveSheetIndex(0)->setCellValue('J3', "Nilai ROC Utility");
        $excel->getActiveSheet()->mergeCells('J3:J4');

        $excel->getActiveSheet()->getStyle('A3')->applyFromArray($style_col);
        $excel->getActiveSheet()->getStyle('A4')->applyFromArray($style_col);
        $excel->getActiveSheet()->getStyle('B3')->applyFromArray($style_col);
        $excel->getActiveSheet()->getStyle('B4')->applyFromArray($style_col);
        $excel->getActiveSheet()->getStyle('C3')->applyFromArray($style_col);
        $excel->getActiveSheet()->getStyle('C4')->applyFromArray($style_col);
        $excel->getActiveSheet()->getStyle('D3')->applyFromArray($style_col);
        $excel->getActiveSheet()->getStyle('D4')->applyFromArray($style_col);
        $excel->getActiveSheet()->getStyle('E3')->applyFromArray($style_col);
        $excel->getActiveSheet()->getStyle('F3')->applyFromArray($style_col);
        $excel->getActiveSheet()->getStyle('G3')->applyFromArray($style_col);
        $excel->getActiveSheet()->getStyle('H3')->applyFromArray($style_col);
        $excel->getActiveSheet()->getStyle('E4')->applyFromArray($style_col);
        $excel->getActiveSheet()->getStyle('F4')->applyFromArray($style_col);
        $excel->getActiveSheet()->getStyle('G4')->applyFromArray($style_col);
        $excel->getActiveSheet()->getStyle('H4')->applyFromArray($style_col);

        $excel->getActiveSheet()->getStyle('I3')->applyFromArray($style_col);
        $excel->getActiveSheet()->getStyle('J3')->applyFromArray($style_col);
        $excel->getActiveSheet()->getStyle('I4')->applyFromArray($style_col);
        $excel->getActiveSheet()->getStyle('J4')->applyFromArray($style_col);

        $kriteria = $this->kriteria();

        $subkriteria = $this->subkriteria($kriteria);

        $tabel_rekap = $this->rekapitulasiJalan();

        $roc_sub = $this->rocSub($kriteria,$subkriteria,$tabel_rekap);

        $roc_utility = $this->rocUtility($roc_sub,$kriteria,$subkriteria);

        array_multisort(array_column($roc_utility, 'total'), SORT_ASC,array_column($roc_utility, 'nama_jalan'), SORT_ASC,$roc_utility);

        $no = 1; 
        $numrow = 5; 
        foreach($roc_utility as $key => $val){ 
          $excel->setActiveSheetIndex(0)->setCellValue('A'.$numrow, $no);
          $excel->setActiveSheetIndex(0)->setCellValue('B'.$numrow, $val['no_ruas']);
          $excel->setActiveSheetIndex(0)->setCellValue('C'.$numrow, $val['nama_jalan']);
          $excel->setActiveSheetIndex(0)->setCellValue('D'.$numrow, $val['kec']);
          $excel->setActiveSheetIndex(0)->setCellValue('E'.$numrow, get_detail_master_jalan($val['id_master_jalan'],getConfigValues('KRITERIA_BAIK')[0]));
          $excel->setActiveSheetIndex(0)->setCellValue('F'.$numrow, get_detail_master_jalan($val['id_master_jalan'],getConfigValues('KRITERIA_SEDANG')[0]));
          $excel->setActiveSheetIndex(0)->setCellValue('G'.$numrow, get_detail_master_jalan($val['id_master_jalan'],getConfigValues('KRITERIA_RUSAK_RINGAN')[0]));
          $excel->setActiveSheetIndex(0)->setCellValue('H'.$numrow, get_detail_master_jalan($val['id_master_jalan'],getConfigValues('KRITERIA_RUSAK_BERAT')[0]));

          $total_length = get_detail_master_jalan($val['id_master_jalan'],getConfigValues('KRITERIA_BAIK')[0]) + get_detail_master_jalan($val['id_master_jalan'],getConfigValues('KRITERIA_SEDANG')[0]) + get_detail_master_jalan($val['id_master_jalan'],getConfigValues('KRITERIA_RUSAK_RINGAN')[0]) + get_detail_master_jalan($val['id_master_jalan'],getConfigValues('KRITERIA_RUSAK_BERAT')[0]);

          $excel->setActiveSheetIndex(0)->setCellValue('I'.$numrow, $total_length);
          $excel->setActiveSheetIndex(0)->setCellValue('J'.$numrow, $val['total']);


          $excel->getActiveSheet()->getStyle('A'.$numrow)->applyFromArray($style_row);
          $excel->getActiveSheet()->getStyle('B'.$numrow)->applyFromArray($style_row);
          $excel->getActiveSheet()->getStyle('C'.$numrow)->applyFromArray($style_row);
          $excel->getActiveSheet()->getStyle('D'.$numrow)->applyFromArray($style_row);
          $excel->getActiveSheet()->getStyle('E'.$numrow)->applyFromArray($style_row);
          $excel->getActiveSheet()->getStyle('F'.$numrow)->applyFromArray($style_row);
          $excel->getActiveSheet()->getStyle('G'.$numrow)->applyFromArray($style_row);
          $excel->getActiveSheet()->getStyle('H'.$numrow)->applyFromArray($style_row);
          $excel->getActiveSheet()->getStyle('I'.$numrow)->applyFromArray($style_row);
          $excel->getActiveSheet()->getStyle('J'.$numrow)->applyFromArray($style_row);

          $no++;
          $numrow++;
        }
        $excel->getActiveSheet()->getColumnDimension('A')->setWidth(5);
        $excel->getActiveSheet()->getColumnDimension('B')->setWidth(10);
        $excel->getActiveSheet()->getColumnDimension('C')->setWidth(30);
        $excel->getActiveSheet()->getColumnDimension('D')->setWidth(20);
        $excel->getActiveSheet()->getColumnDimension('E')->setWidth(10);
        $excel->getActiveSheet()->getColumnDimension('F')->setWidth(10);
        $excel->getActiveSheet()->getColumnDimension('G')->setWidth(10);
        $excel->getActiveSheet()->getColumnDimension('H')->setWidth(10);
        $excel->getActiveSheet()->getColumnDimension('I')->setWidth(10);
        $excel->getActiveSheet()->getColumnDimension('J')->setWidth(20);


        $excel->getActiveSheet()->getDefaultRowDimension()->setRowHeight(-1);

        $excel->getActiveSheet()->getPageSetup()->setOrientation(PHPExcel_Worksheet_PageSetup::ORIENTATION_LANDSCAPE);
        $excel->getActiveSheet(0)->setTitle("Laporan SPK SMARTER ROC");
        $excel->setActiveSheetIndex(0);
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment; filename="laporan_spk_smarter_'.date('dmYHis').'.xlsx"');
        header('Cache-Control: max-age=0');
        $write = PHPExcel_IOFactory::createWriter($excel, 'Excel2007');
        $write->save('php://output');

        exit();

      }

}