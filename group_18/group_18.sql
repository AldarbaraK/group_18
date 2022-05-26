-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- 主機： 127.0.0.1
-- 產生時間： 2022-05-26 13:06:50
-- 伺服器版本： 10.4.22-MariaDB
-- PHP 版本： 8.1.2

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- 資料庫: `group_18`
--
CREATE DATABASE IF NOT EXISTS `group_18` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE `group_18`;

-- --------------------------------------------------------

--
-- 資料表結構 `admin_info`
--

CREATE TABLE `admin_info` (
  `admin_account` varchar(64) NOT NULL,
  `admin_password` varchar(200) NOT NULL,
  `admin_email` varchar(64) NOT NULL,
  `admin_name` varchar(30) NOT NULL,
  `admin_nickname` varchar(30) NOT NULL,
  `admin_birth` date NOT NULL,
  `admin_phone` varchar(20) NOT NULL,
  `admin_insertDate` date NOT NULL,
  `admin_sex` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- 傾印資料表的資料 `admin_info`
--

INSERT INTO `admin_info` (`admin_account`, `admin_password`, `admin_email`, `admin_name`, `admin_nickname`, `admin_birth`, `admin_phone`, `admin_insertDate`, `admin_sex`) VALUES
('admin', 'admin123456', 'admin@gmail.com', 'admin', '管理者', '2022-05-21', '0911222333', '2022-05-21', '男性');

-- --------------------------------------------------------

--
-- 資料表結構 `deal_record`
--

CREATE TABLE `deal_record` (
  `member_account` varchar(64) NOT NULL,
  `game_ID` int(11) NOT NULL,
  `deal_score` int(11) DEFAULT NULL,
  `deal_price` int(11) NOT NULL,
  `deal_datetime` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- 傾印資料表的資料 `deal_record`
--

INSERT INTO `deal_record` (`member_account`, `game_ID`, `deal_score`, `deal_price`, `deal_datetime`) VALUES
('allan96452', 10, 5, 1190, '2022-05-26 12:42:57'),
('allan96452', 16, 4, 903, '2022-05-26 12:42:57'),
('member', 4, NULL, 325, '2022-05-11 14:57:26'),
('member', 21, NULL, 108, '2022-05-03 05:57:26'),
('Unshun0120', 15, 3, 0, '2022-05-26 12:42:57'),
('Unshun0120', 22, NULL, 26, '2022-04-19 19:57:26');

-- --------------------------------------------------------

--
-- 資料表結構 `game_categories`
--

CREATE TABLE `game_categories` (
  `game_ID` int(11) NOT NULL COMMENT '遊戲編號',
  `game_type` varchar(150) NOT NULL COMMENT '類型'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- 傾印資料表的資料 `game_categories`
--

INSERT INTO `game_categories` (`game_ID`, `game_type`) VALUES
(1, '冒險'),
(1, '動作'),
(2, '冒險'),
(2, '動作'),
(3, '卡牌'),
(3, '策略'),
(4, '冒險'),
(4, '動作'),
(4, '汽機車模擬'),
(5, '休閒'),
(5, '冒險'),
(6, '休閒'),
(6, '冒險'),
(7, '冒險'),
(7, '動作'),
(7, '多人'),
(8, '動作'),
(8, '多人'),
(9, '動作'),
(9, '恐怖'),
(9, '第一人稱'),
(10, '冒險'),
(10, '動作'),
(10, '單人'),
(11, '休閒'),
(11, '多人'),
(12, '休閒'),
(12, '單人'),
(12, '策略'),
(13, '休閒'),
(13, '多人'),
(13, '策略'),
(14, '休閒'),
(14, '多人'),
(14, '策略'),
(15, '休閒'),
(15, '單人'),
(16, '冒險'),
(16, '動作'),
(16, '單人'),
(17, '冒險'),
(17, '動作'),
(18, '冒險'),
(18, '動作'),
(19, '冒險'),
(19, '動作'),
(20, '休閒'),
(20, '策略'),
(21, '休閒'),
(22, '休閒'),
(22, '多人'),
(22, '策略'),
(23, '休閒'),
(24, '冒險'),
(24, '動作'),
(25, '冒險'),
(25, '動作'),
(25, '恐怖'),
(26, '休閒'),
(26, '冒險'),
(27, '休閒'),
(27, '冒險'),
(28, '冒險'),
(28, '動作'),
(29, '休閒'),
(29, '動作');

-- --------------------------------------------------------

--
-- 資料表結構 `game_info`
--

CREATE TABLE `game_info` (
  `game_ID` int(11) NOT NULL COMMENT '遊戲編號',
  `game_name` varchar(150) NOT NULL COMMENT '遊戲名稱',
  `game_date` date NOT NULL COMMENT '發行日期',
  `game_rating` varchar(150) NOT NULL COMMENT '遊戲分級',
  `game_price` int(11) NOT NULL COMMENT '價格',
  `game_discount` int(11) NOT NULL COMMENT '折扣',
  `game_developer` varchar(150) NOT NULL COMMENT '開發人員',
  `game_publisher` varchar(150) NOT NULL COMMENT '發行商',
  `game_story` mediumtext NOT NULL COMMENT '故事'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- 傾印資料表的資料 `game_info`
--

INSERT INTO `game_info` (`game_ID`, `game_name`, `game_date`, `game_rating`, `game_price`, `game_discount`, `game_developer`, `game_publisher`, `game_story`) VALUES
(1, '艾爾登法環\r\n', '2022-02-25', '限制級', 1290, 0, 'FromSoftware Inc.', 'FromSoftware Inc., BANDAI NAMCO Entertainment', '艾爾登法環是以正統黑暗奇幻世界為舞台的動作RPG遊戲。 走進遼闊的場景與地下迷宮探索未知，挑戰困難重重的險境，享受克服困境時的成就感吧。 不僅如此，登場角色之間的利害關係譜成的群像劇，更是不容錯過。'),
(2, 'Monster Hunter: World', '2018-08-10', '輔導級', 920, 0, 'CAPCOM Co., Ltd.', 'CAPCOM Co., Ltd.', '新的生命之地。狩獵, 就是本能! 在最新作「Monster Hunter: World」中, 玩家可以體驗終極的狩獵生活, 活用新建構的世界中各種各樣的地形 與生態環境享受狩獵的驚喜與興奮。'),
(3, 'Yu-Gi-Oh! Master Duel', '2022-01-19', '普通級', 0, 0, 'Konami Digital Entertainment', 'Konami Digital Entertainment', '史上最強的數位卡牌遊戲！'),
(4, 'Grand Theft Auto V', '2015-04-14', '限制級', 1299, 25, 'Rockstar North', 'Rockstar Games', 'PC 版 Grand Theft Auto V 可讓玩家以 4K 或更高的解析度，探索獲得大獎肯定的洛聖都和布雷恩郡遊戲世界，而且也可讓玩家體驗每秒 60 影格的遊戲執行效果。'),
(5, '星之卡比 探索發現', '2022-03-25', '普通級', 1790, 0, 'HAL Laboratory', 'Nintendo', '《星之卡比 探索發現》是《星之卡比》系列第一款 3D 動作遊戲，除了過往熟悉的複製能力，這回還能透過塞滿嘴獲得新能力。 故事背景設定在一個「過去已有文明存在的世界」。卡比為了救出被神祕敵人「野獸軍團」俘虜的瓦豆魯迪們而展開冒險， 在各關卡中必須與野獸軍團戰鬥、解開難題，遊戲場景豐富度可說是歷代之最。'),
(6, 'Super Mario Galaxy', '2020-09-18', '普通級\r\n', 1480, 0, 'Nintendo', 'Nintendo', '在百年一度慶祝星塵帶來恩惠的「星塵祭」之夜，整座城堡和碧姬公主被突然現身的庫巴綁架了。瑪利歐被擊飛到宇宙的另一端，與星星之子「奇可」和謎一樣的女子「羅潔塔」相遇。瑪利歐為了尋找拯救碧姫公主的線索，在廣大的宇宙展開冒險之旅。'),
(7, 'LEGO® Star Wars™ : 天行者傳奇', '2022-04-06', '保護級', 1240, 0, 'TT Games', 'Warner Bros. Games, Warner Bros. Interactive Entertainment', '在這款與衆不同的遊戲中，體驗全九部天行者傳奇電影。300 多個可玩人物、100 多部載具和 23 個星球可供探索，遙遠的銀河從未如此有趣！ *包含經典歐比王·肯諾比可玩人物'),
(8, 'Apex 英雄', '2020-11-05', '輔導級', 0, 0, 'Respawn Entertainment', 'Electronic Arts', '《Apex 英雄》是一款由 Respawn Entertainment 打造的獲獎免費英雄射擊遊戲。掌握一系列不斷增加且擁有強大技能的傳說級角色，並體驗戰略性小隊玩法和新一代英雄射擊與大逃殺遊戲中的創新玩法。'),
(9, 'Resident Evil Village', '2021-05-07', '限制級', 1730, 0, 'CAPCOM Co., Ltd.', 'CAPCOM Co., Ltd.', '在《Resident Evil》主系列的第8部作品中展開一場令人毛骨悚然的絕命拚搏。 伊森一家的平靜生活又再一次被捲進了混亂之中，而打破這種平靜日常的不是別人，正是克里斯·雷德菲爾。伊森又再一次陷入那無法醒來的噩夢。 經過多年開發，日趨成熟的RE Engine為大家打造了全新的生存「動作」恐怖體驗。'),
(10, '勇者鬥惡龍XI S 尋覓逝去的時光', '2020-12-05', '保護級', 1190, 0, 'Square Enix', 'Square Enix', 'Definitive Edition 內含備受讚譽的『勇者鬥惡龍XI』主遊戲，以及額外劇情、管弦樂配樂、2D 模式等等新內容！無論你是老練玩家或新冒險家，都能享受最極致的 DQXI 遊戲體驗。'),
(11, '天堂II', '2004-01-13', '輔導級', 0, 0, 'NCsoft', '吉恩立', '天堂Ⅱ的世界是以建立在兩塊陸地上的三個王國為中心。年輕的國王拉烏爾平定內亂後建立了新興王國─亞丁，自稱為古代艾爾摩瑞丁王國嫡系。另外位於陸地北部的軍事大國─艾爾摩，還有大洋彼岸的西方國家─格勒西亞，這三個王國互相牽制，同時，他們對領土的強烈自治意識，使這三王國陷入了爭奪王位承權的混戰當中......。'),
(12, '貓咪大戰爭', '2012-11-25', '普通級', 0, 0, 'PONOS株式會社', 'PONOS株式會社', '貓咪大戰爭（手機版）有多個不同語言的版本（包括：日文版、韓文版、英文版(支援英語、法語、義大利語、德語、西班牙語)、繁體中文版），各個版本之間的活動和進度均不相容。 。總下載量為7200萬。 至今能持續增長中。'),
(13, '爐石戰記', '2014-03-11', '普通級', 0, 0, '暴雪娛樂', '暴雪娛樂', '《爐石戰記》（英語：Hearthstone，中國大陸譯作「爐石傳說」，香港和台灣舊譯「爐石戰記：魔獸英雄傳」，中國大陸舊譯「爐石傳說：魔獸英雄傳」）是暴雪娛樂發行的一款集換式卡片遊戲。由暴雪員工Rob Pardo在2013年3月的PAX（英語：PAX） 2013公布。遊戲在2013年夏進入Beta測試。2014年1月24日進入公測階段。2014年3月13日，歐、亞、美三個伺服器正式營運，中國伺服器也於3月15日正式營運。'),
(14, '知識王live', '2014-12-06', '普通級', 0, 0, 'BRAVE KNIGHT', '隆中網路', '《知識王》是由BRAVE KNIGHT工作室負責遊戲設計與開發，隆中網路負責產品發行與營運，於2014年底在Android平臺以及iOS平臺所推出的多人線上手機遊戲，並於2017年6月底推出好友連線對戰功能的《知識王LIVE》。玩家在遊玩時，須在指定時間內回答題目。'),
(15, '憤怒鳥\r\n', '2009-12-11', '普通級', 0, 0, 'Rovio娛樂', 'Rovio娛樂', '憤怒鳥（英語：Angry Birds，中國大陸譯作「憤怒的小鳥」）是芬蘭遊戲公司Rovio娛樂出品的電子遊戲系列。系列作品主要面向智慧型電話，玩法以控制彈弓發射小鳥、打擊建築物和小豬的益智遊戲為主。但之後系列登上遊戲機平台，並涉足競速和捲軸射擊等遊戲類型。此外系列還有改編動畫等跨媒體作品。'),
(16, '刺客教條', '2007-11-13', '限制級', 1129, 80, '育碧蒙特婁\r\n育碧安納西\r\nGameloft\r\nGriptonite Games', '育碧軟體', '刺客教條系列（英語：Assassin\'s Creed）是由育碧軟體發行的歷史隱蔽類遊戲系列（潛伏遊戲），包括有許多續作和其他作品。主要的單人遊戲由育碧蒙特婁進行開發，並且由育碧安納西進行多人遊戲的開發。該系列產品受到了大部分評論家的好評。2016年9月，系列售出超過一億份，並成為育碧軟體最暢銷的遊戲。系列靈感來自弗拉基米爾·巴托爾的小說《Alamut》，被認為是《波斯王子系列》的精神續作。'),
(17, '破曉傳奇', '2021-09-10', '輔導級', 1490, 0, 'BANDAI NAMCO Studios Inc.', '\r\nBANDAI NAMCO Entertainment', '３００年的暴政、不明面具、遺失的痛覺與記憶。化身為強大火焰之劍的唯一使用者，與不可碰觸的少女及伙伴們一起挺身對抗壓迫者吧。以新世代技術描繪出表情生動的角色，一個關於解放的戰鬥故事。'),
(18, '漫威星際異攻隊', '2021-10-26', '輔導級', 1790, 0, 'Eidos蒙特婁', '\r\n史克威爾艾尼克斯', '《漫威星際異攻隊》（英語：Marvel\'s Guardians of the Galaxy）是由Eidos蒙特婁開發並由史克威爾艾尼克斯歐洲發行的動作冒險遊戲。該遊戲基於漫威漫畫的星際異攻隊漫畫系列，於2021年10月26日在Microsoft Windows、任天堂Switch、PlayStation 4、PlayStation 5、Xbox One和Xbox Series X/S上發佈。'),
(19, '天外世界', '2019-10-25', '限制級', 1790, 0, '黑曜石娛樂', 'Private Division', '《天外世界》（英語：The Outer Worlds，台灣舊譯「外圍世界」）是一款由黑曜石娛樂開發、Private Division發行的動作角色扮演遊戲。本作於2019年10月25日在Microsoft Windows、PlayStation 4及Xbox One平台上推出，此後於2020年6月5日登陸任天堂Switch平台。'),
(20, '超級雞馬', '2016-03-04', '輔導級', 420, 0, 'Clever Endeavor Games', 'Clever Endeavor Games', 'Ultimate Chicken Horse是一款平台視頻遊戲，玩家在其中扮演各種動物的角色。每場比賽的目標是通過一次建造一個平台關卡（每個玩家）來得分，並在關卡另一側的旗幟上相互比賽。玩家添加旨在挑戰對手的障礙，同時確保他們自己能夠處理他們的手藝。如果沒有人達到目標，或者如果每個人都達到目標，那麼沒有人得到任何分數。每輪都會根據各種成就獲得積分，例如首先達到目標或設置成功的陷阱。比賽的獲勝者是在設定的回合數後達到一定分數或得分最多的玩家。每輪估計持續一分鐘。\r\n該遊戲的 PC、Nintendo Switch 和 PlayStation 4 版本支持本地和在線交叉遊戲。'),
(21, 'Ori and the Blind Forest', '2015-03-11', '普通級', 108, 0, '\r\nMoon Studios GmbH', 'Xbox Game Studios', '《Ori and the Blind Forest》通過 Moon Studios 為 PC 製作的視覺震撼動作平台遊戲，講述了一個注定要成為英雄的年輕孤兒的故事。'),
(22, 'Among US', '2018-11-17', '輔導級', 102, 25, '\r\nInnersloth', '\r\nInnersloth', '一款線上與單機皆可玩的派對遊戲，4 至 15 名玩家相互合作與背叛... 一切都發生在太空之中！'),
(23, 'For The King', '2018-04-19', '普通級', 370, 15, '\r\nIronOak Games', '\r\nCurve Games', 'For The King是一款結合桌遊和 roguelike 類型元素的跨越領域戰略型 RPG 遊戲。可以在線和單機進行單人或多人合作的遊戲體驗。'),
(24, '槍火重生', '2021-11-18', '保護級', 318, 0, '\r\nDuoyi Games', '\r\nDuoyi Games', '《槍火重生》是一款融合了第一人稱射擊、Roguelite隨機要素和RPG策略選擇的冒險闖關遊戲。玩家在遊戲裡可以操縱不同能力的英雄組建多種機體的玩法，使用隨機掉落的武器在隨機性關卡中進行冒險挑戰。可以單人暢玩，也可以最多四人組隊挑戰。'),
(25, 'The Walking Dead: The Telltale Definitive Series', '2020-10-30', '限制級', 698, 0, 'Skybound Games', 'Skybound Games', 'The Walking Dead: The Telltale Definitive Series 內含全 4 季遊戲、400 Days 和 The Walking Dead:Michonne，共有 23 個不同章節、超過 50 小時的遊戲內容。'),
(26, '《Unravel Two》', '2018-06-09', '保護級', 808, 25, '\r\nColdwood Interactive\r\n', 'Electronic Arts', '切斷過去的枷鎖，形成新的羈絆。'),
(27, 'SPORE', '2008-12-19', '普通級', 1083, 33, '\r\nMaxis™', '\r\nElectronic Arts ', '通過 Spore 成為您自己的宇宙的建築師，這是一個令人興奮的單人冒險。從單細胞到銀河神，在你自己創造的宇宙中進化你的生物。'),
(28, '《星際大戰：戰場前線™》', '2015-11-16', '輔導級', 1359, 80, 'DICE', '\r\nElectronic Arts', '《星際大戰：戰場前線™》終極版內含《星際大戰：戰場前線™》豪華典藏版，以及《星際大戰：戰場前線™》季票。'),
(29, '雙人成行', '2021-03-26', '輔導級', 1708, 90, 'Hazelight', 'Electronic Arts', '在《雙人成行》中踏上人生中最瘋狂的旅程。利用好友通行證*邀請好友免費遊玩。');

-- --------------------------------------------------------

--
-- 資料表結構 `game_language`
--

CREATE TABLE `game_language` (
  `game_ID` int(11) NOT NULL COMMENT '遊戲編號',
  `game_lang` varchar(150) NOT NULL COMMENT '語言'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- 傾印資料表的資料 `game_language`
--

INSERT INTO `game_language` (`game_ID`, `game_lang`) VALUES
(2, '日文'),
(2, '繁體中文'),
(2, '英文'),
(3, '日文'),
(3, '英文'),
(5, '日文'),
(5, '繁體中文'),
(5, '英文');

-- --------------------------------------------------------

--
-- 資料表結構 `game_pic`
--

CREATE TABLE `game_pic` (
  `game_ID` int(11) NOT NULL,
  `game_picture` varchar(150) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- 傾印資料表的資料 `game_pic`
--

INSERT INTO `game_pic` (`game_ID`, `game_picture`) VALUES
(1, 'product_1'),
(2, 'product_2'),
(3, 'product_3'),
(4, 'product_4'),
(5, 'product_5'),
(6, 'product_6'),
(7, 'product_7'),
(8, 'product_8'),
(9, 'product_9'),
(10, 'product_10'),
(11, 'product_11'),
(12, 'product_12'),
(13, 'product_13'),
(14, 'product_14'),
(15, 'product_15'),
(16, 'product_16'),
(17, 'product_17'),
(18, 'product_18'),
(19, 'product_19'),
(20, 'product_20'),
(21, 'product_21'),
(22, 'product_22'),
(23, 'product_23'),
(24, 'product_24'),
(25, 'product_25'),
(26, 'product_26'),
(27, 'product_27'),
(28, 'product_28'),
(29, 'product_29');

-- --------------------------------------------------------

--
-- 資料表結構 `member_cart`
--

CREATE TABLE `member_cart` (
  `member_account` varchar(64) NOT NULL,
  `game_ID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- 傾印資料表的資料 `member_cart`
--

INSERT INTO `member_cart` (`member_account`, `game_ID`) VALUES
('allan96452', 8),
('allan96452', 9),
('member', 1),
('member', 5),
('Unshun0120', 4),
('Unshun0120', 5),
('Unshun0120', 6);

-- --------------------------------------------------------

--
-- 資料表結構 `member_collection`
--

CREATE TABLE `member_collection` (
  `member_account` varchar(64) NOT NULL,
  `game_ID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- 傾印資料表的資料 `member_collection`
--

INSERT INTO `member_collection` (`member_account`, `game_ID`) VALUES
('allan96452', 10),
('allan96452', 16),
('member', 4),
('member', 21),
('Unshun0120', 15),
('Unshun0120', 22);

-- --------------------------------------------------------

--
-- 資料表結構 `member_comment`
--

CREATE TABLE `member_comment` (
  `game_ID` int(11) NOT NULL,
  `member_account` varchar(64) NOT NULL,
  `comment_time` datetime NOT NULL,
  `comment` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- 傾印資料表的資料 `member_comment`
--

INSERT INTO `member_comment` (`game_ID`, `member_account`, `comment_time`, `comment`) VALUES
(3, 'member', '2022-05-20 11:39:34', '讚讚喔'),
(3, 'member', '2022-05-21 11:39:34', '感覺不錯喔'),
(3, 'Unshun0120', '2022-05-21 11:39:34', '普通~'),
(3, 'Unshun0120', '2022-05-21 11:40:34', '真的還好'),
(4, 'allan96452', '2022-05-20 11:37:30', '好好玩'),
(7, 'allan96452', '2022-05-21 11:37:30', '真讚喔!\r\n');

-- --------------------------------------------------------

--
-- 資料表結構 `member_details`
--

CREATE TABLE `member_details` (
  `member_account` varchar(64) NOT NULL,
  `member_level` varchar(64) NOT NULL,
  `member_cost` int(11) NOT NULL,
  `login_count` int(11) NOT NULL,
  `bought_count` int(11) NOT NULL,
  `score_count` int(11) NOT NULL,
  `comment_count` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- 資料表結構 `member_follow`
--

CREATE TABLE `member_follow` (
  `member_account` varchar(64) NOT NULL,
  `game_ID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- 傾印資料表的資料 `member_follow`
--

INSERT INTO `member_follow` (`member_account`, `game_ID`) VALUES
('allan96452', 22),
('member', 15),
('Unshun0120', 11);

-- --------------------------------------------------------

--
-- 資料表結構 `member_info`
--

CREATE TABLE `member_info` (
  `member_account` varchar(64) NOT NULL COMMENT '會員帳號',
  `member_password` varchar(200) NOT NULL COMMENT '會員密碼',
  `member_email` varchar(64) NOT NULL COMMENT '會員電子信箱',
  `member_name` varchar(30) NOT NULL COMMENT '會員姓名',
  `member_nickname` varchar(30) NOT NULL COMMENT '會員暱稱',
  `member_birth` date NOT NULL COMMENT '會員生日',
  `member_phone` varchar(20) NOT NULL COMMENT '會員電話',
  `member_signupDate` date NOT NULL COMMENT '註冊日期',
  `member_sex` varchar(10) NOT NULL COMMENT '性別'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- 傾印資料表的資料 `member_info`
--

INSERT INTO `member_info` (`member_account`, `member_password`, `member_email`, `member_name`, `member_nickname`, `member_birth`, `member_phone`, `member_signupDate`, `member_sex`) VALUES
('allan96452', '$2y$10$c0aTyVqszG6mtR.zpESvIuBgTZOC4woCsUpLLLZZxMf0bIOI1ZGnS', 'allan96452@gmail.com', '莊明憲', 'Xian', '2001-09-05', '963111111', '2022-05-14', '男性'),
('member', '$2y$10$Vb1ZRb/zVvtUvm26Chx7QegncZBFend8F6H/1WB6WYFcUSVf3Z/I6', 'member@gmail.com', '測試帳號', '測試', '2022-05-14', '912345678', '2022-05-14', '男性'),
('Unshun0120', '$2y$10$PWBkQkOyIqb9aZqxP73o6Olhq3WtxO6fQ9BwMLygLfx1Ksom7d84.', 'unshun0120@gmail.com', '李永紳', '紳', '2001-01-20', '972069867', '2022-05-14', '男性');

--
-- 已傾印資料表的索引
--

--
-- 資料表索引 `admin_info`
--
ALTER TABLE `admin_info`
  ADD PRIMARY KEY (`admin_account`);

--
-- 資料表索引 `deal_record`
--
ALTER TABLE `deal_record`
  ADD PRIMARY KEY (`member_account`,`game_ID`),
  ADD KEY `game_ID` (`game_ID`);

--
-- 資料表索引 `game_categories`
--
ALTER TABLE `game_categories`
  ADD PRIMARY KEY (`game_ID`,`game_type`);

--
-- 資料表索引 `game_info`
--
ALTER TABLE `game_info`
  ADD PRIMARY KEY (`game_ID`);

--
-- 資料表索引 `game_language`
--
ALTER TABLE `game_language`
  ADD PRIMARY KEY (`game_ID`,`game_lang`) USING BTREE;

--
-- 資料表索引 `game_pic`
--
ALTER TABLE `game_pic`
  ADD PRIMARY KEY (`game_ID`,`game_picture`);

--
-- 資料表索引 `member_cart`
--
ALTER TABLE `member_cart`
  ADD PRIMARY KEY (`member_account`,`game_ID`),
  ADD KEY `game_ID` (`game_ID`);

--
-- 資料表索引 `member_collection`
--
ALTER TABLE `member_collection`
  ADD PRIMARY KEY (`member_account`,`game_ID`),
  ADD KEY `game_ID` (`game_ID`);

--
-- 資料表索引 `member_comment`
--
ALTER TABLE `member_comment`
  ADD PRIMARY KEY (`game_ID`,`member_account`,`comment_time`),
  ADD KEY `member_account` (`member_account`);

--
-- 資料表索引 `member_details`
--
ALTER TABLE `member_details`
  ADD PRIMARY KEY (`member_account`);

--
-- 資料表索引 `member_follow`
--
ALTER TABLE `member_follow`
  ADD PRIMARY KEY (`member_account`,`game_ID`),
  ADD KEY `game_ID` (`game_ID`);

--
-- 資料表索引 `member_info`
--
ALTER TABLE `member_info`
  ADD PRIMARY KEY (`member_account`);

--
-- 在傾印的資料表使用自動遞增(AUTO_INCREMENT)
--

--
-- 使用資料表自動遞增(AUTO_INCREMENT) `game_info`
--
ALTER TABLE `game_info`
  MODIFY `game_ID` int(11) NOT NULL AUTO_INCREMENT COMMENT '遊戲編號', AUTO_INCREMENT=30;

--
-- 已傾印資料表的限制式
--

--
-- 資料表的限制式 `deal_record`
--
ALTER TABLE `deal_record`
  ADD CONSTRAINT `deal_record_ibfk_1` FOREIGN KEY (`game_ID`) REFERENCES `game_info` (`game_ID`) ON DELETE CASCADE ON UPDATE NO ACTION,
  ADD CONSTRAINT `deal_record_ibfk_2` FOREIGN KEY (`member_account`) REFERENCES `member_info` (`member_account`) ON DELETE CASCADE ON UPDATE NO ACTION;

--
-- 資料表的限制式 `game_categories`
--
ALTER TABLE `game_categories`
  ADD CONSTRAINT `game_categories_ibfk_1` FOREIGN KEY (`game_ID`) REFERENCES `game_info` (`game_ID`) ON DELETE CASCADE ON UPDATE NO ACTION;

--
-- 資料表的限制式 `game_language`
--
ALTER TABLE `game_language`
  ADD CONSTRAINT `game_language_ibfk_1` FOREIGN KEY (`game_ID`) REFERENCES `game_info` (`game_ID`) ON DELETE CASCADE ON UPDATE NO ACTION;

--
-- 資料表的限制式 `game_pic`
--
ALTER TABLE `game_pic`
  ADD CONSTRAINT `game_pic_ibfk_1` FOREIGN KEY (`game_ID`) REFERENCES `game_info` (`game_ID`) ON DELETE CASCADE ON UPDATE NO ACTION;

--
-- 資料表的限制式 `member_cart`
--
ALTER TABLE `member_cart`
  ADD CONSTRAINT `member_cart_ibfk_1` FOREIGN KEY (`game_ID`) REFERENCES `game_info` (`game_ID`) ON DELETE CASCADE ON UPDATE NO ACTION,
  ADD CONSTRAINT `member_cart_ibfk_2` FOREIGN KEY (`member_account`) REFERENCES `member_info` (`member_account`) ON DELETE CASCADE ON UPDATE NO ACTION;

--
-- 資料表的限制式 `member_collection`
--
ALTER TABLE `member_collection`
  ADD CONSTRAINT `member_collection_ibfk_1` FOREIGN KEY (`member_account`) REFERENCES `member_info` (`member_account`) ON DELETE CASCADE ON UPDATE NO ACTION,
  ADD CONSTRAINT `member_collection_ibfk_2` FOREIGN KEY (`game_ID`) REFERENCES `game_info` (`game_ID`) ON DELETE CASCADE ON UPDATE NO ACTION;

--
-- 資料表的限制式 `member_comment`
--
ALTER TABLE `member_comment`
  ADD CONSTRAINT `member_comment_ibfk_1` FOREIGN KEY (`game_ID`) REFERENCES `game_info` (`game_ID`) ON DELETE CASCADE ON UPDATE NO ACTION,
  ADD CONSTRAINT `member_comment_ibfk_2` FOREIGN KEY (`member_account`) REFERENCES `member_info` (`member_account`) ON DELETE CASCADE ON UPDATE NO ACTION;

--
-- 資料表的限制式 `member_details`
--
ALTER TABLE `member_details`
  ADD CONSTRAINT `member_details_ibfk_1` FOREIGN KEY (`member_account`) REFERENCES `member_info` (`member_account`) ON DELETE CASCADE ON UPDATE NO ACTION;

--
-- 資料表的限制式 `member_follow`
--
ALTER TABLE `member_follow`
  ADD CONSTRAINT `member_follow_ibfk_1` FOREIGN KEY (`game_ID`) REFERENCES `game_info` (`game_ID`) ON DELETE CASCADE ON UPDATE NO ACTION,
  ADD CONSTRAINT `member_follow_ibfk_2` FOREIGN KEY (`member_account`) REFERENCES `member_info` (`member_account`) ON DELETE CASCADE ON UPDATE NO ACTION;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
