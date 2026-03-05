@startuml
left to right direction
skinparam packageStyle rectangle

actor "Visitante Público" as Visitante
actor "Aluno (Registado)" as Aluno
actor "Administrador (Coord.)" as Admin

Visitante <|-- Aluno
Aluno <|-- Admin

rectangle "Plataforma WeAreSchool" {
  usecase "UC01: Consultar Catálogo Geral" as UC01
  usecase "UC02: Filtrar Projetos (Disciplinas/Anos/Tags)" as UC02
  usecase "UC03: Visualizar Detalhe e Ficheiros no Browser" as UC03
  usecase "UC04: Registar / Efetuar Login" as UC04
  
  usecase "UC05: Submeter Novo Projeto" as UC05
  usecase "UC06: Adicionar Disciplinas Parceiras" as UC06
  
  usecase "UC07: Aprovar/Rejeitar Projetos Pendentes" as UC07
  usecase "UC08: Gerir Currículo (Disciplinas)" as UC08
  usecase "UC09: Moderar Plataforma e Utilizadores" as UC09
  
  usecase "UC10: Avaliar Projetos (Atribuir Estrelas)" as UC10
  usecase "UC11: Sistema de Mensagens Privadas" as UC11
  
  usecase "UC12: Editar Perfil de Utilizador" as UC12
  usecase "UC13: Gerir os Meus Projetos (Estado/Detalhes)" as UC13
  usecase "UC14: Receber Notificações do Sistema" as UC14
  usecase "UC15: Adicionar Múltiplos Anexos" as UC15
  
  usecase "UC16: Aceder ao Dashboard de Estatísticas" as UC16
}

Visitante --> UC01
Visitante --> UC02
Visitante --> UC03
Visitante --> UC04

Aluno --> UC05
Aluno --> UC06
UC05 .> UC06 : <<include>>
UC05 .> UC15 : <<include>>
Aluno --> UC10
Aluno --> UC11
Aluno --> UC12
Aluno --> UC13
Aluno --> UC14

Admin --> UC07
Admin --> UC08
Admin --> UC09
Admin --> UC16

@enduml