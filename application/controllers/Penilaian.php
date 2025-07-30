<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Penilaian extends CI_Controller {

    public function __construct() {
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

    public function index() {
        $id_user = $this->session->userdata('id_user');
		$data['title'] = 'Penilaian';
		$data['user'] = $this->db->get_where('mst_user', ['email' => $this->session->userdata('email')])->row_array();
		$data['list_user'] = $this->db->get('mst_user')->result_array();
		$data['identitas'] = $this->db->get('tbl_aplikasi')->row();
        $data['alternatif'] = $this->Alternatif_model->get_all_alternatif();
		$data['kriteria'] = $this->Kriteria_model->get_all_kriteria();
		$data['subkriteria'] = $this->Subkriteria_model->get_all_subkriteria();
		$data['penilaian'] = $this->Penilaian_model->get_all_penilaian();

		$data['all_alternatif_filled'] = $this->Penilaian_model->is_all_alternatif_filled();
		$current_year = date('Y'); // Mendapatkan tahun saat ini
		$data['penilaian_exist'] = $this->Penilaian_model->CekPenilaianExist($current_year);
		if($data['penilaian_exist'] > 0){
			$this->load->view('templates/header', $data);
			$this->load->view('templates/sidebar_admin', $data);
			$this->load->view('templates/404');
			$this->load->view('templates/footer');
			// $this->load->view('admin/penilaian/index', $data);
		} else {
			
			$this->load->view('templates/header', $data);
			$this->load->view('templates/sidebar_admin', $data);
			$this->load->view('admin/penilaian/index', $data);
			$this->load->view('templates/footer');
		}
    }
	public function import() 
	{
		if ($_SERVER['REQUEST_METHOD'] === 'POST') {
			// Validasi file CSV
			$allowed_ext = array('csv');
			$file_name = $_FILES['file']['name'];
			$file_ext = strtolower(pathinfo($file_name, PATHINFO_EXTENSION));

			if (!in_array($file_ext, $allowed_ext)) {
				$this->session->set_flashdata('msg', 'error');
				$this->session->set_flashdata('alert_msg', '<div class="alert alert-danger" role="alert">Hanya file CSV yang diizinkan.</div>');
				redirect($_SERVER['HTTP_REFERER']);
			}

			$file_path = $_FILES['file']['tmp_name'];
			if (empty($file_path)) {
				$this->session->set_flashdata('msg', 'error');
				$this->session->set_flashdata('alert_msg', '<div class="alert alert-danger" role="alert">File tidak valid atau kosong.</div>');
				redirect($_SERVER['HTTP_REFERER']);
			}

			if (($handle = fopen($file_path, "r")) !== FALSE) {
				fgetcsv($handle); // Lewati header

				$insert_data = array();
				$error_messages = array();
				$data_detail = array();
				$current_year = 2022;

				// Periksa apakah sudah ada data penilaian tahun ini
				$query = $this->db->select('id')
								->from('penilaian')
								->where("YEAR(date_created)", $current_year)
								->get();

				if ($query->num_rows() > 0) {
					$existing_id = $query->row()->id;
				} else {
					// Insert data penilaian baru jika belum ada
					$data = [
						'date_created' => date('Y-m-d H:i:s')
					];
					$this->Penilaian_model->add_penilaian($data);
					$existing_id = $this->db->insert_id(); // Ambil ID yang baru saja dimasukkan
				}

				while (($row = fgetcsv($handle)) !== FALSE) {
					if (count($row) < 3) {
						$error_messages[] = "Baris tidak lengkap: Kolom kurang dari 3.";
						continue;
					}

					$id_alternatif = isset($row[0]) ? trim($row[0]) : '';
					$id_kriteria = isset($row[1]) ? trim($row[1]) : '';
					$id_subkriteria = isset($row[2]) ? trim($row[2]) : '';

					if (empty($id_alternatif) || empty($id_kriteria) || empty($id_subkriteria)) {
						$error_messages[] = "Terdapat baris dengan data kosong.";
						continue;
					}

					$data_detail[] = array(
						'id_penilaian' => $existing_id,
						'id_alternatif' => $id_alternatif,
						'id_kriteria' => $id_kriteria,
						'id_subkriteria' => $id_subkriteria
					);
				}
				
				fclose($handle);

				if (!empty($error_messages)) {
					$error_message = '<div class="alert alert-danger" role="alert">';
					$error_message .= "Terdapat kesalahan dalam file CSV:<br>";
					$error_message .= implode('<br>', $error_messages);
					$error_message .= '</div>';
					$this->session->set_flashdata('msg', 'error');
					$this->session->set_flashdata('alert_msg', $error_message);
					redirect($_SERVER['HTTP_REFERER']);
				}

				if (!empty($data_detail)) {
					$this->db->trans_start(); // Mulai transaksi
					$this->Penilaian_model->add_detail_penilaian_import($data_detail);
					$this->db->trans_complete(); // Selesaikan transaksi

					if ($this->db->trans_status() === FALSE) {
						$this->session->set_flashdata('msg', 'error');
						$this->session->set_flashdata('alert_msg', '<div class="alert alert-danger" role="alert">Terjadi kesalahan saat menyimpan data.</div>');
						redirect($_SERVER['HTTP_REFERER']);
					}

					$this->session->set_flashdata('msg', 'simpan');
					$this->session->set_flashdata('alert_msg', '<div class="alert alert-success" role="alert">Data berhasil diimpor.</div>');
					redirect('penilaian');
				} else {
					$this->session->set_flashdata('msg', 'error');
					$this->session->set_flashdata('alert_msg', '<div class="alert alert-danger" role="alert">Gunakan template yang sudah disediakan.</div>');
					redirect('penilaian');
				}
			} else {
				$this->session->set_flashdata('msg', 'error');
				$this->session->set_flashdata('alert_msg', '<div class="alert alert-danger" role="alert">Gagal membaca file CSV.</div>');
				redirect($_SERVER['HTTP_REFERER']);
			}
		} else {
			show_404();
		}
	}


	public function check_filled() {
		if ($this->Penilaian_model->is_all_alternatif_filled()) {
			echo json_encode(true);
		} else {
			echo json_encode(false);
		}
	}
	public function getSubkriteriaByKriteria()
	{
		/**
		 * Mengambil ID kriteria dari input POST, mengambil semua subkriteria yang terkait dengan kriteria tersebut
		 * dari model Subkriteria, dan mengembalikan data dalam format JSON.
		 *
		 * @return void
		 */
		$id_kriteria = $this->input->post('id_kriteria');
		$data = $this->Subkriteria_model->get_all_subkriteria_by_kriteria($id_kriteria);
		echo json_encode($data);
	}

	public function add()
	{
		// Ambil input dari form
		$id_alternatif = $this->input->post('id_alternatif');
		$id_kriteria = $this->input->post('id_kriteria');
		$id_subkriteria = $this->input->post('id_subkriteria');

		// Validasi input
		if (empty($id_alternatif) || empty($id_kriteria) || empty($id_subkriteria)) {
			$this->session->set_flashdata('msg','error');
			$this->session->set_flashdata('alert_msg', '<div class="alert alert-danger text-center">Silahkan isi semua.</div>');
			redirect('penilaian');
			return;
		}

		// Periksa apakah alternatif sudah mengisi kriteria yang sama
		$query = $this->db->select('*')
						->from('detail_penilaian')
						->where('id_alternatif', $id_alternatif)
						->where('id_kriteria', $id_kriteria)
						->get();

		if ($query->num_rows() > 0) {
			// Jika kombinasi id_alternatif dan id_kriteria sudah ada, tampilkan pesan error
			$this->session->set_flashdata('msg','error');
			$this->session->set_flashdata('alert_msg', '<div class="alert alert-danger text-center">Alternatif ini sudah mengisi kriteria yang sama</div>');
			redirect('penilaian');
			return;
		}

		// Mulai transaksi
		$this->db->trans_start();

		// Periksa apakah ada data penilaian pada tahun sekarang
		$current_year = date('Y'); // Mendapatkan tahun saat ini

		$query = $this->db->select('id')
						->from('penilaian')
						->where("YEAR(date_created) = $current_year")
						->get();

		if ($query->num_rows() > 0) {
			// Jika data ditemukan, gunakan ID yang sudah ada
			$existing_id = $query->row()->id;
		} else {
			// Jika tidak ada data, buat data baru di tabel penilaian
			$data = [
				'date_created' => date('Y-m-d H:i:s')
			];
			$this->Penilaian_model->add_penilaian($data);
			$existing_id = $this->db->insert_id(); // Dapatkan ID baru
		}

		// Simpan data ke tabel detail_penilaian
		$data_detail = [
			'id_penilaian' => $existing_id,
			'id_alternatif' => $id_alternatif,
			'id_kriteria' => $id_kriteria,
			'id_subkriteria' => $id_subkriteria,
			'is_cart' => 0 // Default value for is_cart
		];
		$this->Penilaian_model->add_detail_penilaian($data_detail);

		// Selesai transaksi
		$this->db->trans_complete();

		if ($this->db->trans_status() === FALSE) {
			// Jika transaksi gagal, tampilkan pesan error
			$this->session->set_flashdata('msg','error');
			$this->session->set_flashdata('alert_msg', '<div class="alert alert-danger text-center">Gagal menyimpan data.</div>');
		} else {
			// Jika berhasil, tampilkan pesan sukses
			$this->session->set_flashdata('msg', 'simpan');
			$this->session->set_flashdata('alert_msg', '<div class="alert alert-success text-center">Berhasil menyimpan data.</div>');
		}

		// Redirect ke halaman penilaian
		redirect('penilaian');
	}

	public function delete($id_alternatif)
	{
		// $this->Penilaian_model->delete_detail_penilaian($id);
		$this->Penilaian_model->delete_detail_penilaian($id_alternatif);
		$this->session->set_flashdata('msg', 'hapus');
		$this->session->set_flashdata('alert_msg', '<div class="alert alert-warning text-center">Berhasil menghapus.</div>');
		// Redirect ke halaman penilaian
		redirect('penilaian');
	}
	public function hitung()
	{
		$data_cart =[
			'is_cart' => 1
		];
		$this->Penilaian_model->update_cart($data_cart);
		// Ambil data dari form POST
		$id_detail_penilaian = $this->input->post('id_detail_penilaian', true);
		$id_alternatif = $this->input->post('id_alternatif', true);
		$nilai = $this->input->post('nilai', true);
		$id_kriteria = $this->input->post('id_kriteria', true);
		$type_kriteria = $this->input->post('type_kriteria', true);

		// Validasi apakah ada data yang dikirim
		if (empty($id_detail_penilaian) || empty($id_alternatif) || empty($nilai) || empty($id_kriteria) || empty($type_kriteria)) {
			$this->session->set_flashdata('msg','error');
			$this->session->set_flashdata('alert_msg', '<div class="alert alert-danger text-center">Data tidak lengkap. Silakan periksa kembali.</div>');
			redirect('penilaian'); // Kembalikan ke halaman penilaian
			return;
		}
		$periode = date('Y');
		$data_header_saw = [
			'periode' => $periode,
		];
		$this->Penilaian_model->header_saw($data_header_saw);
		$this->Penilaian_model->header_smart($data_header_saw);
		$id_header_saw = $this->db->insert_id(); // Ambil ID yang baru saja dimasukkan
		// Siapkan array data untuk insert batch
		$data_to_insert = [];

		foreach ($id_detail_penilaian as $index => $id_detail) {
			$data_to_insert[] = [
				'id_detail_penilaian' => $id_detail,
				'id_header_saw' => $id_header_saw,
				'id_alternatif' => $id_alternatif[$index],
				'id_kriteria' => $id_kriteria[$index],
				'type_kriteria' => $type_kriteria[$index],
				'nilai' => $nilai[$index],
				'date_created' => date('Y-m-d H:i:s'), // Waktu saat data dibuat
			];
		}
		$data_to_insert_smart = [];

		foreach ($id_detail_penilaian as $index => $id_detail) {
			$data_to_insert_smart[] = [
				'id_detail_penilaian' => $id_detail,
				'id_header_smart' => $id_header_saw,
				'id_alternatif' => $id_alternatif[$index],
				'id_kriteria' => $id_kriteria[$index],
				'type_kriteria' => $type_kriteria[$index],
				'nilai' => $nilai[$index],
				'date_created' => date('Y-m-d H:i:s'), // Waktu saat data dibuat
			];
		}
		// Panggil model untuk menyimpan data menggunakan insert_batch
		$result = $this->Penilaian_model->metode_saw($data_to_insert);
		$result_smart = $this->Penilaian_model->metode_smart($data_to_insert_smart);
		if ($result) {
			$this->session->set_flashdata('msg', 'simpan');
			$this->session->set_flashdata('success', 'Proses perhitungan berhasil dilakukan.');
		} else {
			$this->session->set_flashdata('msg', 'error');
			$this->session->set_flashdata('alert_msg', '<div class="alert alert-danger text-center">Terjadi kesalahan saat menyimpan data.</div>');
		}
		redirect('laporan'); // Redirect ke laporan setelah hitung selesai
	}
	public function proses_eliminasi()
	{
		// Pastikan ini adalah request POST
		if ($this->input->server('REQUEST_METHOD') !== 'POST') {
			show_404();
		}

		// Ambil daftar id_alternatif yang dicentang
		$id_alternatif = $this->input->post('id_alternatif');

		// Periksa apakah ada data yang dipilih
		if (empty($id_alternatif)) {
			$this->session->set_flashdata('msg', 'error');
			$this->session->set_flashdata('alert_msg', '<div class="alert alert-danger text-center">Tidak ada data yang dipilih untuk dieliminasi.</div>');
			redirect('perbekel');
		}

		// Update status is_eliminated menjadi 1 menggunakan update batch
		$updated = $this->Penilaian_model->batch_eliminate_alternatif($id_alternatif);
		$updated_smart = $this->Penilaian_model->batch_eliminate_alternatif_smart($id_alternatif);
		if ($updated && $updated_smart) {
			$this->session->set_flashdata('msg', 'eliminasi');
			$this->session->set_flashdata('alert_msg', '<div class="alert alert-info text-center">Data berhasil dieliminasi.</div>');
		} else {
			$this->session->set_flashdata('msg', 'error');
			$this->session->set_flashdata('alert_msg', '<div class="alert alert-danger text-center">Gagal mengeliminasi data.</div>');
		}

		// Redirect kembali ke halaman utama
		redirect('perbekel');
	}
	public function proses_restore()
	{
		$this->load->model('Penilaian_model');

		$id_alternatif = $this->input->post('id_alternatif');

		if (!empty($id_alternatif)) {
			$this->Penilaian_model->restore_data($id_alternatif);
			$this->Penilaian_model->restore_data_smart($id_alternatif);
			$this->session->set_flashdata('msg','restore');
			$this->session->set_flashdata('alert_msg', '<div class="alert alert-info text-center">Eliminasi Dibatalkan.</div>');
		} else {
			$this->session->set_flashdata('msg', 'error');
			$this->session->set_flashdata('alert_msg', '<div class="alert alert-danger text-center">Pilih setidaknya satu data untuk direstore.</div>');
		}

		redirect('perbekel');
	}

	public function eliminasi($id_alternatif)
	{
		$params = array(
                    'is_eliminated' => 2
                );
		$this->Penilaian_model->eliminasi($id_alternatif, $params);
		$this->Penilaian_model->eliminasi_smart($id_alternatif, $params);
		$this->session->set_flashdata('msg','eliminasi');
		$this->session->set_flashdata('alert_msg', '<div class="alert alert-warning text-center">Berhasil menghapus.</div>');
		redirect('perbekel'); 
	}
	public function restore($id_alternatif)
	{
		$params = array(
                    'is_eliminated' => 0
                );
		$this->Penilaian_model->eliminasi($id_alternatif, $params);
		$this->Penilaian_model->eliminasi_smart($id_alternatif, $params);
		$this->session->set_flashdata('msg','restore');
		$this->session->set_flashdata('alert_msg', '<div class="alert alert-info text-center">Eliminasi Dibatalkan.</div>');
		redirect('perbekel'); 
	}
	public function final()
    {
        // Pastikan request adalah POST
        if ($this->input->method() !== 'post') {
            redirect(base_url('laporan')); // Redirect if not a POST request
        }

        // Ambil data dari input tersembunyi
        $id_alternatif_saw = $this->input->post('id_alternatif_saw');
        $nilai_saw = $this->input->post('nilai_saw');
        $ranking_saw = $this->input->post('ranking_saw');

        $id_alternatif_smart = $this->input->post('id_alternatif_smart');
        $nilai_smart = $this->input->post('nilai_smart');
        $ranking_smart = $this->input->post('ranking_smart');
		

		// Pastikan tahun saat ini untuk update
		if (!is_numeric(date('Y'))) {
			$this->session->set_flashdata('alert_msg', '<div class="alert alert-danger" role="alert">Tahun tidak valid.</div>');
			redirect(base_url('laporan'));
			return;
		}

		// Hentikan eksekusi jika ada error
		if (!$this->db->conn_id) {
			show_error('Database connection failed.');
		}
		
        $current_year = date('Y'); // Mendapatkan tahun saat ini
        $now = date('Y-m-d H:i:s'); // Untuk kolom date_created
		// --- Perbaikan: Tentukan rentang tanggal untuk tahun saat ini ---
		$start_of_year = $current_year . '-01-01 00:00:00';
		$end_of_year = $current_year . '-12-31 23:59:59';
        // Inisialisasi status operasi
        $saw_updated = false;
        $smart_updated = false;

        // --- Proses Update Header SAW ---
        // Asumsi: Header untuk tahun ini sudah ada. Jika tidak, proses update detail akan bermasalah.
        // Anda perlu memastikan header_metode_saw untuk $current_year ada sebelum ini dijalankan.
        $header_saw_id = 0;
        $existing_header_saw = $this->db->get_where('header_metode_saw', ['periode' => $current_year])->row();

        if ($existing_header_saw) {
            $header_saw_id = $existing_header_saw->id; // Ambil ID header yang sudah ada
            $header_saw_data = ['is_accepted' => 1]; // Hanya update is_accepted
            $this->db->where('id', $header_saw_id); // Update berdasarkan ID primary key
            $this->db->update('header_metode_saw', $header_saw_data);
        } else {
            // Jika header tidak ada, ini adalah kondisi error karena kita hanya UPDATE
            // Anda mungkin ingin menampilkan pesan error atau redirect.
            $this->session->set_flashdata('alert_msg', '<div class="alert alert-warning" role="alert">Header SAW untuk tahun ini belum ada. Gagal menyimpan hasil.</div>');
            redirect(base_url('laporan'));
            return; // Hentikan eksekusi
        }

        // --- Proses Update untuk Metode SAW (detail) ---
        if (!empty($id_alternatif_saw) && is_array($id_alternatif_saw)) {
            foreach ($id_alternatif_saw as $key => $alt_id) {
                $data_saw_detail = [
                    'id_header_saw' => $header_saw_id, // Link ke header
                    'hasil_akhir' => $nilai_saw[$key],
                    'ranking' => $ranking_saw[$key],
                    'date_created' => $now // Perbarui date_created untuk indikasi waktu update
                ];
                
                // Kondisi WHERE: id_alternatif dan YEAR(date_created) saat ini
                // Pastikan ada baris yang sesuai untuk diupdate
                $this->db->where('id_alternatif', $alt_id);
                // Menggunakan YEAR(date_created) untuk mencocokkan tahun
                // $this->db->where("YEAR(date_created) = '$current_year'"); 
				$this->db->where('date_created >=', $start_of_year);
            	$this->db->where('date_created <=', $end_of_year);
                $this->db->update('metode_saw', $data_saw_detail);
				
                if ($this->db->affected_rows() > 0) {
                    $saw_updated = true;
                }
            }
        }

        // --- Proses Update Header SMART ---
        $header_smart_id = 0;
        $existing_header_smart = $this->db->get_where('header_metode_smart', ['periode' => $current_year])->row();

        if ($existing_header_smart) {
            $header_smart_id = $existing_header_smart->id;
            $header_smart_data = ['is_accepted' => 1];
            $this->db->where('id', $header_smart_id);
            $this->db->update('header_metode_smart', $header_smart_data);
        } else {
            // Jika header tidak ada, ini adalah kondisi error karena kita hanya UPDATE
            $this->session->set_flashdata('alert_msg', '<div class="alert alert-warning" role="alert">Header SMART untuk tahun ini belum ada. Gagal menyimpan hasil.</div>');
            redirect(base_url('laporan'));
            return; // Hentikan eksekusi
        }

        // --- Proses Update untuk Metode SMART (detail) ---
        if (!empty($id_alternatif_smart) && is_array($id_alternatif_smart)) {
            foreach ($id_alternatif_smart as $key => $alt_id) {
                $data_smart_detail = [
                    'id_header_smart' => $header_smart_id, // Link ke header
                    'hasil_akhir' => $nilai_smart[$key],
                    'ranking' => $ranking_smart[$key],
                    'date_created' => $now // Perbarui date_created
                ];

                $this->db->where('id_alternatif', $alt_id);
                // $this->db->where("YEAR(date_created) = '$current_year'");
				$this->db->where('date_created >=', $start_of_year);
            $this->db->where('date_created <=', $end_of_year);
                $this->db->update('metode_smart', $data_smart_detail);
				
                if ($this->db->affected_rows() > 0) {
                    $smart_updated = true;
                }
            }
        }
		
        // Pesan feedback berdasarkan hasil update
        if ($saw_updated || $smart_updated) {
            $this->session->set_flashdata('msg', 'simpan');
        } else {
            // Kondisi ini tercapai jika tidak ada baris yang diupdate sama sekali
            // yang bisa berarti id_alternatif tidak ditemukan di tahun ini,
            // atau ada masalah lain.
            $this->session->set_flashdata('alert_msg', '<div class="alert alert-warning" role="alert">Gagal memperbarui hasil akhir. Pastikan data alternatif sudah ada untuk tahun ini.</div>');
        }

        redirect(base_url('laporan'));
    }

	public function get_penilaian_by_alternatif($id_alternatif)
	{
		// Query untuk mengambil data kriteria dan subkriteria berdasarkan id_alternatif
		$this->db->select('kriteria.id as id_kriteria, kriteria.nama_kriteria, subkriteria.nama_subkriteria');
		$this->db->from('detail_penilaian');
		$this->db->join('kriteria', 'detail_penilaian.id_kriteria = kriteria.id');
		$this->db->join('subkriteria', 'detail_penilaian.id_subkriteria = subkriteria.id');
		$this->db->where('detail_penilaian.id_alternatif', $id_alternatif);
		$data = $this->db->get()->result_array();

		echo json_encode($data); // Mengembalikan data dalam format JSON
	}
	public function get_subkriteria_by_kriteria($id_kriteria)
	{
		// Query untuk mengambil subkriteria berdasarkan id_kriteria
		$this->db->select('id as id_subkriteria, nama_subkriteria, nilai');
		$this->db->from('subkriteria');
		$this->db->where('id_kriteria', $id_kriteria);
		$data = $this->db->get()->result_array();

		echo json_encode($data); // Mengembalikan data dalam format JSON
	}
	public function update_penilaian()
	{
		$id_alternatif = $this->input->post('id_alternatif');
		$subkriteria = $this->input->post('subkriteria');

		if (empty($id_alternatif) || empty($subkriteria)) {
			echo json_encode(['status' => 'error', 'message' => 'Data tidak lengkap']);
			return;
		}

		foreach ($subkriteria as $id_kriteria => $id_subkriteria) {
			if (empty($id_subkriteria)) {
				continue; // Lewati jika subkriteria tidak dipilih
			}
			$this->db->where('id_alternatif', $id_alternatif);
			$this->db->where('id_kriteria', $id_kriteria);
			$this->db->update('detail_penilaian', ['id_subkriteria' => $id_subkriteria]);
		}
		$this->session->set_flashdata('msg','edit');
		echo json_encode(['status' => 'success']);
	}

}
