/*
Navicat MySQL Data Transfer

Source Server         : Xamp2
Source Server Version : 50616
Source Host           : 127.0.0.1:3306
Source Database       : vote

Target Server Type    : MYSQL
Target Server Version : 50616
File Encoding         : 65001

Date: 2014-09-28 23:25:46
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for account
-- ----------------------------
DROP TABLE IF EXISTS `account`;
CREATE TABLE `account` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `account` varchar(50) NOT NULL,
  `password` varchar(50) NOT NULL,
  `fullname` varchar(50) NOT NULL,
  `avatar` varchar(50) DEFAULT 'avatar-default.jpg',
  `unit_id` int(11) NOT NULL,
  `teaching` text NOT NULL,
  `introduced` text NOT NULL,
  `status` int(5) DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of account
-- ----------------------------
INSERT INTO `account` VALUES ('1', 'admin', 'e10adc3949ba59abbe56e057f20f883e', 'Phạm Tất Đạt', 'avatar-1.jpg', '1', 'Phát triển ứng dụng web', 'Hôm nay, xin chia sẻ với anh em hình ảnh ngôi sao thời trang Hạ Anh cùng tai nghe độ dán da trang trí từ Khắc Tên. Bộ ảnh này được nhiếp ảnh gia ProK thực hiện. Tai nghe dùng trong loạt này là chiếc Harman Kardon CL màu đen và được thiết kế bên Khắc Tên trang trí lại với màu vàng và màu tím. Chẳng biết nói gì hơn, thôi anh em coi hình đi. Nhiếp Ảnh Gia: ProK Đặng Quốc Chương Mẫu: Hạ Anh, Ngôi Sao Thời Trang Máy: Tai nghe trang trí da từ...', '3');
INSERT INTO `account` VALUES ('2', 'manhnb', 'e10adc3949ba59abbe56e057f20f883e', 'Bùi Tiến Mạnh', 'avatar-2.jpg', '2', 'Phát triển ứng dụng web', 'Phân khúc xe hatchback cao cấp chỉ thật sự nóng lên vào giữa năm ngoái, khi Mercedes Benz khuấy động thị trường Việt Nam với việc lần đầu ra mắt chiếc A-class thế hệ thứ 3. Ngay sau đó, BMW cũng kịp thời ra mắt chiếc BMW 116i để cạnh tranh với đối thủ A200 thấp nhất trong dòng A-class của Mercedes.', '2');
INSERT INTO `account` VALUES ('3', 'ngant', 'e10adc3949ba59abbe56e057f20f883e', 'Nguyễn Thị Ngân', 'avatar-3.jpg', '1', 'Phát triển ứng dụng web', 'Toshiba mới đây thông báo hãng sẽ thúc đẩy quá trình tái cấu trúc ngành hàng PC của mình nhằm tập trung hơn vào các sản phẩm dành cho doanh nghiệp (Business to Business - B2B), đồng thời thu hẹp phân khúc hướng đến người tiêu dùng (Business to Consumer - B2C)', '2');
INSERT INTO `account` VALUES ('4', 'thaont', 'e10adc3949ba59abbe56e057f20f883e', 'Nguyễn Thị Thảo', 'avatar-4.jpg', '1', 'Không gì cả', 'Trong bài đánh giá hôm nay, chúng ta hãy cùng điểm qua những ưu nhược điểm và hiệu năng của chiếc máy tính 2 trong 1 ASUS Transformer Book T200. Đây là phiên bản nâng cấp của chiếc Transformer Book T100 năm ngoái.', '2');
INSERT INTO `account` VALUES ('5', 'thongbm', 'e10adc3949ba59abbe56e057f20f883e', 'Bùi Minh Thông', 'avatar-5.jpg', '1', 'Công nghệ phần mềm', 'Sở hữu một chiếc ô tô ở Việt Nam là cả một vấn đề không hề đơn giản, vì ngoài việc mua xe với mức giá cao do chịu nhiều loại thuế thì trong quá trình sử dụng nó chúng ta còn phải gánh thêm rất nhiều chi phí nuôi xe khác', '2');
INSERT INTO `account` VALUES ('6', 'kunny171', 'e10adc3949ba59abbe56e057f20f883e', 'Phạm Tất Đạt', 'avatar-6.jpg', '1', 'Công nghệ phần mềm', 'Chiếc tablet Kindle Fire HDX 8.9\" của Amazon năm nay đã được nâng cấp mới với chip xử lý Snapdragon 805 nhanh hơn, cải tiến công nghệ âm thanh Dolby Atmos, chạy trên hệ điều hành Fire OS 4 mới nhất, pin 12 tiếng và có luôn tính năng tìm thông tin đồ vật Firefly vốn trước đây chỉ có trên điện thoại Fire của hãng này.', '2');
INSERT INTO `account` VALUES ('7', 'sennt', 'e10adc3949ba59abbe56e057f20f883e', 'Nguyễn Thị Sen', 'avatar-7.jpg', '3', 'Mạng máy tính', 'Đúng như tên gọi của nó, Fire HD Kids Edition là một chiếc tablet dành riêng cho trẻ em và Amazon đã rất cố gắng làm cho nó phù hợp nhất có thể đối với lứa tuổi thiếu nhi. Mặc dù nó mắc hơn bản Fire HD thường 50 USD nhưng bù lại các bậc cha mẹ sẽ yên tâm hơn nhiều vì Amazon chấp nhận bảo hành tất cả mọi sự cố hỏng hóc trong vòng 2 năm và trả lại máy mới.', '2');
INSERT INTO `account` VALUES ('8', 'test', 'e10adc3949ba59abbe56e057f20f883e', 'test', 'avatar-8.jpg', '3', 'Chế tạo máy', 'Khoa CNTT', '1');

-- ----------------------------
-- Table structure for guide
-- ----------------------------
DROP TABLE IF EXISTS `guide`;
CREATE TABLE `guide` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` text NOT NULL,
  `content` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of guide
-- ----------------------------
INSERT INTO `guide` VALUES ('1', ' Aku ora mudheng carane gawe web ki pie jal?', '<p><span style=\"font-family: Helvetica, sans-serif; background-color: rgb(255, 255, 255); font-weight: bold;\">Yo kudu sinau no mas bro, kan saiki okeh referensi nggo sinau. Ono buku, ono internet ono konco dll. Kowe modal komputer karo koneksi internet wae kowe mesti isoh gawe web dalam jangka waktu kurang dari sebulan kok.</span></p><p><span style=\"font-family: Helvetica, sans-serif; background-color: rgb(255, 255, 255); font-weight: bold;\"><a href=\"http://www.upsieutoc.com/images/2014/09/20/358b12.jpg\">http://www.upsieutoc.com/images/2014/09/20/358b12.jpg</a><br></span></p>');
INSERT INTO `guide` VALUES ('9', ' Aku ora mudheng carane gawe web ki pie jal?', '<p><span style=\"font-family: Helvetica, sans-serif; background-color: rgb(255, 255, 255); font-weight: bold;\">Yo kudu sinau no mas bro, kan saiki okeh referensi nggo sinau. Ono buku, ono internet ono konco dll. Kowe modal komputer karo koneksi internet wae kowe mesti isoh gawe web dalam jangka waktu kurang dari sebulan kok.</span></p><p><span style=\"font-family: Helvetica, sans-serif; background-color: rgb(255, 255, 255); font-weight: bold;\"><a href=\"http://www.upsieutoc.com/images/2014/09/20/358b12.jpg\">http://www.upsieutoc.com/images/2014/09/20/358b12.jpg</a><br></span></p>');

-- ----------------------------
-- Table structure for unit
-- ----------------------------
DROP TABLE IF EXISTS `unit`;
CREATE TABLE `unit` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `unit_name` text NOT NULL,
  `unit_des` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of unit
-- ----------------------------
INSERT INTO `unit` VALUES ('1', 'Cục Thuế', 'Cục Thuế');
INSERT INTO `unit` VALUES ('2', 'Cục Xuất Nhập Khẩu', 'Cục Xuất Nhập Khẩu');
INSERT INTO `unit` VALUES ('3', 'Cục Hải Quan', 'Cục Hải Quan');
INSERT INTO `unit` VALUES ('4', 'Cục Tổng Ngành', 'Cục Tổng Ngành');

-- ----------------------------
-- Table structure for vote
-- ----------------------------
DROP TABLE IF EXISTS `vote`;
CREATE TABLE `vote` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `account_id` int(11) NOT NULL,
  `account_vote` int(11) NOT NULL,
  `time` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `account_id1` (`account_id`),
  CONSTRAINT `fk_user_vote` FOREIGN KEY (`account_id`) REFERENCES `account` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of vote
-- ----------------------------
INSERT INTO `vote` VALUES ('1', '1', '4', '2014-09-19 14:57:19');
INSERT INTO `vote` VALUES ('2', '2', '3', '2014-09-19 14:57:34');
INSERT INTO `vote` VALUES ('3', '7', '5', '2014-09-19 14:58:01');
INSERT INTO `vote` VALUES ('4', '1', '6', '2014-09-19 14:58:11');
INSERT INTO `vote` VALUES ('5', '3', '2', '2014-09-19 17:35:07');

-- ----------------------------
-- Table structure for vote_time
-- ----------------------------
DROP TABLE IF EXISTS `vote_time`;
CREATE TABLE `vote_time` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `timestart` datetime NOT NULL,
  `timeend` datetime NOT NULL,
  `active` int(11) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of vote_time
-- ----------------------------
INSERT INTO `vote_time` VALUES ('1', '2014-09-20 22:02:20', '2014-09-27 19:02:29', '1');

-- ----------------------------
-- View structure for account_info
-- ----------------------------
DROP VIEW IF EXISTS `account_info`;
CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost`  VIEW `account_info` AS SELECT account.*, unit.unit_name, unit.unit_des FROM account JOIN unit WHERE account.unit_id = unit.id ;

-- ----------------------------
-- View structure for vote_info
-- ----------------------------
DROP VIEW IF EXISTS `vote_info`;
CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost`  VIEW `vote_info` AS SELECT vote.*, account_info.fullname as account_id_voted, account_info.unit_id, account_info.unit_name, account_info.avatar, account_info.`status` FROM `vote` JOIN account_info WHERE vote.account_id = account_info.id ;
