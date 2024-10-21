-- Inserciones para la tabla client
INSERT INTO client (
        name_clt,
        username,
        passwd_clt,
        email_clt,
        phone_clt,
        address_clt
    )
VALUES (
        'Juan Pérez',
        'juanp',
        'contrasena123',
        'juan.perez@example.com',
        '555-1234',
        'Calle Principal 123'
    ),
    (
        'María López',
        'marial',
        'contrasena456',
        'maria.lopez@example.com',
        '555-5678',
        'Avenida Secundaria 456'
    );
-- Inserciones para la tabla product
INSERT INTO product (
        name_pd,
        description_pd,
        price,
        inventory,
        image_url
    )
VALUES (
        'Galletas',
        'Caja de dos paquetes de galletas con chispas con chocolate',
        10.00,
        100,
        'galletas.jpg' -- actualizar url
    ),
    (
        'Jamon',
        'Paquete de 1 kg de jamon de pavo',
        20.00,
        80,
        'jamon.jpg' -- atualizar url
    ),
    (
        'Leche',
        'Botella de 1 litro de leche entera de vaca',
        30.00,
        50,
        'Leche-esta-es-la-mas-saludable-que-puedes-consumir.jpg'
    ),
    (
        'Papas',
        'Bolsa de papas de 100 gr',
        40.00,
        70,
        'papas.jpg'
    );
-- Inserciones para la tabla admin
INSERT INTO admin (user_adm, passwd_adm)
VALUES ('admin1', 'admincontrasena1'),
    ('admin2', 'admincontrasena2');