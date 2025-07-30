<?php
defined('BASEPATH') or exit('No direct script access allowed');
date_default_timezone_set('Asia/Makassar');

class Admin extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		is_logged_in();
		is_admin();

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
		$data['kriteria_by_type'] = $this->Kriteria_model->get_all_kriteria_by_jenis();
		$data['kriteria_by_bobot'] = $this->Kriteria_model->get_all_kriteria_by_bobot();
		$data['preview_penilaian'] = $this->Penilaian_model->preview_penilaian($current_year);
		$data['eliminasi_alternatif'] = $this->Penilaian_model->get_all_alternatif_eliminated($current_year);
		$this->load->view('templates/header', $data);
		$this->load->view('templates/sidebar_admin', $data);
		$this->load->view('admin/index', $data);
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
	public function setup_aplikasi(){
		$data['title'] = 'Identitas Aplikasi';
		$data['user'] = $this->db->get_where('mst_user', ['email' => $this->session->userdata('email')])->row_array();
		$data['data_aplikasi'] = $this->db->get_where('tbl_aplikasi')->result();
		$this->load->view('templates/header', $data);
		$this->load->view('templates/sidebar_admin', $data);
		$this->load->view('admin/aplikasi/v_aplikasi', $data);
		$this->load->view('templates/footer');
	}
	public function update_aplikasi(){
		$upload_image = $_FILES['logo']['name'];
		if ($upload_image) {
			$config['allowed_types'] = 'gif|jpg|png';
			$config['max_size']     = '2048';
			$config['upload_path'] = './assets/dist/aplikasi/';
			$this->load->library('upload', $config);
			if ($this->upload->do_upload('logo')) {
				$data['data_aplikasi'] = $this->db->get_where('tbl_aplikasi')->result();
				$old_image = $data['data_aplikasi']['logo'];
				if ($old_image != 'default.png') {
					unlink(FCPATH . 'assets/dist/aplikasi/' . $old_image);
				}
				$new_image = $this->upload->data('file_name');
				$this->db->set('logo', $new_image);
			} else {
				echo $this->upload->display_errors();
			}
		}
		$id = $this->input->post('id');
		$nama_aplikasi = $this->input->post('nama_aplikasi');
		$alamat = $this->input->post('alamat');
		$telp = $this->input->post('telp');
		$nama_developer = $this->input->post('nama_developer');
		
		$this->db->set('id', $id);
		$this->db->set('nama_aplikasi', $nama_aplikasi);
		$this->db->set('alamat', $alamat);
		$this->db->set('telp', $telp);
		$this->db->set('nama_developer', $nama_developer);
		
		$this->db->update('tbl_aplikasi');
		$this->db->where('id',$id);
		$this->session->set_flashdata('message', 'Simpan Perubahan');
		redirect('admin/index');
	}
	public function edit_profile()
	{
		$upload_image = $_FILES['image']['name'];
		if ($upload_image) {
			$config['allowed_types'] = 'gif|jpg|png';
			$config['max_size']     = '2048';
			$config['upload_path'] = './assets/dist/img/profile/';
			$this->load->library('upload', $config);
			if ($this->upload->do_upload('image')) {
				$data['user'] = $this->db->get_where('mst_user', ['email' => $this->session->userdata('email')])->row_array();
				$old_image = $data['user']['image'];
				if ($old_image != 'default.png') {
					unlink(FCPATH . 'assets/dist/img/profile/' . $old_image);
				}
				$new_image = $this->upload->data('file_name');
				// $this->db->set('image', $new_image);
				$id_user = $this->session->userdata('id_user');
				$this->db->query("UPDATE mst_user set image='$new_image' WHERE id_user='$id_user'");
			} else {
				echo $this->upload->display_errors();
			}
		}
		$nama = $this->input->post('nama');
		
		// $this->db->set('nama', $nama);
		// $this->db->update('mst_user');
		// $this->db->where('id_user',$id_user);
		$id_user = $this->session->userdata('id_user');
		$this->db->query("UPDATE mst_user SET nama='$nama' WHERE id_user='$id_user'");
		$this->session->set_flashdata('message', 'Simpan Perubahan');
		redirect('admin/index');
	}

	public function ubah_password()
	{
		$current_password = $this->input->post('current_password');
		$new_password1 = $this->input->post('new_password1');
		$new_password2 = $this->input->post('new_password2');

		// Periksa apakah password baru sesuai
		if ($new_password1 !== $new_password2) {
			$this->session->set_flashdata('msg', '<div class="alert alert-danger font-weight-bolder text-center" role="alert">Ubah Password Gagal !! <br> Password baru dan konfirmasi password tidak cocok</div>');
			redirect('admin/index');
			return;
		}

		// Periksa apakah password baru sama dengan password lama
		if ($current_password == $new_password1) {
			$this->session->set_flashdata('msg', '<div class="alert alert-danger font-weight-bolder text-center" role="alert">Ubah Password Gagal !! <br> Password baru tidak boleh sama dengan password lama</div>');
			redirect('admin/index');
			return;
		}

		// Hash password baru dan simpan ke database
		$password_hash = password_hash($new_password1, PASSWORD_DEFAULT);
		$this->db->set('password', $password_hash);
		$this->db->where('id_user', $this->session->userdata('id_user'));
		$this->db->update('mst_user');

		$this->session->set_flashdata('message', 'Ubah Password');
		redirect('admin/index');
	}
	

	public function man_user()
	{
		$this->form_validation->set_rules('nama', 'Nama Lengkap', 'required|trim');
		$this->form_validation->set_rules('email', 'Alamat Email', 'required|trim|is_unique[mst_user.email]', array(
			'is_unique' => 'Alamat Email sudah ada'
		));
		$this->form_validation->set_rules('password1', 'Password', 'required|trim|min_length[3]|matches[password2]', array(
			'matches' => 'Password tidak sama',
			'min_length' => 'password min 3 karakter'
		));
		$this->form_validation->set_rules('password2', 'Password', 'required|trim|matches[password1]');
		// $this->form_validation->set_rules('level','level','required|callback_cek_level');
		// $this->form_validation->set_rules('level','level','required|callback_cek_level_admin');
		$this->form_validation->set_rules('nik','NIK','required|trim|is_unique[mst_user.nik]', array(
			'is_unique' => 'Nomor Induk Kepegawaian Sudah Digunakan'
		));
		if ($this->form_validation->run() == FALSE) {
			$data['title'] = 'Management User';
			$data['user'] = $this->db->get_where('mst_user', ['email' => $this->session->userdata('email')])->row_array();
			$data['list_user'] = $this->admin->getAllUser();
			
			

			$this->load->view('templates/header', $data);
			$this->load->view('templates/sidebar_admin', $data);
			$this->load->view('admin/master/man_user', $data);
			$this->load->view('templates/footer');
		} else {
			$data = array(
				'nama' => $this->input->post('nama', true),
				'nik' => $this->input->post('nik', true),
				
				'email' => $this->input->post('email', true),
				'level' => $this->input->post('level', true),
				'password' => password_hash($this->input->post('password1'), PASSWORD_DEFAULT),
				'date_created' => date('Y/m/d'),
				'image' => 'default.png',
				'is_active' => 1
			);
			
        	$this->db->insert('mst_user', $data);
			$this->session->set_flashdata('message', 'Tambah Data');
			
			redirect('admin/man_user');
        
			
		}
	}

	public function get_user()
	{
		$id_user = $this->input->post('id_user');
		echo json_encode($this->db->get_where('mst_user', ['id_user' => $id_user])->row_array());
	}

	public function edit_user()
	{
		$id_user = $this->input->post('id_user');
		$nama = $this->input->post('nama');
		
		$nik = $this->input->post('nik');
		$level = $this->input->post('level');
		$is_active = $this->input->post('is_active');

		$this->db->set('nama', $nama);
		
		$this->db->set('nik', $nik);
		$this->db->set('level', $level);
		$this->db->set('is_active', $is_active);
		$this->db->where('id_user', $id_user);
		$this->db->update('mst_user');
		$this->session->set_flashdata('message', 'Ubah Data');
		redirect('admin/man_user');
	}

	

	

	public function backup_database(){
        $this->load->dbutil();

        $prefs = array(     
            'format'      => 'sql',             
            'filename'    => "backupdb_gusananta_".date("Ymd-His").'.sql'
            );

        $backup =& $this->dbutil->backup($prefs); 

        $db_name = "backupdb_gusananta_".date("Ymd-His") .'.sql';
        $save = FCPATH.'assets/backupdb/'.$db_name;
        $this->load->helper('file');
        write_file($save, $backup); 


        $this->load->helper('download');
        force_download($db_name, $backup);
    }
    
}
