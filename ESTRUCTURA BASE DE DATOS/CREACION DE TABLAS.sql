CREATE TABLE client (
    clt_id INT AUTO_INCREMENT,
    name_clt VARCHAR(50) NOT NULL,
    username VARCHAR(50) UNIQUE NOT NULL,
    passwd_clt VARCHAR(50) NOT NULL,
    email_clt VARCHAR(50) UNIQUE NOT NULL,
    phone_clt VARCHAR(20),
    address_clt TEXT NOT NULL,
    CONSTRAINT pk_client PRIMARY KEY (clt_id)
);
CREATE TABLE product (
    product_id INT AUTO_INCREMENT,
    name_pd VARCHAR(100) NOT NULL,
    description_pd TEXT NOT NULL,
    price DECIMAL(10, 2) NOT NULL,
    inventory INT NOT NULL,
    image_url TEXT NOT NULL,
    CONSTRAINT pk_product PRIMARY KEY (product_id)
);
CREATE TABLE admin (
    admin_id INT AUTO_INCREMENT,
    user_adm VARCHAR(100) UNIQUE NOT NULL,
    passwd_adm VARCHAR(100) NOT NULL,
    CONSTRAINT pk_admin PRIMARY KEY (admin_id)
);
CREATE TABLE purchase (
    purchase_id INT AUTO_INCREMENT,
    clt_id INT,
    purchase_date TIMESTAMP NOT NULL,
    total DECIMAL(10, 2) NOT NULL,
    CONSTRAINT pk_purchase PRIMARY KEY (purchase_id),
    CONSTRAINT fk_clt_id FOREIGN KEY (clt_id) REFERENCES client(clt_id) ON DELETE
    SET NULL ON UPDATE CASCADE
);
CREATE TABLE purchase_detail (
    detail_id INT AUTO_INCREMENT,
    purchase_id INT,
    product_id INT,
    quantity INT NOT NULL,
    CONSTRAINT pk_purchase_detail PRIMARY KEY (detail_id),
    CONSTRAINT fk_purchase_id FOREIGN KEY (purchase_id) REFERENCES purchase(purchase_id) ON DELETE CASCADE ON UPDATE CASCADE,
    CONSTRAINT fk_product_id FOREIGN KEY (product_id) REFERENCES product(product_id) ON DELETE
    SET NULL ON UPDATE CASCADE
);
CREATE TABLE sale (
    sale_id INT AUTO_INCREMENT,
    admin_id INT,
    product_id INT,
    quantity_sold INT NOT NULL,
    sale_date TIMESTAMP NOT NULL,
    CONSTRAINT pk_sale PRIMARY KEY (sale_id),
    CONSTRAINT fk_admin_id FOREIGN KEY (admin_id) REFERENCES admin(admin_id) ON DELETE
    SET NULL ON UPDATE CASCADE,
        CONSTRAINT fk_product_id FOREIGN KEY (product_id) REFERENCES product(product_id) ON DELETE
    SET NULL ON UPDATE CASCADE
);