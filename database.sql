-- phpMyAdmin SQL Dump
-- version 4.9.7
-- https://www.phpmyadmin.net/
--

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `ads`
--

CREATE TABLE `ads` (
  `id` int(20) UNSIGNED NOT NULL,
  `image` varchar(100) NOT NULL,
  `title` varchar(500) NOT NULL,
  `area` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `blockedips`
--

CREATE TABLE `blockedips` (
  `id` int(250) UNSIGNED NOT NULL,
  `ip` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Tablo döküm verisi `blockedips`
--

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `blog`
--

CREATE TABLE `blog` (
  `id` int(250) UNSIGNED NOT NULL,
  `title` varchar(500) CHARACTER SET utf8 NOT NULL,
  `content` text CHARACTER SET utf8 NOT NULL,
  `date` varchar(50) CHARACTER SET utf8 NOT NULL,
  `views` varchar(500) CHARACTER SET utf8 NOT NULL,
  `sef` text CHARACTER SET utf8 NOT NULL,
  `image` varchar(500) NOT NULL,
  `author` varchar(500) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `browsers`
--

CREATE TABLE `browsers` (
  `browsers` text NOT NULL,
  `devices` text NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Tablo döküm verisi `browsers`
--

INSERT INTO `browsers` (`browsers`, `devices`) VALUES
('{}', '{}');

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `closedtools`
--

CREATE TABLE `closedtools` (
  `id` int(200) UNSIGNED NOT NULL,
  `name` varchar(500) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `contact`
--

CREATE TABLE `contact` (
  `id` int(20) UNSIGNED NOT NULL,
  `name` varchar(200) NOT NULL,
  `email` varchar(200) NOT NULL,
  `message` varchar(5000) NOT NULL,
  `status` varchar(200) NOT NULL,
  `date` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `editors`
--

CREATE TABLE `editors` (
  `id` int(50) UNSIGNED NOT NULL,
  `username` varchar(500) NOT NULL,
  `password` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `notes`
--

CREATE TABLE `notes` (
  `id` int(255) UNSIGNED NOT NULL,
  `note` text NOT NULL,
  `date` varchar(500) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `settings`
--

CREATE TABLE `settings` (
  `title` varchar(200) NOT NULL,
  `aboutUs` text NOT NULL,
  `username` varchar(500) NOT NULL,
  `password` varchar(500) NOT NULL,
  `lastIp` varchar(200) NOT NULL,
  `logs` text NOT NULL,
  `homeSlogan` varchar(1000) NOT NULL,
  `blogSlogan` varchar(1000) NOT NULL,
  `typeWriter` varchar(10) NOT NULL,
  `typeWriterBlog` varchar(10) NOT NULL,
  `favicon` varchar(500) NOT NULL,
  `ogImage` varchar(500) NOT NULL,
  `description` varchar(1000) NOT NULL,
  `googleCodes` text NOT NULL,
  `github` varchar(500) NOT NULL,
  `instagram` varchar(500) NOT NULL,
  `website` varchar(500) NOT NULL,
  `cookie` text NOT NULL,
  `cookieUpdate` varchar(200) NOT NULL,
  `keywords` text NOT NULL,
  `aboutUsPage` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Tablo döküm verisi `settings`
--

INSERT INTO `settings` (`title`, `aboutUs`, `username`, `password`, `lastIp`, `logs`, `homeSlogan`, `blogSlogan`, `typeWriter`, `typeWriterBlog`, `favicon`, `ogImage`, `description`, `googleCodes`, `github`, `instagram`, `website`, `cookie`, `cookieUpdate`, `keywords`, `aboutUsPage`) VALUES
('Web Tools', '', 'admin', '21232f297a57a5a743894a0e4a801fc3', '', '', 'Totally User Oriented,<br>Free and Uninterrupted!', 'We also wanted you to hear from us :)', 'on', 'on', '', '', '', '', '', '', '', '', '1658521243', '', '');

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `stats`
--

CREATE TABLE `stats` (
  `metaTag` varchar(200) NOT NULL,
  `md5` varchar(200) NOT NULL,
  `whois` varchar(200) NOT NULL,
  `proxy` varchar(200) NOT NULL,
  `password` varchar(200) NOT NULL,
  `englishNumbers` varchar(200) NOT NULL,
  `coloredText` varchar(200) NOT NULL,
  `colorPicker` varchar(200) NOT NULL,
  `wordCount` varchar(200) NOT NULL,
  `schoolPoint` varchar(200) NOT NULL,
  `currency` varchar(200) NOT NULL,
  `currencyCalculator` varchar(200) NOT NULL,
  `draw` varchar(200) NOT NULL,
  `indexCalculator` varchar(200) NOT NULL,
  `estimatedReading` varchar(200) NOT NULL,
  `githubProject` varchar(200) NOT NULL,
  `editor` varchar(200) NOT NULL,
  `githubUser` varchar(200) NOT NULL,
  `weather` varchar(200) NOT NULL,
  `screenshot` varchar(200) NOT NULL,
  `discord` varchar(200) NOT NULL,
  `calculator` varchar(200) NOT NULL,
  `ip` varchar(200) NOT NULL,
  `qrCode` varchar(200) NOT NULL,
  `preview` varchar(200) NOT NULL,
  `imageCompressor` varchar(200) NOT NULL,
  `siteResource` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Tablo döküm verisi `stats`
--

INSERT INTO `stats` (`metaTag`, `md5`, `whois`, `proxy`, `password`, `englishNumbers`, `coloredText`, `colorPicker`, `wordCount`, `schoolPoint`, `currency`, `currencyCalculator`, `draw`, `indexCalculator`, `estimatedReading`, `githubProject`, `editor`, `githubUser`, `weather`, `screenshot`, `discord`, `calculator`, `ip`, `qrCode`, `preview`, `imageCompressor`, `siteResource`) VALUES
('0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0');

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `visits`
--

CREATE TABLE `visits` (
  `id` int(200) UNSIGNED NOT NULL,
  `time` varchar(100) NOT NULL,
  `visit` varchar(2000) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


--
-- Dökümü yapılmış tablolar için indeksler
--

--
-- Tablo için indeksler `ads`
--
ALTER TABLE `ads`
  ADD PRIMARY KEY (`id`);

--
-- Tablo için indeksler `blockedips`
--
ALTER TABLE `blockedips`
  ADD PRIMARY KEY (`id`);

--
-- Tablo için indeksler `blog`
--
ALTER TABLE `blog`
  ADD PRIMARY KEY (`id`);

--
-- Tablo için indeksler `closedtools`
--
ALTER TABLE `closedtools`
  ADD PRIMARY KEY (`id`);

--
-- Tablo için indeksler `contact`
--
ALTER TABLE `contact`
  ADD PRIMARY KEY (`id`);

--
-- Tablo için indeksler `editors`
--
ALTER TABLE `editors`
  ADD PRIMARY KEY (`id`);

--
-- Tablo için indeksler `notes`
--
ALTER TABLE `notes`
  ADD PRIMARY KEY (`id`);

--
-- Tablo için indeksler `visits`
--
ALTER TABLE `visits`
  ADD PRIMARY KEY (`id`);

--
-- Dökümü yapılmış tablolar için AUTO_INCREMENT değeri
--

--
-- Tablo için AUTO_INCREMENT değeri `ads`
--
ALTER TABLE `ads`
  MODIFY `id` int(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- Tablo için AUTO_INCREMENT değeri `blockedips`
--
ALTER TABLE `blockedips`
  MODIFY `id` int(250) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- Tablo için AUTO_INCREMENT değeri `blog`
--
ALTER TABLE `blog`
  MODIFY `id` int(250) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- Tablo için AUTO_INCREMENT değeri `closedtools`
--
ALTER TABLE `closedtools`
  MODIFY `id` int(200) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- Tablo için AUTO_INCREMENT değeri `contact`
--
ALTER TABLE `contact`
  MODIFY `id` int(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- Tablo için AUTO_INCREMENT değeri `editors`
--
ALTER TABLE `editors`
  MODIFY `id` int(50) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- Tablo için AUTO_INCREMENT değeri `notes`
--
ALTER TABLE `notes`
  MODIFY `id` int(255) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- Tablo için AUTO_INCREMENT değeri `visits`
--
ALTER TABLE `visits`
  MODIFY `id` int(200) UNSIGNED NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
