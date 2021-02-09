<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends MY_Controller {

	public function __construct(){

		parent::__construct();

		$this->load->library(['form_validation']);
		$this->load->helper(['url']);

		date_default_timezone_set("ASIA/JAKARTA");

	}

	public function index(){
        $sql = "SELECT * FROM kriteria";
        $data = $this->db->query($sql);

		$W = $this->bobot($data->num_rows());

        $kriteria = array();

        foreach($data->result_array() as $key => $val)
        {
            if(array_key_exists($val['rangking'],$W) == true)
            {
                $kriteria[$key]['kriteria'] = $val['kriteria'];
                $kriteria[$key]['rangking'] = $val['rangking'];
                $kriteria[$key]['bobot'] = $W[$val['rangking']];
            }
        }

        $sql = "SELECT * FROM sub_kriteria";
        $data_sub = $this->db->query($sql);

        $Ws = $this->bobot($data_sub->num_rows());

        $subkriteria = array();

        foreach($kriteria as $key => $val)
        {
            $subkriteria[$key]['kriteria'] = $val['kriteria'];
            foreach($data_sub->result_array() as $key1 => $sub)
            {
                if(array_key_exists($sub['rangking'],$Ws) == true)
                {
                    $subkriteria[$key]['sub_kriteria'][$key1] = $sub['sub_kriteria'];
                    $subkriteria[$key]['rangking'][$key1] = $sub['rangking'];
                    $subkriteria[$key]['bobot'][$key1] = $Ws[$sub['rangking']];
                }
            }
        }


        $tabel_rekap = array();

        $sql = "SELECT * FROM master_jalan";
        $data_jalan = $this->db->query($sql);

        if($data_jalan->num_rows() > 0)
        {
            foreach($data_jalan->result_array() as $key => $val)
            {
                $tabel_rekap[$key]['no_ruas'] = $val['no_ruas'];
                $tabel_rekap[$key]['nama_jalan'] = $val['prefiks'].' '.$val['nama_jalan'];  
                $tabel_rekap[$key]['kec'] = $val['kec'];

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
                                $tabel_rekap[$key][$get_kriteria->result_array()[0]['kriteria']] = $value['length'];
                            }
                        }
                    }
                }
            }
        }


        $roc_sub = array();
        foreach($tabel_rekap as $key => $val)
        {
            $roc_sub[$key]['no_ruas'] = $val['no_ruas'];
            $roc_sub[$key]['nama_jalan'] = $val['nama_jalan'];
            $roc_sub[$key]['kec'] = $val['kec'];

            foreach($subkriteria as $key1 => $sub)
            {
                foreach($sub['sub_kriteria'] as $key2 => $subsub)
                {
                    if($val['Baik'] >= pecah($subsub)[0] && $val['Baik'] <= pecah($subsub)[1])
                    {
                       $roc_sub[$key]['Baik'] = $sub['bobot'][$key2];
                   }

                   if($val['Sedang'] >= pecah($subsub)[0] && $val['Sedang'] <= pecah($subsub)[1])
                   {
                       $roc_sub[$key]['Sedang'] = $sub['bobot'][$key2];
                   }

                   if($val['Rusak Ringan'] >= pecah($subsub)[0] && $val['Rusak Ringan'] <= pecah($subsub)[1])
                   {
                       $roc_sub[$key]['Rusak Ringan'] = $sub['bobot'][$key2];
                   }

                   if($val['Rusak Berat'] >= pecah($subsub)[0] && $val['Rusak Berat'] <= pecah($subsub)[1])
                   {
                       $roc_sub[$key]['Rusak Berat'] = $sub['bobot'][$key2];
                   }
               }
            }
        }

        $roc_utility = array();

        foreach($roc_sub as $key => $val)
        {
                $roc_utility[$key]['no_ruas'] = $val['no_ruas'];
                $roc_utility[$key]['nama_jalan'] = $val['nama_jalan'];
                $roc_utility[$key]['kec'] = $val['kec'];

                $roc_utility[$key]['Baik'] = (isset($val['Baik'])?$val['Baik']:0) * $kriteria[array_search('Baik', array_column($kriteria, 'kriteria'))]['bobot'];

                $roc_utility[$key]['Sedang'] = (isset($val['Sedang'])?$val['Sedang']:0) * $kriteria[array_search('Sedang', array_column($kriteria, 'kriteria'))]['bobot'];

                $roc_utility[$key]['Rusak Ringan'] = (isset($val['Rusak Ringan'])?$val['Rusak Ringan']:0) * $kriteria[array_search('Rusak Ringan', array_column($kriteria, 'kriteria'))]['bobot'];

                $roc_utility[$key]['Rusak Berat'] = (isset($val['Rusak Berat'])?$val['Rusak Berat']:0) * $kriteria[array_search('Rusak Berat', array_column($kriteria, 'kriteria'))]['bobot'];

                $roc_utility[$key]['total'] = $roc_utility[$key]['Baik'] + $roc_utility[$key]['Sedang'] + $roc_utility[$key]['Rusak Ringan'] + $roc_utility[$key]['Rusak Berat'];
            
        }

        // array_multisort(array_column($roc_utility, 'total'), SORT_ASC,array_column($roc_utility, 'nama_jalan'), SORT_ASC,$roc_utility);


        $array['kriteria'] = $kriteria;
        $array['subkriteria'] = $subkriteria;
        $array['tabel_rekap'] = $tabel_rekap;
        $array['roc_sub'] = $roc_sub;
        $array['roc_utility'] = $roc_utility;
    
		$this->render_backend('home_developer',$array);
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
}