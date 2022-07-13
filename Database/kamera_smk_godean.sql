-- phpMyAdmin SQL Dump
-- version 4.9.0.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 14 Jul 2022 pada 01.56
-- Versi server: 10.4.6-MariaDB
-- Versi PHP: 7.3.9

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `kamera_smk_godean`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `admins`
--

CREATE TABLE `admins` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `NIP` varchar(18) COLLATE utf8mb4_unicode_ci NOT NULL,
  `alamat` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `no_tlp` varchar(15) COLLATE utf8mb4_unicode_ci NOT NULL,
  `role` enum('Admin','Petugas') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Petugas',
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `admins`
--

INSERT INTO `admins` (`id`, `name`, `email`, `password`, `NIP`, `alamat`, `no_tlp`, `role`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'Nugroho', 'admin@multi-auth.test', '$2y$10$44H2WKhjikgpFIniwIYXye2//FqL9CJqIrmGId/24qrpWTQQsikfy', '1234567890123456', 'Jalan yang sangat jauh banget', '085803956811', 'Admin', NULL, '2022-05-24 01:08:21', '2022-05-24 01:08:21'),
(3, 'Susilo', 'susilo-admin@multi-auth.test', '$2y$10$AtAbpAumyyXS07vhE.V5Te7UshdDp9GQX/46/QvTkLiQ/DtHfhAZm', '567128877728172988', 'Ring Road utara Km 11', '085803956801', 'Petugas', NULL, '2022-05-24 01:13:36', '2022-05-29 03:06:09'),
(4, 'Bery', 'bery-admin@multi-auth.test', '$2y$10$jcV0xm4IFVpiCLf0m816sOjpr5DbdpWvP77stxs9yF8wfSt2BGmMC', '123456789065432212', 'Jalan Kenangan KM 11', '084803956810', 'Petugas', NULL, '2022-05-24 01:25:12', '2022-05-29 03:05:29'),
(5, 'Fuad', 'Fuad@mail.com', '$2y$10$qVTNIAmQVKhy8gzbKCtBTO4sizFpmXxGIa4apGS8MuCmnh4WI1rii', '123456666666768883', 'Sebuah rumah yang jauh', '085803956811', 'Petugas', NULL, '2022-05-25 03:41:09', '2022-05-29 03:01:53');

-- --------------------------------------------------------

--
-- Struktur dari tabel `artikel`
--

CREATE TABLE `artikel` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `judul` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `image` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `isi` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `status_tampil` enum('ya','tidak') COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `artikel`
--

INSERT INTO `artikel` (`id`, `judul`, `image`, `isi`, `status_tampil`, `created_at`, `updated_at`) VALUES
(1, 'Promo 2', '1653360344.jpg', 'Ini coba 2', 'tidak', '2022-05-23 19:29:46', '2022-05-25 10:00:47'),
(2, 'Promo', '1653451291.jpg', 'Hari ini Promo lo\r\nAyo Sewa', 'tidak', '2022-05-25 04:01:31', '2022-06-28 02:44:38'),
(3, 'Promo Baru Ini', '1653451338.jpg', 'Kapan lagi dapat ini\r\nayo sewa\r\nmumpung murah', 'tidak', '2022-05-25 04:02:19', '2022-06-28 02:44:54'),
(4, 'Promo Baru Ini lo', '1653451388.jpg', 'Kamera ini harga sewa murah banget\r\ncuma 12000\r\nayo sewa', 'tidak', '2022-05-25 04:03:08', '2022-06-28 02:39:16');

-- --------------------------------------------------------

--
-- Struktur dari tabel `barang`
--

CREATE TABLE `barang` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `nama` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `barcode` varchar(8) COLLATE utf8mb4_unicode_ci NOT NULL,
  `image` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `harga_siswa` double(8,2) NOT NULL,
  `harga_alumni` double(8,2) NOT NULL,
  `harga_guru` double(8,2) NOT NULL,
  `harga_umum` double(8,2) NOT NULL,
  `id_katagori` smallint(5) UNSIGNED DEFAULT NULL,
  `merk` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `jumlah` int(11) NOT NULL,
  `id_kelengkapan` bigint(20) UNSIGNED DEFAULT NULL,
  `id_lokasi` smallint(5) UNSIGNED NOT NULL,
  `keterangan` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status_tampil` enum('ya','tidak') COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `barang`
--

INSERT INTO `barang` (`id`, `nama`, `barcode`, `image`, `harga_siswa`, `harga_alumni`, `harga_guru`, `harga_umum`, `id_katagori`, `merk`, `jumlah`, `id_kelengkapan`, `id_lokasi`, `keterangan`, `status_tampil`, `created_at`, `updated_at`) VALUES
(3, 'Canon 1000x', '461364', '1653399028.jpg', 12000.00, 13000.00, 14000.00, 15000.00, 9, 'Canon', 4, NULL, 4, NULL, 'ya', '2022-05-19 07:35:43', '2022-05-31 13:24:20'),
(4, 'Baterai', '870173', '1653402884.jpg', 5000.00, 3000.00, 5000.00, 30000.00, 1, 'Canon', 8, 3, 1, NULL, 'ya', '2022-05-19 07:37:31', '2022-05-25 03:08:48'),
(5, 'Charger', '547246', '1653402858.jpg', 3000.00, 4000.00, 5000.00, 6000.00, 1, 'Canon', 6, 3, 1, 'Sama dengan Kamera', 'ya', '2022-05-19 07:39:24', '2022-05-31 13:32:21'),
(6, 'Tripod Panjang', '492694', '1653403086.jpg', 13000.00, 12000.00, 12000.00, 12000.00, 6, NULL, 15, NULL, 1, NULL, 'ya', '2022-05-19 09:21:10', '2022-05-24 16:02:44'),
(7, 'Kamera', '697642', '1653448092.jpg', 12000.00, 125000.00, 11000.00, 15000.00, 9, 'Canon', 5, NULL, 3, NULL, 'ya', '2022-05-25 03:08:12', '2022-05-31 13:24:08'),
(8, 'Kamera Baru', '282722', '1656304961.jpg', 5000.00, 15000.00, 10000.00, 18000.00, 9, 'Canon', 5, NULL, 4, NULL, 'ya', '2022-06-27 04:42:42', '2022-06-27 04:42:42'),
(9, 'Kabel HDMI', '722146', '1656305069.jpg', 5000.00, 5000.00, 5000.00, 5000.00, 10, 'No merk', 3, NULL, 7, NULL, 'ya', '2022-06-27 04:44:29', '2022-06-27 04:44:29'),
(10, 'Baterai Kamera', '730156', '1656665927.jpg', 12000.00, 12000.00, 12000.00, 12000.00, 1, 'Canon', 2, 3, 1, NULL, 'ya', '2022-07-01 08:58:48', '2022-07-01 08:58:48'),
(11, 'Record', '389270', '1656666012.jpg', 12000.00, 13000.00, 14000.00, 15000.00, 3, 'nicon', 5, NULL, 7, NULL, 'ya', '2022-07-01 09:00:12', '2022-07-01 09:00:12');

-- --------------------------------------------------------

--
-- Struktur dari tabel `barang_rusak`
--

CREATE TABLE `barang_rusak` (
  `id_barang_rusak` bigint(20) UNSIGNED NOT NULL,
  `id_barang` bigint(20) UNSIGNED NOT NULL,
  `jumlah` int(11) NOT NULL,
  `keterangan` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` enum('hilang','rusak') COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `barang_rusak`
--

INSERT INTO `barang_rusak` (`id_barang_rusak`, `id_barang`, `jumlah`, `keterangan`, `status`, `created_at`, `updated_at`) VALUES
(3, 6, 4, 'Patah kaki depan', 'rusak', '2022-05-23 05:04:29', '2022-05-31 13:20:42'),
(4, 6, 4, NULL, 'rusak', '2022-05-29 02:52:00', '2022-05-29 02:52:20');

-- --------------------------------------------------------

--
-- Struktur dari tabel `denda`
--

CREATE TABLE `denda` (
  `id` smallint(5) UNSIGNED NOT NULL,
  `denda_siswa` double(10,2) NOT NULL DEFAULT 0.00,
  `denda_alumni` double(10,2) NOT NULL DEFAULT 0.00,
  `denda_guru` double(10,2) NOT NULL DEFAULT 0.00,
  `denda_umum` double(10,2) NOT NULL DEFAULT 0.00,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `denda`
--

INSERT INTO `denda` (`id`, `denda_siswa`, `denda_alumni`, `denda_guru`, `denda_umum`, `created_at`, `updated_at`) VALUES
(1, 2000.00, 6000.00, 4000.00, 10000.00, '2022-05-26 17:42:16', '2022-05-26 17:57:05');

-- --------------------------------------------------------

--
-- Struktur dari tabel `detail_alumni`
--

CREATE TABLE `detail_alumni` (
  `id_alumni` char(36) COLLATE utf8mb4_unicode_ci NOT NULL,
  `NIK` varchar(16) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `id_program_keahlian` smallint(5) UNSIGNED NOT NULL,
  `tahun_lulus` year(4) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `detail_alumni`
--

INSERT INTO `detail_alumni` (`id_alumni`, `NIK`, `id_program_keahlian`, `tahun_lulus`, `created_at`, `updated_at`) VALUES
('c037611a-b362-4e0d-956c-20a46ff5975d', '3404130905000003', 2, 2020, '2022-05-21 10:03:41', '2022-05-29 03:30:58');

-- --------------------------------------------------------

--
-- Struktur dari tabel `detail_guru`
--

CREATE TABLE `detail_guru` (
  `id_guru` char(36) COLLATE utf8mb4_unicode_ci NOT NULL,
  `NIP` varchar(18) COLLATE utf8mb4_unicode_ci NOT NULL,
  `bidang_keahlian` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `jabatan` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `detail_guru`
--

INSERT INTO `detail_guru` (`id_guru`, `NIP`, `bidang_keahlian`, `jabatan`, `created_at`, `updated_at`) VALUES
('7a0a8473-1bd3-4759-8650-4eea91a1f76b', '045550192190931931', 'akuntansi', 'tetap', '2022-05-22 09:35:56', '2022-05-29 03:38:51'),
('9aea1beb-ea22-4bc1-8862-eba2773cf476', '029029303019301990', 'Multimedia', 'Guru Besar', '2022-05-22 09:56:08', '2022-05-29 03:39:33'),
('a1e9b94a-0f63-4009-ae6e-cce4173a16c2', '019208934801828308', 'Akuntansi', 'Guru Honorer', '2022-05-19 02:52:23', '2022-05-29 03:35:21');

-- --------------------------------------------------------

--
-- Struktur dari tabel `detail_siswa`
--

CREATE TABLE `detail_siswa` (
  `id_siswa` char(36) COLLATE utf8mb4_unicode_ci NOT NULL,
  `id_program_keahlian` smallint(5) UNSIGNED NOT NULL,
  `NIS` varchar(5) COLLATE utf8mb4_unicode_ci NOT NULL,
  `Kelas` enum('X','XI','XII') COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `detail_siswa`
--

INSERT INTO `detail_siswa` (`id_siswa`, `id_program_keahlian`, `NIS`, `Kelas`, `created_at`, `updated_at`) VALUES
('0cf33883-6e97-4344-9a92-e80650e9c4d7', 1, '7400', 'X', '2022-05-27 12:48:44', '2022-05-27 12:48:44'),
('43858b4d-e5d1-419d-b04f-f8fd0b8f2046', 4, '7403', 'XI', '2022-06-27 04:54:35', '2022-06-27 04:54:35'),
('7b8b20a0-9767-467f-899e-29ce58b657bf', 2, '7401', 'X', '2022-05-19 01:40:54', '2022-05-22 08:44:19');

-- --------------------------------------------------------

--
-- Struktur dari tabel `detail_umum`
--

CREATE TABLE `detail_umum` (
  `id_umum` char(36) COLLATE utf8mb4_unicode_ci NOT NULL,
  `NIK` varchar(16) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `detail_umum`
--

INSERT INTO `detail_umum` (`id_umum`, `NIK`, `created_at`, `updated_at`) VALUES
('22b26209-fdbe-4f36-883e-9066953b1ffb', '3404130905000002', '2022-05-19 02:50:27', '2022-05-29 03:44:12'),
('aa38d207-325c-44d2-996d-dc3be01dbdd1', '3444444444444445', '2022-05-21 10:07:17', '2022-06-10 09:06:43');

-- --------------------------------------------------------

--
-- Struktur dari tabel `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uuid` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `katagori`
--

CREATE TABLE `katagori` (
  `id` smallint(5) UNSIGNED NOT NULL,
  `katagori` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `katagori`
--

INSERT INTO `katagori` (`id`, `katagori`, `created_at`, `updated_at`) VALUES
(1, 'Kelengkapan', '2022-05-18 01:07:16', '2022-05-18 01:07:16'),
(3, 'Audio', '2022-05-18 01:07:16', '2022-05-19 09:04:34'),
(6, 'Tripot', '2022-05-19 08:03:50', '2022-05-19 08:03:50'),
(8, 'Drone', '2022-05-19 09:14:48', '2022-05-19 09:14:48'),
(9, 'Kamera', '2022-05-31 13:22:50', '2022-05-31 13:22:50'),
(10, 'Kabel', '2022-06-27 04:43:29', '2022-06-27 04:43:29');

-- --------------------------------------------------------

--
-- Struktur dari tabel `kontak`
--

CREATE TABLE `kontak` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `alamat` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `jam_buka` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `wa_link` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `no_tlp` varchar(15) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `keterangan` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `kontak`
--

INSERT INTO `kontak` (`id`, `alamat`, `jam_buka`, `wa_link`, `no_tlp`, `keterangan`, `created_at`, `updated_at`) VALUES
(1, 'SMK 1 Godean', 'Senin - Sabtu\r\nJam 08.00 - 15.30', 'https://wa.me/6285803956810', '+6285803956810', 'Hari Minggu Libur ya', '2022-05-25 08:00:43', '2022-05-25 08:34:26');

-- --------------------------------------------------------

--
-- Struktur dari tabel `lokasi`
--

CREATE TABLE `lokasi` (
  `id` smallint(5) UNSIGNED NOT NULL,
  `lokasi` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `lokasi`
--

INSERT INTO `lokasi` (`id`, `lokasi`, `created_at`, `updated_at`) VALUES
(1, 'Rak 01', '2022-05-18 01:07:16', '2022-05-18 01:07:16'),
(2, 'Rak 02', '2022-05-18 01:07:16', '2022-05-18 01:07:16'),
(3, 'Rak 03', '2022-05-18 01:07:16', '2022-05-18 01:07:16'),
(4, 'Rak 04', '2022-05-18 01:07:16', '2022-05-18 01:07:16'),
(7, 'Rak 7', '2022-06-27 04:43:05', '2022-06-27 04:43:05');

-- --------------------------------------------------------

--
-- Struktur dari tabel `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2014_10_12_000000_create_users_table', 1),
(2, '2014_10_12_100000_create_password_resets_table', 1),
(3, '2019_08_19_000000_create_failed_jobs_table', 1),
(4, '2019_12_14_000001_create_personal_access_tokens_table', 1),
(6, '2022_05_07_121739_create_barang_table', 1),
(7, '2022_05_07_123737_create_katagori_table', 1),
(8, '2022_05_07_124947_create_lokasi_table', 1),
(9, '2022_05_07_140802_foreign_barang_table', 1),
(10, '2022_05_16_143555_create_program_keahlian_table', 1),
(11, '2022_05_16_145559_create_detail_siswa_table', 1),
(12, '2022_05_17_140425_create_detail_alumni_table', 1),
(13, '2022_05_17_150324_create_detail_umum_table', 1),
(14, '2022_05_17_165356_create_detail_guru_table', 1),
(16, '2022_05_23_092821_create_barang_rusak_table', 2),
(17, '2022_05_24_020756_create_artikel_table', 3),
(21, '2022_04_24_085413_create_admins_table', 4),
(22, '2022_05_24_121140_create_pesanan_table', 5),
(23, '2022_05_25_142315_create_kontak_table', 6),
(25, '2022_05_26_153907_create_sewa_table', 8),
(27, '2022_05_26_150207_create_denda_table', 9);

-- --------------------------------------------------------

--
-- Struktur dari tabel `password_resets`
--

CREATE TABLE `password_resets` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `personal_access_tokens`
--

CREATE TABLE `personal_access_tokens` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `tokenable_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tokenable_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `abilities` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `pesanan`
--

CREATE TABLE `pesanan` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `id_user` char(36) COLLATE utf8mb4_unicode_ci NOT NULL,
  `id_barang` bigint(20) UNSIGNED NOT NULL,
  `jumlah` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `pesanan`
--

INSERT INTO `pesanan` (`id`, `id_user`, `id_barang`, `jumlah`, `created_at`, `updated_at`) VALUES
(25, '7b8b20a0-9767-467f-899e-29ce58b657bf', 3, 1, '2022-06-28 02:15:40', '2022-06-28 02:15:40'),
(26, '7a0a8473-1bd3-4759-8650-4eea91a1f76b', 9, 1, '2022-06-28 02:17:18', '2022-06-28 02:17:18');

-- --------------------------------------------------------

--
-- Struktur dari tabel `program_keahlian`
--

CREATE TABLE `program_keahlian` (
  `id` smallint(5) UNSIGNED NOT NULL,
  `nama_program` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `program_keahlian`
--

INSERT INTO `program_keahlian` (`id`, `nama_program`, `created_at`, `updated_at`) VALUES
(1, 'Akuntansi dan Keuangan Lembaga', '2022-05-18 01:07:16', '2022-05-18 01:07:16'),
(2, 'Manajemen Perkantoran dan Layanan Bisnis', '2022-05-18 01:07:16', '2022-05-18 01:07:16'),
(3, 'Pemasaran', '2022-05-18 01:07:16', '2022-05-18 01:07:16'),
(4, 'Desain dan Komunikasi Visual', '2022-05-18 01:07:16', '2022-05-18 01:07:16');

-- --------------------------------------------------------

--
-- Struktur dari tabel `sewa`
--

CREATE TABLE `sewa` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `id_user` char(36) COLLATE utf8mb4_unicode_ci NOT NULL,
  `id_barang` bigint(20) UNSIGNED NOT NULL,
  `jumlah` int(11) NOT NULL,
  `tgl_sewa` date NOT NULL,
  `tgl_harus_kembali` date NOT NULL,
  `tgl_kembali` date DEFAULT NULL,
  `keperluan` enum('Lomba','KBM','Pribadi') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Pribadi',
  `denda_lain` double(20,2) DEFAULT NULL,
  `keterangan_sewa` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status_acc` enum('proses-sewa','disewa','proses-kembali','selesai') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'proses-sewa',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `keterangan_kembali` text COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `sewa`
--

INSERT INTO `sewa` (`id`, `id_user`, `id_barang`, `jumlah`, `tgl_sewa`, `tgl_harus_kembali`, `tgl_kembali`, `keperluan`, `denda_lain`, `keterangan_sewa`, `status_acc`, `created_at`, `updated_at`, `keterangan_kembali`) VALUES
(16, '7b8b20a0-9767-467f-899e-29ce58b657bf', 5, 1, '2022-05-27', '2022-05-28', NULL, 'Pribadi', NULL, NULL, 'proses-sewa', '2022-05-26 16:26:26', '2022-05-26 16:26:26', NULL),
(18, '7b8b20a0-9767-467f-899e-29ce58b657bf', 6, 1, '2022-05-27', '2022-05-28', NULL, 'Pribadi', NULL, NULL, 'proses-sewa', '2022-05-26 16:26:26', '2022-05-26 16:26:26', NULL),
(33, '22b26209-fdbe-4f36-883e-9066953b1ffb', 6, 5, '2022-05-27', '2022-05-28', NULL, 'Pribadi', NULL, NULL, 'disewa', '2022-05-28 01:25:07', '2022-06-07 09:10:44', NULL),
(60, 'a1e9b94a-0f63-4009-ae6e-cce4173a16c2', 6, 1, '2022-06-01', '2022-06-02', NULL, 'Pribadi', NULL, NULL, 'disewa', '2022-06-01 08:48:34', '2022-06-01 08:48:34', NULL),
(64, 'a1e9b94a-0f63-4009-ae6e-cce4173a16c2', 6, 1, '2022-05-20', '2022-05-21', '2022-05-21', 'Pribadi', NULL, NULL, 'selesai', '2022-06-01 11:11:57', '2022-06-01 11:14:43', NULL),
(65, 'a1e9b94a-0f63-4009-ae6e-cce4173a16c2', 5, 8, '2022-05-10', '2022-05-11', '2022-05-11', 'Pribadi', NULL, NULL, 'selesai', '2022-06-01 11:13:31', '2022-06-01 11:13:44', NULL),
(66, '7b8b20a0-9767-467f-899e-29ce58b657bf', 6, 6, '2022-05-10', '2022-05-11', '2022-05-11', 'Pribadi', NULL, NULL, 'selesai', '2022-06-01 11:14:18', '2022-06-01 11:14:18', NULL),
(67, '7b8b20a0-9767-467f-899e-29ce58b657bf', 5, 6, '2022-05-29', '2022-05-30', '2022-05-30', 'Pribadi', NULL, NULL, 'selesai', '2022-06-01 11:15:43', '2022-06-01 11:15:43', NULL),
(68, '7b8b20a0-9767-467f-899e-29ce58b657bf', 5, 6, '2022-05-23', '2022-05-25', '2022-05-25', 'Pribadi', NULL, NULL, 'selesai', '2022-06-01 11:16:53', '2022-06-01 11:16:53', NULL),
(69, '7b8b20a0-9767-467f-899e-29ce58b657bf', 7, 6, '2022-05-14', '2022-05-15', '2022-05-15', 'Pribadi', NULL, NULL, 'selesai', '2022-06-01 11:18:02', '2022-06-01 11:18:02', NULL),
(70, '7b8b20a0-9767-467f-899e-29ce58b657bf', 4, 6, '2022-05-03', '2022-05-04', '2022-05-05', 'Pribadi', 3000.00, NULL, 'selesai', '2022-06-01 11:18:36', '2022-06-01 11:46:37', NULL),
(71, 'c037611a-b362-4e0d-956c-20a46ff5975d', 6, 3, '2022-05-04', '2022-05-06', '2022-05-06', 'Pribadi', NULL, NULL, 'selesai', '2022-06-01 11:52:05', '2022-06-01 11:53:19', NULL),
(72, 'c037611a-b362-4e0d-956c-20a46ff5975d', 5, 3, '2022-05-15', '2022-05-16', '2022-05-17', 'Pribadi', NULL, NULL, 'selesai', '2022-06-01 11:55:04', '2022-06-01 11:55:04', NULL),
(73, 'a1e9b94a-0f63-4009-ae6e-cce4173a16c2', 5, 3, '2022-06-01', '2022-06-02', '2022-06-02', 'Pribadi', NULL, NULL, 'selesai', '2022-06-01 12:04:57', '2022-06-01 12:04:57', NULL),
(74, 'a1e9b94a-0f63-4009-ae6e-cce4173a16c2', 6, 3, '2022-06-06', '2022-06-07', '2022-06-07', 'Pribadi', NULL, NULL, 'selesai', '2022-06-01 12:05:29', '2022-06-01 12:05:29', NULL),
(75, 'a1e9b94a-0f63-4009-ae6e-cce4173a16c2', 4, 5, '2022-06-11', '2022-06-12', '2022-06-12', 'Pribadi', NULL, NULL, 'selesai', '2022-06-01 12:05:58', '2022-06-01 12:05:58', NULL),
(76, 'a1e9b94a-0f63-4009-ae6e-cce4173a16c2', 7, 5, '2022-06-16', '2022-06-17', '2022-06-17', 'Pribadi', NULL, NULL, 'selesai', '2022-06-01 12:06:25', '2022-06-01 12:06:25', NULL),
(77, 'a1e9b94a-0f63-4009-ae6e-cce4173a16c2', 7, 5, '2022-06-21', '2022-06-22', '2022-06-22', 'Pribadi', NULL, NULL, 'selesai', '2022-06-01 12:06:46', '2022-06-01 12:06:46', NULL),
(78, 'a1e9b94a-0f63-4009-ae6e-cce4173a16c2', 4, 5, '2022-06-26', '2022-06-27', '2022-06-27', 'Pribadi', NULL, NULL, 'selesai', '2022-06-01 12:07:13', '2022-06-01 12:07:13', NULL),
(79, 'a1e9b94a-0f63-4009-ae6e-cce4173a16c2', 5, 1, '2022-06-29', '2022-07-01', '2022-06-30', 'Pribadi', NULL, NULL, 'selesai', '2022-06-01 12:07:45', '2022-06-07 09:05:45', NULL),
(99, '22b26209-fdbe-4f36-883e-9066953b1ffb', 4, 1, '2022-06-06', '2022-06-08', '2022-06-09', 'Pribadi', 5000.00, NULL, 'proses-kembali', '2022-06-04 07:43:09', '2022-06-07 09:28:57', NULL),
(105, '9aea1beb-ea22-4bc1-8862-eba2773cf476', 3, 3, '2022-06-04', '2022-06-05', '2022-07-06', 'Pribadi', NULL, NULL, 'proses-kembali', '2022-06-04 07:54:39', '2022-07-06 07:00:13', NULL),
(112, '9aea1beb-ea22-4bc1-8862-eba2773cf476', 3, 1, '2022-06-07', '2022-06-09', '2022-07-06', 'Pribadi', NULL, NULL, 'proses-kembali', '2022-06-06 01:55:06', '2022-07-06 07:00:13', NULL),
(114, '9aea1beb-ea22-4bc1-8862-eba2773cf476', 4, 3, '2022-06-07', '2022-06-08', '2022-06-08', 'Pribadi', NULL, NULL, 'selesai', '2022-06-06 22:51:42', '2022-06-06 23:00:21', NULL),
(118, '7a0a8473-1bd3-4759-8650-4eea91a1f76b', 3, 1, '2022-06-07', '2022-06-08', NULL, 'Pribadi', NULL, NULL, 'disewa', '2022-06-07 10:08:35', '2022-06-07 10:08:35', NULL),
(119, '9aea1beb-ea22-4bc1-8862-eba2773cf476', 9, 1, '2022-06-27', '2022-06-28', '2022-06-28', 'Pribadi', NULL, NULL, 'selesai', '2022-06-27 04:47:21', '2022-06-27 04:48:31', NULL),
(120, '9aea1beb-ea22-4bc1-8862-eba2773cf476', 9, 3, '2022-06-27', '2022-06-28', '2022-07-06', 'Pribadi', NULL, NULL, 'proses-kembali', '2022-06-27 04:51:26', '2022-07-06 07:00:13', NULL),
(124, '9aea1beb-ea22-4bc1-8862-eba2773cf476', 6, 1, '2022-06-28', '2022-06-29', '2022-07-06', 'Pribadi', NULL, NULL, 'proses-kembali', '2022-06-28 04:00:28', '2022-07-06 07:00:13', NULL),
(125, 'aa38d207-325c-44d2-996d-dc3be01dbdd1', 10, 1, '2022-07-01', '2022-07-02', '2022-07-01', 'Pribadi', NULL, NULL, 'selesai', '2022-07-01 09:01:11', '2022-07-01 09:02:54', NULL),
(127, '22b26209-fdbe-4f36-883e-9066953b1ffb', 10, 1, '2022-06-30', '2022-07-01', '2022-07-01', 'Pribadi', NULL, NULL, 'proses-kembali', '2022-07-01 09:06:12', '2022-07-01 09:06:45', NULL);

-- --------------------------------------------------------

--
-- Struktur dari tabel `users`
--

CREATE TABLE `users` (
  `id` char(36) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `role` enum('Siswa','Alumni','Guru','Umum') COLLATE utf8mb4_unicode_ci NOT NULL,
  `jenis_kelamin` enum('laki-laki','perempuan') COLLATE utf8mb4_unicode_ci NOT NULL,
  `alamat` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `no_tlp` varchar(15) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `email_verified_at`, `password`, `role`, `jenis_kelamin`, `alamat`, `no_tlp`, `remember_token`, `created_at`, `updated_at`) VALUES
('0cf33883-6e97-4344-9a92-e80650e9c4d7', 'Lambang Dwi Windu Setyo Nugroho', 'lambangdwisin@email.com', NULL, '$2y$10$CTtw0hQp7UizLD3cS4V6sufYeNSrxIPA00MLxH1U3.qGXjRxY/1pO', 'Siswa', 'laki-laki', 'Polowidi Trimulyo Sleman', '085803956810', NULL, '2022-05-27 12:48:44', '2022-05-27 12:48:44'),
('22b26209-fdbe-4f36-883e-9066953b1ffb', 'Bagas Aji', 'user@mail.test', NULL, '$2y$10$77wdmeJfPushRY0sb1N56.vgLkWqRjyBEC9/oDbD2mTyy9Wzj0D4q', 'Umum', 'laki-laki', 'Ngemplak Kalangan', '+6285803956870', NULL, '2022-04-19 00:00:02', '2022-05-29 03:44:12'),
('43858b4d-e5d1-419d-b04f-f8fd0b8f2046', 'Windu', 'windu@mail.com', NULL, '$2y$10$LnjV4VVYzKYdIB15Qgx7Fu3acuqy2Qkqwf2DZxMNb1K1zTvJJADlW', 'Siswa', 'laki-laki', 'Polowidi, Trimulyo, Sleman', '085803956810', NULL, '2022-06-27 04:54:35', '2022-06-27 04:54:35'),
('7a0a8473-1bd3-4759-8650-4eea91a1f76b', 'Lambang DWSN', 'lambangdwsn@email.com', NULL, '$2y$10$.UeP5YPOPbjWSt1Y2.uHBOeJyHfQuXahthhVZYpkTwBdyPs97Su6W', 'Guru', 'laki-laki', 'Koanan, Godean, Sleman', '085899991218', 'C1pFiufpwX0DFJ4MEUlzd1N3Uac4RgkSWbXRmlAdaL68HA8Z5lMZuTg4pvbn', '2022-05-22 09:35:56', '2022-06-28 02:17:01'),
('7b8b20a0-9767-467f-899e-29ce58b657bf', 'Fitri Nur Azizah', 'fitriana@email.com', NULL, '$2y$10$ew/Qdb0IulWTBh5a1jCU1.RrCg11C1kLHbTgZ9njqDAU5ovLkqUEC', 'Siswa', 'perempuan', 'Jalan kenangan km 5 Sleman', '085803956811', 'B5Lxjd439AQxHIaUDXNNG3WgtsjPmzpNsDByWrqmNDNAFPBFKS8dQspdg0il', '2022-05-18 21:56:54', '2022-06-28 02:15:31'),
('9aea1beb-ea22-4bc1-8862-eba2773cf476', 'Arif', 'Arif@email.com', NULL, '$2y$10$dczC0WOHUAGouhXakK1gMeEn.E8Mt/JVKGBHedgqNtGDcB6qI76ie', 'Guru', 'laki-laki', 'Jalan Pramuka No 12', '+6280912090909', NULL, '2022-05-22 09:56:08', '2022-05-29 03:39:33'),
('a1e9b94a-0f63-4009-ae6e-cce4173a16c2', 'Rahmat Maulanan', 'ahmat@gmail.com', NULL, '$2y$10$BKzi6Fzc8gxbuQpHT2IE2.PVp9JXX0IlM1/tqEviGzfSQ6hqbbKgW', 'Guru', 'laki-laki', 'Jalan kenangan km 10 jogjakarta', '085803956810', NULL, '2022-05-19 02:52:23', '2022-05-29 03:35:21'),
('aa38d207-325c-44d2-996d-dc3be01dbdd1', 'Aziz Putra', 'userganteng@mail.test', NULL, '$2y$10$zrwY9DOrlR6LlEnhH5BLlenNbTZmn9AkXJ4DP5Jht/K6cTvBx27Wm', 'Umum', 'laki-laki', 'Jl kaliurang km 9', '089975678899', NULL, '2022-05-21 10:07:17', '2022-06-10 09:06:43'),
('c037611a-b362-4e0d-956c-20a46ff5975d', 'Barjo kusuma', 'barjo@gmail.com', NULL, '$2y$10$6WgA4pMvvc26aWmxCBZCv.Oyu8N4YCY2NmWtLtUn8F723IBwL25cm', 'Alumni', 'laki-laki', 'Polowidi, Trimulyo, Sleman', '085803956810', NULL, '2022-05-21 10:03:41', '2022-05-29 03:30:58');

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `admins`
--
ALTER TABLE `admins`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `admins_email_unique` (`email`),
  ADD UNIQUE KEY `admins_nip_unique` (`NIP`);

--
-- Indeks untuk tabel `artikel`
--
ALTER TABLE `artikel`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `barang`
--
ALTER TABLE `barang`
  ADD PRIMARY KEY (`id`),
  ADD KEY `barang_id_kelengkapan_foreign` (`id_kelengkapan`),
  ADD KEY `barang_id_katagori_foreign` (`id_katagori`),
  ADD KEY `barang_id_lokasi_foreign` (`id_lokasi`);

--
-- Indeks untuk tabel `barang_rusak`
--
ALTER TABLE `barang_rusak`
  ADD PRIMARY KEY (`id_barang_rusak`),
  ADD KEY `barang_rusak_id_barang_foreign` (`id_barang`);

--
-- Indeks untuk tabel `denda`
--
ALTER TABLE `denda`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `detail_alumni`
--
ALTER TABLE `detail_alumni`
  ADD UNIQUE KEY `detail_alumni_id_alumni_unique` (`id_alumni`),
  ADD UNIQUE KEY `detail_alumni_nik_unique` (`NIK`),
  ADD KEY `detail_alumni_id_program_keahlian_foreign` (`id_program_keahlian`);

--
-- Indeks untuk tabel `detail_guru`
--
ALTER TABLE `detail_guru`
  ADD UNIQUE KEY `detail_guru_id_guru_unique` (`id_guru`),
  ADD UNIQUE KEY `detail_guru_nip_unique` (`NIP`);

--
-- Indeks untuk tabel `detail_siswa`
--
ALTER TABLE `detail_siswa`
  ADD UNIQUE KEY `detail_siswa_id_siswa_unique` (`id_siswa`),
  ADD UNIQUE KEY `detail_siswa_nis_unique` (`NIS`),
  ADD KEY `detail_siswa_id_program_keahlian_foreign` (`id_program_keahlian`);

--
-- Indeks untuk tabel `detail_umum`
--
ALTER TABLE `detail_umum`
  ADD UNIQUE KEY `detail_umum_id_umum_unique` (`id_umum`),
  ADD UNIQUE KEY `detail_umum_nik_unique` (`NIK`);

--
-- Indeks untuk tabel `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indeks untuk tabel `katagori`
--
ALTER TABLE `katagori`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `katagori_katagori_unique` (`katagori`);

--
-- Indeks untuk tabel `kontak`
--
ALTER TABLE `kontak`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `lokasi`
--
ALTER TABLE `lokasi`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `password_resets`
--
ALTER TABLE `password_resets`
  ADD KEY `password_resets_email_index` (`email`);

--
-- Indeks untuk tabel `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  ADD KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`);

--
-- Indeks untuk tabel `pesanan`
--
ALTER TABLE `pesanan`
  ADD PRIMARY KEY (`id`),
  ADD KEY `pesanan_id_barang_foreign` (`id_barang`),
  ADD KEY `pesanan_id_user_foreign` (`id_user`);

--
-- Indeks untuk tabel `program_keahlian`
--
ALTER TABLE `program_keahlian`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `program_keahlian_nama_program_unique` (`nama_program`);

--
-- Indeks untuk tabel `sewa`
--
ALTER TABLE `sewa`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sewa_id_barang_foreign` (`id_barang`),
  ADD KEY `sewa_id_user_foreign` (`id_user`);

--
-- Indeks untuk tabel `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `admins`
--
ALTER TABLE `admins`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT untuk tabel `artikel`
--
ALTER TABLE `artikel`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT untuk tabel `barang`
--
ALTER TABLE `barang`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT untuk tabel `barang_rusak`
--
ALTER TABLE `barang_rusak`
  MODIFY `id_barang_rusak` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT untuk tabel `denda`
--
ALTER TABLE `denda`
  MODIFY `id` smallint(5) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT untuk tabel `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `katagori`
--
ALTER TABLE `katagori`
  MODIFY `id` smallint(5) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT untuk tabel `kontak`
--
ALTER TABLE `kontak`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT untuk tabel `lokasi`
--
ALTER TABLE `lokasi`
  MODIFY `id` smallint(5) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT untuk tabel `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- AUTO_INCREMENT untuk tabel `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `pesanan`
--
ALTER TABLE `pesanan`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT untuk tabel `program_keahlian`
--
ALTER TABLE `program_keahlian`
  MODIFY `id` smallint(5) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT untuk tabel `sewa`
--
ALTER TABLE `sewa`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=128;

--
-- Ketidakleluasaan untuk tabel pelimpahan (Dumped Tables)
--

--
-- Ketidakleluasaan untuk tabel `barang`
--
ALTER TABLE `barang`
  ADD CONSTRAINT `barang_id_katagori_foreign` FOREIGN KEY (`id_katagori`) REFERENCES `katagori` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `barang_id_kelengkapan_foreign` FOREIGN KEY (`id_kelengkapan`) REFERENCES `barang` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `barang_id_lokasi_foreign` FOREIGN KEY (`id_lokasi`) REFERENCES `lokasi` (`id`) ON UPDATE CASCADE;

--
-- Ketidakleluasaan untuk tabel `barang_rusak`
--
ALTER TABLE `barang_rusak`
  ADD CONSTRAINT `barang_rusak_id_barang_foreign` FOREIGN KEY (`id_barang`) REFERENCES `barang` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ketidakleluasaan untuk tabel `detail_alumni`
--
ALTER TABLE `detail_alumni`
  ADD CONSTRAINT `detail_alumni_id_alumni_foreign` FOREIGN KEY (`id_alumni`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `detail_alumni_id_program_keahlian_foreign` FOREIGN KEY (`id_program_keahlian`) REFERENCES `program_keahlian` (`id`) ON DELETE NO ACTION ON UPDATE CASCADE;

--
-- Ketidakleluasaan untuk tabel `detail_guru`
--
ALTER TABLE `detail_guru`
  ADD CONSTRAINT `detail_guru_id_guru_foreign` FOREIGN KEY (`id_guru`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ketidakleluasaan untuk tabel `detail_siswa`
--
ALTER TABLE `detail_siswa`
  ADD CONSTRAINT `detail_siswa_id_program_keahlian_foreign` FOREIGN KEY (`id_program_keahlian`) REFERENCES `program_keahlian` (`id`) ON DELETE NO ACTION ON UPDATE CASCADE,
  ADD CONSTRAINT `detail_siswa_id_siswa_foreign` FOREIGN KEY (`id_siswa`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ketidakleluasaan untuk tabel `detail_umum`
--
ALTER TABLE `detail_umum`
  ADD CONSTRAINT `detail_umum_id_umum_foreign` FOREIGN KEY (`id_umum`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ketidakleluasaan untuk tabel `pesanan`
--
ALTER TABLE `pesanan`
  ADD CONSTRAINT `pesanan_id_barang_foreign` FOREIGN KEY (`id_barang`) REFERENCES `barang` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `pesanan_id_user_foreign` FOREIGN KEY (`id_user`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ketidakleluasaan untuk tabel `sewa`
--
ALTER TABLE `sewa`
  ADD CONSTRAINT `sewa_id_barang_foreign` FOREIGN KEY (`id_barang`) REFERENCES `barang` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `sewa_id_user_foreign` FOREIGN KEY (`id_user`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
