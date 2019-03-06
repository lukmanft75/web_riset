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

DROP TABLE IF EXISTS `user_position_histories`;
CREATE TABLE `user_position_histories` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `job_title_ids` varchar(50) NOT NULL,
  `year_1` year(4) NOT NULL,
  `year_2` year(4) NOT NULL,
  `created_at` datetime NOT NULL,
  `created_by` varchar(100) NOT NULL,
  `created_ip` varchar(50) NOT NULL,
  `updated_at` datetime NOT NULL,
  `updated_by` varchar(100) NOT NULL,
  `updated_ip` varchar(50) NOT NULL,
  `xtimestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

ALTER TABLE `user_position_histories`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=0;

--
-- 20190306
--

DROP TABLE IF EXISTS `user_details`;
CREATE TABLE `user_details` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  
  `full_name` varchar(255) NOT NULL,
  `place_of_birth` varchar(255) NOT NULL,
  `date_of_birth` datetime NOT NULL,
  `sex` varchar(255) NOT NULL,
  `marital_status` varchar(255) NOT NULL,
  `nationality` varchar(255) NOT NULL,
  `religion` varchar(255) NOT NULL,
  `home_address` TEXT NOT NULL,
  `phone_hp` varchar(255) NOT NULL,
  `no_kk` varchar(255) NOT NULL,
  `no_ktp` varchar(255) NOT NULL,
  `no_npwp` varchar(255) NOT NULL,
  `bank_account_name` varchar(255) NOT NULL,
  `bank_account_no` varchar(255) NOT NULL,
  `jamsostek_no` varchar(255) NOT NULL,
  `bpjs_kesehatan_no` varchar(255) NOT NULL,
  `photo_profile` varchar(255) NOT NULL,
  
  `created_at` datetime NOT NULL,
  `created_by` varchar(100) NOT NULL,
  `created_ip` varchar(50) NOT NULL,
  `updated_at` datetime NOT NULL,
  `updated_by` varchar(100) NOT NULL,
  `updated_ip` varchar(50) NOT NULL,
  `xtimestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

ALTER TABLE `user_details`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=0;

  
DROP TABLE IF EXISTS `user_family`;
CREATE TABLE `user_family` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  
  `relation` varchar(255) NOT NULL,
  `full_name` varchar(255) NOT NULL,
  `date_of_birth` datetime NOT NULL,
  `nik` varchar(255) NOT NULL,
  `phone_for_emergency` varchar(255) NOT NULL,
  `occupation` varchar(255) NOT NULL,
  
  `created_at` datetime NOT NULL,
  `created_by` varchar(100) NOT NULL,
  `created_ip` varchar(50) NOT NULL,
  `updated_at` datetime NOT NULL,
  `updated_by` varchar(100) NOT NULL,
  `updated_ip` varchar(50) NOT NULL,
  `xtimestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

ALTER TABLE `user_family`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=0;

  
DROP TABLE IF EXISTS `user_education`;
CREATE TABLE `user_education` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  
  `leave_of_study` varchar(255) NOT NULL,
  `institution` varchar(255) NOT NULL,
  `town_city` varchar(255) NOT NULL,
  `major` varchar(255) NOT NULL,
  `graduation_year` year(4) NOT NULL,
  `gpa` varchar(255) NOT NULL,
  
  `created_at` datetime NOT NULL,
  `created_by` varchar(100) NOT NULL,
  `created_ip` varchar(50) NOT NULL,
  `updated_at` datetime NOT NULL,
  `updated_by` varchar(100) NOT NULL,
  `updated_ip` varchar(50) NOT NULL,
  `xtimestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

ALTER TABLE `user_education`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=0;

-----------------------------------------------------------------------------------
-----------------------------------------------------------------------------------
-----------------------------------------------------------------------------------

-- DROP TABLE IF EXISTS `bank_soal`;
-- CREATE TABLE `bank_soal` (
  -- `id` int(11) NOT NULL,
  -- `tingkat` smallint (6) NOT NULL,
  -- `mapel` varchar (100) NOT NULL,
  -- `tema` varchar (100) NOT NULL,
  -- `tipe_soal` varchar (500) NOT NULL,
  -- `plh_a` varchar (255) NOT NULL,
  -- `plh_b` varchar (255) NOT NULL,
  -- `plh_c` varchar (255) NOT NULL,
  -- `plh_d` varchar (255) NOT NULL,
  -- `plh_true` varchar (1) NOT NULL,
  -- `uraian` varchar (500) NOT NULL,
  -- `created_at` datetime NOT NULL,
  -- `created_by` varchar(100) NOT NULL,
  -- `created_ip` varchar(20) DEFAULT NULL,
  -- `updated_at` datetime NOT NULL,
  -- `updated_by` varchar(100) NOT NULL,
  -- `updated_ip` varchar(20) DEFAULT NULL,
  -- `xtimestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
-- ) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- ALTER TABLE `bank_soal`
  -- ADD PRIMARY KEY (`id`);
  
-- ALTER TABLE `bank_soal`
  -- MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=0;
  
  
  