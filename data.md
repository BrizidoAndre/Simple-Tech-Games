# Entregas

- Diagrama
- instrucoes.txt
- diagram.png
- dump.sql

# Banco de dados

## Users

- id,
- name
- email (unique)
- password
- phone

## admin

- id
- user_id
- first_access (bool)
- created_at

## FirstAccess

- id
- admin_id
- link
- created_at (validade 1 hora)

## Player

- id
- user_id
- deleted

## Token

- id
- player_id
- token
- created_at (validade 1 hora)

## Logs

- id
- Timestamp
- Tipo (ATULAIZAÇÃO, CADASTRO, REMOÇÃO, OUTROS)
- Descrição

## Games

- id
- image_path
- Date (Y-m-d)
- number_pieces

## Pieces

- id
- url
- position

## PlayerPieces

- id
- player_id
- piece_id
- currentPosition

## Solution

- id
- player_id
- time_taken
- game_id
- resolution_date

