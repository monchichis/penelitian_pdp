<?php 
class Penilaian_model extends CI_Model 
{ 
  function __construct()
  {
    parent::__construct();
  }
  public function CekHeaderSmart($current_year)
  {
    $query = $this->db->select('id')
                      ->from('header_metode_smart')
                      ->where("periode =", $current_year)
                      ->where('is_accepted',  1)
                      ->get();

    return $query->num_rows() > 0;
  }
  public function CekHeaderSaw($current_year)
  {
    $query = $this->db->select('id')
                      ->from('header_metode_saw')
                      ->where("periode =", $current_year)
                      ->where('is_accepted',  1)
                      ->get();

    return $query->num_rows() > 0;
  }
  public function CekPreviewSmart($current_year)
  {
    $query = $this->db->select('*')
              ->from('metode_smart')
              ->where('YEAR(date_created)', $current_year)
              ->where('nilai >', 0)
              ->where('ranking >', 0)
              ->get();

    return $query->num_rows() > 0;
  }
  public function CekPreview($current_year)
  {
    $query = $this->db->select('*')
              ->from('metode_saw')
              ->where('YEAR(date_created)', $current_year)
              ->where('nilai >', 0)
              ->where('ranking >', 0)
              ->get();

    return $query->num_rows() > 0;
  }
  public function batch_eliminate_alternatif($id_alternatif)
  {
      // Pastikan $id_alternatif berupa array dan tidak kosong
      if (!is_array($id_alternatif) || empty($id_alternatif)) {
          return false;
      }

      // Siapkan data untuk update batch
      $update_data = [];
      foreach ($id_alternatif as $id) {
          $update_data[] = [
              'id_alternatif'  => $id,
              'is_eliminated'  => 2
          ];
      }

      // Lakukan batch update (hanya jika ada data yang valid)
      return $this->db->update_batch('metode_saw', $update_data, 'id_alternatif');
  }
  public function batch_eliminate_alternatif_smart($id_alternatif)
  {
      // Pastikan $id_alternatif berupa array dan tidak kosong
      if (!is_array($id_alternatif) || empty($id_alternatif)) {
          return false;
      }

      // Siapkan data untuk update batch
      $update_data = [];
      foreach ($id_alternatif as $id) {
          $update_data[] = [
              'id_alternatif'  => $id,
              'is_eliminated'  => 2
          ];
      }

      // Lakukan batch update (hanya jika ada data yang valid)
      return $this->db->update_batch('metode_smart', $update_data, 'id_alternatif');
  }
  public function get_siswa_ids($limit)
  {
      $this->db->select('id_alternatif');
      $this->db->distinct();
      $this->db->from('metode_saw');
      $this->db->order_by('id_alternatif', 'ASC'); // Sesuaikan urutan jika perlu
      $this->db->limit($limit);
      return $this->db->get()->result_array();
  }
  // public function update_batch_metode_saw($data_to_update)
  // {
  //   if (empty($data_to_update)) {
  //       return false;
  //   }
    
  //   $this->db->update_batch('metode_saw', $data_to_update, 'id_alternatif');
  //   return $this->db->affected_rows() > 0;
  // }
  public function update_metode_saw($data_to_update)
  {
      if (empty($data_to_update)) {
          return false;
      }

      $affected = 0;
      foreach ($data_to_update as $data) {
          $this->db->where('id_alternatif', $data['id_alternatif']);
          $this->db->update('metode_saw', [
              'hasil_akhir' => $data['hasil_akhir'],
              'ranking' => $data['ranking']
          ]);
          $affected += $this->db->affected_rows();
      }

      return true;
  }
  public function update_metode_smart($data_to_update)
  {
      if (empty($data_to_update)) {
          return false;
      }

      $affected = 0;
      foreach ($data_to_update as $data) {
          $this->db->where('id_alternatif', $data['id_alternatif']);
          $this->db->update('metode_smart', [
              'hasil_akhir' => $data['hasil_akhir'],
              'ranking' => $data['ranking']
          ]);
          $affected += $this->db->affected_rows();
      }

      return true;
  }

  // Update cart with new data
  function update_cart($data_cart)
  {
    try {
      return $this->db->update('detail_penilaian', $data_cart);
    } catch (Exception $ex) {
      throw new Exception('Penilaian_model model : Error in update_cart function - ' . $ex);
    }  
  }
  public function header_saw($data)
  {
    try {
      $this->db->insert('header_metode_saw', $data);
      return $this->db->insert_id();
    } catch (Exception $ex) {
      throw new Exception('Penilaian_model model : Error in header_saw function - ' . $ex);
    }  
  }
  public function header_smart($data)
  {
    try {
      $this->db->insert('header_metode_smart', $data);
      return $this->db->insert_id();
    } catch (Exception $ex) {
      throw new Exception('Penilaian_model model : Error in header_smart function - ' . $ex);
    }  
  }
  
 public function update_header_saw($periode, $data)
  {
      $this->db->where('periode', $periode);
      return $this->db->update('header_metode_saw', $data);
  }
  public function update_header_smart($periode, $data)
  {
      $this->db->where('periode', $periode);
      return $this->db->update('header_metode_smart', $data);
  }
  // Add new penilaian and return the inserted ID
  public function add_penilaian($data)
  {
    try {
      $this->db->insert('penilaian', $data);
      return $this->db->insert_id();
    } catch (Exception $ex) {
      throw new Exception('Penilaian_model model : Error in add_penilaian function - ' . $ex);
    }  
  }

  // Add new detail penilaian
  public function add_detail_penilaian($data_detail)
  {
    try {
      $this->db->insert('detail_penilaian', $data_detail);
    } catch (Exception $ex) {
      throw new Exception('Penilaian_model model : Error in add_detail_penilaian function - ' . $ex);
    }
  }
  public function add_detail_penilaian_import($data_detail)
  {
    try {
      $this->db->insert_batch('detail_penilaian', $data_detail);
    } catch (Exception $ex) {
      throw new Exception('Penilaian_model model : Error in add_detail_penilaian function - ' . $ex);
    }
  }
  public function get_min_max_saw()
  {
      $result = $this->db->query("SELECT 
                                      k.id AS id_kriteria, 
                                      k.nama_kriteria,
                                      MIN(sk.nilai) AS nilai_min,
                                      MAX(sk.nilai) AS nilai_max
                                  FROM detail_penilaian dp
                                  JOIN penilaian p ON dp.id_penilaian = p.id
                                  JOIN subkriteria sk ON dp.id_subkriteria = sk.id
                                  JOIN kriteria k ON sk.id_kriteria = k.id
                                  WHERE dp.is_cart = 1
                                  AND YEAR(p.date_created) = YEAR(CURDATE())
                                  GROUP BY k.id, k.nama_kriteria")->result_array();
      
      // Konversi array hasil query menjadi array asosiatif dengan id_kriteria sebagai key
      $min_max_data = [];
      foreach ($result as $row) {
          $min_max_data[$row['id_kriteria']] = [
              'nama_kriteria' => $row['nama_kriteria'],
              'nilai_min' => $row['nilai_min'],
              'nilai_max' => $row['nilai_max']
          ];
      }

      return $min_max_data; // Mengembalikan data dalam bentuk array dengan id_kriteria sebagai key
  }

  public function get_min_max_smart()
  {
      $result = $this->db->query("SELECT 
                                      k.id AS id_kriteria, 
                                      k.nama_kriteria,
                                      MIN(sk.nilai) AS nilai_min,
                                      MAX(sk.nilai) AS nilai_max
                                  FROM detail_penilaian dp
                                  JOIN penilaian p ON dp.id_penilaian = p.id
                                  JOIN subkriteria sk ON dp.id_subkriteria = sk.id
                                  JOIN kriteria k ON sk.id_kriteria = k.id
                                  WHERE dp.is_cart = 1
                                  AND YEAR(p.date_created) = YEAR(CURDATE())
                                  GROUP BY k.id, k.nama_kriteria")->result_array();
      
      // Konversi array hasil query menjadi array asosiatif dengan id_kriteria sebagai key
      $min_max_data = [];
      foreach ($result as $row) {
          $min_max_data[$row['id_kriteria']] = [
              'nama_kriteria' => $row['nama_kriteria'],
              'nilai_min' => $row['nilai_min'],
              'nilai_max' => $row['nilai_max']
          ];
      }

      return $min_max_data; // Mengembalikan data dalam bentuk array dengan id_kriteria sebagai key
  }

  // Get all penilaian details
  public function get_all_penilaian()
  {
    $this->db->select('detail_penilaian.id, alternatif.id as id_alternatif, alternatif.nama_siswa, kriteria.nama_kriteria, kriteria.bobot, kriteria.type, subkriteria.nama_subkriteria, subkriteria.nilai, kriteria.id as id_kriteria');
    $this->db->from('alternatif');
    $this->db->join('detail_penilaian', 'alternatif.id = detail_penilaian.id_alternatif');
    $this->db->join('penilaian', 'penilaian.id = detail_penilaian.id_penilaian');
    $this->db->join('kriteria', 'kriteria.id = detail_penilaian.id_kriteria');
    $this->db->join('subkriteria', 'subkriteria.id = detail_penilaian.id_subkriteria');
    $this->db->where('is_cart', '0');
    
    $query = $this->db->get();
    return $query->result_array();
  }
  public function get_all_penilaian_report()
  {
    $this->db->select('detail_penilaian.id, alternatif.nama_siswa, kriteria.nama_kriteria, kriteria.bobot, kriteria.type, subkriteria.nama_subkriteria, subkriteria.nilai, kriteria.id as id_kriteria, kriteria.bobot, penilaian.date_created, alternatif.id as id_alternatif');
    $this->db->from('alternatif');
    $this->db->join('detail_penilaian', 'alternatif.id = detail_penilaian.id_alternatif');
    $this->db->join('penilaian', 'penilaian.id = detail_penilaian.id_penilaian');
    $this->db->join('kriteria', 'kriteria.id = detail_penilaian.id_kriteria');
    $this->db->join('subkriteria', 'subkriteria.id = detail_penilaian.id_subkriteria');
    $this->db->where('is_cart', '1');
    $this->db->where('YEAR(penilaian.date_created)', date('Y'));
    $query = $this->db->get();
    return $query->result_array();
  }
  // public function preview_penilaian($current_year)
  // {
  //   return $this->db->query("SELECT DISTINCT alternatif.id as id_alternatif, alternatif.nama_siswa, metode_saw.hasil_akhir, metode_saw.ranking
  //                               FROM alternatif
  //                               JOIN metode_saw ON metode_saw.id_alternatif = alternatif.id
  //                               JOIN header_metode_saw ON metode_saw.id_header_saw = header_metode_saw.id
  //                               WHERE header_metode_saw.periode = '$current_year' AND metode_saw.is_eliminated = 0 AND header_metode_saw.is_accepted = 1
  //                               ORDER BY hasil_akhir DESC")->result_array();
  // }
  public function preview_penilaian($current_year)
  {
    return $this->db->query("SELECT DISTINCT alternatif.id as id_alternatif, alternatif.nama_siswa,
       metode_saw.hasil_akhir as hasil_saw, metode_saw.ranking as ranking_saw,
       metode_smart.hasil_akhir as hasil_smart, metode_smart.ranking as ranking_smart
                              FROM alternatif
                              JOIN metode_saw ON metode_saw.id_alternatif = alternatif.id
                              JOIN header_metode_saw ON metode_saw.id_header_saw = header_metode_saw.id
                              JOIN metode_smart ON metode_smart.id_alternatif = alternatif.id
                              JOIN header_metode_smart ON metode_smart.id_header_smart = header_metode_smart.id
                              WHERE header_metode_saw.periode = '$current_year' AND header_metode_smart.periode = '$current_year'
                                AND metode_saw.is_eliminated = 0 AND metode_smart.is_eliminated = 0
                                AND header_metode_saw.is_accepted = 1 AND header_metode_smart.is_accepted = 1
                              -- Mengurutkan berdasarkan hasil_smart tertinggi,
                              -- kemudian jika hasil_smart sama, urutkan berdasarkan hasil_saw tertinggi.
                              ORDER BY metode_smart.hasil_akhir DESC, metode_saw.hasil_akhir DESC")->result_array();
  }
  public function get_all_alternatif_eliminated($current_year)
  {
    return $this->db->query("SELECT DISTINCT alternatif.id as id_alternatif, alternatif.nama_siswa,
       metode_saw.hasil_akhir as hasil_saw, metode_saw.ranking as ranking_saw,
       metode_smart.hasil_akhir as hasil_smart, metode_smart.ranking as ranking_smart
                                FROM alternatif
                                JOIN metode_saw ON metode_saw.id_alternatif = alternatif.id
                                JOIN header_metode_saw ON metode_saw.id_header_saw = header_metode_saw.id
                                JOIN metode_smart ON metode_smart.id_alternatif = alternatif.id
                                JOIN header_metode_smart ON metode_smart.id_header_smart = header_metode_smart.id
                                WHERE header_metode_saw.periode = '$current_year' AND header_metode_smart.periode = '$current_year' 
                                  AND metode_saw.is_eliminated = 2 AND metode_smart.is_eliminated = 2 
                                  AND header_metode_saw.is_accepted = 1 AND header_metode_smart.is_accepted = 1
                                ORDER BY metode_smart.hasil_akhir DESC, metode_saw.hasil_akhir DESC")->result_array();
  }
  public function eliminasi($id_alternatif, $params)
  {
    try {
      $this->db->where('id_alternatif', $id_alternatif);
      return $this->db->update('metode_saw', $params);
    } catch (Exception $ex) {
      throw new Exception('Penilaian_model model : Error in eliminasi function - ' . $ex);
    }
  }
  public function eliminasi_smart($id_alternatif, $params)
  {
    try {
      $this->db->where('id_alternatif', $id_alternatif);
      return $this->db->update('metode_smart', $params);
    } catch (Exception $ex) {
      throw new Exception('Penilaian_model model : Error in eliminasi function - ' . $ex);
    }
  }
  public function restore_data($id_alternatif)
  {
      $this->db->where_in('id_alternatif', $id_alternatif);
      $this->db->update('metode_saw', ['is_eliminated' => 0]);
  }
  public function restore_data_smart($id_alternatif)
  {
      $this->db->where_in('id_alternatif', $id_alternatif);
      $this->db->update('metode_smart', ['is_eliminated' => 0]);
  }

  public function filter_get_all_penilaian_report($current_year)
  {
    $this->db->select('detail_penilaian.id, alternatif.nama_siswa, kriteria.nama_kriteria, kriteria.bobot, kriteria.type, subkriteria.nama_subkriteria, subkriteria.nilai, kriteria.id as id_kriteria, kriteria.bobot, penilaian.date_created, alternatif.id as id_alternatif');
    $this->db->from('alternatif');
    $this->db->join('detail_penilaian', 'alternatif.id = detail_penilaian.id_alternatif');
    $this->db->join('penilaian', 'penilaian.id = detail_penilaian.id_penilaian');
    $this->db->join('kriteria', 'kriteria.id = detail_penilaian.id_kriteria');
    $this->db->join('subkriteria', 'subkriteria.id = detail_penilaian.id_subkriteria');
    $this->db->where('is_cart', '1');
    $this->db->where('YEAR(penilaian.date_created)', $current_year);
    $query = $this->db->get();
    return $query->result_array();
  }
  public function get_min($id_kriteria)
  {
    return $this->db->query("SELECT MIN(nilai) as min FROM subkriteria WHERE id_kriteria = '$id_kriteria'")->row_array();
  }
  public function get_max($id_kriteria)
  {
    return $this->db->query("SELECT MAX(nilai) as max FROM subkriteria WHERE id_kriteria = '$id_kriteria'")->row_array();
  }

  // Delete detail penilaian by ID
  public function delete_detail_penilaian($id_alternatif)
  {
    $this->db->where('id_alternatif', $id_alternatif);
    $this->db->delete('detail_penilaian');
  }

  // Get all alternatif
  public function get_all_alternatif() 
  {
    return $this->db->get('alternatif')->result_array();
  }

  // Get all kriteria
  public function get_all_kriteria() 
  {
    return $this->db->get('kriteria')->result_array();
  }

  // Get all detail penilaian
  public function get_all_detailpenilaian() 
  {
    return $this->db->get('detail_penilaian')->result_array();
  }

  // Check if all alternatif are filled
  public function is_all_alternatif_filled() 
  {
    $alternatif = $this->get_all_alternatif();
    $kriteria = $this->get_all_kriteria();

    foreach ($alternatif as $alt) {
      $penilaian = $this->db->where('id_alternatif', $alt['id'])->get('detail_penilaian')->result_array();

      if (count($penilaian) != count($kriteria)) {
        return false;
      }
    }

    return true;
  }

  // Insert batch data into metode_saw table
  public function metode_saw($data)
  {
    $this->db->insert_batch('metode_saw', $data);

    if ($this->db->affected_rows() > 0) {
      return true; // Success
    } else {
      return false; // Failure
    }
  }
  // Insert batch data into metode_saw table
  public function metode_smart($data)
  {
    $this->db->insert_batch('metode_smart', $data);

    if ($this->db->affected_rows() > 0) {
      return true; // Success
    } else {
      return false; // Failure
    }
  }
  // Fungsi untuk memeriksa apakah penilaian sudah ada berdasarkan tahun
    public function CekPenilaianExist($current_year) {
        // Query untuk memeriksa keberadaan data
        $query = $this->db->select('penilaian.id')
                          ->from('penilaian')
                          ->join('detail_penilaian', 'penilaian.id = detail_penilaian.id_penilaian')
                          ->where("detail_penilaian.is_cart", 1) // Penilaian yang belum selesai
                          ->where("YEAR(penilaian.date_created) =", $current_year)
                          ->get();

        // Mengembalikan hasil: true jika ada data, false jika tidak ada
        return $query->num_rows() > 0;
    }
}
