<?php
defined('BASEPATH') or exit('No direct script access allowed');
date_default_timezone_set('Asia/Makassar');

class Perbekel extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		is_logged_in();

		$this->load->helper('ata');
		$this->load->helper('tglindo');
		$this->load->helper('rupiah');
		$this->load->model('Admin_model', 'admin');
		$this->load->model('User_model', 'user');
		$this->load->model('Alternatif_model');
        $this->load->model('Kriteria_model');
        $this->load->model('Subkriteria_model');
		$this->load->model('Penilaian_model');
	}
	
	public function index()
	{
		$id_user = $this->session->userdata('id_user');
        $current_year = date('Y');
		$data['title'] = 'Beranda';
		$data['user'] = $this->db->get_where('mst_user', ['email' => $this->session->userdata('email')])->row_array();
		$data['list_user'] = $this->db->get('mst_user')->result_array();
		$data['identitas'] = $this->db->get('tbl_aplikasi')->row();
		$data['jumlah_alternatif'] = $this->Alternatif_model->get_all_alternatif_count();
		$data['jumlah_kriteria'] = $this->Kriteria_model->get_all_kriteria_count();
		$data['jumlah_subkriteria'] = $this->Subkriteria_model->get_all_subkriteria_count();
		$data['alternatif'] = $this->Alternatif_model->get_all_alternatif();
        $data['kriteria'] = $this->Kriteria_model->get_all_kriteria();
		$data['preview_penilaian'] = $this->Penilaian_model->preview_penilaian($current_year);
		$data['eliminasi_alternatif'] = $this->Penilaian_model->get_all_alternatif_eliminated($current_year);
		
		 // --- Perbaikan Data untuk Grafik Highcharts (Series Terpisah) ---
		 $chart_categories = [];
		 $chart_data_rekomendasi = []; // Data untuk series Rekomendasi (biru)
		 $chart_data_tereliminasi = []; // Data untuk series Tereliminasi (merah)
 
		 // Menggabungkan data dan menandai untuk pengurutan dan pemisahan series
		 $all_alternatif_for_chart = [];
 
		 foreach ($data['preview_penilaian'] as $row) {
			 $all_alternatif_for_chart[] = [
				 'nama_siswa' => $row['nama_siswa'],
				 'hasil_akhir_chart' => $row['hasil_smart'], // Pilihlah salah satu: hasil_saw atau hasil_smart
				 'is_eliminated' => false
			 ];
		 }
 
		 foreach ($data['eliminasi_alternatif'] as $row) {
			 $all_alternatif_for_chart[] = [
				 'nama_siswa' => $row['nama_siswa'],
				 'hasil_akhir_chart' => $row['hasil_smart'], // Pilihlah salah satu: hasil_saw atau hasil_smart
				 'is_eliminated' => true
			 ];
		 }
 
		 // Urutkan data berdasarkan 'hasil_akhir_chart' secara descending
		 usort($all_alternatif_for_chart, function($a, $b) {
			 return $b['hasil_akhir_chart'] <=> $a['hasil_akhir_chart'];
		 });
 
		 // Isi categories dan data points untuk Highcharts dalam dua series terpisah
		 foreach ($all_alternatif_for_chart as $alt) {
			 $chart_categories[] = "'" . $alt['nama_siswa'] . "'";
			 
			 // Untuk setiap kategori, satu series akan memiliki nilai (dan yang lain null)
			 // agar batang grafik muncul di kategori yang sama.
			 if ($alt['is_eliminated']) {
				 $chart_data_rekomendasi[] = 'null'; // Jika tereliminasi, nilai rekomendasi adalah null
				 $chart_data_tereliminasi[] = round($alt['hasil_akhir_chart'], 2);
			 } else {
				 $chart_data_rekomendasi[] = round($alt['hasil_akhir_chart'], 2);
				 $chart_data_tereliminasi[] = 'null'; // Jika rekomendasi, nilai tereliminasi adalah null
			 }
		 }
		 
		 $data['chart_categories_json'] = implode(',', $chart_categories);
		 $data['chart_data_rekomendasi_json'] = implode(',', $chart_data_rekomendasi);
		 $data['chart_data_tereliminasi_json'] = implode(',', $chart_data_tereliminasi);

		$this->load->view('templates/header', $data);
		$this->load->view('templates/sidebar_perbekel', $data);
		$this->load->view('perbekel/index', $data);
		$this->load->view('templates/footer');
	}
	public function get_kriteria_data() {
        try {
            // Panggil model untuk mendapatkan data kriteria berdasarkan bobot
            $data = $this->Kriteria_model->get_all_kriteria_by_bobot();

            // Jika data kosong, kirim array kosong sebagai JSON
            if (empty($data)) {
                $data = [];
            }

            // Kirim data sebagai JSON
            header('Content-Type: application/json');
            echo json_encode($data);
        } catch (Exception $ex) {
            // Tangkap kesalahan dan kirim pesan kesalahan sebagai JSON
            header('Content-Type: application/json');
            echo json_encode(['error' => 'Error in Admin Controller: ' . $ex->getMessage()]);
        }
    }
	public function get_kriteria_by_type() {
		try {
			// Panggil model untuk mendapatkan data kriteria berdasarkan type
			$data = $this->Kriteria_model->get_all_kriteria_by_jenis();

			// Kelompokkan data berdasarkan type ( Benefit = 1, Cost = 2 )
			$groupedData = [
				'Benefit' => [],
				'Cost' => []
			];

			foreach ($data as $item) {
				if ($item['type'] == 1) {
					$groupedData['Benefit'][] = [
						'name' => $item['nama_kriteria'],
						'y' => floatval($item['bobot'])
					];
				} elseif ($item['type'] == 2) {
					$groupedData['Cost'][] = [
						'name' => $item['nama_kriteria'],
						'y' => floatval($item['bobot'])
					];
				}
			}

			// Kirim data sebagai JSON
			header('Content-Type: application/json');
			echo json_encode($groupedData);
		} catch (Exception $ex) {
			header('Content-Type: application/json');
			echo json_encode(['error' => 'Error in Admin Controller: ' . $ex->getMessage()]);
		}
	}
    
}
