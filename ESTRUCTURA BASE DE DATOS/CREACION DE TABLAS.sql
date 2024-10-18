CREATE TABLE usuario (
    usr_id INT AUTO_INCREMENT,
    name_usr VARCHAR(50) NOT NULL,
    username VARCHAR(50) UNIQUE NOT NULL,
    passwd_usr VARCHAR(50) NOT NULL,
    email_usr VARCHAR(50) UNIQUE NOT NULL,
    phone_user VARCHAR(20),
    adress_usr TEXT NOT NULL,
    CONSTRAINT pk_usuario PRIMARY KEY (usr_id)
);
CREATE TABLE producto (
    product_id INT AUTO_INCREMENT,
    name_pd VARCHAR(100) NOT NULL,
    description_pd TEXT NOT NULL,
    price DECIMAL(10, 2) NOT NULL,
    inventory INT NOT NULL,
    image_url TEXT NOT NULL,
    CONSTRAINT pk_producto PRIMARY KEY (product_id)
);
CREATE TABLE admin (
    admin_id INT AUTO_INCREMENT,
    user_adm VARCHAR(100) UNIQUE NOT NULL,
    passwd_adm VARCHAR(100) NOT NULL,
    CONSTRAINT pk_admin PRIMARY KEY (admin_id)
);
CREATE TABLE buy (
    buy_id INT AUTO_INCREMENT,
    user_id INT,
    buy_date TIMESTAMP NOT NULL,
    total DECIMAL(10, 2) NOT NULL,
    CONSTRAINT pk_buy PRIMARY KEY (buy_id),
    CONSTRAINT fk_user_id FOREIGN KEY (user_id) REFERENCES usuario(usr_id) ON DELETE
    SET NULL ON UPDATE CASCADE
);
CREATE TABLE buy_detail (
    detail_id INT AUTO_INCREMENT,
    buy_id INT,
    product_id INT,
    quantity INT NOT NULL,
    CONSTRAINT pk_buy_detail PRIMARY KEY (detail_id),
    CONSTRAINT fk_buy_id FOREIGN KEY (buy_id) REFERENCES buy(buy_id) ON DELETE CASCADE ON UPDATE CASCADE,
    CONSTRAINT fk_product_id FOREIGN KEY (product_id) REFERENCES producto(product_id) ON DELETE
    SET NULL ON UPDATE CASCADE
);
CREATE TABLE venta (
    venta_id INT AUTO_INCREMENT,
    admin_id INT,
    product_id INT,
    quantity_sold INT NOT NULL,
    sale_date TIMESTAMP NOT NULL,
    CONSTRAINT pk_venta PRIMARY KEY (venta_id),
    CONSTRAINT fk_admin_id FOREIGN KEY (admin_id) REFERENCES admin(admin_id) ON DELETE
    SET NULL ON UPDATE CASCADE,
        CONSTRAINT fk_product_id FOREIGN KEY (product_id) REFERENCES producto(product_id) ON DELETE
    SET NULL ON UPDATE CASCADE
);