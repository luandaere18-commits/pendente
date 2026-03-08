<?php

namespace App\Swagger;

/**
 * @OA\Info(
 *     title="API Centros",
 *     version="1.1.0",
 *     description="Documentação da API de Centros, incluindo operações de CRUD e relacionamentos."
 * )
 *
 * @OA\Server(
 *     url="/api",
 *     description="API principal"
 * )
 * 
 * @OA\SecurityScheme(
 *     securityScheme="bearerAuth",
 *     type="http",
 *     scheme="bearer",
 *     bearerFormat="JWT"
 * )
 *

 * @OA\Tag(
 *     name="Centros",
 *     description="Operações relacionadas aos centros"
 * )
 *
 * @OA\Tag(
 *     name="Cursos",
 *     description="Operações relacionadas aos cursos"
 * )
 *
 * @OA\Tag(
 *     name="Formadores",
 *     description="Operações relacionadas aos formadores"
 * )
 *
 * @OA\Tag(
 *     name="Horários",
 *     description="Operações relacionadas aos horários de cursos"
 * )
 *
 * @OA\Tag(
 *     name="Pré-inscrições",
 *     description="Operações relacionadas às pré-inscrições de cursos"
 * )
 *
 * @OA\Tag(
 *     name="Produtos",
 *     description="Operações relacionadas a produtos"
 * )
 *
 * @OA\Tag(
 *     name="Categorias",
 *     description="Operações relacionadas a categorias de produtos"
 * )
 *
 * @OA\Schema(
 *     schema="Centro",
 *     type="object",
 *     required={"nome", "localizacao", "contactos"},
 *     @OA\Property(property="id", type="integer", readOnly=true),
 *     @OA\Property(property="nome", type="string", maxLength=100),
 *     @OA\Property(property="localizacao", type="string"),
 *     @OA\Property(property="contactos", type="array", @OA\Items(type="string")),
 *     @OA\Property(property="email", type="string", format="email", nullable=true)
 * )
 *
 * @OA\Schema(
 *     schema="CentroInput",
 *     type="object",
 *     required={"nome", "localizacao", "contactos"},
 *     @OA\Property(property="nome", type="string", maxLength=100),
 *     @OA\Property(property="localizacao", type="string"),
 *     @OA\Property(property="contactos", type="array", @OA\Items(type="string")),
 *     @OA\Property(property="email", type="string", format="email", nullable=true),
 *     example={
 *         "nome": "Centro de Formação Profissional",
 *         "localizacao": "Rua das Flores, 123, Luanda",
 *         "contactos": {"923456789", "912345678"},
 *         "email": "contato@centro.com"
 *     }
 * )
 *
 * @OA\Schema(
 *     schema="Curso",
 *     type="object",
 *     required={"nome", "descricao", "modalidade", "ativo", "centros"},
 *     @OA\Property(property="id", type="integer", readOnly=true),
 *     @OA\Property(property="nome", type="string", maxLength=100),
 *     @OA\Property(property="descricao", type="string"),
 *     @OA\Property(property="programa", type="string", nullable=true),
 *     @OA\Property(property="area", type="string", maxLength=100, nullable=true),
 *     @OA\Property(property="modalidade", type="string", enum={"presencial", "online"}),
 *     @OA\Property(property="imagem_url", type="string", format="uri", nullable=true),
 *     @OA\Property(property="ativo", type="boolean"),
 *     @OA\Property(
 *         property="centros", 
 *         type="array", 
 *         @OA\Items(
 *             type="object",
 *             @OA\Property(property="centro_id", type="integer"),
 *             @OA\Property(property="preco", type="number", minimum=0),
 *             @OA\Property(property="duracao", type="string"),
 *             @OA\Property(property="data_arranque", type="string", format="date", nullable=true)
 *         )
 *     ),
 *     @OA\Property(property="formadores", type="array", @OA\Items(type="integer")),
 *     example={
 *         "id": 1,
 *         "nome": "Curso de Informática",
 *         "descricao": "Curso completo de informática básica e avançada.",
 *         "programa": "Módulo 1: Windows\nMódulo 2: Office\nMódulo 3: Internet",
 *         "area": "Tecnologia",
 *         "modalidade": "presencial",
 *         "imagem_url": "https://exemplo.com/imagem.jpg",
 *         "ativo": true,
 *         "centros": {
 *             {
 *                 "centro_id": 1,
 *                 "preco": 50000,
 *                 "duracao": "3 meses",
 *                 "data_arranque": "2025-08-01"
 *             }
 *         },
 *         "formadores": {1, 2}
 *     }
 * )
 *
 * @OA\Schema(
 *     schema="CursoInput",
 *     type="object",
 *     required={"nome", "descricao", "modalidade", "ativo", "centros"},
 *     @OA\Property(property="nome", type="string", maxLength=100),
 *     @OA\Property(property="descricao", type="string"),
 *     @OA\Property(property="programa", type="string", nullable=true),
 *     @OA\Property(property="area", type="string", maxLength=100, nullable=true),
 *     @OA\Property(property="modalidade", type="string", enum={"presencial", "online"}),
 *     @OA\Property(property="imagem_url", type="string", format="uri", nullable=true),
 *     @OA\Property(property="ativo", type="boolean"),
 *     @OA\Property(
 *         property="centros", 
 *         type="array", 
 *         @OA\Items(
 *             type="object",
 *             @OA\Property(property="centro_id", type="integer"),
 *             @OA\Property(property="preco", type="number", minimum=0),
 *             @OA\Property(property="duracao", type="string"),
 *             @OA\Property(property="data_arranque", type="string", format="date", nullable=true)
 *         )
 *     ),
 *     @OA\Property(property="formadores", type="array", @OA\Items(type="integer")),
 *     example={
 *         "nome": "Curso de Informática",
 *         "descricao": "Curso completo de informática básica e avançada.",
 *         "programa": "Módulo 1: Windows\nMódulo 2: Office\nMódulo 3: Internet",
 *         "area": "Tecnologia",
 *         "modalidade": "presencial",
 *         "imagem_url": "https://exemplo.com/imagem.jpg",
 *         "ativo": true,
 *         "centros": {
 *             {
 *                 "centro_id": 1,
 *                 "preco": 50000,
 *                 "duracao": "3 meses",
 *                 "data_arranque": "2025-08-01"
 *             }
 *         },
 *         "formadores": {1, 2}
 *     }
 * )
 * @OA\Schema(
 *     schema="Formador",
 *     type="object",
 *     required={"nome", "contactos"},
 *     @OA\Property(property="id", type="integer", readOnly=true),
 *     @OA\Property(property="nome", type="string", maxLength=100),
 *     @OA\Property(property="email", type="string", format="email", nullable=true),
 *     @OA\Property(property="contactos", type="array", @OA\Items(type="string")),
 *     @OA\Property(property="especialidade", type="string", maxLength=100, nullable=true),
 *     @OA\Property(property="bio", type="string", maxLength=500, nullable=true),
 *     @OA\Property(property="foto_url", type="string", format="uri", nullable=true),
 *     @OA\Property(property="cursos", type="array", @OA\Items(type="integer")),
 *     @OA\Property(property="centros", type="array", @OA\Items(type="integer")),
 *     example={
 *         "id": 1,
 *         "nome": "João Silva",
 *         "email": "joao@exemplo.com",
 *         "contactos": {"923456789", "912345678"},
 *         "especialidade": "Informática",
 *         "bio": "Formador com experiência em cursos de tecnologia.",
 *         "foto_url": "https://exemplo.com/foto.jpg",
 *         "cursos": {1, 2},
 *         "centros": {1}
 *     }
 * )
 *
 * @OA\Schema(
 *     schema="FormadorInput",
 *     type="object",
 *     required={"nome", "contactos"},
 *     @OA\Property(property="nome", type="string", maxLength=100),
 *     @OA\Property(property="email", type="string", format="email", nullable=true),
 *     @OA\Property(property="contactos", type="array", @OA\Items(type="string")),
 *     @OA\Property(property="especialidade", type="string", maxLength=100, nullable=true),
 *     @OA\Property(property="bio", type="string", maxLength=500, nullable=true),
 *     @OA\Property(property="foto_url", type="string", format="uri", nullable=true),
 *     @OA\Property(property="cursos", type="array", @OA\Items(type="integer")),
 *     @OA\Property(property="centros", type="array", @OA\Items(type="integer")),
 *     example={
 *         "nome": "João Silva",
 *         "email": "joao@exemplo.com",
 *         "contactos": {"923456789", "912345678"},
 *         "especialidade": "Informática",
 *         "bio": "Formador com experiência em cursos de tecnologia.",
 *         "foto_url": "https://exemplo.com/foto.jpg",
 *         "cursos": {1, 2},
 *         "centros": {1}
 *     }
 * )

 * @OA\Schema(
 *     schema="Horario",
 *     type="object",
 *     required={"id", "curso_id", "centro_id", "dia_semana", "periodo", "hora_inicio", "hora_fim"},
 *     @OA\Property(property="id", type="integer", example=1),
 *     @OA\Property(property="curso_id", type="integer", example=2),
 *     @OA\Property(property="centro_id", type="integer", example=3),
 *     @OA\Property(property="dia_semana", type="string", example="Segunda"),
 *     @OA\Property(property="periodo", type="string", example="manhã"),
 *     @OA\Property(property="hora_inicio", type="string", example="08:00"),
 *     @OA\Property(property="hora_fim", type="string", example="10:00"),
 *     @OA\Property(property="created_at", type="string", format="date-time", example="2025-07-31T08:00:00Z"),
 *     @OA\Property(property="updated_at", type="string", format="date-time", example="2025-07-31T08:00:00Z"),
 *     example={
 *         "id": 1,
 *         "curso_id": 2,
 *         "centro_id": 3,
 *         "dia_semana": "Segunda",
 *         "periodo": "manhã",
 *         "hora_inicio": "08:00",
 *         "hora_fim": "10:00",
 *         "created_at": "2025-07-31T08:00:00Z",
 *         "updated_at": "2025-07-31T08:00:00Z"
 *     }
 * )

 * @OA\Schema(
 *     schema="HorarioInput",
 *     type="object",
 *     required={"curso_id", "centro_id", "dia_semana", "periodo", "hora_inicio", "hora_fim"},
 *     @OA\Property(property="curso_id", type="integer", example=2),
 *     @OA\Property(property="centro_id", type="integer", example=3),
 *     @OA\Property(property="dia_semana", type="string", example="Segunda"),
 *     @OA\Property(property="periodo", type="string", example="manhã"),
 *     @OA\Property(property="hora_inicio", type="string", example="08:00"),
 *     @OA\Property(property="hora_fim", type="string", example="10:00"),
 *     example={
 *         "curso_id": 2,
 *         "centro_id": 3,
 *         "dia_semana": "Segunda",
 *         "periodo": "manhã",
 *         "hora_inicio": "08:00",
 *         "hora_fim": "10:00"
 *     }
 * )

 * @OA\Schema(
 *     schema="HorarioUpdateInput",
 *     type="object",
 *     required={"dia_semana", "periodo", "hora_inicio", "hora_fim"},
 *     @OA\Property(property="dia_semana", type="string", example="Segunda"),
 *     @OA\Property(property="periodo", type="string", example="manhã"),
 *     @OA\Property(property="hora_inicio", type="string", example="08:00"),
 *     @OA\Property(property="hora_fim", type="string", example="10:00"),
 *     example={
 *         "dia_semana": "Segunda",
 *         "periodo": "manhã",
 *         "hora_inicio": "08:00",
 *         "hora_fim": "10:00"
 *     }
 * )
 * 
 * 

 * @OA\Schema(
 *     schema="PreInscricao",
 *     type="object",
 *     required={"id", "curso_id", "centro_id", "nome_completo", "contactos", "status"},
 *     @OA\Property(property="id", type="integer", example=1),
 *     @OA\Property(property="curso_id", type="integer", example=2),
 *     @OA\Property(property="centro_id", type="integer", example=3),
 *     @OA\Property(property="horario_id", type="integer", nullable=true, example=4),
 *     @OA\Property(property="nome_completo", type="string", example="Maria dos Santos"),
 *     @OA\Property(property="contactos", type="array", @OA\Items(type="string")),
 *     @OA\Property(property="email", type="string", format="email", nullable=true, example="maria@email.com"),
 *     @OA\Property(property="status", type="string", enum={"pendente","confirmado","cancelado"}, example="pendente"),
 *     @OA\Property(property="observacoes", type="string", nullable=true, example="Precisa de material especial"),
 *     @OA\Property(property="created_at", type="string", format="date-time", example="2025-07-31T08:00:00Z"),
 *     @OA\Property(property="updated_at", type="string", format="date-time", example="2025-07-31T08:00:00Z"),
 *     example={
 *         "id": 1,
 *         "curso_id": 2,
 *         "centro_id": 3,
 *         "horario_id": 4,
 *         "nome_completo": "Maria dos Santos",
 *         "contactos": {"923456789", "912345678"},
 *         "email": "maria@email.com",
 *         "status": "pendente",
 *         "observacoes": "Precisa de material especial",
 *         "created_at": "2025-07-31T08:00:00Z",
 *         "updated_at": "2025-07-31T08:00:00Z"
 *     }
 * )
 *
 * @OA\Schema(
 *     schema="PreInscricaoInput",
 *     type="object",
 *     required={"curso_id", "centro_id", "nome_completo", "contactos"},
 *     @OA\Property(property="curso_id", type="integer", example=2),
 *     @OA\Property(property="centro_id", type="integer", example=3),
 *     @OA\Property(property="horario_id", type="integer", nullable=true, example=4),
 *     @OA\Property(property="nome_completo", type="string", example="Maria dos Santos"),
 *     @OA\Property(property="contactos", type="array", @OA\Items(type="string")),
 *     @OA\Property(property="email", type="string", format="email", nullable=true, example="maria@email.com"),
 *     @OA\Property(property="observacoes", type="string", nullable=true, example="Precisa de material especial"),
 *     example={
 *         "curso_id": 2,
 *         "centro_id": 3,
 *         "horario_id": 4,
 *         "nome_completo": "Maria dos Santos",
 *         "contactos": {"923456789", "912345678"},
 *         "email": "maria@email.com",
 *         "observacoes": "Precisa de material especial"
 *     }
 * )
 *
 * @OA\Schema(
 *     schema="PreInscricaoStatusInput",
 *     type="object",
 *     required={"status"},
 *     @OA\Property(property="status", type="string", enum={"pendente","confirmado","cancelado"}, example="pendente"),
 *     example={
 *         "status": "pendente"
 *     }
 * )
 * 
 * 
 * @OA\Schema(
 *   schema="Produto",
 *   type="object",
 *   required={"nome", "preco", "categoria_id"},
 *   @OA\Property(property="id", type="integer"),
 *   @OA\Property(property="nome", type="string"),
 *   @OA\Property(property="descricao", type="string", nullable=true),
 *   @OA\Property(property="preco", type="number", format="float"),
 *   @OA\Property(property="imagem", type="string", nullable=true),
 *   @OA\Property(property="categoria_id", type="integer"),
 *   @OA\Property(property="ativo", type="boolean"),
 *   @OA\Property(property="em_destaque", type="boolean"),
 *   @OA\Property(property="categoria", ref="#/components/schemas/Categoria"),
 *   @OA\Property(property="created_at", type="string", format="date-time"),
 *   @OA\Property(property="updated_at", type="string", format="date-time")
 * )
 *
 * @OA\Schema(
 *   schema="ProdutoInput",
 *   type="object",
 *   required={"nome", "preco", "categoria_id"},
 *   @OA\Property(property="nome", type="string"),
 *   @OA\Property(property="descricao", type="string", nullable=true),
 *   @OA\Property(property="preco", type="number", format="float"),
 *   @OA\Property(property="imagem", type="string", nullable=true),
 *   @OA\Property(property="categoria_id", type="integer"),
 *   @OA\Property(property="ativo", type="boolean"),
 *   @OA\Property(property="em_destaque", type="boolean")
 * )
 * 
 * 
 * @OA\Schema(
 *   schema="Categoria",
 *   type="object",
 *   required={"id", "nome", "tipo"},
 *   @OA\Property(property="id", type="integer", example=1),
 *   @OA\Property(property="nome", type="string", example="Bebidas"),
 *   @OA\Property(property="descricao", type="string", nullable=true, example="Categoria de bebidas"),
 *   @OA\Property(property="tipo", type="string", enum={"loja","snack"}, example="loja"),
 *   @OA\Property(property="ativo", type="boolean", example=true),
 *   @OA\Property(property="created_at", type="string", format="date-time", example="2025-07-31T08:00:00Z"),
 *   @OA\Property(property="updated_at", type="string", format="date-time", example="2025-07-31T08:00:00Z"),
 *   example={
 *     "id": 1,
 *     "nome": "Bebidas",
 *     "descricao": "Categoria de bebidas",
 *     "tipo": "loja",
 *     "ativo": true,
 *     "created_at": "2025-07-31T08:00:00Z",
 *     "updated_at": "2025-07-31T08:00:00Z"
 *   }
 * )
 * 
 * @OA\Schema(
 *   schema="CategoriaInput",
 *   type="object",
 *   required={"nome", "tipo"},
 *   @OA\Property(property="nome", type="string", example="Bebidas"),
 *   @OA\Property(property="descricao", type="string", nullable=true, example="Categoria de bebidas"),
 *   @OA\Property(property="tipo", type="string", enum={"loja","snack"}, example="loja"),
 *   @OA\Property(property="ativo", type="boolean", example=true)
 * )
 */

class SwaggerInfo {}


