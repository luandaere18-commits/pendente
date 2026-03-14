SELECT 
    id, 
    nome, 
    contactos, 
    CHAR_LENGTH(contactos) as contactos_size
FROM formadores 
LIMIT 5;
