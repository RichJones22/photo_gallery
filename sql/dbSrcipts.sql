Mysql -u gallery -p photo_gallery

create database photo_gallery;

use photo_gallery;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE `users` (
  `id` int(11) NOT NULL auto_increment,
  `username` varchar(50) NOT NULL,
  `password` varchar(40) NOT NULL,
  `first_name` varchar(30) NOT NULL,
  `last_name` varchar(30) NOT NULL,
  PRIMARY KEY  (`id`)
) AUTO_INCREMENT=2;

grant all privileges on photo_gallery.* 
to 'gallery'@'localhost'
identified by 'password';


create table photographs (
id int(11) not null auto_increment primary key,
filename varchar(255) not null,
type varchar(100) not null,
size int(11) not null,
caption varchar(255) not null
);


create table comments (
id int(11) not null auto_increment primary key,
photograph_id int(11) not null,
created datetime not null,
author varchar(250) not null,
body text not null
);

--
-- add index to foriegn id, photograph_id
--
alter table comments add index (photograph_id);



