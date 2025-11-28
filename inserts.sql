-- Inserts para tabela usuarios
INSERT INTO `usuarios` (`nome_usuario`, `usuario`, `senha`) VALUES
('Admin', 'admin@construcasa.com', 'admin123'),
('João Silva', 'joao.silva@construcasa.com', 'senha123'),
('Maria Oliveira', 'maria.oliveira@construcasa.com', 'senha123'),
('Pedro Santos', 'pedro.santos@construcasa.com', 'senha123'),
('Ana Costa', 'ana.costa@construcasa.com', 'senha123'),
('Carlos Pereira', 'carlos.pereira@construcasa.com', 'senha123'),
('Fernanda Lima', 'fernanda.lima@construcasa.com', 'senha123'),
('Lucas Souza', 'lucas.souza@construcasa.com', 'senha123'),
('Juliana Alves', 'juliana.alves@construcasa.com', 'senha123'),
('Roberto Ferreira', 'roberto.ferreira@construcasa.com', 'senha123');

-- Inserts para tabela fornecedor
INSERT INTO `fornecedor` (`nome_fornecedor`, `destino`, `cnpj_empresa`, `local_empresa`) VALUES
('Cimento Forte', 'São Paulo', '12.345.678/0001-90', 'São Paulo - SP'),
('Tijolos Brasil', 'Rio de Janeiro', '98.765.432/0001-10', 'Rio de Janeiro - RJ'),
('Areia e Pedra Ltda', 'Minas Gerais', '11.222.333/0001-44', 'Belo Horizonte - MG'),
('Tintas Coloridas', 'Paraná', '55.666.777/0001-88', 'Curitiba - PR'),
('Ferro e Aço S.A.', 'Rio Grande do Sul', '99.888.777/0001-22', 'Porto Alegre - RS'),
('Madeireira do Norte', 'Amazonas', '33.444.555/0001-66', 'Manaus - AM'),
('Vidros e Espelhos', 'Santa Catarina', '77.888.999/0001-33', 'Florianópolis - SC'),
('Elétrica Segura', 'Bahia', '22.333.444/0001-55', 'Salvador - BA'),
('Hidráulica Total', 'Pernambuco', '66.777.888/0001-11', 'Recife - PE'),
('Telhas e Coberturas', 'Goiás', '44.555.666/0001-99', 'Goiânia - GO');

-- Inserts para tabela cadastro_produto
-- Assumindo que os fornecedores têm IDs de 1 a 10
INSERT INTO `cadastro_produto` (`fk_fornecedor`, `nome_produto`, `peso_produto`, `unidade_medida`, `data_cadastro`, `preco_unitario`, `data_validade`, `nota_fiscal`) VALUES
(1, 'Cimento CP II', '50kg', 'Saco', '2023-01-10', '35.00', '2024-01-10', 'NF-1001'),
(2, 'Tijolo Baiano', '2kg', 'Milheiro', '2023-01-12', '800.00', '2030-12-31', 'NF-1002'),
(3, 'Areia Média', '1000kg', 'Metro Cúbico', '2023-01-15', '120.00', '2030-12-31', 'NF-1003'),
(4, 'Tinta Acrílica Branca', '18L', 'Lata', '2023-01-20', '250.00', '2025-06-30', 'NF-1004'),
(5, 'Vergalhão 3/8', '12m', 'Barra', '2023-01-25', '45.00', '2030-12-31', 'NF-1005'),
(6, 'Tábua de Pinus', '3m', 'Unidade', '2023-02-01', '25.00', '2030-12-31', 'NF-1006'),
(7, 'Janela de Vidro', '1.20x1.00m', 'Unidade', '2023-02-05', '400.00', '2030-12-31', 'NF-1007'),
(8, 'Fio 2.5mm', '100m', 'Rolo', '2023-02-10', '150.00', '2030-12-31', 'NF-1008'),
(9, 'Cano PVC 100mm', '6m', 'Barra', '2023-02-15', '60.00', '2030-12-31', 'NF-1009'),
(10, 'Telha Portuguesa', '1kg', 'Milheiro', '2023-02-20', '1500.00', '2030-12-31', 'NF-1010');

-- Inserts para tabela entrada_produto
-- Assumindo fk_material de 1 a 10 e fk_usuario de 1 a 10
INSERT INTO `entrada_produto` (`fk_material`, `fk_usuario`, `nome_produto`, `nota_fiscal`, `data_saida`, `quantidade`) VALUES
(1, 1, 'Cimento CP II', 'NF-2001', NULL, 100),
(2, 2, 'Tijolo Baiano', 'NF-2002', NULL, 5),
(3, 3, 'Areia Média', 'NF-2003', NULL, 10),
(4, 4, 'Tinta Acrílica Branca', 'NF-2004', NULL, 50),
(5, 5, 'Vergalhão 3/8', 'NF-2005', NULL, 200),
(6, 6, 'Tábua de Pinus', 'NF-2006', NULL, 150),
(7, 7, 'Janela de Vidro', 'NF-2007', NULL, 20),
(8, 8, 'Fio 2.5mm', 'NF-2008', NULL, 30),
(9, 9, 'Cano PVC 100mm', 'NF-2009', NULL, 100),
(10, 10, 'Telha Portuguesa', 'NF-2010', NULL, 2);

-- Inserts para tabela saida_produto
-- Assumindo fk_usuario de 1 a 10. Note que esta tabela não tem fk_material no schema fornecido, apenas nome_produto.
INSERT INTO `saida_produto` (`fk_usuario`, `nome_produto`, `nota_fiscal`, `quantidade`, `data_saida`) VALUES
(1, 'Cimento CP II', 'NF-3001', 10, '2023-03-01'),
(2, 'Tijolo Baiano', 'NF-3002', 1, '2023-03-02'),
(3, 'Areia Média', 'NF-3003', 2, '2023-03-03'),
(4, 'Tinta Acrílica Branca', 'NF-3004', 5, '2023-03-04'),
(5, 'Vergalhão 3/8', 'NF-3005', 20, '2023-03-05'),
(6, 'Tábua de Pinus', 'NF-3006', 10, '2023-03-06'),
(7, 'Janela de Vidro', 'NF-3007', 2, '2023-03-07'),
(8, 'Fio 2.5mm', 'NF-3008', 5, '2023-03-08'),
(9, 'Cano PVC 100mm', 'NF-3009', 10, '2023-03-09'),
(10, 'Telha Portuguesa', 'NF-3010', 0, '2023-03-10');

-- Inserts para tabela alerta_estoque
-- Assumindo fk_material de 1 a 10
INSERT INTO `alerta_estoque` (`fk_material`, `nome_produto`, `quantidade_produto`, `condicao_reposicao`) VALUES
(1, 'Cimento CP II', 90, 'Normal'),
(2, 'Tijolo Baiano', 4, 'Baixo'),
(3, 'Areia Média', 8, 'Normal'),
(4, 'Tinta Acrílica Branca', 45, 'Normal'),
(5, 'Vergalhão 3/8', 180, 'Normal'),
(6, 'Tábua de Pinus', 140, 'Normal'),
(7, 'Janela de Vidro', 18, 'Normal'),
(8, 'Fio 2.5mm', 25, 'Normal'),
(9, 'Cano PVC 100mm', 90, 'Normal'),
(10, 'Telha Portuguesa', 2, 'Crítico');
