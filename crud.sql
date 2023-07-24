CREATE TABLE testintervolga.comments (
	id INT auto_increment NOT NULL,
	comment TEXT NOT NULL,
	username varchar(100) NOT NULL,
	datetimecomment DATETIME NOT NULL,
	CONSTRAINT comments_PK PRIMARY KEY (id)
)
ENGINE=InnoDB
DEFAULT CHARSET=utf8mb4
COLLATE=utf8mb4_general_ci;