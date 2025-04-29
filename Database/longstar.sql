
CREATE TABLE longstar;

USE longstar;

CREATE TABLE admin (
    id INT(11) PRIMARY KEY AUTO_INCREMENT,
    username VARCHAR(255),
    password VARCHAR(255),
    creationDate DATETIME DEFAULT CURRENT_TIMESTAMP()
);

CREATE TABLE adminLogs (
    id INT(11) PRIMARY KEY AUTO_INCREMENT,
    adminId INT(11),
    logInTime DATETIME DEFAULT CURRENT_TIMESTAMP(),
    logOutTime VARCHAR(255) DEFAULT NULL
);

CREATE TABLE users (
    id INT(11) PRIMARY KEY AUTO_INCREMENT,
    username VARCHAR(255),
    email VARCHAR(255),
    gender VARCHAR(255),
    password VARCHAR(255),
    phoneNumber VARCHAR(255),
    state VARCHAR(255),
    pinCode INT(11),
    address VARCHAR(255),
    creationDate DATETIME DEFAULT CURRENT_TIMESTAMP(),
    updationDate DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

CREATE TABLE userlogs (
    loginId INT(11) PRIMARY KEY AUTO_INCREMENT,
    userId INT(11),
    loggedIn DATETIME DEFAULT CURRENT_TIMESTAMP(),
    loggedOut VARCHAR(255) DEFAULT "In"
);

CREATE TABLE orders (
    id INT(11) PRIMARY KEY AUTO_INCREMENT,
    userId INT(11),
    productId INT(11),
    quantity INT(11),
    price INT(11),
    total INT(11),
    mode VARCHAR(255),
    creationDate DATETIME DEFAULT CURRENT_TIMESTAMP()
);

CREATE TABLE category (
    id INT(11) PRIMARY KEY AUTO_INCREMENT,
    categoryId INT(11),
    categoryName VARCHAR(255),
    categoryImage VARCHAR(255),
    categoryDescription VARCHAR(255),
    creationDate DATETIME DEFAULT CURRENT_TIMESTAMP(),
    updationDate DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

CREATE TABLE products (
    id INT(11) PRIMARY KEY AUTO_INCREMENT,
    categoryId INT(11),
    productName VARCHAR(255),
    productDescription VARCHAR(255),
    price INT(11),
    availability INT(11),
    isDeleted BOOLEAN DEFAULT FALSE,
    productImage1 VARCHAR(255),
    productImage2 VARCHAR(255),
    productImage3 VARCHAR(255),
    creationDate DATETIME DEFAULT CURRENT_TIMESTAMP(),
    updationDate DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

CREATE TABLE cart (
    id INT(11) PRIMARY KEY AUTO_INCREMENT,
    userId INT(11),
    productId int(11),
    insertionDate DATETIME DEFAULT CURRENT_TIMESTAMP()
);

CREATE TABLE wishlist (
    id int(11) PRIMARY KEY AUTO_INCREMENT,
    productId int(11),
    userId int(11),
    insertionDate DATETIME DEFAULT CURRENT_TIMESTAMP()
);

CREATE TABLE deletedProducts (
    id INT(11) PRIMARY KEY AUTO_INCREMENT,
    productId INT(11) NOT NULL,
    productName VARCHAR(255) NOT NULL,
    productPrice VARCHAR(255) NOT NULL,
    productImage VARCHAR(255) DEFAULT NULL,
    deletionDate DATETIME DEFAULT CURRENT_TIMESTAMP()
);

CREATE TABLE trackorder (
    id INT(11) PRIMARY KEY AUTO_INCREMENT,
    orderId INT(11) NOT NULL,
    userId INT(11),
    productId int(11),
    orderStatus VARCHAR(255) DEFAULT "Order Received",
    expectedDelivery VARCHAR(255),
    orderReceived DATETIME DEFAULT CURRENT_TIMESTAMP(),
    updationDate DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);