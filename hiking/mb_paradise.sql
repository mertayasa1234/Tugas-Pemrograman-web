-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 18, 2025 at 10:38 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `mb_paradise`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `id_admin` int(11) NOT NULL,
  `nama_admin` varchar(100) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `foto_profil` varchar(255) DEFAULT NULL,
  `email` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`id_admin`, `nama_admin`, `username`, `password`, `foto_profil`, `email`) VALUES
(1, 'Mertayasa', 'admin123', '$2y$10$v4HWZ64liWTk0WIcTxgaBuYxTu6n1AfJY96wOk.lQD0KIATQzq/RW', 'assets/admin/poto.jpg', 'admin@example.com');

-- --------------------------------------------------------

--
-- Table structure for table `bukti_pembayaran`
--

CREATE TABLE `bukti_pembayaran` (
  `id_bukti` int(11) NOT NULL,
  `id_pesanan` int(11) NOT NULL,
  `file_bukti` text NOT NULL,
  `tanggal_upload` timestamp NOT NULL DEFAULT current_timestamp(),
  `status` enum('Menunggu Verifikasi','Diterima','Ditolak') DEFAULT 'Menunggu Verifikasi',
  `catatan` text DEFAULT NULL,
  `alasan_penolakan` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `bukti_pembayaran`
--

INSERT INTO `bukti_pembayaran` (`id_bukti`, `id_pesanan`, `file_bukti`, `tanggal_upload`, `status`, `catatan`, `alasan_penolakan`) VALUES
(15, 35, 'uploads/WIN_20241007_18_04_02_Pro.jpg', '2025-01-18 01:41:29', 'Diterima', NULL, NULL),
(16, 36, 'uploads/WIN_20241007_18_04_02_Pro.jpg', '2025-01-18 02:35:12', 'Diterima', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `guide`
--

CREATE TABLE `guide` (
  `id_guide` int(11) NOT NULL,
  `nama_guide` varchar(100) NOT NULL,
  `no_hp` varchar(15) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `guide`
--

INSERT INTO `guide` (`id_guide`, `nama_guide`, `no_hp`) VALUES
(41, 'Guide 1', '081234567890'),
(42, 'Guide 2', '081234567891'),
(43, 'Guide 3', '081234567892'),
(44, 'Guide 4', '081234567893'),
(45, 'Guide 5', '081234567894'),
(46, 'Guide 6', '081234567895'),
(47, 'Guide 7', '081234567896'),
(48, 'Guide 8', '081234567897'),
(49, 'Guide 9', '081234567898'),
(50, 'Guide 10', '081234567899'),
(51, 'Guide 11', '081234567900'),
(52, 'Guide 12', '081234567901'),
(53, 'Guide 13', '081234567902'),
(54, 'Guide 14', '081234567903'),
(55, 'Guide 15', '081234567904'),
(56, 'Guide 16', '081234567905'),
(57, 'Guide 17', '081234567906'),
(60, 'mertayasa', '08881'),
(61, 'ayu', '081919899'),
(62, 'kadek', '0999');

-- --------------------------------------------------------

--
-- Table structure for table `informasi_pendakian`
--

CREATE TABLE `informasi_pendakian` (
  `id_informasi` int(11) NOT NULL,
  `id_pesanan` int(11) NOT NULL,
  `waktu_pendakian` time NOT NULL,
  `lokasi_kumpul` text NOT NULL,
  `nama_guide` varchar(100) DEFAULT NULL,
  `no_telepon_guide` varchar(15) DEFAULT NULL,
  `informasi_tambahan` text DEFAULT NULL,
  `tanggal_dibuat` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `informasi_pendakian`
--

INSERT INTO `informasi_pendakian` (`id_informasi`, `id_pesanan`, `waktu_pendakian`, `lokasi_kumpul`, `nama_guide`, `no_telepon_guide`, `informasi_tambahan`, `tanggal_dibuat`) VALUES
(40, 35, '10:00:00', 'Desa Kintamani', 'mertayasa', '08881', 'Tolong datang cepat waktu', '2025-01-18 01:44:17'),
(41, 36, '02:00:00', 'Songan', 'ayu', '081919899', 'Saya Sudah mempersiapkan guide terbaik', '2025-01-18 02:36:40');

-- --------------------------------------------------------

--
-- Table structure for table `jadwal_guide`
--

CREATE TABLE `jadwal_guide` (
  `id_jadwal` int(11) NOT NULL,
  `id_guide` int(11) NOT NULL,
  `id_pesanan` int(11) NOT NULL,
  `tanggal` date NOT NULL,
  `waktu_mulai` time DEFAULT NULL,
  `waktu_selesai` time DEFAULT NULL,
  `lokasi_kumpul` varchar(255) DEFAULT NULL,
  `status` enum('Scheduled','Completed','Cancelled') DEFAULT 'Scheduled',
  `catatan` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `jadwal_guide`
--

INSERT INTO `jadwal_guide` (`id_jadwal`, `id_guide`, `id_pesanan`, `tanggal`, `waktu_mulai`, `waktu_selesai`, `lokasi_kumpul`, `status`, `catatan`) VALUES
(9, 60, 35, '2025-01-25', '10:00:00', '13:00:00', 'Desa Kintamani', 'Scheduled', NULL),
(10, 61, 36, '2025-01-19', '02:00:00', '10:00:00', 'Songan', 'Scheduled', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `paket`
--

CREATE TABLE `paket` (
  `id_paket` int(11) NOT NULL,
  `nama_paket` varchar(100) NOT NULL,
  `deskripsi` text DEFAULT NULL,
  `harga` decimal(10,2) NOT NULL,
  `gambar` varchar(255) DEFAULT NULL,
  `durasi` int(11) NOT NULL,
  `kuota_min` int(11) NOT NULL,
  `kuota_max` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `paket`
--

INSERT INTO `paket` (`id_paket`, `nama_paket`, `deskripsi`, `harga`, `gambar`, `durasi`, `kuota_min`, `kuota_max`) VALUES
(1, 'Private Package', 'Experience an exclusive hiking trip with personalized service.', 500000.00, 'assets/paket/private.jpg', 9, 1, 5),
(2, 'Sharing Package', 'Join a group and enjoy a fun and social hiking adventure.', 350000.00, 'assets/paket/sharing.jpg', 9, 3, 8),
(3, 'Group Package', 'Perfect for families, friends, or corporate outings.', 300000.00, 'assets/paket/group.jpg', 9, 7, 100);

-- --------------------------------------------------------

--
-- Table structure for table `pesanan`
--

CREATE TABLE `pesanan` (
  `id_pesanan` int(11) NOT NULL,
  `id_paket` int(11) NOT NULL,
  `id_guide` int(11) DEFAULT NULL,
  `id_pelanggan` int(11) NOT NULL,
  `tanggal_pesan` date NOT NULL,
  `tanggal_mendaki` date NOT NULL,
  `jumlah_orang` int(11) NOT NULL,
  `harga` decimal(10,2) NOT NULL,
  `catatan` text DEFAULT NULL,
  `bukti_pembayaran` text DEFAULT NULL,
  `status_pesanan` enum('Menunggu Konfirmasi','Dikonfirmasi','Menunggu Pembayaran','Menunggu Verifikasi','Diterima','Ditolak','Lunas','Dikirim','Selesai') NOT NULL DEFAULT 'Menunggu Konfirmasi',
  `total_harga` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `pesanan`
--

INSERT INTO `pesanan` (`id_pesanan`, `id_paket`, `id_guide`, `id_pelanggan`, `tanggal_pesan`, `tanggal_mendaki`, `jumlah_orang`, `harga`, `catatan`, `bukti_pembayaran`, `status_pesanan`, `total_harga`) VALUES
(35, 3, 60, 5, '2025-01-18', '2025-01-25', 8, 300000.00, 'cobaa', 'uploads/WIN_20241007_18_04_02_Pro.jpg', 'Selesai', 2400000.00),
(36, 1, 61, 5, '2025-01-18', '2025-01-19', 2, 500000.00, 'Tolong guidenya yang oke', 'uploads/WIN_20241007_18_04_02_Pro.jpg', 'Selesai', 1000000.00);

-- --------------------------------------------------------

--
-- Table structure for table `ulasan`
--

CREATE TABLE `ulasan` (
  `id_ulasan` int(11) NOT NULL,
  `id_pesanan` int(11) NOT NULL,
  `ulasan` text NOT NULL,
  `rating` int(11) NOT NULL CHECK (`rating` between 1 and 5),
  `tanggal_ulasan` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `ulasan`
--

INSERT INTO `ulasan` (`id_ulasan`, `id_pesanan`, `ulasan`, `rating`, `tanggal_ulasan`) VALUES
(7, 35, 'Guidenya super oke. Pemandanganya juga mantap', 5, '2025-01-18 16:45:22'),
(8, 36, 'Mantap, saya mendapatkan pelayanan yang luar biasa', 5, '2025-01-18 17:37:20');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id_pelanggan` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `nama` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `address` text NOT NULL,
  `password` varchar(255) NOT NULL,
  `create_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id_pelanggan`, `username`, `nama`, `email`, `address`, `password`, `create_at`) VALUES
(1, 'mertayasa', 'mertayasa', 'merta@example.com', 'Jl.Bantas, Kintamanai, Bangli', '$2y$10$GI73N7HfRjbNMuC6xtWTAudotJSQsfgVQ2eA.E0wFY6hCcyrqNsjS', '2025-01-16 07:20:30'),
(5, 'usermerta', 'I Wayan Mertayasa', 'mertayasa@example.com', 'Jl. Bantas, Kintamani, Bangli', '$2y$10$BbLZAZt24d.s6XGcnaA7wOFT.wKbCvB7JKOndsOpPwgtZ9UP7qKE6', '2025-01-18 08:28:57');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`id_admin`),
  ADD UNIQUE KEY `username` (`username`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `bukti_pembayaran`
--
ALTER TABLE `bukti_pembayaran`
  ADD PRIMARY KEY (`id_bukti`),
  ADD KEY `id_pesanan` (`id_pesanan`);

--
-- Indexes for table `guide`
--
ALTER TABLE `guide`
  ADD PRIMARY KEY (`id_guide`);

--
-- Indexes for table `informasi_pendakian`
--
ALTER TABLE `informasi_pendakian`
  ADD PRIMARY KEY (`id_informasi`),
  ADD KEY `informasi_pendakian_ibfk_1` (`id_pesanan`);

--
-- Indexes for table `jadwal_guide`
--
ALTER TABLE `jadwal_guide`
  ADD PRIMARY KEY (`id_jadwal`),
  ADD KEY `id_guide` (`id_guide`),
  ADD KEY `id_pesanan` (`id_pesanan`);

--
-- Indexes for table `paket`
--
ALTER TABLE `paket`
  ADD PRIMARY KEY (`id_paket`);

--
-- Indexes for table `pesanan`
--
ALTER TABLE `pesanan`
  ADD PRIMARY KEY (`id_pesanan`),
  ADD KEY `id_paket` (`id_paket`),
  ADD KEY `id_pelanggan` (`id_pelanggan`);

--
-- Indexes for table `ulasan`
--
ALTER TABLE `ulasan`
  ADD PRIMARY KEY (`id_ulasan`),
  ADD UNIQUE KEY `id_pesanan` (`id_pesanan`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id_pelanggan`),
  ADD UNIQUE KEY `username` (`username`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `id_admin` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `bukti_pembayaran`
--
ALTER TABLE `bukti_pembayaran`
  MODIFY `id_bukti` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `guide`
--
ALTER TABLE `guide`
  MODIFY `id_guide` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=63;

--
-- AUTO_INCREMENT for table `informasi_pendakian`
--
ALTER TABLE `informasi_pendakian`
  MODIFY `id_informasi` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=42;

--
-- AUTO_INCREMENT for table `jadwal_guide`
--
ALTER TABLE `jadwal_guide`
  MODIFY `id_jadwal` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `paket`
--
ALTER TABLE `paket`
  MODIFY `id_paket` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `pesanan`
--
ALTER TABLE `pesanan`
  MODIFY `id_pesanan` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=37;

--
-- AUTO_INCREMENT for table `ulasan`
--
ALTER TABLE `ulasan`
  MODIFY `id_ulasan` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id_pelanggan` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `bukti_pembayaran`
--
ALTER TABLE `bukti_pembayaran`
  ADD CONSTRAINT `bukti_pembayaran_ibfk_1` FOREIGN KEY (`id_pesanan`) REFERENCES `pesanan` (`id_pesanan`) ON DELETE CASCADE;

--
-- Constraints for table `informasi_pendakian`
--
ALTER TABLE `informasi_pendakian`
  ADD CONSTRAINT `informasi_pendakian_ibfk_1` FOREIGN KEY (`id_pesanan`) REFERENCES `pesanan` (`id_pesanan`) ON DELETE CASCADE;

--
-- Constraints for table `jadwal_guide`
--
ALTER TABLE `jadwal_guide`
  ADD CONSTRAINT `jadwal_guide_ibfk_1` FOREIGN KEY (`id_guide`) REFERENCES `guide` (`id_guide`),
  ADD CONSTRAINT `jadwal_guide_ibfk_2` FOREIGN KEY (`id_pesanan`) REFERENCES `pesanan` (`id_pesanan`);

--
-- Constraints for table `pesanan`
--
ALTER TABLE `pesanan`
  ADD CONSTRAINT `pesanan_ibfk_1` FOREIGN KEY (`id_paket`) REFERENCES `paket` (`id_paket`) ON DELETE CASCADE,
  ADD CONSTRAINT `pesanan_ibfk_2` FOREIGN KEY (`id_pelanggan`) REFERENCES `users` (`id_pelanggan`) ON DELETE CASCADE;

--
-- Constraints for table `ulasan`
--
ALTER TABLE `ulasan`
  ADD CONSTRAINT `ulasan_ibfk_1` FOREIGN KEY (`id_pesanan`) REFERENCES `pesanan` (`id_pesanan`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
