CREATE TABLE IF NOT EXISTS user_loved_books (
    id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(255) NOT NULL,
    author VARCHAR(255) NOT NULL,
    genre VARCHAR(100),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    email VARCHAR(100) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE cart (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    title VARCHAR(255),
    author VARCHAR(255),
    image VARCHAR(255),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    quantity INT DEFAULT 1
);

CREATE TABLE books (
    id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(255),
    author VARCHAR(255),
    image VARCHAR(255),
    ganre VARCHAR(100),
    price DECIMAL(6,2),
    season ENUM('WINTER', 'SPRING', 'SUMMER', 'AUTUMN')
);
ALTER TABLE books ADD COLUMN description TEXT;

INSERT INTO books (title, author, image, ganre, description, price, season)
VALUES ('The Book Eaters', 'Sunyi Dean', '/imgs/books/book1.jpg', 'Roman', 'An unusual sci-fi story about a book eater woman who tries desperately to save her dangerous mind-eater son from tradition and certain death. Complete with dysfunctional family values, light Sapphic romance, and a strong, complex protagonist. Not for the faint of heart.', 12.99, 'WINTER');

ALTER TABLE cart
ADD COLUMN book_id INT,
ADD COLUMN description TEXT;

INSERT INTO books (title, author, description, season, price, image, ganre)
VALUES 
(
  'Cackle',
  'Rachel Harrison',
  'Are your Halloween movies of choice The Witches of Eastwick and Practical Magic? Look no further than here - where a woman recovering from a breakup moves to a quaint town in upstate New York and befriends a beautiful witch.',
  'WINTER',
  13.99,
  '/imgs/books/book2.jpg',
  'Fantasy'
);
INSERT INTO books (title, author, description, season, price, image, ganre)
VALUES 
(
  'The Body',
  'Stephen King',
  'Powerful novel that takes you back to a nostalgic time, exploring both the beauty and danger and loss of innocence that is youth.',
  'SPRING',
  11.49,
  '/imgs/books/spring1.jpg',
  'Drama'
),
(
  'Carry: A Memoir of Survival on Stolen Land',
  'Toni Jenson',
  'This memoir about the author''s relationship with gun violence feels both expansive and intimate, resulting in a lyrical indictment of the way things are.',
  'SPRING',
  12.75,
  '/imgs/books/spring2.jpg',
  'Memoir'
);
INSERT INTO books (title, author, description, season, price, image, ganre)
VALUES 
(
  'Crude: A Memoir',
  'Pablo Fajardo & ​​Sophie Tardy-Joubert',
  'Drawing and color by Damien Roudeau | This book illustrates the struggles of a group of indigenous Ecuadoreans as they try to sue the ChevronTexaco company for damage their oil fields did to the Amazon and her people.',
  'SUMMER',
  14.25,
  '/imgs/books/summer1.jpg',
  'Graphic Novel'
),
(
  'Let My People Go Surfing',
  'Yvon Chouinard',
  'Chouinard—climber, businessman, environmentalist—shares tales of courage and persistence from his experience of founding and leading Patagonia, Inc.',
  'SUMMER',
  15.50,
  '/imgs/books/summer2.jpg',
  'Biography'
);
INSERT INTO books (title, author, description, season, price, image, ganre)
VALUES 
(
  'Casual Conversation',
  'Renia White',
  'White''s impressive debut collection takes readers through and beyond the concepts of conversation and the casual - both what we say to each other and what we don''t, examining the possibilities around how we construct and communicate identity.',
  'AUTUMN',
  12.30,
  '/imgs/books/autumn1.jpg',
  'Poetry'
),
(
  'The Great Fire',
  'Lou Ureneck',
  'The harrowing story of an ordinary American and a principled Naval officer who, horrified by the burning of Smyrna, led an extraordinary rescue effort that saved a quarter of a million refugees from the Armenian Genocide.',
  'AUTUMN',
  14.99,
  '/imgs/books/autumn2.jpg',
  'History'
);


