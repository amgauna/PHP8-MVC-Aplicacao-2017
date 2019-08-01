CREATE TABLE users(
    id INT UNSIGNED NOT NULL AUTO_INCREMENT,
    name VARCHAR(50),
    email VARCHAR(80) NOT NULL,
    password VARCHAR(40) NOT NULL,
    PRIMARY KEY(id)
) COLLATE=utf8_unicode_ci;

// Vamos inserir alguns registros para nossos testes.

INSERT INTO users(name, email, password) VALUES
('Usuário 1', 'user1@user.com', '123'),
('Usuário 2', 'user2@user.com', '456'),
('Usuário 3', 'user3@user.com', '789');