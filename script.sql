CREATE DATABASE games;
USE games;
create table games
(
    id            int auto_increment
        primary key,
    image_path    varchar(255) not null,
    date          date         not null comment '(y-m-d)',
    number_pieces int          not null
);

create table pieces
(
    id       int auto_increment
        primary key,
    game_id  int          not null,
    url      varchar(255) not null,
    position int          not null,
    constraint pieces_games_id_fk
        foreign key (game_id) references games (id)
            on update cascade on delete cascade
);

create table users
(
    id       int auto_increment
        primary key,
    name     varchar(255)     not null,
    email    varchar(255)     not null,
    password varchar(522)     null,
    phone    varchar(30)      not null,
    is_admin bit default b'1' not null,
    constraint email
        unique (email)
);

create table admin
(
    id          int auto_increment
        primary key,
    user_id     int                                  not null,
    first_acess bit      default b'1'                not null,
    created_at  datetime default current_timestamp() not null,
    constraint admin_users_id_fk
        foreign key (user_id) references users (id)
            on update cascade on delete cascade
);

create table first_access
(
    id         int auto_increment
        primary key,
    admin_id   int          not null,
    link       varchar(255) not null,
    created_at int          not null,
    constraint first_access_admin_id_fk
        foreign key (admin_id) references admin (id)
            on update cascade on delete cascade
);

create table logs
(
    id              int auto_increment
        primary key,
    createtimestamp int          not null,
    tipo            varchar(255) not null,
    descrição       varchar(255) not null,
    admin_id        int          not null,
    constraint logs_admin_id_fk
        foreign key (admin_id) references admin (id)
            on update cascade on delete cascade
);

create table player
(
    id      int auto_increment
        primary key,
    user_id int                  not null,
    deleted tinyint(1) default 0 not null,
    constraint player_users_id_fk
        foreign key (user_id) references users (id)
            on update cascade on delete cascade
);

create table player_pieces
(
    id              int auto_increment
        primary key,
    player_id       int not null,
    piece_id        int not null,
    currentPosition int not null,
    constraint player_pieces_pieces_id_fk
        foreign key (piece_id) references pieces (id)
            on update cascade on delete cascade,
    constraint player_pieces_player_id_fk
        foreign key (player_id) references player (id)
            on update cascade on delete cascade
);

create table solution
(
    id              int auto_increment
        primary key,
    player_id       int  not null,
    time_taken      int  not null,
    game_id         int  not null,
    resolution_date date not null,
    constraint solution_games_id_fk
        foreign key (game_id) references games (id)
            on update cascade on delete cascade,
    constraint solution_player_id_fk
        foreign key (player_id) references player (id)
            on update cascade on delete cascade
);

create table token
(
    id         int auto_increment
        primary key,
    player_id  int          not null,
    token_text varchar(522) not null,
    created_at int          not null,
    constraint token_player_id_fk
        foreign key (player_id) references player (id)
            on update cascade on delete cascade
);

