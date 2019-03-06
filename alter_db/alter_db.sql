DROP TABLE IF EXISTS `job_title`;
CREATE TABLE `job_title` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `web_module` int(11) NOT NULL,
  `created_at` datetime NOT NULL,
  `created_by` varchar(100) NOT NULL,
  `created_ip` varchar(20) DEFAULT NULL,
  `updated_at` datetime NOT NULL,
  `updated_by` varchar(100) NOT NULL,
  `updated_ip` varchar(20) DEFAULT NULL,
  `xtimestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

ALTER TABLE `job_title`
  ADD PRIMARY KEY (`id`);
  
ALTER TABLE `job_title`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=0;

INSERT INTO `job_title` (name,web_module) VALUES
('Kepala Sekolah','1'),
('Wakil Kepala Sekolah','1'),
('Kurikulum','1'),
('Kesiswaan','1'),
('Humas','1'),
('Guru Bidang','1'),
('Guru Kelas','1'),
('Operator TU','1'),
('Operator Perpus','1');

-----------------------------------------------------------------------------------
-----------------------------------------------------------------------------------
-----------------------------------------------------------------------------------

DROP TABLE IF EXISTS `bank_soal`;
CREATE TABLE `bank_soal` (
  `id` int(11) NOT NULL,
  `tingkat` smallint (6) NOT NULL,
  `mapel` varchar (100) NOT NULL,
  `tema` varchar (100) NOT NULL,
  `tipe_soal` varchar (500) NOT NULL,
  `plh_a` varchar (255) NOT NULL,
  `plh_b` varchar (255) NOT NULL,
  `plh_c` varchar (255) NOT NULL,
  `plh_d` varchar (255) NOT NULL,
  `plh_true` varchar (1) NOT NULL,
  `uraian` varchar (500) NOT NULL,
  `created_at` datetime NOT NULL,
  `created_by` varchar(100) NOT NULL,
  `created_ip` varchar(20) DEFAULT NULL,
  `updated_at` datetime NOT NULL,
  `updated_by` varchar(100) NOT NULL,
  `updated_ip` varchar(20) DEFAULT NULL,
  `xtimestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

ALTER TABLE `bank_soal`
  ADD PRIMARY KEY (`id`);
  
ALTER TABLE `bank_soal`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=0;