-- phpMyAdmin SQL Dump
-- version 4.7.4
-- https://www.phpmyadmin.net/
--
-- Anamakine: 127.0.0.1:3306
-- Üretim Zamanı: 10 Kas 2017, 12:22:53
-- Sunucu sürümü: 5.7.19
-- PHP Sürümü: 5.6.31

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Veritabanı: `youtubedb`
--

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `channels`
--

DROP TABLE IF EXISTS `channels`;
CREATE TABLE IF NOT EXISTS `channels` (
  `channelID` int(11) NOT NULL AUTO_INCREMENT,
  `channelName` varchar(50) DEFAULT NULL,
  `channelLink` varchar(100) DEFAULT NULL,
  `channelPicture` varchar(200) DEFAULT NULL,
  `channelVid` varchar(200) DEFAULT NULL,
  PRIMARY KEY (`channelID`),
  UNIQUE KEY `channeName` (`channelName`)
) ENGINE=MyISAM AUTO_INCREMENT=9 DEFAULT CHARSET=latin1;

--
-- Tablo döküm verisi `channels`
--

INSERT INTO `channels` (`channelID`, `channelName`, `channelLink`, `channelPicture`, `channelVid`) VALUES
(1, 'MetallicaTV', '/user/MetallicaTV', 'https://yt3.ggpht.com/-KfpwETSc-OE/AAAAAAAAAAI/AAAAAAAAAAA/d9daqOEKOrk/s176-c-k-no-mo-rj-c0xffffff/photo.jpg', 'https://www.youtube.com/embed/NlbNjQPzPPc?rel=0'),
(2, 'MÃ¼zik', '/channel/UC-9-kyTW8ZkZNDHQJ6FgpwQ', '//yt3.ggpht.com/pHwZj3tkgC3SJFbuqebBoT7WtVcIwAijEmcbe9VDCauv9ZlG6uS2zjvZQUSO7SfFqa3xjYqGp_L4QbM7=s176-nd-c-c0xffffffff-rj-k-no', 'https://www.youtube.com/embed/fbHbTBP_u7U?rel=0'),
(3, 'Oyunlar', '/channel/UCOpNcN46UbXVtpKMrmU4Abg', '//yt3.ggpht.com/Ud1xlhxCsA-mYDsSo7kcp0NRYfIb-xDVTsuwPS-jde6BWEO5IV3b8t3DkOZG2np_oewT7CGLgE3KKAe4KMI=s176-nd-c-c0xffffffff-rj-k-no', 'https://www.youtube.com/embed/H5mO-ED_tpg?rel=0'),
(4, 'PewDiePie', '/user/PewDiePie', 'https://yt3.ggpht.com/-rJq9gk1QIis/AAAAAAAAAAI/AAAAAAAAAAA/Kx4wkvKOfxY/s176-c-k-no-mo-rj-c0xffffff/photo.jpg', 'https://www.youtube.com/embed/YulJWy1Wq7Y?rel=0'),
(5, 'BilgisayarKavramlari', '/channel/UCkkgrhDCJheXQNIFqUVw0_g', 'https://yt3.ggpht.com/--mLGDCDbzN0/AAAAAAAAAAI/AAAAAAAAAAA/i68LGwbO1NU/s176-c-k-no-mo-rj-c0xffffff/photo.jpg', 'https://www.youtube.com/embed/6E6KNyCBwas?rel=0'),
(6, 'PlayStation', '/user/PlayStation', 'https://yt3.ggpht.com/-m9m3AVA2sCI/AAAAAAAAAAI/AAAAAAAAAAA/p9EFobCpXEQ/s176-c-k-no-mo-rj-c0xffffff/photo.jpg', 'https://www.youtube.com/embed/ovFJkUVQexc?rel=0'),
(7, 'thenewboston', '/user/thenewboston', 'https://yt3.ggpht.com/--n5ELY2uT-U/AAAAAAAAAAI/AAAAAAAAAAA/d9JvaIEpstw/s176-c-k-no-mo-rj-c0xffffff/photo.jpg', 'https://www.youtube.com/embed/2VUludkxZz0?rel=0'),
(8, 'Technopat', '/user/technopatnet', 'https://yt3.ggpht.com/-yI5MHfCeQs4/AAAAAAAAAAI/AAAAAAAAAAA/_4KZuGTLJPI/s176-c-k-no-mo-rj-c0xffffff/photo.jpg', 'https://www.youtube.com/embed/VrJ2NXwSkx4?rel=0');

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `userId` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(18) NOT NULL,
  `password` varchar(10) NOT NULL,
  `userPicture` varchar(200) DEFAULT NULL,
  PRIMARY KEY (`userId`),
  UNIQUE KEY `username` (`username`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

--
-- Tablo döküm verisi `users`
--

INSERT INTO `users` (`userId`, `username`, `password`, `userPicture`) VALUES
(1, 'admin', 'password', 'img/profile_pictures/admin.png');

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `users_channels`
--

DROP TABLE IF EXISTS `users_channels`;
CREATE TABLE IF NOT EXISTS `users_channels` (
  `userID` int(11) NOT NULL,
  `channelID` int(11) NOT NULL,
  PRIMARY KEY (`userID`,`channelID`),
  KEY `FK_channelID` (`channelID`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Tablo döküm verisi `users_channels`
--

INSERT INTO `users_channels` (`userID`, `channelID`) VALUES
(1, 1),
(1, 2),
(1, 3),
(1, 4),
(1, 5),
(1, 6),
(1, 7),
(1, 8);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
