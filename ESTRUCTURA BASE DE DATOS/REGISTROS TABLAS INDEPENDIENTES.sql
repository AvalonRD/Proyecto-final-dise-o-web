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
        'Arroz',
        'Paquete de 1 kg de arroz',
        20.50,
        100,
        'arroz.jpg' -- actualizar url
    ),
    (
        'Frijoles',
        'Paquete de 1 kg de frijoles',
        25.00,
        80,
        'frijoles.jpg' -- atualizar url
    ),
    (
        'Aceite',
        'Botella de 1 litro de aceite vegetal',
        30.00,
        50,
        'aceite.jpg'
    ),
    (
        'Azúcar',
        'Paquete de 1 kg de azúcar',
        18.00,
        70,
        'azucar.jpg'
    );
-- Inserciones para la tabla admin
INSERT INTO admin (user_adm, passwd_adm)
VALUES ('admin1', 'admincontrasena1'),
    ('admin2', 'admincontrasena2');