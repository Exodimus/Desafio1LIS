use lisp1;
DELIMITER //

drop PROCEDURE if EXISTS gen_balance_general_fecha //
create PROCEDURE gen_balance_general_fecha(IN fecha_ini DATE,fecha_fini DATE)   
begin



declare mov_final integer default 0;

declare mov_fecha date;
declare mov_monto decimal(12,2);
declare mov_tipo varchar(50);
declare mov_mtipo varchar(5);
declare mov_entrada decimal(12,2);
declare mov_salida decimal(12,2);
declare mov_id integer;

declare saldo_anterior decimal(12,2) default 0.0;
declare saldo_actual decimal(12,2);

declare tentrada decimal(12,2) default 0.0;
declare tsalida decimal(12,2) default 0.0;
declare tanterior decimal(12,2) default 0.0;

declare b2 cursor for select monto,mtipo from movimientos where fecha < fecha_ini;
declare b1 cursor for select id,tipo,fecha,monto,mtipo from movimientos where fecha between fecha_ini and fecha_fini order by fecha asc;
declare continue handler for not found set mov_final=1;



drop TEMPORARY table if exists bal_gen;
create TEMPORARY TABLE bal_gen(
bal_saldo_anterior decimal(18,2),
bal_fecha date,
bal_entrada decimal(18,2),
bal_salida decimal(18,2),
bal_saldo_actual decimal(18,2));
open b2;
bucle1:LOOP

fetch b2 into mov_monto,mov_mtipo;
if mov_final=1 THEN
leave bucle1;
end if;

if mov_mtipo='E' THEN
set saldo_anterior=saldo_anterior+mov_monto;
set tentrada=tentrada+mov_monto;
ELSE
set saldo_anterior=saldo_anterior-mov_monto;
set tsalida=tsalida+mov_monto;
end if;

end loop bucle1;
close b2;

set tanterior=saldo_anterior;
set mov_final=0;
insert into bal_gen(bal_saldo_anterior,bal_fecha,bal_entrada,bal_salida,bal_saldo_actual) values(0.0,fecha_ini,0,0,saldo_anterior);

open b1;
bucle: LOOP

FETCH b1 into mov_id,mov_tipo,mov_fecha,mov_monto,mov_mtipo;
if mov_final=1 THEN
leave bucle;
end if;

if mov_mtipo='E' THEN
set saldo_actual=saldo_anterior+mov_monto;
set mov_entrada=mov_monto;
set mov_salida=0.0;
ELSE
set saldo_actual=saldo_anterior-mov_monto;
set mov_entrada=0.0;
set mov_salida=mov_monto;
end if;

insert into bal_gen(bal_saldo_anterior,bal_fecha,bal_entrada,bal_salida,bal_saldo_actual) values(saldo_anterior,mov_fecha,mov_entrada,mov_salida,saldo_actual);
set saldo_anterior=saldo_actual;
end loop bucle;
close b1;

insert into bal_gen(bal_saldo_anterior,bal_fecha,bal_entrada,bal_salida,bal_saldo_actual) values(tanterior,fecha_fini,tentrada,tsalida,saldo_actual);
select * from bal_gen;
end //