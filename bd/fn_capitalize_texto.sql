-- Active: 1731884224365@@127.0.0.1@3306@admin_brartnet
DELIMITER $$

CREATE FUNCTION fn_capitalize_texto(input VARCHAR(255)) RETURNS VARCHAR(255)
BEGIN
    RETURN CONCAT(UPPER(SUBSTRING(input, 1, 1)), LOWER(SUBSTRING(input, 2)));
END $$

DELIMITER ;