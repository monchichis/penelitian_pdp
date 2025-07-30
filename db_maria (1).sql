-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Waktu pembuatan: 09 Bulan Mei 2025 pada 11.17
-- Versi server: 10.2.6-MariaDB-log
-- Versi PHP: 7.4.19

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `db_maria`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `alternatif`
--

CREATE TABLE `alternatif` (
  `id` int(11) NOT NULL,
  `nis` text NOT NULL,
  `nama_siswa` varchar(250) NOT NULL,
  `jenis_kelamin` varchar(250) NOT NULL,
  `agama` varchar(250) NOT NULL,
  `alamat` text NOT NULL,
  `tahun` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `alternatif`
--

INSERT INTO `alternatif` (`id`, `nis`, `nama_siswa`, `jenis_kelamin`, `agama`, `alamat`, `tahun`) VALUES
(1, '5102044707450000', 'NI WAYAN SANDRI', 'Perempuan', 'Hindu', 'Penarukan Kaja', 0),
(2, '5102047112640120', 'NI MADE WIRTI', 'Perempuan', 'Hindu', 'Penarukan Kaja', 0),
(3, '5102047112600110', 'NI WAYAN SUETI', 'Perempuan', 'Hindu', 'Penarukan Kaja', 0),
(4, '5102043012450010', 'I WAYAN JARWA', 'Laki-Laki', 'Hindu', 'Penarukan Kaja', 0),
(5, '5102043012450010', 'I MADE PUDNYA', 'Laki-Laki', 'Hindu', 'Penarukan Kaja', 0),
(6, '510204060967000', 'DEWA KOMANG ARIADA', 'Laki-Laki', 'Hindu', 'Penarukan Tengah Kaja', 0),
(7, '5102041008620000', 'IDA BAGUS KADE KERTAWINAYA', 'Laki-Laki', 'Hindu', 'Penarukan Tengah Kaja', 0),
(8, '5102041008620000', 'IDA BAGUS NYOMAN NARAYANA', 'Laki-Laki', 'Hindu', 'Penarukan Tengah Kaja', 0),
(9, '510204621172000', 'I WAYAN TARNI', 'Laki-Laki', 'Hindu', 'Penarukan Tengah Kelod', 0),
(10, '510204061240000', 'I GUSTI PUTU SUDAMA', 'Laki-Laki', 'Hindu', 'Penarukan Tengah Kelod', 0),
(11, '5102044405580000', 'NI NYOMAN WESI', 'Perempuan', 'Hindu', 'Penarukan Tengah Kelod', 0),
(12, '5102044405580000', 'GUSTI PUTU MERTADANA', 'Laki-Laki', 'Hindu', 'Penarukan Tengah Kelod', 0),
(13, '51020402036000', 'I WAYAN KOPER', 'Laki-Laki', 'Hindu', 'Penarukan Tengah Kelod', 0),
(14, '510204101071000', 'I WAYAN SUMARWA', 'Laki-Laki', 'Hindu', 'Penarukan Kelod', 0),
(15, '510204441170000', 'NI WAYAN PUSPASARI', 'Perempuan', 'Hindu', 'Penarukan Kelod', 0),
(16, '5102047112660040', 'NI MADE SURYANI', 'Perempuan', 'Hindu', 'Penarukan Kelod', 0),
(17, '5102047112660040', 'NI MADE SUASTENI', 'Perempuan', 'Hindu', 'Penarukan Kelod', 0),
(18, '510204471262000', 'NI MADE PASAR', 'Perempuan', 'Hindu', 'Penarukan Bantas', 0);

-- --------------------------------------------------------

--
-- Struktur dari tabel `detail_penilaian`
--

CREATE TABLE `detail_penilaian` (
  `id` int(110) NOT NULL,
  `id_penilaian` int(110) NOT NULL,
  `id_alternatif` int(110) NOT NULL,
  `id_kriteria` int(110) NOT NULL,
  `id_subkriteria` int(110) NOT NULL,
  `is_cart` int(110) NOT NULL COMMENT '0 = belum\r\n1 = sudah'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `detail_penilaian`
--

INSERT INTO `detail_penilaian` (`id`, `id_penilaian`, `id_alternatif`, `id_kriteria`, `id_subkriteria`, `is_cart`) VALUES
(1, 1, 1, 1, 4, 1),
(2, 1, 1, 2, 7, 1),
(3, 1, 1, 3, 15, 1),
(4, 1, 2, 1, 1, 1),
(5, 1, 2, 2, 5, 1),
(6, 1, 2, 3, 14, 1),
(7, 1, 3, 1, 1, 1),
(8, 1, 3, 2, 5, 1),
(9, 1, 3, 3, 13, 1),
(10, 1, 4, 1, 1, 1),
(11, 1, 4, 2, 5, 1),
(12, 1, 4, 3, 13, 1),
(13, 1, 5, 1, 1, 1),
(14, 1, 5, 2, 5, 1),
(15, 1, 5, 3, 14, 1),
(16, 1, 6, 1, 1, 1),
(17, 1, 6, 2, 5, 1),
(18, 1, 6, 3, 10, 1),
(19, 1, 7, 1, 1, 1),
(20, 1, 7, 2, 5, 1),
(21, 1, 7, 3, 14, 1),
(22, 1, 8, 1, 2, 1),
(23, 1, 8, 2, 7, 1),
(24, 1, 8, 3, 17, 1),
(25, 1, 9, 1, 1, 1),
(26, 1, 9, 2, 5, 1),
(27, 1, 9, 3, 17, 1),
(28, 1, 10, 1, 1, 1),
(29, 1, 10, 2, 7, 1),
(30, 1, 10, 3, 12, 1),
(31, 1, 11, 1, 1, 1),
(32, 1, 11, 2, 5, 1),
(33, 1, 11, 3, 13, 1),
(34, 1, 12, 1, 2, 1),
(35, 1, 12, 2, 5, 1),
(36, 1, 12, 3, 15, 1),
(37, 1, 13, 1, 1, 1),
(38, 1, 13, 2, 5, 1),
(39, 1, 13, 3, 13, 1),
(40, 1, 14, 1, 2, 1),
(41, 1, 14, 2, 7, 1),
(42, 1, 14, 3, 15, 1),
(43, 1, 15, 1, 3, 1),
(44, 1, 15, 2, 7, 1),
(45, 1, 15, 3, 14, 1),
(46, 1, 16, 1, 1, 1),
(47, 1, 16, 2, 7, 1),
(48, 1, 16, 3, 15, 1),
(49, 1, 17, 1, 1, 1),
(50, 1, 17, 2, 7, 1),
(51, 1, 17, 3, 14, 1),
(52, 1, 18, 1, 1, 1),
(53, 1, 18, 2, 5, 1),
(54, 1, 18, 3, 13, 1);

-- --------------------------------------------------------

--
-- Struktur dari tabel `header_metode_saw`
--

CREATE TABLE `header_metode_saw` (
  `id` int(11) NOT NULL,
  `is_accepted` int(11) NOT NULL COMMENT '0 = draft\r\n1 = accepted\r\n2 = reject',
  `periode` int(11) NOT NULL,
  `date_created` date NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `header_metode_saw`
--

INSERT INTO `header_metode_saw` (`id`, `is_accepted`, `periode`, `date_created`) VALUES
(1, 1, 2025, '2025-05-08');

-- --------------------------------------------------------

--
-- Struktur dari tabel `kriteria`
--

CREATE TABLE `kriteria` (
  `id` int(11) NOT NULL,
  `nama_kriteria` varchar(250) NOT NULL,
  `bobot` float NOT NULL,
  `type` int(11) NOT NULL COMMENT '1 = Benefit\r\n2 = Cost'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `kriteria`
--

INSERT INTO `kriteria` (`id`, `nama_kriteria`, `bobot`, `type`) VALUES
(1, 'Jumlah Anggota Keluarga', 25, 2),
(2, 'Kelompok Pekerjaan', 30, 1),
(3, 'Kerentanan Sosial & Ekonomi', 45, 2);

-- --------------------------------------------------------

--
-- Struktur dari tabel `metode_saw`
--

CREATE TABLE `metode_saw` (
  `id` int(11) NOT NULL,
  `id_header_saw` int(11) NOT NULL,
  `id_detail_penilaian` int(11) NOT NULL,
  `id_alternatif` int(11) NOT NULL,
  `id_kriteria` int(11) NOT NULL,
  `type_kriteria` int(11) NOT NULL,
  `nilai` int(11) NOT NULL,
  `hasil_akhir` double NOT NULL,
  `ranking` int(11) NOT NULL,
  `is_eliminated` int(11) NOT NULL COMMENT '0 = tidak\r\n1 = ya',
  `date_created` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `metode_saw`
--

INSERT INTO `metode_saw` (`id`, `id_header_saw`, `id_detail_penilaian`, `id_alternatif`, `id_kriteria`, `type_kriteria`, `nilai`, `hasil_akhir`, `ranking`, `is_eliminated`, `date_created`) VALUES
(1, 1, 1, 1, 1, 2, 4, 0.888, 3, 0, '2025-05-08 12:30:21'),
(2, 1, 2, 1, 2, 1, 3, 0.888, 3, 0, '2025-05-08 12:30:21'),
(3, 1, 3, 1, 3, 2, 3, 0.888, 3, 0, '2025-05-08 12:30:21'),
(4, 1, 4, 2, 1, 2, 1, 0.913, 2, 0, '2025-05-08 12:30:21'),
(5, 1, 5, 2, 2, 1, 4, 0.913, 2, 0, '2025-05-08 12:30:21'),
(6, 1, 6, 2, 3, 2, 4, 0.913, 2, 0, '2025-05-08 12:30:21'),
(7, 1, 7, 3, 1, 2, 1, 0.913, 2, 0, '2025-05-08 12:30:21'),
(8, 1, 8, 3, 2, 1, 4, 0.913, 2, 0, '2025-05-08 12:30:21'),
(9, 1, 9, 3, 3, 2, 4, 0.913, 2, 0, '2025-05-08 12:30:21'),
(10, 1, 10, 4, 1, 2, 1, 0.913, 2, 0, '2025-05-08 12:30:21'),
(11, 1, 11, 4, 2, 1, 4, 0.913, 2, 0, '2025-05-08 12:30:21'),
(12, 1, 12, 4, 3, 2, 4, 0.913, 2, 0, '2025-05-08 12:30:21'),
(13, 1, 13, 5, 1, 2, 1, 0.913, 2, 0, '2025-05-08 12:30:21'),
(14, 1, 14, 5, 2, 1, 4, 0.913, 2, 0, '2025-05-08 12:30:21'),
(15, 1, 15, 5, 3, 2, 4, 0.913, 2, 0, '2025-05-08 12:30:21'),
(16, 1, 16, 6, 1, 2, 1, 0.913, 2, 0, '2025-05-08 12:30:21'),
(17, 1, 17, 6, 2, 1, 4, 0.913, 2, 0, '2025-05-08 12:30:21'),
(18, 1, 18, 6, 3, 2, 4, 0.913, 2, 0, '2025-05-08 12:30:21'),
(19, 1, 19, 7, 1, 2, 1, 0.913, 2, 0, '2025-05-08 12:30:21'),
(20, 1, 20, 7, 2, 1, 4, 0.913, 2, 0, '2025-05-08 12:30:21'),
(21, 1, 21, 7, 3, 2, 4, 0.913, 2, 0, '2025-05-08 12:30:21'),
(22, 1, 22, 8, 1, 2, 2, 0.763, 7, 0, '2025-05-08 12:30:21'),
(23, 1, 23, 8, 2, 1, 3, 0.763, 7, 0, '2025-05-08 12:30:21'),
(24, 1, 24, 8, 3, 2, 3, 0.763, 7, 0, '2025-05-08 12:30:21'),
(25, 1, 25, 9, 1, 2, 1, 0.8, 6, 0, '2025-05-08 12:30:21'),
(26, 1, 26, 9, 2, 1, 4, 0.8, 6, 0, '2025-05-08 12:30:21'),
(27, 1, 27, 9, 3, 2, 3, 0.8, 6, 0, '2025-05-08 12:30:21'),
(28, 1, 28, 10, 1, 2, 1, 0.7, 8, 2, '2025-05-08 12:30:21'),
(29, 1, 29, 10, 2, 1, 3, 0.7, 8, 2, '2025-05-08 12:30:21'),
(30, 1, 30, 10, 3, 2, 3, 0.7, 8, 2, '2025-05-08 12:30:21'),
(31, 1, 31, 11, 1, 2, 1, 0.913, 2, 0, '2025-05-08 12:30:21'),
(32, 1, 32, 11, 2, 1, 4, 0.913, 2, 0, '2025-05-08 12:30:21'),
(33, 1, 33, 11, 3, 2, 4, 0.913, 2, 0, '2025-05-08 12:30:21'),
(34, 1, 34, 12, 1, 2, 2, 0.863, 4, 0, '2025-05-08 12:30:21'),
(35, 1, 35, 12, 2, 1, 4, 0.863, 4, 0, '2025-05-08 12:30:21'),
(36, 1, 36, 12, 3, 2, 3, 0.863, 4, 0, '2025-05-08 12:30:21'),
(37, 1, 37, 13, 1, 2, 1, 0.913, 2, 0, '2025-05-08 12:30:21'),
(38, 1, 38, 13, 2, 1, 4, 0.913, 2, 0, '2025-05-08 12:30:21'),
(39, 1, 39, 13, 3, 2, 4, 0.913, 2, 0, '2025-05-08 12:30:21'),
(40, 1, 40, 14, 1, 2, 2, 0.763, 7, 0, '2025-05-08 12:30:21'),
(41, 1, 41, 14, 2, 1, 3, 0.763, 7, 0, '2025-05-08 12:30:21'),
(42, 1, 42, 14, 3, 2, 3, 0.763, 7, 0, '2025-05-08 12:30:21'),
(43, 1, 43, 15, 1, 2, 3, 0.938, 1, 0, '2025-05-08 12:30:21'),
(44, 1, 44, 15, 2, 1, 3, 0.938, 1, 0, '2025-05-08 12:30:21'),
(45, 1, 45, 15, 3, 2, 4, 0.938, 1, 0, '2025-05-08 12:30:21'),
(46, 1, 46, 16, 1, 2, 1, 0.7, 8, 2, '2025-05-08 12:30:21'),
(47, 1, 47, 16, 2, 1, 3, 0.7, 8, 2, '2025-05-08 12:30:21'),
(48, 1, 48, 16, 3, 2, 3, 0.7, 8, 2, '2025-05-08 12:30:21'),
(49, 1, 49, 17, 1, 2, 1, 0.813, 5, 0, '2025-05-08 12:30:21'),
(50, 1, 50, 17, 2, 1, 3, 0.813, 5, 0, '2025-05-08 12:30:21'),
(51, 1, 51, 17, 3, 2, 4, 0.813, 5, 0, '2025-05-08 12:30:21'),
(52, 1, 52, 18, 1, 2, 1, 0.913, 2, 0, '2025-05-08 12:30:21'),
(53, 1, 53, 18, 2, 1, 4, 0.913, 2, 0, '2025-05-08 12:30:21'),
(54, 1, 54, 18, 3, 2, 4, 0.913, 2, 0, '2025-05-08 12:30:21');

-- --------------------------------------------------------

--
-- Struktur dari tabel `mst_user`
--

CREATE TABLE `mst_user` (
  `id_user` int(11) NOT NULL,
  `nama` text NOT NULL,
  `nik` text NOT NULL,
  `email` text NOT NULL,
  `password` text NOT NULL,
  `level` text NOT NULL,
  `date_created` date NOT NULL,
  `image` text NOT NULL,
  `is_active` int(2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `mst_user`
--

INSERT INTO `mst_user` (`id_user`, `nama`, `nik`, `email`, `password`, `level`, `date_created`, `image`, `is_active`) VALUES
(15, 'Maria Augeni Wingkor', '0111844', 'admin@desapenarukan.go.id', '$2y$10$VUEKgUN6JfiE.Ka7.yKXI.Arwpcvy2IP1JV.csFCQFMGYPfCbkayO', 'Admin', '2019-10-02', 'default3.png', 1),
(35, 'I PUTU RAI SUTEJA. SH.', '5555', 'perbekel@desapenarukan.go.id', '$2y$10$VUEKgUN6JfiE.Ka7.yKXI.Arwpcvy2IP1JV.csFCQFMGYPfCbkayO', 'Perbekel', '2022-03-08', 'default.png', 1);

-- --------------------------------------------------------

--
-- Struktur dari tabel `penilaian`
--

CREATE TABLE `penilaian` (
  `id` int(11) NOT NULL,
  `date_created` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `penilaian`
--

INSERT INTO `penilaian` (`id`, `date_created`) VALUES
(1, '2025-03-16 18:05:45');

-- --------------------------------------------------------

--
-- Struktur dari tabel `subkriteria`
--

CREATE TABLE `subkriteria` (
  `id` int(11) NOT NULL,
  `id_kriteria` int(11) NOT NULL,
  `nama_subkriteria` varchar(250) NOT NULL,
  `nilai` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `subkriteria`
--

INSERT INTO `subkriteria` (`id`, `id_kriteria`, `nama_subkriteria`, `nilai`) VALUES
(1, 1, '1-2 orang', 1),
(2, 1, '3-4 orang', 2),
(3, 1, '5-6 orang', 3),
(4, 1, '> = 7 orang', 4),
(5, 2, 'Tidak Bekerja', 4),
(6, 2, 'Buruh Harian Lepas', 3),
(7, 2, 'Petani/Nelayan kecil', 3),
(8, 2, 'Pekerja Informal', 2),
(9, 2, 'Pekerja Formal', 1),
(10, 3, 'Gangguan Jiwa', 4),
(11, 3, 'KK Tunggal', 3),
(12, 3, 'Lansia Istri Sakit', 3),
(13, 3, 'Lansia KK Tunggal', 4),
(14, 3, 'Miskin', 4),
(15, 3, 'Orang Tua Sakit Kronis', 3),
(16, 3, 'Orang Tua Sakit Stroke', 4),
(17, 3, 'Sakit Kronis', 3),
(18, 3, 'Suami Sakit Stroke', 4);

-- --------------------------------------------------------

--
-- Struktur dari tabel `tbl_aplikasi`
--

CREATE TABLE `tbl_aplikasi` (
  `id` int(11) NOT NULL,
  `nama_aplikasi` varchar(250) NOT NULL,
  `alamat` varchar(250) NOT NULL,
  `telp` varchar(250) NOT NULL,
  `nama_developer` varchar(250) NOT NULL,
  `logo` varchar(250) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `tbl_aplikasi`
--

INSERT INTO `tbl_aplikasi` (`id`, `nama_aplikasi`, `alamat`, `telp`, `nama_developer`, `logo`) VALUES
(1, 'SISTEM PENDUKUNG KEPUTUSAN PENENTUAN CALON PENERIMA (BLT-DD) MENGGUNAKAN METODE SAW DI DESA PENARUKAN TABANAN BALI', 'Jl. Tantra, Penarukan, Kec. Kerambitan, Kabupaten Tabanan, Bali 82161', '081238798182', 'Maria Augeni Wingkor', 'Lambang_Kabupaten_Tabanan.png');

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `alternatif`
--
ALTER TABLE `alternatif`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `detail_penilaian`
--
ALTER TABLE `detail_penilaian`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `header_metode_saw`
--
ALTER TABLE `header_metode_saw`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `kriteria`
--
ALTER TABLE `kriteria`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `metode_saw`
--
ALTER TABLE `metode_saw`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `mst_user`
--
ALTER TABLE `mst_user`
  ADD PRIMARY KEY (`id_user`);

--
-- Indeks untuk tabel `penilaian`
--
ALTER TABLE `penilaian`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `subkriteria`
--
ALTER TABLE `subkriteria`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `tbl_aplikasi`
--
ALTER TABLE `tbl_aplikasi`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `alternatif`
--
ALTER TABLE `alternatif`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT untuk tabel `detail_penilaian`
--
ALTER TABLE `detail_penilaian`
  MODIFY `id` int(110) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=55;

--
-- AUTO_INCREMENT untuk tabel `header_metode_saw`
--
ALTER TABLE `header_metode_saw`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT untuk tabel `kriteria`
--
ALTER TABLE `kriteria`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT untuk tabel `metode_saw`
--
ALTER TABLE `metode_saw`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=55;

--
-- AUTO_INCREMENT untuk tabel `mst_user`
--
ALTER TABLE `mst_user`
  MODIFY `id_user` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=40;

--
-- AUTO_INCREMENT untuk tabel `penilaian`
--
ALTER TABLE `penilaian`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT untuk tabel `subkriteria`
--
ALTER TABLE `subkriteria`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT untuk tabel `tbl_aplikasi`
--
ALTER TABLE `tbl_aplikasi`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
