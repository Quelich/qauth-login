
/*Create accounts table to store user information*/
CREATE TABLE IF NOT EXISTS accounts (
id int(11) NOT NULL AUTO_INCREMENT,
username varchar(50) NOT NULL,
password varchar(300) NOT NULL,
email varchar(100) NOT NULL,
phone varchar(50) NOT NULL,
address varchar(200) NOT NULL,
PRIMARY KEY (id)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;
